<?php

namespace App\Http\Controllers;

use App\Models\Terrain;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class TerrainController extends Controller
{
    public function store(Request $request)
    {
        // Validation des données
        $validator = Validator::make($request->all(), [
            'telephone' => 'required|exists:utilisateurs,telephone',
            'carte_identite' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'titre_propriete' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'photos.*' => 'nullable|file|mimes:jpg,jpeg,png|max:4096',

            'nombre_joueurs' => 'nullable|integer|min:1',
            'heure_ouverture' => 'nullable|string',
            'heure_fermeture' => 'nullable|string',

            'temps_match' => 'nullable|in:fixe,variable',
            'duree_match' => 'nullable|integer',
            'nombre_periodes' => 'nullable|integer',
            'delai_match' => 'nullable|integer',

            'tarif' => 'nullable|integer',
            'prix_reservation' => 'nullable|integer',

            'vestiaire' => 'nullable|in:avec_douches,sans_douches,non',

            'points_forts' => 'nullable|string',
            'description' => 'nullable|string',
            'adresse' => 'nullable|string',
            'emplacement' => 'nullable|string',
            'reglement' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first()
            ], 422);
        }

        // 📂 Gestion des fichiers
        $cartePath = $request->hasFile('carte_identite')
            ? $request->file('carte_identite')->store('terrains/cartes', 'public')
            : null;

        $titrePath = $request->hasFile('titre_propriete')
            ? $request->file('titre_propriete')->store('terrains/titres', 'public')
            : null;

        $photosPaths = [];
        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $photo) {
                $photosPaths[] = $photo->store('terrains/photos', 'public');
            }
        }

        // Création du terrain
        $terrain = Terrain::create([
            'user_id' => Auth::id(), // l’utilisateur connecté est le propriétaire
            'telephone' => $request->telephone,
            'carte_identite_path' => $cartePath,
            'titre_propriete_path' => $titrePath,
            'photos' => $photosPaths,

            'nombre_joueurs' => $request->nombre_joueurs,
            'heure_ouverture' => $request->heure_ouverture,
            'heure_fermeture' => $request->heure_fermeture,

            'temps_match' => $request->temps_match,
            'duree_match' => $request->duree_match,
            'nombre_periodes' => $request->nombre_periodes,
            'delai_match' => $request->delai_match,

            'tarif' => $request->tarif,
            'prix_reservation' => $request->prix_reservation,

            'vestiaire' => $request->vestiaire,
            'points_forts' => $request->points_forts,
            'description' => $request->description,
            'adresse' => $request->adresse,
            'emplacement' => $request->emplacement,
            'reglement' => $request->reglement,
        ]);

        // Réponse JSON
        return response()->json([
            'success' => true,
            'message' => 'Terrain ajouté avec succès ✅',
            'terrain' => $terrain
        ], 201);
    }



        public function index()
    {
        // Récupérer tous les terrains avec leur propriétaire (utilisateur)
        $terrains = Terrain::with('utilisateur')->latest()->get();

        return response()->json([
            'success' => true,
            'count' => $terrains->count(),
            'terrains' => $terrains
        ]);
    }

    public function destroy(string $id)
    {
        $terrain = Terrain::find($id);

        if (!$terrain) {
            return response()->json([
                'success' => false,
                'message' => 'Terrain non trouvé ❌'
            ], 404);
        }

        // Supprimer les fichiers associés si tu veux (optionnel)
        if ($terrain->carte_identite_path && \Storage::disk('public')->exists($terrain->carte_identite_path)) {
            \Storage::disk('public')->delete($terrain->carte_identite_path);
        }
        if ($terrain->titre_propriete_path && \Storage::disk('public')->exists($terrain->titre_propriete_path)) {
            \Storage::disk('public')->delete($terrain->titre_propriete_path);
        }
        if ($terrain->photos) {
            foreach ($terrain->photos as $photo) {
                if (\Storage::disk('public')->exists($photo)) {
                    \Storage::disk('public')->delete($photo);
                }
            }
        }

        // Supprimer le terrain
        $terrain->delete();

        return response()->json([
            'success' => true,
            'message' => 'Terrain supprimé avec succès ✅'
        ]);
    }
    public function show($id)
    {
        $terrain = Terrain::with('utilisateur')->find($id);

        if (!$terrain) {
            return response()->json([
                'success' => false,
                'message' => 'Terrain non trouvé ❌'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'terrain' => $terrain
        ], 200);
    }

    public function search(Request $request)
    {
        $query = $request->input('q'); // le mot-clé saisi

        if (!$query) {
            return response()->json([
                'success' => false,
                'message' => 'Veuillez entrer un mot-clé pour la recherche.'
            ], 400);
        }

        // 🔎 Recherche sur plusieurs colonnes (adresse, description, points forts...)
        $terrains = Terrain::where('adresse', 'LIKE', "%{$query}%")
            ->orWhere('description', 'LIKE', "%{$query}%")
            ->orWhere('points_forts', 'LIKE', "%{$query}%")
            ->orWhere('emplacement', 'LIKE', "%{$query}%")
            ->orWhere('adresse', 'LIKE', "%{$query}%")
            ->with('utilisateur')
            ->get();

        if ($terrains->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'Aucun terrain trouvé pour ce mot-clé.'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'count' => $terrains->count(),
            'terrains' => $terrains
        ], 200);
    }

}


