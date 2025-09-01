<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Utilisateur;

class AuthController extends Controller
{
    // Afficher le formulaire de connexion
    public function showLoginForm()
    {
        // Si l'utilisateur est déjà connecté, le rediriger vers utilisateurs.index
        if (Auth::check()) {
            return redirect()->route('utilisateurs.index');
        }
        
        return view('auth.login');
    }

    // Traiter la tentative de connexion
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'login' => 'required|string',
            'password' => 'required|string',
        ]);

        // Rechercher l'utilisateur par login
        $user = Utilisateur::where('login', $credentials['login'])->first();

        // Vérifier si l'utilisateur existe et si le mot de passe est correct
        if ($user && Hash::check($credentials['password'], $user->password)) {
            // Connecter l'utilisateur
            Auth::login($user, $request->has('remember'));
            $request->session()->regenerate();

            // Tenter de récupérer le service de livraison via la relation many-to-many
            $deliveryService = $user->deliveryServices->first();

            // Si aucun service n'est trouvé, essayer avec la relation one-to-one
            if (!$deliveryService) {
                $deliveryService = $user->deliveryService;
            }

            // Si un service de livraison est trouvé, stocker ses informations en session
            if ($deliveryService) {
                session([
                    'delivery_service_id' => $deliveryService->id,
                    'delivery_service_nom' => $deliveryService->nom,
                ]);
            }

            // Redirection vers la page des commandes
            return redirect()->route('commandes.index');
        }

        return back()->withErrors([
            'login' => 'Les identifiants fournis sont incorrects.',
        ])->onlyInput('login');
    }

    // Déconnexion
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}