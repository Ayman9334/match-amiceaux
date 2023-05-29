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

        $clubMembersIds = $club->clubMembers->map(function ($clubMember) {
            return $clubMember->member_id;
        });

        $members = User::select('id', 'nom')->whereIn('id', $clubMembersIds)
            ->with(['clubMember' => function ($query) {
                $query->select('id as member_id', 'member_role as role');
            }])
            ->get();

        return [
            'nom_club' => $club->nom_club,
            'role' => $user->clubMember->member_role,
            'members_number' => count($members),
            'membres' => $members,
        ];
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

    public function gererInvitation($invCode)
    {
        $user = auth()->user();

        if ($user->clubMember) return response(['message' => 'Tu a déjà un club'], 401);

        if (count($user->clubDemandes) >= 5) return response(['message' => 'Vous ne pouvez pas exiger plus de 5 clubs'], 403);

        $club = Club::where('club_code', $invCode)->first();

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

        return response($clubDemandes, 201);
    }

    public function accepteInvitations(Request $request)
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
    // /**
    //  * Show the form for editing the specified resource.
    //  */
    public function edit(string $id)
    {
        $club =  Club::find($id);
        return $club->only('id', 'nom_club');
    }

    // /**
    //  * Update the specified resource in storage.
    //  */
    public function update(ClubRequest $request, string $id)
    {
        $user = auth()->user();
        $club =  Club::find($id);

        $clubRole = $user->clubMember->member_role;

        if (!($clubRole === 'proprietaire' || $clubRole === 'coproprietaire')) return abort(401);
        if ($club->id !== $user->clubMember->club->id) return abort(401);

        $club->update(['nom_club' => $request->nom_club]);

        return response()->noContent(204);
    }

    /**
     * Remove the specified resource from storage.
     */
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

    

}
