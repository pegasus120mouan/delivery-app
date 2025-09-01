<!DOCTYPE html>
<html>
<head>
    <title>Vérification de votre boutique</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .pin-code {
            background-color: #f8f9fa;
            border: 2px solid #4a5568;
            border-radius: 8px;
            padding: 15px;
            text-align: center;
            font-size: 24px;
            font-weight: bold;
            color: #4a5568;
            margin: 20px 0;
        }
        .verification-link {
            background-color: #4a5568;
            color: white;
            padding: 12px 24px;
            text-decoration: none;
            border-radius: 8px;
            display: inline-block;
            margin: 15px 0;
        }
        .warning {
            background-color: #fff3cd;
            border: 1px solid #ffeaa7;
            border-radius: 8px;
            padding: 10px;
            margin: 15px 0;
        }
    </style>
</head>
<body>
    <h1>Bonjour,</h1>
    
    <p>Merci d'avoir enregistré votre boutique sur notre plateforme <strong>Delivery App</strong>.</p>
    
    <p>Veuillez utiliser le code PIN suivant pour vérifier votre adresse e-mail et activer votre compte :</p>
    
    <div class="pin-code">
        🔑 Code PIN : {{ $pinCode }}
    </div>
    
    <p>Vous pouvez vérifier votre compte en cliquant sur le lien ci-dessous et en saisissant votre code PIN :</p>
    <a href="{{ $verificationUrl }}" target="_blank" class="verification-link">{{ $verificationUrl }}</a>
    
    <div class="warning">
        ⚠️ Ce code expirera dans 1 heure.
    </div>
    
    <p>Si vous n'avez pas créé de compte, vous pouvez ignorer ce message.</p>
    
    <p>Merci,<br>
    <strong>L'équipe Delivery App</strong></p>
</body>
</html>
