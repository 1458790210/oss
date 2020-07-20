<?php

namespace Cloud\Oss;

use Illuminate\Support\ServiceProvider;

class CloudOssProvider extends ServiceProvider
{
    /**
     * @return void
     */
    public function boot()
    {
        // 发布配置文件
        $this->publishes([
            __DIR__ . '/config/cloud_oss.php' => config_path('cloud_oss.php'),
        ]);
    }

    /**
     * @return void
     */
    public function register()
    {
        $this->app->singleton('cloud_oss', function ($app) {
            return new CloudOss($app['config']);
        });
    }
}