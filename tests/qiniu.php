<?php

use Cloud\Oss\CloudOss;
use Cloud\Oss\CloudOssException;

require_once '../../../vendor/autoload.php';
$config = [
    'driver'     => env('UPLOAD_DRIVER'),
    'access_key' => env('CLOUD_ACCESS_KEY'),
    'secret_key' => env('CLOUD_SECRET_KEY'),
    'bucket'     => env('CLOUD_BUCKET'),
    'domain'     => env('CLOUD_DOMAIN'),
    'endpoint'   => env('CLOUD_ENDPOINT'),
];
// 获取七牛云对象存储实现类
$oss = CloudOss::qiniu($config);

// 上传文件
try {
    $result = $oss->uploadFile('test.txt', 'test.txt');
    var_dump($result);
} catch (CloudOssException $e) {
    var_dump($e->getMessage());
} catch (Exception $e) {
}

//上传字符串
try {
    $result = $oss->uploadData('test2.txt', 'hello world');
    var_dump($result);
} catch (CloudOssException $e) {
    var_dump($e->getMessage());
}

//重命名文件
try {
    $oss->renameFile('test2.txt', 'helloworld.txt');
    var_dump('rename file ok.');
} catch (CloudOssException $e) {
    var_dump($e->getMessage());
}

//文件详细信息
try {
    $result = $oss->getFileInfo('helloworld.txt');
    var_dump($result);
} catch (CloudOssException $e) {
    var_dump($e->getMessage());
}

//删除文件
try {
    $oss->deleteFile('helloworld.txt');
    var_dump('delete file ok.');
} catch (CloudOssException $e) {
    var_dump($e->getMessage());
}

// 文件列表
try {
    $result = $oss->getFileList(null, null, 1);
    var_dump($result);
} catch (CloudOssException $e) {
    var_dump($e->getMessage());
}
