<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Expédition de votre commande</title>
</head>

<body>
<p>Bonjour,</p>

<p>Votre commande <strong>{{ $basket->order_id }}</strong> a bien été expédiée.</p>

@if($data['carrier'] ?? null)
<p><strong>Transporteur :</strong> {{ $data['carrier'] }}</p>
@endif

@if($data['tracking_number'] ?? null)
<p><strong>Numéro de suivi :</strong> {{ $data['tracking_number'] }}</p>
@endif

@if(!empty($data['proof_path']))
<p>Une preuve de dépôt est jointe à cet email.</p>
@endif

@if(empty($data['carrier']) && empty($data['tracking_number']) && empty($data['proof_path']))
<p>Cette notification confirme simplement que votre dossier a été déposé.</p>
@endif

<p>Cordialement,<br>L'équipe</p>
<a href="https://toquetoque.net">https://toquetoque.net</a>

</body>
</html>