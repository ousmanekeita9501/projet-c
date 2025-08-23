<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Terrain extends Model
{
    use HasFactory;

    protected $fillable = [
        'telephone',
        'carte_identite_path',
        'titre_propriete_path',
        'photos',
        'nombre_joueurs',
        'heure_ouverture',
        'heure_fermeture',
        'temps_match',
        'duree_match',
        'nombre_periodes',
        'delai_match',
        'tarif',
        'prix_reservation',
        'vestiaire',
        'points_forts',
        'description',
        'adresse',
        'emplacement',
        'reglement',
    ];

    protected $casts = [
        'photos' => 'array', // conversion JSON <-> array
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
     // Relation avec User

    public function utilisateur()
    {
        return $this->belongsTo(\App\Models\Utilisateur::class, 'user_id');
    }


}
