<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MatchDemamde extends Model
{
    use HasFactory;

    public function matchDemamdeUsers()
    {
        return $this->hasMany(MatchDemandeUser::class,'match_demamde_id');
    }
}
