<?php

return [
    'drivers' => [
        'pasargad' => [
            'merchantSheba' => env('PASARGAD_SHEBA', '12123456987546321584765324'),
            'shebaPattern' => '/^(12)[0-9]{22}$/',
        ],

        // 'mellat' => [
        //     'merchantSheba' => env('MELLAT_SHEABA', '14123456987546321584765324'),
        //     'shebaPattern' => '/^(14)[0-9]{22}$/',
        // ],

        // 'saman' => [
        //     'merchantSheba' => env('SAMAN_SHEBA', '16123456987546321584765324'),
        //     'shebaPattern' => '/^(16)[0-9]{22}$/',
        // ],
    ],
];
