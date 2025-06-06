<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Réinitialisation de dossier</title>
</head>
<body>
    <p>Bonjour {{ $user->name }},</p>

    <p>Votre dossier référencé sous la commande <strong>{{ $order->order_id }}</strong> a été réinitialisé.</p>

    <p>Vous pouvez dès à présent y accéder à nouveau pour compléter ou modifier les fichiers nécessaires.</p>

    <p>Merci de votre confiance,</p>
    <p>L'équipe toquetoque.net</p>
    <a href="https://toquetoque.net">https://toquetoque.net</a>
</body>
</html>