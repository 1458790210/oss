<?php

return [
    'driver'           => env('UPLOAD_DRIVER'),
    'CLOUD_ACCESS_KEY' => env('CLOUD_ACCESS_KEY'),
    'CLOUD_SECRET_KEY' => env('CLOUD_SECRET_KEY'),
    'bucket'           => env('CLOUD_BUCKET'),
    'domain'           => env('CLOUD_DOMAIN'),
    'endpoint'         => 'http://oss-cn-beijing.aliyuncs.com',
];
