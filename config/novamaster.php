<?php

return [

    "resources" => [

        \Tsung\NovaMaster\Nova\Address::class,
        \Tsung\NovaMaster\Nova\Bank::class,
        \Tsung\NovaMaster\Nova\Company::class,
        \Tsung\NovaMaster\Nova\Configuration::class,
        \Tsung\NovaMaster\Nova\Document::class,
        \Tsung\NovaMaster\Nova\Holiday::class,
        \Tsung\NovaMaster\Nova\Note::class,
        \Tsung\NovaMaster\Nova\Phone::class,
        \Tsung\NovaMaster\Nova\Unit::class,

    ],

    "document" => [

        "morph" => [
            \Tsung\NovaHumanResource\Nova\Person::class,
            \Tsung\NovaHumanResource\Nova\Employee::class,
        ],

        'accepted_type' => [
            'image/apng',
            'image/bmp',
            'image/x-ms-bmp',
            'image/gif',
            'image/x-icon',
            'image/jpeg',
            'image/png',
            'image/svg+xml',
            'image/tiff',
            'image/webp',
            //'application/pdf',
        ],
    ],

    'note' => [

        'morph' => [
            \Tsung\NovaHumanResource\Nova\Person::class,
            \Tsung\NovaHumanResource\Nova\Employee::class,
        ],
    ],

    'phone' => [

        'morph' => [
            \Tsung\NovaHumanResource\Nova\Person::class,
            \Tsung\NovaHumanResource\Nova\Employee::class,
        ],

        'types' => [
            1 => 'HOME',
            2 => 'OFFICE',
            3 => 'MOBILE',
        ],
    ],

    'bank' => [

        'morph' => [
            \Tsung\NovaHumanResource\Nova\Person::class,
        ],
    ],

    'address' => [

        'morph' => [
            \Tsung\NovaHumanResource\Nova\Person::class,
        ],

        'types' => [
            1 => 'HOME',
            2 => 'OFFICE',
            3 => 'BRANCH',
        ]
    ],

];
