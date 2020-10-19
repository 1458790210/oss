<?php

namespace Cloud\Oss;

/**
 * 云存储
 *
 * @package Cloud\oss
 */
abstract class AbsCloudOss implements CloudOssInterface
{

    /**
     * 配置信息
     *
     * @var array
     */
    protected $config = [];

    /**
     * AbsCloudOss constructor.
     *
     * @param array $config
     * @throws CloudOssException
     */
    public function __construct(array $config)
    {
        if (!isset($config['access_key']) || empty($config['access_key'])) {
            throw new CloudOssException('access_key 必须填写！');
        }

        if (!isset($config['secret_key']) || empty($config['secret_key'])) {
            throw new CloudOssException('secret_key 必须填写！');
        }

        if (!isset($config['bucket']) || empty($config['bucket'])) {
            throw new CloudOssException('bucket 必须填写！');
        }

        $this->config = $config;
    }

    /**
     * 获取配置
     *
     * @return array
     */
    public function getConfig()
    {
        return $this->config;
    }

}
