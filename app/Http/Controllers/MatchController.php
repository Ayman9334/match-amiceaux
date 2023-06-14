<?php

namespace App\Http\Controllers;

use App\Http\Requests\FiltreRechercheRequest;
use App\Http\Requests\StoreMatchRequest;
use App\Models\MatchDemamde;
use App\Models\MatchDemandeUser;
use App\Models\MatchMedia;
use App\Models\TableMatch;
use App\Models\TypeEnumsDetail;
use Illuminate\Http\Request;
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
        $match = TableMatch::find($id);

        abort_if(!$match, 404);

        $match['medias'] = $match->matchMedias->pluck('media');
        unset($match['matchMedias']);

        return $match;
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

    public function EnvoyerInvitation(Request $request, string $match_id)
    {
        $user = auth()->user();
        $match = TableMatch::find($match_id);
        abort_unless($match, 404, 'match n\'exist pas');

        $userClubId = $user->clubMember->club_id;
        $request->validate([
            "InvType" => "required|string|in:solo,club",
            "equipe" => "required|string|in:A,B",
            "InvClub" => "array",
            "InvClub.*" => [
                Rule::exists('club_members', 'id')->where('club_id', $userClubId),
                'distinct',
            ],
        ]);

        $userInvitations = $user->matchDemamdes;

        abort_if(count($userInvitations) >= 5, 403, 'Vous avez dépassé le nombre maximum d\'invitations');

        abort_if($userInvitations->where('match_id', $match->id)->first(), 403, 'Vous avez déjà envoyé une invitation à ce match');

        $matchDemamde = new MatchDemamde;
        $matchDemamde->utilisateur_id = $user->id;
        $matchDemamde->match_id = $match->id;

        if ($request->InvType == "solo") {

            $matchDemamde->invitation_type = 'solo';
            $matchDemamde->save();
        } else {
            //using club
            abort_if(count($request->InvClub) < 2, 403, 'vous doit acceder 2 membres ou plus');
            $userClubRole = $user->clubMember->member_role;
            abort_unless(($userClubRole == 'proprietaire' || $userClubRole == 'coproprietaire'), 401);

            $matchDemamde->invitation_type = 'club';
            $matchDemamde->save();

            $clubMemberIds = $request->InvClub;
            foreach ($clubMemberIds as $clubMemberId) {
                $matchDemamdeUser = new MatchDemandeUser;
                $matchDemamdeUser->club_member_id = $clubMemberId;
                $matchDemamde->matchDemamdeUsers()->save($matchDemamdeUser);
            }
        }
        return response()->noContent();
    }
}
