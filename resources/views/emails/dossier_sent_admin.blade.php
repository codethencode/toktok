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

<p>Un client vient de valider son dossier ID : <b>{{ $orderId }}</b></p>
<p>Il faut à présent traiter et expédier le dossier</p>
{{--<x-order-summary :orderId="$orderId" />--}}
<p>
<a href="#">https://coursierjuridique.com/login</a></p>
Bien cordialement,
<a href="#">https://coursierjuridique.com</a>

