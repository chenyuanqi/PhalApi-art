<?php

/**
 * File\Redis\Mongo\Memcache 配置
 * @author vikey.chen <vikey@chenyuanqi.com>
 */
return array(
    //Redis配置项
    'redis' => array(
        //Redis缓存配置项
        'servers'  => array(
            'host'   => '127.0.0.1',        //Redis 服务器地址
            'port'   => '6379',             //Redis 端口号
            'prefix' => 'vikey_',           //Redis-key 前缀
            'auth'   => '',                 //Redis 连接密码
        ),
        // Redis分库对应关系
        'DB'       => array(
            'developers' => 1,
            'user'       => 2,
            'code'       => 3,
        ),
        //使用阻塞式读取队列时的等待时间单位/秒
        'blocking' => 5,
    ),

    /**
     * MC缓存服务器参考配置
     */
    'mc' => array(
        'host' => '127.0.0.1',
        'port' => 11211,
    ),

    /**
     * 文件缓存路径配置
     */
    'file' => array(
        'log'   => API_ROOT . '/Runtime',
        'cache' => array(
            'path' => API_ROOT."/Runtime/data"
        ),
    ),
);