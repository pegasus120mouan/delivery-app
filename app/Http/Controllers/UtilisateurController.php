<?php

namespace App\Http\Controllers;

use App\Models\Utilisateur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UtilisateurController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $utilisateurs = Utilisateur::all();
        return view('utilisateurs.index', compact('utilisateurs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'prenoms' => 'required|string|max:255',
            'login' => 'required|string|max:255|unique:utilisateurs',
            'role' => 'required|string|in:admin,client,livreur',
            'contact' => 'required|string|max:20|unique:utilisateurs',
            'lieu_habitation' => 'required|string|max:255',
            'whatsapp' => 'nullable|string|max:20',
            'password' => 'required|string|min:8|confirmed',
        ]);
        $validated['password'] = Hash::make($request->password);
        
        Utilisateur::create($validated);
        
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Utilisateur créé avec succès!'
            ]);
        }
    
        return redirect()->route('utilisateurs.index')
            ->with('success', 'Utilisateur créé avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Utilisateur $utilisateur)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Utilisateur $utilisateur)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Utilisateur $utilisateur)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'prenoms' => 'required|string|max:255',
            'contact' => 'required|string|max:20|unique:utilisateurs,contact,' . $utilisateur->id,
            'whatsapp' => 'nullable|string|max:20',
            'lieu_habitation' => 'nullable|string|max:255',
            'email' => 'nullable|unique:utilisateurs,email,' . $utilisateur->id,
        ]);
    
        // Mise à jour mot de passe si présent
        if ($request->filled('password')) {
            $validated['password'] = Hash::make($request->password);
        }
    
        $utilisateur->update($validated);
    
        return redirect()->route('utilisateurs.profile', $utilisateur->id)
                     ->with('popup', true);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Utilisateur $utilisateur)
    {
        $utilisateur->delete();
        return redirect()->route('utilisateurs.index')
                         ->with('popup', true);
    }

    public function profile(Utilisateur $utilisateur)
    {
        return view('utilisateurs.profile', compact('utilisateur'));
    }

    public function changePassword(Request $request, Utilisateur $utilisateur)
    {
        $request->validate([
            'ancien_password' => 'required|string',
            'nouveau_password' => 'required|string|min:8',
            'confirmer_nouveau_password' => 'required|string|same:nouveau_password',
        ], [
            'confirmer_nouveau_password.same' => 'La confirmation du mot de passe ne correspond pas.',
            'nouveau_password.min' => 'Le mot de passe doit contenir au moins 8 caractères.'
        ]);

        // Vérifier si l'ancien mot de passe est correct
        if (!Hash::check($request->ancien_password, $utilisateur->password)) {
            return back()->withErrors(['ancien_password' => 'L\'ancien mot de passe est incorrect.'])->withInput();
        }

        // Vérifier si le nouveau mot de passe est différent de l'ancien
        if (Hash::check($request->nouveau_password, $utilisateur->password)) {
            return back()
                ->withErrors(['nouveau_password' => 'Le nouveau mot de passe doit être différent de l\'ancien.'])
                ->withInput();
        }
    
        // Mettre à jour le mot de passe
        $utilisateur->update([
            'password' => Hash::make($request->nouveau_password),
        ]);

        return redirect()->route('utilisateurs.profile', $utilisateur)
            ->with('success', 'Mot de passe mis à jour avec succès.');
    }

    public function updateAvatar(Request $request, Utilisateur $utilisateur)
    {
        $request->validate([
            'avatar' => 'required|image|max:2048', // Vérifie que c'est une image, max 2 Mo
        ]);
    
        // Supprimer l'ancien avatar s'il existe
        if ($utilisateur->avatar) {
            Storage::disk('public')->delete('utilisateurs/' . $utilisateur->avatar);
        }
    
        // Stocker la nouvelle image
        $avatarName = time() . '.' . $request->avatar->extension();
        $request->avatar->storeAs('utilisateurs', $avatarName, 'public');
    
        // Mettre à jour le champ avatar dans la base de données
        $utilisateur->update(['avatar' => $avatarName]);
    
        return redirect()->back()->with('success', 'Avatar mis à jour avec succès.');
    }

    public function livreurs()
    {
        // On récupère uniquement les utilisateurs dont le rôle est "livreur"
        $livreurs = Utilisateur::where('role', 'livreur')->get();

        return view('utilisateurs.livreurs', compact('livreurs'));
    }



    public function gestionnaires()
    {
        // On récupère uniquement les utilisateurs dont le rôle est "livreur"
        $gestionnaires = Utilisateur::where('role', 'gerant')->get();

        return view('utilisateurs.gestionnaires', compact('gestionnaires'));
    }
}