<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservation;
use Illuminate\Support\Facades\Validator;

class ReservationController extends Controller
{
    public function store(Request $request)
    {
        // Validation des données
        $validator = Validator::make($request->all(), [
            'telephone_utilisateur' => 'required|exists:utilisateurs,telephone',
            'terrain_id' => 'required|exists:terrains,id',
            'date_reservation' => 'required|date',
            'heure_reservation' => 'required|date_format:H:i',
            'code_secret' => 'required|date_format:H:i|after:heure_debut',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first()
            ], 422);
        }

        // Création de la réservation
        $reservation = Reservation::create([
            'telephone_utilisateur' => $request->telephone_utilisateur ,
            'terrain_id' => $request->terrain_id,
            'date_reservation' => $request->date_reservation,
            'heure_reservation' => $request->heure_reservation,
            'code_secret' => $request->code_secret,
        ]);

        // Réponse JSON
        return response()->json([
            'success' => true,
            'message' => 'Réservation ajoutée avec succès ✅',
            'reservation' => $reservation
        ], 201);
    }

     public function index(){
        $reservations = Reservation::all();
        return response()->json([
            'success' => true,
            'reservations' => $reservations
        ]);
     }

    public function show($id){
        $reservation = Reservation::find($id);
        if (!$reservation) {
            return response()->json([
                'success' => false,
                'message' => 'Réservation non trouvée'
            ], 404);
        }
        return response()->json([
            'success' => true,
            'reservation' => $reservation
        ]);
    }

    public function getByTelephone($telephone)
    {
        // On récupère toutes les réservations liées à ce numéro
        $reservations = Reservation::where('telephone_utilisateur', $telephone)->get();

        if ($reservations->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'Aucune réservation trouvée pour ce numéro.'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'reservations' => $reservations
        ], 200);
    }

    public function getByTerrain($terrainId)
    {
        // On récupère toutes les réservations pour ce terrain
        $reservations = Reservation::where('terrain_id', $terrainId)->get();

        if ($reservations->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'Aucune réservation trouvée pour ce terrain.'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'reservations' => $reservations
        ], 200);
    }

}
