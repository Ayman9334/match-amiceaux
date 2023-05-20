<?php

namespace App\Http\Controllers;

use App\Models\Club;
use App\Models\User;
use Illuminate\Http\Request;

class ClubController extends Controller
{

    public function check_utilisateur()
    {
        $user = auth()->user();

        if (!$user->clubMember) {
            return ['message' => 'club introuvable'];
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

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Club $club)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Club $club)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Club $club)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Club $club)
    {
        //
    }
}
