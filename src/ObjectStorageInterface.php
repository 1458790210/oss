<?php

namespace Cloud\Oss;

/**
 * Interface ObjectStorageInterface
 *
 * @package Cloud\Oss
 */
interface ObjectStorageInterface
{

    /**
     * 上传文件
     *
     * @param string $localFile
     * @param string $key
     * @param array $policy
     * @return array
     * @throws \Cloud\Oss\ObjectStorageException
     */
    public function uploadFile($key, $localFile, $policy = null);

    /**
     * 上传数据
     *
     * @param mixed $data
     * @param string $key
     * @param array $policy
     * @return array
     * @throws \Cloud\Oss\ObjectStorageException
     */
    public function uploadData($key, $data, $policy = null);

    /**
     * 移动／重命名文件
     *
     * @param string $oldKey
     * @param string $newKey
     * @throws \Cloud\Oss\ObjectStorageException
     */
    public function renameFile($oldKey, $newKey);

    /**
     * 删除文件
     *
     * @param string $key
     * @throws \Cloud\Oss\ObjectStorageException
     */
    public function deleteFile($key);

    /**
     * 获取私有文件下载链接
     *
     * @param string $baseUrl
     * @param int $expires
     * @return string
     */
    public function getPrivateFileUrl($baseUrl, $expires = 3600);

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
    public function getFileList($prefix = null, $marker = null, $limit = 100, $delimiter = null);

    /**
     * 获取文件信息
     *
     * @param string $key
     * @return array
     * @throws \Cloud\Oss\ObjectStorageException
     */
    public function getFileInfo($key);
}
