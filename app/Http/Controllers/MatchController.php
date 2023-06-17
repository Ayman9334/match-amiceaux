<?php

namespace App\Http\Controllers;

use App\Http\Requests\FiltreRechercheRequest;
use App\Http\Requests\StoreMatchRequest;
use App\Models\MatchDemamde;
use App\Models\MatchDemandeUser;
use App\Models\MatchMedia;
use App\Models\MatchMembre;
use App\Models\TableMatch;
use App\Models\TypeEnumsDetail;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class MatchController extends Controller
{
    public function index(FiltreRechercheRequest $request)
    {
        $filtreData = $request->validated();
        $latitude = $filtreData['latitude'];
        $longitude = $filtreData['longitude'];
        $distance = $filtreData['range'];

        $matchs = TableMatch::select('id', 'organisateur_id', 'match_date', 'nembre_joueur', 'lieu', 'lieu2', 'niveau', 'categorie', 'ligue')
            ->selectRaw(
                "(6371 * acos(cos(radians($latitude)) * cos(radians(latitude)) * cos(radians(longitude) - radians($longitude)) + sin(radians($latitude)) * sin(radians(latitude)))) AS distance"
            )
            ->having('distance', '<=', $distance)
            ->orderBy('distance', 'asc');


        abort_unless($matchs->exists(), 204);

        $columnsCheck = ['niveaux' => 'niveau', 'categories' => 'categorie', 'ligues' => 'ligue'];
        foreach ($columnsCheck as $key => $value) {
            if (isset($filtreData[$key]) && count($filtreData[$key])) {
                $matchs->whereIn($value, $filtreData[$key]);
            }
        }

        $dataEnvoyer = $matchs->get()->map(function ($match) {
            $match['organisateur_nom'] = $match->organisateur->nom;
            unset($match['organisateur'], $match['organisateur_id']);

            $matchmedia = $match->matchMedias()->orderBy('id', 'asc')->first();
            $match['media'] = $matchmedia?->media;
            $match['media_type'] = $matchmedia?->media_type;

            $enums = ['ligue', 'categorie', 'niveau'];
            foreach ($enums as $enum) {
                $match[$enum] = TypeEnumsDetail::where('code', $match[$enum])->value('libelle');
            }
            $match['distance'] = round($match['distance'], 1) . 'km';
            return $match;
        });

        return response($dataEnvoyer, 200);
    }

    public function store(StoreMatchRequest $request)
    {
        $matchData = $request->validated();
        $photos = [];

        if ($request->hasFile('images')) {
            $medias = $request->file('images');
            //store les photo
            foreach ($medias as $media) {
                $photo = $media->store('images/matchs', 'public');
                $photos[] = ['path' => $photo, 'extension' => $media->getClientOriginalExtension()];
            }
        }

        $matchData["organisateur_id"] =  $request->user()->id;
        $MatchCree = TableMatch::create($matchData);
        foreach ($photos as $photo) {
            MatchMedia::create([
                'match_id' => $MatchCree->id,
                'media' => $photo['path'],
                'media_type' =>  $photo['extension'],
            ]);
        }
        return response()->noContent();
    }

    public function show(string $id)
    {
        $user = Auth::guard('sanctum')->user();

        $match = TableMatch::find($id);
        abort_if(!$match, 404);

        $dataEnvoyer = $match->only('id', 'match_date', 'nembre_joueur', 'lieu', 'lieu2', 'latitude', 'longitude', 'niveau', 'categorie', 'ligue', 'description');
        $dataEnvoyer['organisateur'] = $match->organisateur->nom;
        $dataEnvoyer['medias'] = $match->matchMedias->pluck('media');

        //get enums from code
        $enums = ['ligue', 'categorie', 'niveau'];
        foreach ($enums as $enum) {
            $dataEnvoyer[$enum] = TypeEnumsDetail::where('code', $match[$enum])->value('libelle');
        }

        if (!$user) return $dataEnvoyer;

        //get match membres
        $dataEnvoyer['matchMembres'] = [
            "equipeA" => $match->matchMembres->where('equipe', 'A')->pluck('utilisateur.nom'),
            "equipeB" => $match->matchMembres->where('equipe', 'B')->pluck('utilisateur.nom'),
        ];

        //check if user admin of a club
        $membreInf = $user->clubMember;
        $dataEnvoyer['clubAdmin'] = in_array($membreInf?->member_role, ['proprietaire', 'coproprietaire']);

        if ($dataEnvoyer['clubAdmin']) {
            $dataEnvoyer['clubMembres'] = $membreInf->club->clubMembers->map(function ($clubMembre) {
                return [
                    "membre_id" => $clubMembre->id,
                    "nom" => $clubMembre->member->nom,
                ];
            });
        }

        return $dataEnvoyer;
    }

    public function edit(TableMatch $table_matche)
    {
        //
    }

    public function update(Request $request, TableMatch $table_matche)
    {
        //
    }

    public function destroy(TableMatch $table_matche)
    {
        //
    }

    //NO CRUD
    public function afficheUserMatch()
    {
        $user = auth()->user();
        $userMatchs = $user->matchs;

        $dataEnv = $userMatchs->map(function ($match) {
            $matchEnvInfo = $match->only('id', 'match_date', 'nembre_joueur', 'lieu', 'lieu2', 'niveau', 'categorie', 'ligue', 'description');

            $matchEnvInfo["matchMembres"] =  [
                "equipeA" => $match->matchMembres->where('equipe', "A")->map(function ($matchMembre) {
                    return [
                        "id" => $matchMembre->id,
                        "nom" => $matchMembre->utilisateur->nom
                    ];
                })->values(),
                "equipeB" => $match->matchMembres->where('equipe', "B")->map(function ($matchMembre) {
                    return [
                        "id" => $matchMembre->id,
                        "nom" => $matchMembre->utilisateur->nom
                    ];
                })->values(),
            ];

            $demandes = $match->matchDemamdes->map(function ($matchDemamde) {
                $dmEnv = $matchDemamde->only('id', 'invitation_type', 'equipe');

                if ($matchDemamde->invitation_type == "solo") {
                    $dmEnv['demandeur'] = $matchDemamde->utilisateur->nom;
                    return $dmEnv;
                }
                $dmEnv['clubNom'] = $matchDemamde->club->nom_club;
                $dmEnv['demandeurs'] = $matchDemamde->demandeurs->map(fn ($demandeur) => $demandeur->clubMembre->member->nom);
                return $dmEnv;
            });

            $matchEnvInfo["demandes"] = [
                'equipeA' => $demandes->filter(fn ($demande) => $demande['equipe'] == 'A'),
                'equipeB' => $demandes->filter(fn ($demande) => $demande['equipe'] == 'B'),
            ];

            $enums = ['ligue', 'categorie', 'niveau'];
            foreach ($enums as $enum) {
                $matchEnvInfo[$enum] = TypeEnumsDetail::where('code', $match[$enum])->value('libelle');
            }

            $matchEnvInfo['media'] = $match->matchMedias->value('media');

            return $matchEnvInfo;
        });


        return $dataEnv;
    }


    public function envoyerInvitation(Request $request, string $match_id)
    {
        $user = auth()->user();
        $match = TableMatch::find($match_id);

        abort_unless($match, 404, 'match n\'exist pas');

        $request->validate([
            "InvType" => "required|string|in:solo,club",
            "equipe" => "required|string|in:A,B",
            "InvClub" => "array",
        ]);

        $userInvitations = $user->matchDemamdes;

        abort_if(
            $match->organisateur_id == $user->id,
            403,
            'visiter la panel pour ajouter des membre a tant match'
        );
        abort_if(
            count($userInvitations) >= 5,
            403,
            'Vous avez dépassé le nombre maximum d\'invitations'
        );
        abort_if(
            $userInvitations->where('match_id', $match->id)->first(),
            403,
            'Vous avez déjà envoyé une invitation à ce match'
        );
        abort_if(
            $match->matchMembres->where('utilisateur_id', $user->id)->first(),
            403,
            'Vous êtes déjà dans ce match'
        );

        $nembre_joueur = $match->nembre_joueur;
        $matchMembres = $match->matchMembres->where('equipe', $request->equipe);

        abort_if(
            count($matchMembres) >= $nembre_joueur,
            403,
            'L\'équipe sélectionnée a déjà atteint le nombre maximum de joueurs pour ce match.'
        );


        $matchDemamde = new MatchDemamde;
        $matchDemamde->utilisateur_id = $user->id;
        $matchDemamde->match_id = $match->id;
        $matchDemamde->equipe = $request->equipe;

        if ($request->InvType == "solo") {

            $matchDemamde->invitation_type = 'solo';
            $matchDemamde->save();
        } else {
            //using club
            $clubMembre = $user->clubMember;
            abort_unless($clubMembre, 401);
            //check if user club prop
            $userClubRole = $clubMembre->member_role;
            abort_unless(($userClubRole == 'proprietaire' || $userClubRole == 'coproprietaire'), 401);
            //validate request
            $userClubId = $clubMembre->club_id;
            $request->validate([
                "InvClub.*" => [
                    Rule::exists('club_members', 'id')->where('club_id', $userClubId),
                    'distinct',
                ],
            ]);

            $numberInv = $request->has('InvClub') ? count($request->InvClub) : 0;
            abort_if(
                count($matchMembres) + $numberInv > $nembre_joueur,
                403,
                'L\'ajout de membres supplémentaires dépasserait le nombre maximum de joueurs pour ce euqipe.'
            );
            abort_if(
                $numberInv < 2,
                403,
                'vous doit acceder 2 membres ou plus'
            );
            abort_if(
                $match->matchMembres->where('club_id', $userClubId)->first(),
                403,
                "Un membre de votre club est déjà dans ce match"
            );
            abort_if(
                $match->matchDemamdes->where('club_id', $userClubId)->first(),
                403,
                "Il y a déjà un demande avec ce club"
            );
            abort_if(
                $match->organisateur->clubMember->club_id == $userClubId,
                403,
                "l'organisateur du match est dans votre club"
            );


            $matchDemamde->invitation_type = 'club';
            $matchDemamde->club_id = $userClubId;
            $matchDemamde->save();

            $clubMemberIds = $request->InvClub;
            foreach ($clubMemberIds as $clubMemberId) {
                $matchDemamdeUser = new MatchDemandeUser;
                $matchDemamdeUser->club_member_id = $clubMemberId;
                $matchDemamde->demandeurs()->save($matchDemamdeUser);
            }
        }
        return response()->noContent();
    }

    public function accepterInvitation(string $decision, string $demamde_id)
    {
        $user = auth()->user();

        $matchDemande = MatchDemamde::find($demamde_id);
        abort_if(!$matchDemande, 404);
        $userDM = $matchDemande->utilisateur;

        abort_if(
            count($userDM->matchsMembre->where('date', '>', Carbon::now())) >= 5,
            403,
            "$userDM->nom a dépassé la limite de participation aux matchs"
        );

        $match = $matchDemande->match;
        abort_if($match->organisateur_id != $user->id, 401);


        $equipeMembres = $match->matchMembres->where('equipe', $matchDemande->equipe); //group a ou b

        $nombreAjouter = $matchDemande->invitation_type == "club" ? count($matchDemande->demandeurs) : 1;
        abort_if(
            count($equipeMembres) + $nombreAjouter > $match->nembre_joueur,
            403,
            "vous n'avez pas la capacité d'ajouter $nombreAjouter membre(s)"
        );

        if ($decision == "accepter") {
            if ($matchDemande->invitation_type == "solo") {
                MatchMembre::create([
                    "utilisateur_id" => $userDM->id,
                    "match_id" => $match->id,
                    "equipe" => $matchDemande->equipe,
                ]);
            } else {
                $matchDemandeurs = $matchDemande->demandeurs;
                foreach ($matchDemandeurs as $matchDemandeur) {
                    $clubInfo = $matchDemandeur->clubMembre;
                    MatchMembre::create([
                        "utilisateur_id" => $clubInfo->member_id,
                        "match_id" => $match->id,
                        "club_id" => $clubInfo->club_id,
                        "equipe" => $matchDemande->equipe,
                    ]);
                }
            }
            $matchDemande->delete();
            return response()->noContent(201);
        } elseif ($decision == "refuser") {
            $matchDemande->delete();
            return response()->noContent();
        }
        abort(401);
    }
}
