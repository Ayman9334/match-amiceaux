<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MatchDemamde extends Model
{
    use HasFactory;

    public function utilisateur()
    {
        return $this->belongsTo(User::class, 'utilisateur_id');
    }
    public function demandeurs()
    {
        return $this->hasMany(MatchDemandeUser::class, 'match_demamde_id');
    }
    public function match()
    {
        return $this->belongsTo(TableMatch::class, 'match_id');
    }
    public function club()
    {
        return $this->belongsTo(Club::class, 'club_id');
    }
}
