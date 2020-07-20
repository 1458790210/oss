<?php

namespace Cloud\Oss\driver;

use OSS\Core\OssException;
use OSS\OssClient;
use Cloud\oss\AbsObjectStorage;
use Cloud\oss\ObjectStorageException;

/**
 * 阿里云
 *
 * @package Cloud\Oss\driver
 */
class Aliyun extends AbsObjectStorage
{

    /**
     * @var \OSS\OssClient
     */
    private $client;

    /**
     * Aliyun constructor.
     *
     * @param array $config
     * @throws \Cloud\Oss\ObjectStorageException
     */
    public function __construct(array $config)
    {
        parent::__construct($config);

        try {
            $this->client = new OssClient(
                $config['CLOUD_ACCESS_KEY'],
                $config['CLOUD_SECRET_KEY'],
                isset($config['endpoint']) ? $config['endpoint'] : 'http://oss-cn-hangzhou.aliyuncs.com'
            );
        } catch (OssException $e) {
            throw new ObjectStorageException($e->getErrorMessage(), $e->getErrorCode());
        }
    }

    /**
     * 上传文件
     *
     * @param string $key
     * @param string $localFile
     * @param array $policy
     * @return array
     * @throws \Cloud\Oss\ObjectStorageException
     */
    public function uploadFile($key, $localFile, $policy = null)
    {
        try {
            $result = $this->client->uploadFile(
                $this->config['bucket'],
                $key,
                $localFile
            );

            $result = array_merge($result, $result['info']);
            unset($result['info']);

            return $result;
        } catch (OssException $e) {
            throw new ObjectStorageException($e->getErrorMessage(), $e->getErrorCode());
        }
    }

    /**
     * 上传数据
     *
     * @param string $key
     * @param mixed $data
     * @param array $policy
     * @return array
     * @throws \Cloud\Oss\ObjectStorageException
     */
    public function uploadData($key, $data, $policy = null)
    {
        try {
            $result = $this->client->putObject(
                $this->config['bucket'],
                $key,
                $data
            );

            $result = array_merge($result, $result['info']);
            unset($result['info']);

            return $result;
        } catch (OssException $e) {
            throw new ObjectStorageException($e->getErrorMessage(), $e->getErrorCode());
        }
    }

    /**
     * 移动／重命名文件
     *
     * @param string $oldKey
     * @param string $newKey
     * @throws \Cloud\Oss\ObjectStorageException
     */
    public function renameFile($oldKey, $newKey)
    {
        try {
            $bucket = $this->config['bucket'];
            $this->client->copyObject(
                $bucket,
                $oldKey,
                $bucket,
                $newKey
            );
            $this->client->deleteObject(
                $bucket,
                $oldKey
            );
        } catch (OssException $e) {
            throw new ObjectStorageException($e->getErrorMessage(), $e->getErrorCode());
        }
    }

    /**
     * 删除文件
     *
     * @param string $key
     * @throws \Cloud\Oss\ObjectStorageException
     */
    public function deleteFile($key)
    {
        try {
            $this->client->deleteObject(
                $this->config['bucket'],
                $key
            );
        } catch (OssException $e) {
            throw new ObjectStorageException($e->getErrorMessage(), $e->getErrorCode());
        }
    }

    /**
     * 获取私有文件下载链接
     *
     * @param string $baseUrl
     * @param int $expires
     * @return string
     * @throws \Cloud\Oss\ObjectStorageException
     */
    public function getPrivateFileUrl($baseUrl, $expires = 3600)
    {
        try {
            return $this->client->signUrl(
                $this->config['bucket'],
                $baseUrl,
                $expires
            );
        } catch (OssException $e) {
            throw new ObjectStorageException($e->getErrorMessage(), $e->getErrorCode());
        }
    }

    /**
     * 获取文件列表
     *
     * @param string $prefix
     * @param string $marker
     * @param int $limit
     * @param string $delimiter
     * @return mixed
     * @throws \Cloud\Oss\ObjectStorageException
     */
    public function getFileList($prefix = null, $marker = null, $limit = 100, $delimiter = null)
    {
        try {
            $options = [
                'delimiter' => $delimiter,
                'prefix'    => $prefix,
                'max-keys'  => $limit,
                'marker'    => $marker,
            ];
            $listObjectInfo = $this->client->listObjects(
                $this->config['bucket'],
                $options
            );
            return $listObjectInfo->getObjectList();
        } catch (OssException $e) {
            throw new ObjectStorageException($e->getErrorMessage(), $e->getErrorCode());
        }
    }

    /**
     * 获取文件信息
     *
     * @param string $key
     * @return array
     * @throws \Cloud\Oss\ObjectStorageException
     */
    public function getFileInfo($key)
    {
        try {
            return $this->client->getObjectMeta(
                $this->config['bucket'],
                $key
            );
        } catch (OssException $e) {
            throw new ObjectStorageException($e->getErrorMessage(), $e->getErrorCode());
        }
    }
}
