<?php

namespace App\Http\Controllers;

use App\Models\Utilisateur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function store(Request $request)
    {
        // Validation des données
        $validator = Validator::make($request->all(), [
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'telephone' => 'required|string|max:20|unique:utilisateurs',
            'motDePasse' => 'required|string|min:8',
            'confirmerMotDePasse' => 'required|same:motDePasse',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first()
            ], 422);
        }

        // Création de l'utilisateur
        $user = Utilisateur::create([
            'nom' => $request->nom,
            'prenom' => $request->prenom,
            'telephone' => $request->telephone,
            'password' => Hash::make($request->motDePasse),
            'user_token' => Str::random(60), // Génération d'un token
        ]);

        // Réponse avec token
        return response()->json([
            'success' => true,
            'message' => 'Inscription réussie',
            'token' => $user->user_token,
            'user' => $user
        ], 201);
    }

    public function login(Request $request)
{
    $request->validate([
        'telephone' => 'required|string',
        'password' => 'required|string',
    ]);

    // Recherche de l'utilisateur par téléphone
    $user = Utilisateur::where('telephone', $request->telephone)->first();

    // Vérification du mot de passe manuellement
    if ($user && Hash::check($request->password, $user->password)) {
        // Génération d'un nouveau token si vous voulez
        $token = $user->createToken('USER_token')->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => 'Connexion réussie',
            'token' => $token,
            'user' => $user
        ]);
    }

    return response()->json([
        'success' => false,
        'message' => 'Identifiants incorrects'
    ], 401);
}

    public function index()
    {
        $users = Utilisateur::all();
        return response()->json($users);
    }

    public function show(string $id)
    {
        $user = Utilisateur::find($id);
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Utilisateur non trouvé'
            ], 404);
        }
        return response()->json($user);
    }

    public function update(Request $request, string $id)
    {
        $user = Utilisateur::find($id);
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Utilisateur non trouvé'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'nom' => 'sometimes|string|max:255',
            'prenom' => 'sometimes|string|max:255',
            'telephone' => 'sometimes|string|max:20|unique:utilisateurs,telephone,'.$id,
            'password' => 'sometimes|string|min:8',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first()
            ], 422);
        }

        $data = $request->all();
        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }

        $user->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Utilisateur mis à jour',
            'user' => $user
        ]);
    }

    public function destroy(string $id)
    {
        $user = Utilisateur::find($id);
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Utilisateur non trouvé'
            ], 404);
        }

        $user->delete();
        return response()->json([
            'success' => true,
            'message' => 'Utilisateur supprimé'
        ]);
    }
}
