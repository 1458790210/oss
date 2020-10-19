<?php

use Cloud\Oss\CloudOss;
use Cloud\Oss\CloudOssException;

require_once '../../../vendor/autoload.php';

// 获取阿里云对象存储实现类
$oss = CloudOss::aliyun($config);

// 上传文件
try {
    $result = $oss->uploadFile('test.txt', './test.txt');
    var_dump($result);
} catch (CloudOssException $e) {
    var_dump($e->getMessage());
}

// 上传字符串
try {
    $result = $oss->uploadData('test.txt', 'test.txt');
    var_dump($result);
} catch (CloudOssException $e) {
    var_dump($e->getMessage());
}

// 重命名文件
try {
    $result = $oss->renameFile('test.txt', 'helloworld.txt');
    var_dump($result);
} catch (CloudOssException $e) {
    var_dump($e->getMessage());
}

// 删除文件
try {
    $result = $oss->deleteFile('helloworld.txt');
    var_dump($result);
} catch (CloudOssException $e) {
    var_dump($e->getMessage());
}
