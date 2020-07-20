# php-oss

#### 介绍
文件云储存适配器，一套API通用于腾讯云、阿里云、七牛云

#### 使用说明

```php
$oss = ObjectStorage::aliyun([
	'CLOUD_ACCESS_KEY'     => '...',
	'CLOUD_SECRET_KEY'     => '...',
	'bucket' => '',
]);

// 上传文件
try{
	$result = $oss->uploadFile('test.txt', './test.txt');
	var_dump($result);
}catch(ObjectStorageException $e){
	var_dump($e->getMessage());
}

// 上传字符串
try{
	$result = $oss->uploadData('test.txt', 'hello world');
	var_dump($result);
}catch(ObjectStorageException $e){
	var_dump($e->getMessage());
}

// 重命名文件
try{
	$oss->renameFile('test.txt', 'helloworld.txt');
	var_dump('rename file ok.');
}catch(ObjectStorageException $e){
	var_dump($e->getMessage());
}

// 文件详细信息
try{
	$result = $oss->getFileInfo('helloworld.txt');
	var_dump($result);
}catch(ObjectStorageException $e){
	var_dump($e->getMessage());
}

// 删除文件
try{
	$oss->deleteFile('helloworld.txt');
	var_dump('delete file ok.');
}catch(ObjectStorageException $e){
	var_dump($e->getMessage());
}

// 文件列表
try{
	$result = $oss->getFileList(null, null, 1);
	var_dump($result);
}catch(ObjectStorageException $e){
	var_dump($e->getMessage());
}
```

#### 特别说明


