<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TableMatch extends Model
{
    use HasFactory;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function matchMedias()
    {
        return $this->hasMany(MatchMedia::class,'match_id');
    }
    public function organisateur()
    {
        return $this->belongsTo(User::class,'organisateur_id');
    }
    public function matchMembres()
    {
        return $this->hasMany(MatchMembre::class,'match_id');
    }
    public function matchDemamdes()
    {
        return $this->hasMany(MatchDemamde::class,'match_id');
    }

}
