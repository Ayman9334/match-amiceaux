<?php

namespace App\Http\Controllers;

use App\Http\Requests\ClubRequest;
use App\Models\Club;
use App\Models\ClubDemande;
use App\Models\ClubMember;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ClubController extends Controller
{

    public function index()
    {
        $user = auth()->user();

        if (!$user->clubMember) {
            return response()->noContent();
        }

        $club = $user->clubMember->club;
        $clubMembers = $club->clubMembers;

        $members = $clubMembers->map(function ($clubMember) {
            $member = $clubMember->member;
            return [
                'utilisateur_id' => $member->id,
                'member_id' => $clubMember->id,
                'nom' => $member->nom,
                'member_role' => $clubMember->member_role
            ];
        });

        $resData = [
            'member_id' => $user->clubMember->id,
            'nom_club' => $club->nom_club,
            'role' => $user->clubMember->member_role,
            'members_number' => count($members),
            'membres' => $members,
        ];

        if ($resData['role'] === 'proprietaire' || $resData['role'] === 'coproprietaire') $resData['code'] = $club->club_code;

        return $resData;
    }

    public function store(ClubRequest $request)
    {
        $user = auth()->user();

        if ($user->clubMember) {
            return response('tu a deja un club', 401);
        }

        $nouveau_club = $request->validated();
        $nouveau_club['club_code'] = Str::random(12);
        while (Club::where('club_code', $nouveau_club['club_code'])->exists()) {
            $nouveau_club['club_code'] = Str::random(12);
        }

        $nouveau_club['proprietaire_id'] = $user->id;

        $club = Club::create($nouveau_club);

        $club_proprietaire = [
            'member_id' => $user->id,
            'club_id' => $club->id,
            'member_role' => 'proprietaire'
        ];

        ClubMember::create($club_proprietaire);

        return response()->noContent(201);
    }

    public function edit(string $id)
    {
        $club =  Club::find($id);
        return $club->only('id', 'nom_club');
    }

    public function update(ClubRequest $request, string $id)
    {
        $user = auth()->user();
        $club =  Club::find($id);

        $clubRole = $user->clubMember->member_role;

        $updatedclub = $request->validated();

        if (!($clubRole === 'proprietaire' || $clubRole === 'coproprietaire')) return abort(401);
        if ($club->id !== $user->clubMember->club->id) return abort(401);
        
        $club->update($updatedclub);

        return response()->noContent(204);
    }

    public function destroy(string $id)
    {
        $user = auth()->user();
        $club =  Club::find($id);

        $clubRole = $user->clubMember->member_role;

        if ($clubRole !== 'proprietaire') return abort(401);
        if ($club->id !== $user->clubMember->club->id) return abort(401);

        $club->delete();
        return response()->noContent(204);
    }

    public function gererInvitation(string $invCode)
    {
        $user = auth()->user();

        if ($user->clubMember) return response(['message' => 'Tu a déjà un club'], 403);

        if (count($user->clubDemandes) >= 5) return response(['message' => 'Vous ne pouvez pas exiger plus de 5 clubs'], 403);

        $club = Club::where('club_code', $invCode)->first();

        if (!$club) return response(['message' => 'il n\'y a pas de club avec ce code'], 403);

        if (ClubDemande::where([
            ['club_id', $club->id],
            ['utilisateur_id', $user->id]
        ])->exists()) return response(['message' => 'vous avez déjà envoyé une invitation à ce club'], 403);

        $C_existedInvitations =  count($club->clubDemandes);
        $C_clubmembers = count($club->clubMembers);

        if ($C_existedInvitations >= 14) return response(['message' => 'Le club a beaucoup d\'invitations'], 403);
        if ($C_clubmembers >= 15) return response(['message' => 'Le club a déjà le maximum de membres'], 403);

        $invitation = [
            'utilisateur_id' => $user->id,
            'club_id' => $club->id,
        ];

        ClubDemande::create($invitation);

        return response()->noContent(201);
    }

    public function afficheInvitations()
    {
        $user = auth()->user();

        $clubRole = $user->clubMember->member_role;

        if (!($clubRole === 'proprietaire' || $clubRole === 'coproprietaire')) return abort(401);

        $clubDemandes = $user->clubMember->club->clubDemandes;
        $demandes = $clubDemandes->map(function ($demande) {
            $demandUser = $demande->utilisateur;
            return [
                'demandeId' => $demande->id,
                'nom' => $demandUser->nom,
                'logo' => $demandUser->logo
            ];
        });

        return $demandes;
    }

    public function accepteInvitations(Request $request) //acceptation,demandeId
    {
        $user = auth()->user();

        $clubRole = $user->clubMember->member_role;

        if (!($clubRole === 'proprietaire' || $clubRole === 'coproprietaire')) return abort(401);

        $acceptation = $request->acceptation; //accepted :true / declined : false
        $demande = ClubDemande::find($request->demandeId);

        $club = $user->clubMember->club;

        if (!($demande && $demande->club_id == $club->id)) return abort(401); //check if demande clean

        $C_clubmembers = count($club->clubMembers);
        if ($C_clubmembers >= 15) return response(['message' => 'Le club a déjà le maximum de membres'], 405);

        if (!$acceptation) {
            $demande->delete();
            return response()->noContent(201);
        }

        $userAccepte = User::find($demande->utilisateur_id);
        if ($userAccepte->clubMember) {
            $demande->delete();
            return response(['message' => "$userAccepte->nom est deja un club"], 403);
        }

        // ajouter lutilisateur a le club
        $userAccepte->clubDemandes()->delete();
        ClubMember::create([
            'member_id' => $userAccepte->id,
            'club_id' => $club->id,
        ]);
        return response()->noContent(204);
    }

    public function exclureMembre(string $exclureId)
    {
        $user = auth()->user();
        $clubRole = $user->clubMember->member_role;

        $exclureMembre = ClubMember::find($exclureId);

        if (!($clubRole === 'proprietaire' || $clubRole === 'coproprietaire')) return abort(401);
        if ($user->clubMember->club_id != $exclureMembre->club_id) return abort(401);
        if ($user->id == $exclureMembre->member_id) return abort(401);
        if ($clubRole == 'coproprietaire' && $exclureMembre->member_role != "membre") return abort(401);

        $exclureMembre->delete();
    }

    public function changerole(Request $request)
    { //prendre changeurId,nouveauRole
        $user = auth()->user();
        $usermbr = $user->clubMember;
        $clubRole = $usermbr->member_role;

        $changeurMembre = ClubMember::find($request->changeurId);
        $nouveauRole = $request->nouveauRole;

        if ($clubRole !== 'proprietaire') return abort(401);
        if ($user->clubMember->club_id != $changeurMembre->club_id) return abort(401);
        if ($user->id == $changeurMembre->member_id) return abort(401);

        if ($nouveauRole == 'coproprietaire' || $nouveauRole == 'membre') {
            $changeurMembre->member_role = $nouveauRole;
            $changeurMembre->save();
            return response()->noContent(204);
        }

        //changer le club proprieter a l autre utilisatuer
        if ($nouveauRole == 'proprietaire') {
            $club = $user->clubMember->club;
            $club->id = $changeurMembre->member_id;
            $club->save();

            $usermbr->member_role = 'coproprietaire';
            $usermbr->save();

            $changeurMembre->member_role = 'proprietaire';
            $changeurMembre->save();

            return response()->noContent(204);
        }

        return abort(401);
    }

    public function regenererCode()
    {
        $user = auth()->user();
        $clubRole = $user->clubMember->member_role;

        if (!($clubRole === 'proprietaire' || $clubRole === 'coproprietaire')) return abort(401);

        $club = $user->clubMember->club;

        $club->club_code = Str::random(12);
        while (Club::where('club_code', $club->club_code)->exists()) {
            $club->club_code = Str::random(12);
        }
        $club->save();
        return ['club_code' => $club->club_code];
    }

    public function exitClub()
    {
        $user = auth()->user();

        $clubMember = $user->clubMember;
        if (!$clubMember) return abort(401);

        $clubRole = $clubMember->member_role;
        if ($clubRole === 'proprietaire') return response(['message' => 'En tant que propriétaire de club est impossible de partir.'], 405);

        $clubMember->delete();
        return response()->noContent(204);
    }
}
