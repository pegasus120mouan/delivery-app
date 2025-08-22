<?php

namespace App\Http\Controllers;

use App\Models\Utilisateur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

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
        //
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
}