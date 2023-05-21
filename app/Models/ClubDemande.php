<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClubDemande extends Model
{
    use HasFactory;
    protected $fillable = ['utilisateur_id', 'club_id'];

    public function club()
    {
        return $this->belongsTo(Club::class, 'club_id');
    }

    public function utilisateur()
    {
        return $this->belongsTo(User::class, 'utilisateur_id');
    }
}
