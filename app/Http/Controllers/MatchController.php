<?php

namespace App\Http\Controllers;

use App\Http\Requests\FiltreRechercheRequest;
use App\Http\Requests\StoreMatchRequest;
use App\Models\MatchMedia;
use App\Models\TableMatch;
use App\Models\TypeEnumsDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class MatchController extends Controller
{
    public function index()
    {
        return TableMatch::all();
    }

    public function create()
    {
        //
    }

    public function store(StoreMatchRequest $request)
    {
        $matchData = $request->validated();
        $photos = [];

        if ($request->hasFile('images')) {
            $medias = $request->file('images');
            //validation
            foreach ($medias as $media) {
                $validator = Validator::make(
                    ['image' => $media],
                    ['image' => 'required|mimes:jpg,png,jpeg|max:2500']
                );
                if ($validator->fails()) {
                    return response(['errors' => ['images' => ['les image doit être en format (jpg,png,jpeg) est 10Mo en total']]], 422);
                }
            }
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

    public function show(TableMatch $table_matche)
    {
        //
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

    public function filtreRecherche(FiltreRechercheRequest $request)
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

            $enums = ['ligue','categorie','niveau'];
            foreach ($enums as $enum){
                $match[$enum] = TypeEnumsDetail::where('code', $match[$enum])->value('libelle');
            }
            $match['distance']= round($match['distance'],1).'km';
            return $match;
        });

        return response($dataEnvoyer, 200);
    }
}
