<?php
/**
 * Created by PhpStorm.
 * User: ChenRan
 * Date: 2020/5/21
 * Time: 15:29
 */

namespace Cloud\Oss;

use Illuminate\Config\Repository;

class CloudOss
{
    protected $config;

    /**
     * 构造方法
     */
    public function __construct(Repository $config)
    {
        $this->config = $config->get('cloud_oss');
    }

    public function output()
    {
        dd($this->config);
    }
}