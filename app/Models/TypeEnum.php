<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypeEnum extends Model
{
    use HasFactory;
    protected $fillable = [
        "libelle","code"
    ];

}
