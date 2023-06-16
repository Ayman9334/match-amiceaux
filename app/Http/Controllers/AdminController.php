<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Club;
use App\Models\Match;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $members = User::all();
        return $members;
    }
    public function indexclub()
    {
        $clubs = Club::all();
        $result = [];
    
        foreach ($clubs as $club) {
            $resData = [
                'id' => $club->id,
                'nom_club' => $club->nom_club,
                'members' => [],
            ];
    
            $clubMembers = $club->clubMembers;
    
            foreach ($clubMembers as $clubMember) {
                $member = $clubMember->member;
                $resData['members'][] = [
                    'utilisateur_id' => $member->id,
                    'member_id' => $clubMember->id,
                    'nom' => $member->nom,
                    'member_role' => $clubMember->member_role
                ];
            }
    
            $result[] = $resData;
        }
    
        return $result;
    }
            
    public function createMember(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
        ]);
        
        $member = new User;
        $member->name = $request->name;
        $member->email = $request->email;
        $member->save();
        return redirect()->back()->with('success', 'Member created successfully.');
    }
    
    public function updateMember(Request $request, $id)
    {
        $member = User::findOrFail($id);
        
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
        ]);
        
        $member->name = $request->name;
        $member->email = $request->email;
        $member->save();
        return redirect()->back()->with('success', 'Member updated successfully.');
    }
    
    public function deleteMember($id)
    {
        $member = User::find($id);
        $member->delete();
        // return redirect()->back()->with('success', 'Member deleted successfully.');
    }
    
}





