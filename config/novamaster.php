<?php

return [

    "resources" => [

        \Tsung\NovaMaster\Nova\Address::class,
        \Tsung\NovaMaster\Nova\Bank::class,
        \Tsung\NovaMaster\Nova\Company::class,
        \Tsung\NovaMaster\Nova\Configuration::class,
        \Tsung\NovaMaster\Nova\Note::class,
        \Tsung\NovaMaster\Nova\Phone::class,
        \Tsung\NovaMaster\Nova\Unit::class,
        \Tsung\NovaMaster\Nova\Document::class,

    ],

    "document" => [

        "morph" => [
            \App\Nova\HumanResource\Person::class,
            \App\Nova\HumanResource\Employee::class,
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
            \App\Nova\HumanResource\Person::class,
            \App\Nova\HumanResource\Employee::class,
        ],
    ],

    'phone' => [

        'morph' => [
            \App\Nova\HumanResource\Person::class,
            \Tsung\NovaMaster\Nova\Company::class,
        ],
    ],

];
