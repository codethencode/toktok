<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Facture #{{ $basket->order_id }}</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            color: #333;
            margin: 40px;
        }

        .header {
        display: flex;
        justify-content: space-between;
        margin-bottom: 40px;
    }

    .header .client-block {
        width: 50%;
    }

    .header .company-block {
        width: 40%;
        margin-left: auto;
        text-align: right;
    }

        .header h2 {
            margin-bottom: 5px;
            font-size: 14px;
            font-weight: bold;
        }

        .header p {
            margin: 2px 0;
        }

        h1 {
            font-size: 22px;
            margin-bottom: 20px;
        }

        .container {
            max-width: 700px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ddd;
            background-color: #fff;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        td, th {
            border: 1px solid #ddd;
            padding: 10px;
            vertical-align: top;
        }

        .text-right {
            text-align: right;
        }

        .font-bold {
            font-weight: bold;
        }

        .text-gray {
            color: #777;
        }

        .total-row {
            background-color: #f3f3f3;
        }

        .text-lg {
            font-size: 16px;
        }

        .mb-2 {
            margin-bottom: 8px;
        }

        .italic {
            font-style: italic;
        }
    </style>
</head>
<body>
    <div class="container">

        <!-- En-tête -->
        <div class="header">
            <div class="client-block">
                <h2>Client</h2>
                <p>{{ $company->name ?? 'Nom du client' }}</p>
                <p>{{ $company->adresse ?? 'Adresse du client' }}</p>
                <p>{{ $company->code_postal ?? '' }} {{ $company->ville ?? '' }}</p>
                <p>{{ $company->email ?? '' }} - Tél. {{ $company->telephone ?? '' }}</p>
            </div>
        
            <div class="company-block">
                <h2>Entreprise</h2>
                <p>{{ $companyName ?? 'Nom de l\'entreprise' }}</p>
                <p>{{ $companyAddress ?? 'Adresse de l\'entreprise' }}</p>
                <p>{{ $companyZip ?? '' }} {{ $companyCity ?? '' }}</p>
                <p>{{ $companyCountry ?? 'France' }}</p>
            </div>
        </div>

        <!-- Titre -->
        <h1>Facture – Commande #{{ $basket->order_id }}</h1>

        <!-- Tableau de la commande -->
        <table>
            <tbody>
                <tr>
                    <td class="font-bold">Frais de mise en service</td>
                    <td class="text-right">{{ number_format($basket->baseFeePrice, 2) }} €</td>
                </tr>
                <tr>
                    <td class="font-bold">Nombre de pages</td>
                    <td class="text-right">{{ $basket->numberOfPages }}</td>
                </tr>
                <tr>
                    <td class="font-bold">Type d'impression</td>
                    <td class="text-right">
                        {{ $typeImpression->label ?? 'N/A' }} ({{ number_format($typeImpression->price ?? 0, 2) }} € x {{ $basket->numberOfPages }})<br>
                        = {{ number_format($basket->numberOfPages * ($typeImpression->price ?? 0), 2) }} €
                    </td>
                </tr>
                <tr>
                    <td class="font-bold">Type de reliure</td>
                    <td class="text-right">{{ $typeReliure->label ?? 'N/A' }} - {{ number_format($typeReliure->price ?? 0, 2) }} €</td>
                </tr>
                <tr>
                    <td class="font-bold">Plaidoirie</td>
                    <td class="text-right">
                        <div class="font-bold mb-2">{{ $plaidoirie->label ?? 'N/A' }} - {{ number_format($plaidoirie->price ?? 0, 2) }} €</div>
                        <div class="text-gray italic">{{ $plaidoirie->description ?? '' }}</div>
                    </td>
                </tr>
                <tr>
                    <td class="font-bold">Juridiction</td>
                    <td class="text-right">
                        <div class="font-bold mb-2">{{ $juridiction->label ?? 'N/A' }} - {{ number_format($juridiction->price ?? 0, 2) }} €</div>
                        <div class="text-gray italic">{{ $juridiction->description ?? '' }}</div>
                    </td>
                </tr>
                <tr>
                    <td class="font-bold">Zone géographique</td>
                    <td class="text-right">{{ $zoneGeo->label ?? 'N/A' }} - {{ number_format($zoneGeo->price ?? 0, 2) }} €</td>
                </tr>
                <tr>
                    <td class="font-bold">Option urgence</td>
                    <td class="text-right">
                        {{ $basket->isUrgent === 'true' ? 'Oui' : 'Non' }}
                        @if($basket->urgentPrice > 0)
                            - {{ number_format($basket->urgentPrice ?? 0, 2) }} €
                        @endif
                    </td>
                </tr>
                <tr class="total-row text-lg font-bold">
                    <td>Total</td>
                   
                    <td class="text-right">
                        <small class="text-gray">{{ number_format($basket->total_price / 1.2, 2) }} €<br>
                        Dont TVA : {{ number_format(($basket->total_price) - ($basket->total_price / 1.2), 2) }} €</small><br>
                        soit {{ number_format($basket->total_price, 2) }} € TTC
                    </td>
                   
                </tr>
            </tbody>
        </table>
    </div>
</body>
</html>
