<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - Notre plateforme</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #6b46c1 0%, #9333ea 50%, #7c3aed 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .container {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(20px);
            border-radius: 24px;
            padding: 40px;
            width: 100%;
            max-width: 900px;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 0;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.2);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .left-section {
            background: linear-gradient(135deg, rgba(139, 69, 19, 0.3) 0%, rgba(147, 51, 234, 0.4) 100%);
            border-radius: 20px;
            padding: 40px 30px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }

        .welcome-badge {
            position: absolute;
            top: 20px;
            right: 20px;
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            padding: 8px 20px;
            border-radius: 20px;
            color: white;
            font-size: 14px;
            font-weight: 500;
        }

        .illustration {
            position: relative;
            width: 200px;
            height: 200px;
            margin-bottom: 30px;
        }

        .circle-bg {
            width: 200px;
            height: 200px;
            background: linear-gradient(135deg, #bfdbfe 0%, #ddd6fe 100%);
            border-radius: 50%;
            position: absolute;
            top: 0;
            left: 0;
        }

        .person {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 2;
        }

        .person-body {
            width: 60px;
            height: 80px;
            background: linear-gradient(135deg, #ec4899 0%, #be185d 100%);
            border-radius: 30px 30px 15px 15px;
            position: relative;
        }

        .person-head {
            width: 40px;
            height: 40px;
            background: #fbbf24;
            border-radius: 50%;
            position: absolute;
            top: -20px;
            left: 10px;
        }

        .person-hair {
            width: 35px;
            height: 25px;
            background: #1e40af;
            border-radius: 20px 20px 0 0;
            position: absolute;
            top: -15px;
            left: 2.5px;
        }

        .person-arm {
            width: 25px;
            height: 15px;
            background: #fbbf24;
            border-radius: 10px;
            position: absolute;
            top: 10px;
            right: -20px;
            transform: rotate(-30deg);
        }

        .leaf {
            position: absolute;
            color: #3b82f6;
            font-size: 40px;
        }

        .leaf-1 {
            bottom: 20px;
            left: 20px;
            transform: rotate(-20deg);
        }

        .leaf-2 {
            bottom: 40px;
            right: 30px;
            transform: rotate(30deg);
        }

        .leaf-3 {
            top: 60px;
            left: 10px;
            font-size: 25px;
            transform: rotate(-45deg);
        }

        .description {
            color: rgba(255, 255, 255, 0.9);
            text-align: center;
            font-size: 14px;
            line-height: 1.5;
            max-width: 250px;
        }

        .right-section {
            padding: 40px 30px;
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .form-title {
            color: #374151;
            font-size: 24px;
            font-weight: 600;
            margin-bottom: 30px;
            text-align: center;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            display: block;
            color: #6b7280;
            font-size: 14px;
            margin-bottom: 8px;
            font-weight: 500;
        }

        .form-input {
            width: 100%;
            padding: 12px 0;
            border: none;
            border-bottom: 2px solid #e5e7eb;
            background: transparent;
            font-size: 16px;
            color: #374151;
            transition: border-color 0.3s ease;
        }

        .form-input:focus {
            outline: none;
            border-bottom-color: #7c3aed;
        }

        .login-btn {
            width: 100%;
            background: linear-gradient(135deg, #7c3aed 0%, #9333ea 100%);
            color: white;
            border: none;
            padding: 14px;
            border-radius: 25px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            margin: 30px 0 20px 0;
        }

        .login-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(124, 58, 237, 0.3);
        }

        .form-links {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 20px;
        }

        .form-link {
            color: #6b7280;
            text-decoration: none;
            font-size: 14px;
            transition: color 0.3s ease;
        }

        .form-link:hover {
            color: #7c3aed;
            text-decoration: underline;
        }

        .alert {
            padding: 12px 16px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 14px;
        }

        .alert-danger {
            background-color: #fee2e2;
            color: #dc2626;
            border: 1px solid #fecaca;
        }

        .alert-success {
            background-color: #d1fae5;
            color: #065f46;
            border: 1px solid #a7f3d0;
        }

        .invalid-feedback {
            color: #dc2626;
            font-size: 12px;
            margin-top: 5px;
        }

        .is-invalid {
            border-bottom-color: #dc2626 !important;
        }

        @media (max-width: 768px) {
            .container {
                grid-template-columns: 1fr;
                max-width: 400px;
                padding: 20px;
            }
            
            .left-section {
                margin-bottom: 20px;
                padding: 30px 20px;
            }
            
            .illustration {
                width: 150px;
                height: 150px;
            }
            
            .circle-bg {
                width: 150px;
                height: 150px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="left-section">
            <div class="welcome-badge">Bienvenue</div>
            
            <div class="illustration">
                <div class="circle-bg"></div>
                <div class="person">
                    <div class="person-head">
                        <div class="person-hair"></div>
                    </div>
                    <div class="person-body"></div>
                    <div class="person-arm"></div>
                </div>
                <div class="leaf leaf-1">🌿</div>
                <div class="leaf leaf-2">🌿</div>
                <div class="leaf leaf-3">🍃</div>
            </div>
            
            <p class="description">
                Votre plateforme de gestion de votre service de livraison
            </p>
        </div>

        <div class="right-section">
            <h2 class="form-title">Se connecter à son espace</h2>
            
            <!-- Messages d'alerte -->
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            
            <form method="POST" action="{{ route('login') }}">
                @csrf
                
                <div class="form-group">
                    <label for="login" class="form-label">Login</label>
                    <input type="text" name="login" id="login" 
                           class="form-input @error('login') is-invalid @enderror" 
                           value="{{ old('login') }}" 
                           required 
                           autofocus>
                    @error('login')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="password" class="form-label">Mot de passe</label>
                    <input type="password" name="password" id="password" 
                           class="form-input @error('password') is-invalid @enderror" 
                           required>
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="form-group">
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="remember" name="remember">
                        <label class="form-check-label form-link" for="remember">Se souvenir de moi</label>
                    </div>
                </div>
                
                <button type="submit" class="login-btn">Se connecter</button>
                
                <div class="form-links">
                    <a href="#" class="form-link">Mot de passe oublié ?</a>
                    <a href="#" class="form-link">Créer un compte</a>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Script pour gérer les animations et interactions
        document.addEventListener('DOMContentLoaded', function() {
            const inputs = document.querySelectorAll('.form-input');
            
            inputs.forEach(input => {
                // Ajouter une classe quand l'input est rempli
                input.addEventListener('blur', function() {
                    if (this.value) {
                        this.classList.add('has-value');
                    } else {
                        this.classList.remove('has-value');
                    }
                });
                
                // Pré-remplir la classe si l'input a déjà une valeur
                if (input.value) {
                    input.classList.add('has-value');
                }
            });
        });
    </script>
</body>
</html>