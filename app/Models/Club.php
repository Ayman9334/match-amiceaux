<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Club extends Model
{
    use HasFactory;

    protected $fillable = ['nom_club', 'club_code', 'proprietaire_id'];

    //relations
    public function users()
    {
        return $this->belongsToMany(User::class, 'club_members', 'club_id', 'member_id');
    }
    public function clubMembers()
    {
        return $this->hasMany(ClubMember::class, 'club_id');
    }

    public function clubDemandes()
    {
        return $this->hasMany(ClubDemande::class, 'club_id');
    }
}
