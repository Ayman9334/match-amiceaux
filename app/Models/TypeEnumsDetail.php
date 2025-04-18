<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypeEnumsDetail extends Model
{
    use HasFactory;
    protected $fillable = [
        "type_enum_id","libelle","code"
    ];
    public function TypeEnum(){
        return $this->belongsTo(TypeEnum::class);
    }

}
