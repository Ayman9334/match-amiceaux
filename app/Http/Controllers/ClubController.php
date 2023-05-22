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
            return response('tu a deja un club',401);
        }

        $nouveau_club = $request->validated();
        $nouveau_club['club_code'] = Str::random(12);
        while (Club::where('club_code', $nouveau_club['club_code'])->exists()) {
            $nouveau_club['club_code'] = Str::random(12);
        }

        $nouveau_club['proprietaire_id'] = $user->id;

        $club = Club::create($nouveau_club);
        
        $club_proprietaire= [
            'member_id' => $user->id,
            'club_id' => $club->id,
            'member_role' => 'proprietaire'
        ];

        ClubMember::create($club_proprietaire);

        return response()->noContent(201);
    }

    public function gererInvitation($invCode){
        $user = auth()->user();

        if ($user->clubMember) return response(['message'=>'Tu a déjà un club'],401);
        
        if(count($user->clubDemandes) >= 5) return response(['message'=>'Vous ne pouvez pas exiger plus de 5 clubs'],401);

        $club = Club::where('club_code', $invCode)->first();

        if (ClubDemande::where([
            ['club_id',$club->id],
            ['utilisateur_id',$user->id]
            ])->exists()) return response(['message'=>'vous avez déjà envoyé une invitation à ce club'],401);

        $C_existedInvitations =  count($club->clubDemandes);
        $C_clubmembers = count($club->clubMembers);

        if ($C_existedInvitations >= 20) return response(['message'=>'Le club a beaucoup d\'invitations'],401);
        if ($C_clubmembers>=15) return response(['message'=>'Le club a déjà le maximum de membres'],401);

        $invitation = [ 
            'utilisateur_id' => $user->id,
            'club_id' => $club->id,
        ];

        ClubDemande::create($invitation);

        return response()->noContent(201);
    }

    public function afficheInvitations(){
        $user = auth()->user();

        $clubRole = $user->clubMember->member_role;

        if(!($clubRole === 'proprietaire' || $clubRole === 'coproprietaire')) return abort(403);

        $clubDemandes = $user->clubMember->club->clubDemandes;

        return $clubDemandes;
    }

    // /**
    //  * Show the form for editing the specified resource.
    //  */
    // public function edit(Club $club)
    // {
    //     //
    // }

    // /**
    //  * Update the specified resource in storage.
    //  */
    // public function update(Request $request, Club $club)
    // {
    //     //
    // }

    // /**
    //  * Remove the specified resource from storage.
    //  */
    // public function destroy(Club $club)
    // {
    //     //
    // }
}
