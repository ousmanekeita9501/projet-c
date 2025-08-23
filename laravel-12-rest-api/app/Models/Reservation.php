<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Utilisateur;
class Reservation extends Model
{
     use HasFactory;

    protected $fillable = [
        'telephone_utilisateur',
        'terrain_id',
        'date_reservation',
        'heure_reservation',
        'code_secret',
    ];

    protected $table = 'reservations';

    public function terrain()
    {
        return $this->belongsTo(Terrain::class, 'terrain_id');
    }

    public function utilisateur()
    {
        return $this->belongsTo(Utilisateur::class, 'telephone', 'telephone');
    }
}
