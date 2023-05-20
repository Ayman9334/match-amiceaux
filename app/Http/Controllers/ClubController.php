<?php

namespace App\Http\Controllers;

use App\Http\Requests\ClubRequest;
use App\Models\Club;
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
            return response(null, 204);
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
            'membres' => $members,
        ];
    }



    public function store(ClubRequest $request)
    {
        $user = auth()->user();

        if ($user->clubMember) {
            return response('already have club',401);
        }

        $nouveau_club = $request->validated();

        $nouveau_club['club_code'] = Str::random(9);
        while (Club::where('club_code', $nouveau_club['club_code'])->exists()) {
            $nouveau_club['club_code'] = Str::random(9);
        }
        
        $club = Club::create($nouveau_club);

        $club_proprietaire= [
            'member_id' => $user->id,
            'club_id' => $club->id,
            'member_role' => 'proprietaire'
        ];

        ClubMember::create($club_proprietaire);

        return response(null, 201);
    }

    /**
     * Display the specified resource.
     */
    // public function show(Club $club)
    // {
    //     //
    // }

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
