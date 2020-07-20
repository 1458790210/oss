<?php

namespace Cloud\Oss\Facades;

use Illuminate\Support\Facades\Facade;

class CloudOss extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'cloud_oss';
    }
}