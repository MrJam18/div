<?php
return [
    'adminEmail' => 'admin@example.com',
    'jwt' => [
        'issuer' => 'https://test.com',  //name of your project (for information only)
        'audience' => 'https://frontend.example.com',  //description of the audience, eg. the website using the authentication (for info only)
        'id' => 'UNIQUE-JWT-IDENTIFIER',  //a unique identifier for the JWT, typically a random string
        'expire' => 86400,  //the short-lived JWT token is here set to expire after 5 min.
    ],
];
