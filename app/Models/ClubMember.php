<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClubMember extends Model
{
    use HasFactory;

    protected $fillable = ['member_id','club_id','member_role'];

    public function club(){
        return $this->belongsTo(Club::class, 'club_id');
    }

    public function member(){
        return $this->belongsTo(User::class, 'member_id');
    }
}
