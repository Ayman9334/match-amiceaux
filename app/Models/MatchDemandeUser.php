<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MatchDemandeUser extends Model
{
    use HasFactory;

    public function matchDemande()
    {
        return $this->belongsTo(MatchDemamde::class,'match_demamde_id');
    }
    public function clubMembre()
    {
        return $this->belongsTo(ClubMember::class,'club_member_id');
    }
}
