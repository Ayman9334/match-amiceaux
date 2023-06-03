<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MatchMedia extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'match_id',
        'media',
        'media_type',
        'createur_id',
        'dernier_editeur_id'
    ];

    public function tablematch()
    {
        return $this->hasMany(TableMatch::class);
    }
}
