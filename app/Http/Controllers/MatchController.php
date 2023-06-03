<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMatchRequest;
use App\Models\MatchMedia;
use App\Models\TableMatch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class MatchController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return TableMatch::all();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMatchRequest $request)
    {
        $matchData = $request->validated();
        $photos = [];

        if ($request->hasFile('images')) {
            $files = $request->file('images');
            //validation
            foreach ($files as $file) {
                $validator = Validator::make(
                    ['image' => $file],
                    ['image' => 'required|mimes:jpg,png,jpeg|max:2500']
                );
                if ($validator->fails()) {
                    return response(['errors' => ['images' => ['les image doit être en format (jpg,png,jpeg) est 10Mo en total']]], 422);
                }
            }
            //store les photo
            foreach ($files as $file) {
                $photo = $file->store('images/matchs', 'public');
                $photos[] = ['path' => $photo, 'extension' => $file->getClientOriginalExtension()];
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

    /**
     * Display the specified resource.
     */
    public function show(TableMatch $table_matche)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TableMatch $table_matche)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TableMatch $table_matche)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TableMatch $table_matche)
    {
        //
    }
}
