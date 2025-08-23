<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Utilisateur extends Model
{
    use HasApiTokens, Notifiable;

    protected $table = 'utilisateurs';

    protected $fillable = [
        'nom',
        'prenom',
        'telephone',
        'password',
        'user_token'
    ];

    protected $hidden = [
        'password',
        'user_token',
    ];

    public function terrains()
{
    return $this->hasMany(Terrain::class);
}

}
