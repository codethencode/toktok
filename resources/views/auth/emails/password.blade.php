<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Réinitialisation de votre mot de passe</title>
</head>
<body>
<h1>Réinitialisation de votre mot de passe</h1>
<p>Bonjour,</p>
<p>Vous avez demandé à réinitialiser votre mot de passe. Cliquez sur le lien ci-dessous pour créer un nouveau mot de passe :</p>
<p>
    <a href="{{ $resetLink }}">
        Réinitialiser mon mot de passe
    </a>
</p>
<p>Si vous n'avez pas demandé de réinitialisation de mot de passe, ignorez cet email.</p>
<p>Merci,</p>
<p>L'équipe {{ config('app.name') }}</p>
</body>
</html>
