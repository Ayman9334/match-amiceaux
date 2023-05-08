<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMatchRequest;
use App\Models\TableMatch;
use Illuminate\Http\Request;

class TableMatchController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $data = Table_matche::all();
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
        $matchData["organisateur_id"] =  $request->user()->id;
        TableMatch::create($matchData);
        return response("", 204);
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
