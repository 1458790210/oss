<?php

namespace Cloud\Oss;

/**
 * 基础类
 *
 * @package Cloud\articlecollect
 * @method static \Cloud\Oss\driver\Aliyun aliyun(array $config)
 * @method static \Cloud\Oss\driver\Qcloud qcloud(array $config)
 * @method static \Cloud\Oss\driver\Qiniu qiniu(array $config)
 */
class ObjectStorage
{

    /**
     * 静态调用处理
     *
     * @param string $name
     * @param array $arguments
     * @return mixed
     */
    public static function __callStatic($name, $arguments)
    {
        return self::factory($name, $arguments[0]);
        //		throw new BadMethodCallException("{$name}方法不存在！");
    }

    /**
     * 构建抓取实例
     *
     * @param string $driver
     * @param array $options
     * @return ObjectStorageInterface
     */
    public static function factory($driver, array $options = [])
    {
        if (stripos($driver, '\\') !== 0) {
            $driver = ucwords(str_replace(['-', '_'], ' ', $driver));
            $driver = str_replace(' ', '', $driver);
            $driver = "\\Cloud\\Oss\\driver\\{$driver}";
        }

        if (!class_exists($driver)) {
            throw new \RuntimeException("对象存储驱动不存在：{$driver}");
        }

        return new $driver($options);
    }

}
