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
        $member = User::findOrFail($id);
        $member->delete();
        return redirect()->back()->with('success', 'Member deleted successfully.');
    }
    
}





