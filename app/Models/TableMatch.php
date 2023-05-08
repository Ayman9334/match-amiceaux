<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TableMatch extends Model
{
    use HasFactory;
    protected $fillable = [
        'organisateur_id',
        'match_date',
        'nembre_joueur',
        'lieu',
        'niveau',
        'categorie',
        'ligue',
        'description'
    ];
}
