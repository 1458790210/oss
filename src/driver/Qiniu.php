<?php

namespace Cloud\Oss\driver;

use Qiniu\Auth;
use Qiniu\Config;
use Qiniu\Storage\BucketManager;
use Qiniu\Storage\UploadManager;
use Cloud\Oss\AbsCloudOss;
use Cloud\Oss\CloudOssException;

/**
 * 七牛云
 * @link https://developer.qiniu.com/kodo/sdk/1241/php#4
 */
class Qiniu extends AbsCloudOss
{

    /**
     * @var \Qiniu\Auth
     */
    private $auth;

    /**
     * @var \Qiniu\Storage\UploadManager
     */
    private $uploadManager;

    /**
     * @var \Qiniu\Storage\BucketManager
     */
    private $bucketManager;

    /**
     * Qiniu constructor.
     *
     * @param array $config
     * @throws \Cloud\Oss\CloudOssException
     */
    public function __construct(array $config)
    {
        parent::__construct($config);

        // todo 优化处理
        $qiniuConfig = new Config();

        // 初始化签权对象
        $this->auth = new Auth($config['access_key'], $config['secret_key']);

        // 初始化上传管理器
        $this->uploadManager = new UploadManager();

        // 初始化资源管理器
        $this->bucketManager = new BucketManager($this->auth, $qiniuConfig);
    }

    /**
     * 获取上传 token
     *
     * @param string $key
     * @param int $expires
     * @param array $policy
     * @param bool $strictPolicy
     * @return string
     */
    public function getUploadToken($key = null, $expires = 3600, $policy = null, $strictPolicy = true)
    {
        return $this->auth->uploadToken($this->config['bucket'], $key, $expires, $policy, $strictPolicy);
    }

    /**
     * 上传文件
     *
     * @param string $key
     * @param string $localFile
     * @param array $policy
     * @return array
     * @throws \Cloud\Oss\CloudOssException
     * @throws \Exception
     */
    public function uploadFile($key, $localFile, $policy = null)
    {
        $token = $this->getUploadToken(null, 3600, $policy);

        // 调用 UploadManager 的 putFile 方法进行文件的上传。
        list($ret, $err) = $this->uploadManager->putFile($token, $key, $localFile);

        if ($err !== null) {
            throw new CloudOssException($err);
        }

        return $ret;
    }

    /**
     * 上传数据
     *
     * @param string $key
     * @param mixed $data
     * @param array $policy
     * @return array
     * @throws \Cloud\Oss\CloudOssException
     */
    public function uploadData($key, $data, $policy = null)
    {
        $token = $this->getUploadToken(null, 3600, $policy);

        /** @var $err \Qiniu\Http\Error */
        list($ret, $err) = $this->uploadManager->put($token, $key, $data);

        if ($err !== null) {
            throw new CloudOssException(
                $err->getResponse()->error,
                $err->getResponse()->statusCode
            );
        }

        return $ret;
    }

    /**
     * 移动／重命名文件
     *
     * @param string $oldKey
     * @param string $newKey
     * @param bool $force
     * @throws \Cloud\Oss\CloudOssException
     */
    public function renameFile($oldKey, $newKey, $force = true)
    {
        $bucket = $this->config['bucket'];

        /** @var $err \Qiniu\Http\Error */
        $err = $this->bucketManager->move($bucket, $oldKey, $bucket, $newKey, $force);

        if ($err !== null) {
            throw new CloudOssException(
                $err->getResponse()->error,
                $err->getResponse()->statusCode
            );
        }
    }

    /**
     * 删除文件
     *
     * @param string $key
     * @throws \Cloud\Oss\CloudOssException
     */
    public function deleteFile($key)
    {
        /** @var $err \Qiniu\Http\Error */
        $err = $this->bucketManager->delete($this->config['bucket'], $key);

        if ($err !== null) {
            throw new CloudOssException(
                $err->getResponse()->error,
                $err->getResponse()->statusCode
            );
        }
    }

    /**
     * 获取文件信息
     *
     * @param string $key
     * @return array
     * @throws \Cloud\Oss\CloudOssException
     */
    public function getFileInfo($key)
    {
        /** @var $err \Qiniu\Http\Error */
        list($fileInfo, $err) = $this->bucketManager->stat($this->config['bucket'], $key);

        if ($err !== null) {
            throw new CloudOssException(
                $err->getResponse()->error,
                $err->getResponse()->statusCode
            );
        }

        return $fileInfo;
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
        return $this->auth->privateDownloadUrl($baseUrl, $expires = 3600);
    }

    /**
     * 获取文件列表
     *
     * @param string $prefix
     * @param string $marker
     * @param int $limit
     * @param string $delimiter
     * @return mixed
     * @throws \Cloud\Oss\CloudOssException
     */
    public function getFileList($prefix = null, $marker = null, $limit = 100, $delimiter = null)
    {
        /** @var $err \Qiniu\Http\Error */
        list($ret, $err) = $this->bucketManager->listFiles($this->config['bucket'], $prefix, $marker, $limit,
            $delimiter);

        if ($err !== null) {
            throw new CloudOssException(
                $err->getResponse()->error,
                $err->getResponse()->statusCode
            );
        }

        return $ret;
    }
}
