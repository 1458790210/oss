<?php

namespace Cloud\Oss\driver;

use Qcloud\Cos\Client;
use Qcloud\Cos\Exception\ServiceResponseException;
use Cloud\Oss\AbsObjectStorage;
use Cloud\Oss\ObjectStorageException;

/**
 * 腾讯云
 *
 * @package Cloud\Oss\driver
 */
class Qcloud extends AbsObjectStorage
{

    /**
     * @var \Qcloud\Cos\Client
     */
    private $client;

    /**
     * Qcloud constructor.
     *
     * @param array $config
     * @throws \Cloud\Oss\ObjectStorageException
     */
    public function __construct(array $config)
    {
        parent::__construct($config);

        $this->client = new Client([
            'region'      => isset($config['region']) ? $config['region'] : 'ap-beijing',
            'schema'      => isset($config['schema']) ? $config['schema'] : 'https', //协议头部，默认为http
            'credentials' => [
                'secretId'  => $config['CLOUD_ACCESS_KEY'],
                'secretKey' => $config['CLOUD_ACCESS_KEY'],
            ],
        ]);
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
            return $this->client->putObject([
                'Bucket' => $this->config['bucket'],
                'Key'    => $key,
                'Body'   => fopen($localFile, 'rb'),
            ]);
        } catch (ServiceResponseException $e) {
            throw new ObjectStorageException($e->getMessage(), $e->getCode());
        }
    }

    /**
     * 上传数据
     *
     * @param mixed $data
     * @param string $key
     * @param array $policy
     * @return array
     * @throws \Cloud\Oss\ObjectStorageException
     */
    public function uploadData($key, $data, $policy = null)
    {
        try {
            return $this->client->putObject([
                'Bucket' => $this->config['bucket'],
                'Key'    => $key,
                'Body'   => $data,
            ]);
        } catch (ServiceResponseException $e) {
            throw new ObjectStorageException($e->getMessage(), $e->getCode());
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
            $this->client->copyObject([
                'Bucket'     => $this->config['bucket'],
                'Key'        => $newKey,
                'CopySource' => $oldKey,
                /*
                'MetadataDirective' => 'string',
                'ACL' => 'string',
                'CacheControl' => 'string',
                'ContentDisposition' => 'string',
                'ContentEncoding' => 'string',
                'ContentLanguage' => 'string',
                'ContentLength' => integer,
                'ContentType' => 'string',
                'Expires' => 'string',
                'GrantFullControl' => 'string',
                'GrantRead' => 'string',
                'GrantWrite' => 'string',
                'Metadata' => array(
                'string' => 'string',
                ),
                'ContentMD5' => 'string',
                'ServerSideEncryption' => 'string',
                'StorageClass' => 'string'
                */
            ]);

            $this->client->deleteObject([
                'Bucket' => $this->config['bucket'],
                'Key'    => $oldKey,
            ]);
        } catch (ServiceResponseException $e) {
            throw new ObjectStorageException($e->getMessage(), $e->getCode());
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
            $this->client->deleteObject([
                'Bucket' => $this->config['bucket'],
                'Key'    => $key,
            ]);
        } catch (ServiceResponseException $e) {
            throw new ObjectStorageException($e->getMessage(), $e->getCode());
        }
    }

    /**
     * 获取私有文件下载链接
     *
     * @param string $baseUrl
     * @param int $expires
     * @return string
     */
    public function getPrivateFileUrl($baseUrl, $expires = 3600)
    {
        // TODO: Implement getPrivateFileUrl() method.
        return $baseUrl;
    }

    /**
     * 获取文件列表
     *
     * @param string $prefix
     * @param string $marker
     * @param int $limit
     * @param string $delimiter
     * @return array
     * @throws \Cloud\Oss\ObjectStorageException
     */
    public function getFileList($prefix = null, $marker = null, $limit = 100, $delimiter = null)
    {
        try {
            return $this->client->listObjects([
                'Bucket'    => $this->config['bucket'],
                'Prefix'    => $prefix,
                'Marker'    => $marker,
                'MaxKeys'   => $limit,
                'Delimiter' => $delimiter,
            ]);
        } catch (ServiceResponseException $e) {
            throw new ObjectStorageException($e->getMessage(), $e->getCode());
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
            return $this->client->headObject([
                'Bucket' => $this->config['bucket'],
                'Key'    => $key,
            ]);
        } catch (ServiceResponseException $e) {
            throw new ObjectStorageException($e->getMessage(), $e->getCode());
        }
    }
}
