<?php

return [
    'driver'     => env('UPLOAD_DRIVER'),
    'access_key' => env('CLOUD_ACCESS_KEY'),
    'secret_key' => env('CLOUD_SECRET_KEY'),
    'bucket'     => env('CLOUD_BUCKET'),
    'domain'     => env('CLOUD_DOMAIN'),
    'endpoint'   => env('CLOUD_ENDPOINT'),
];
