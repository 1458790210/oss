<?php

namespace Cloud\Oss;

/**
 * 云存储
 *
 * @package Cloud\oss
 */
abstract class AbsObjectStorage implements ObjectStorageInterface
{

    /**
     * 配置信息
     *
     * @var array
     */
    protected $config = [];

    /**
     * AbsObjectStorage constructor.
     *
     * @param array $config
     * @throws ObjectStorageException
     */
    public function __construct(array $config)
    {
        if (!isset($config['CLOUD_ACCESS_KEY']) || empty($config['CLOUD_ACCESS_KEY'])) {
            throw new ObjectStorageException('CLOUD_ACCESS_KEY 必须填写！');
        }

        if (!isset($config['CLOUD_SECRET_KEY']) || empty($config['CLOUD_SECRET_KEY'])) {
            throw new ObjectStorageException('CLOUD_SECRET_KEY 必须填写！');
        }

        if (!isset($config['bucket']) || empty($config['bucket'])) {
            throw new ObjectStorageException('bucket 必须填写！');
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
