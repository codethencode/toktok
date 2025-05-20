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

<p>Nous vous confirmons la bonne réception de vos informations</p>
<p>Nous allons à présent traiter votre dossier et l'expédier.<br><br>Numéro de commande : <b>{{ $orderId }}</b></p>
{{--<x-order-summary :orderId="$orderId" />--}}
<p>Vous serez informé dès son expédition effectuée<br>
    <a href="#">https://coursierjuridique.com/login</a></p>
Bien cordialement,
<a href="#">https://coursierjuridique.com</a>

