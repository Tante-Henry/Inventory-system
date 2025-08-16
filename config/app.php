<?php
return [
    'env' => 'development',
    'db' => [
        'host' => 'localhost',
        'database' => 'inventory',
        'username' => 'root',
        'password' => '',
    ],
    'jwt' => [
        'secret' => 'your_jwt_secret_here',
        'alg' => 'HS256',
        'issuer' => 'inventory-system',
        'audience' => 'inventory-system-users',
        'ttl' => 3600
    ]
];
