<div>
    <!-- It is never too late to be what you might have been. - George Eliot -->
    <div class="order-summary">
        @if($basket)
{{--            <p>Total Price: {{ $basket->total_price }}</p>--}}
{{--            <p>City Code: {{ $basket->cityCode }}</p>--}}
{{--            <p>City Code Price: {{ $basket->cityCodePrice }}</p>--}}
{{--            <p>Base Fee Price: {{ $basket->baseFeePrice }}</p>--}}
{{--            <p>Number of Pages: {{ $basket->numberOfPages }}</p>--}}
{{--            <p>Print Type: {{ $basket->printType }}</p>--}}
{{--            <p>Print Type Price: {{ $basket->printTypePrice }}</p>--}}
{{--            <p>Reliure Type: {{ $basket->reliureType }}</p>--}}
{{--            <p>Is Abo: {{ $basket->isAbo }}</p>--}}
{{--            <p>Abo Price: {{ $basket->aboPrice }}</p>--}}
{{--            <p>plaideType = {{ $basket->plaideType }}</p>--}}
{{--            <p>plaideTypePrice = {{ $basket->plaideTypePrice }}</p>--}}
{{--            <p>isUrgent = {{ $basket->isUrgent }}</p>--}}
{{--            <p>urgentPrice = {{ $basket->urgentPrice }}</p>--}}
{{--            <p>hasDiscount = {{ $basket->hasDiscount }}</p>--}}
{{--            <p>discountRebate = {{ $basket->discountRebate }}</p>--}}
{{--            <p>isPaid = {{ $basket->isPaid }}</p>--}}
{{--            <p>sendMail = {{ $basket->sendMail }}</p>--}}


            @php
                    $resumeContent = "";

                    $resumeContent .= "Montant Total de votre commande : <b>".$basket->total_price." € TTC</b><br><br>";
                    $resumeContent .= "----------------"."<br>";
                    $resumeContent .= "Détail de votre commande<br>";
                    $resumeContent .= "----------------"."<br><br>";

                    //FRAIS DE CONSTITUTION DE VOTRE DOSSIER

                    $resumeFees = "Frais de constitution de votre dossier incluant l'expédition";
                    $resumeFees.= "de votre dossier vers le tribunal : <b>".$basket->baseFeePrice." € HT</b><br><br>";

                    //FRAIS Impression

                    $resumePrint = "Frais d'impression<br>----------------<br>";
                    $resumePrint .= "Nombre de pages : <b>".$basket->numberOfPages."</b><br>";
                    $resumePrint .= "Type d'impression : <b>".$basket->impression->libelle."</b><br>";
                    $resumePrint .= "Prix à la page : <b>".$basket->printTypePrice." € HT</b><br>";
                    $resumePrint .= "Type de reliure : <b>".$basket->reliure->libelle." - ".$basket->reliureTypePrice." € HT</b><br><br>";

                   //PLAIDOIRIE

                   if($basket->plaideType === 'RepDevis')  {
                       $resumePlaide = "<b>Type de plaidoirie sur Devis (nous contacter)</b>";
                   }
                   elseif ($basket->plaideType === 'DontKnow')
                   {
                       $resumePlaide = "<b>Vous n'avez pas encore décidé si vous désirez nous confier la plaidoirie</b>";
                   }
                   else {
                       $resumePlaide = "Type de plaidoirie : <b>".$basket->plaidoirie->libelle."</b><br>";
                       $resumePlaide .= "Zone géographique de représentation : <b>".$basket->zoneGeo->code." - ".$basket->zoneGeo->name."</b><br>";
                       $resumePlaide .= "Détail de la prestation de plaidoirie : <b>".$basket->plaidoirie->description."</b><br>";
                       $resumePlaide .= "Prix de la prestation : <b>". $basket->plaidoirie->price." € HT</b><br>";
                   }

                   // ABONNEMENT MENSUEL
                    if ($basket->isAbo === 'abo') {
                       $resumeAbo = "Vous avez choisi de vous abonner mensuellement et bénéficiez de 15% de remise sur l'ensemble de nos prestations pour un montant de : <b>".$basket->aboPrice." € HT / mois</b>";
                   } else {
                       $resumeAbo = "Abonnement mensuel : <b>Non Abonné</b>";
                       // (L'abonnement mensuel vous donne droit à 15% de remise sur l'ensemble de nos prestations)
                   }

                    $resumeContent .= $resumeFees;
                    $resumeContent .= $resumePrint;
                    $resumeContent .= $resumePlaide;
                    $resumeContent .= $resumeAbo;

            @endphp

            {!! $resumeContent !!}

        @else
            <p>No order found.</p>
        @endif
    </div>
</div>

