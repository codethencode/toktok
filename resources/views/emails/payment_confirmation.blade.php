@php
// Obtenir l'heure actuelle sous forme de nombre entier (0-23)
$currentHour = (int) date('H');

// Afficher "Bonjour" si l'heure est entre 6h et 17h, sinon "Bonsoir"
if ($currentHour >= 6 && $currentHour < 17) {
    echo "<p>Bonjour,</p>";
} else {
    echo "<p>Bonsoir,</p>";
}
@endphp

<p>Nous vous remercions pour votre confiance !</p>
<p>Vous trouverez ci dessous les informations de votre commande.<br><br>Numéro de commande : <b>{{ $orderId }}</b></p>
<x-order-summary :orderId="$orderId" />
<p>Afin de nous transmettre votre dossier, veuiller vous connecter sur notre interface :<br>
<a href="#">https://coursierjuridique.com/login</a></p>
Bien cordialement,
<a href="#">https://coursierjuridique.com</a>

