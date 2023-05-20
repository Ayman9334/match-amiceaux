<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Club extends Model
{
    use HasFactory;

    public function clubMembers()
    {
        return $this->hasMany(ClubMember::class, 'club_id');
    }
}
