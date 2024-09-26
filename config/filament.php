<?php

return [
    'path' => 'admin',
    'middleware' => [
        'web',
        'auth',
        'admin', // Pastikan middleware admin sudah terdaftar
    ],
    'navigation' => [
        'labels' => [
            'dashboard' => 'Dashboard',
            'users' => 'Users',
        ],
    ],
];
