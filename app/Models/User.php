<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nom',
        'logo',
        'email',
        'password',
        'n_telephone',
        'code_postal',
        'ville',
        'region',
        'adresse',
        'niveau',
        'categorie',
        'league',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    //realations
    public function clubs()
    {
        return $this->belongsToMany(Club::class, 'club_members', 'member_id', 'club_id');
    }
    public function clubMember()
    {
        return $this->hasOne(ClubMember::class, 'member_id');
    }
    public function clubDemandes()
    {
        return $this->hasMany(ClubDemande::class, 'utilisateur_id');
    }
    public function matchs()
    {
        return $this->hasMany(TableMatch::class, 'organisateur_id');
    }
    public function matchDemamdes()
    {
        return $this->hasMany(MatchDemamde::class, 'utilisateur_id');
    }
}
