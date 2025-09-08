<?php

return [

    'custom' => [
        'date_audience' => [
            'required' => 'La date et l\'heure de l’audience sont obligatoires.',
            'date_format' => 'Le format de la date est invalide.',
        ],
        'name' => [
            'required' => 'Le nom est obligatoire.',
        ],
        // etc.
    ],

    'attributes' => [
        'date_audience' => 'date de l’audience',
        'name' => 'nom',
        'adresse' => 'adresse',
        'code_postal' => 'code postal',
        'ville' => 'ville',
        'parties_representees' => 'parties représentées',
    ],

];