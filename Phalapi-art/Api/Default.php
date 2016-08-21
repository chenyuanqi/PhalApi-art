<?php
/**
 * 默认接口服务类
 *
 * @author: dogstar <chanzonghuang@gmail.com> 2014-10-04
 */

class Api_Default extends PhalApi_Api {

	public function getRules() {
        return array(
            'index' => array(
                'username' 	=> array('name' => 'username', 'default' => 'PHPer', ),
            ),
			'redis' => array(
				'content'  => array('name' => 'content', 'require' => true, 'desc' => 'redis 存储 $value内容')
			),
        );
	}
	
	/**
	 * 默认接口服务
	 * @return string title 标题
	 * @return string content 内容
	 * @return string version 版本，格式：X.X.X
	 * @return int time 当前时间戳
	 */
	public function index() {
        return array(
            'title' => 'Hello World!',
            'content' => T('Hi {name}, welcome to use PhalApi!', array('name' => $this->username)),
            'version' => PHALAPI_VERSION,
            'time' => $_SERVER['REQUEST_TIME'],
        );
	}

    /**
     * 用于 redis 测试
     * @return string content redis 需要存储的值
     */
	public function redis() {
        $value = $this->content;
        
		//存入永久的键 $value队
		$result = DI()->redis->set_forever('test', $value, 'testLib');

        /*
		//获取永久的键 $value队
		$result = DI()->redis->get_forever('test',  'testLib');

		//存入一个有时效性的键 $value队,默认600秒
		$result = DI()->redis->set_Time('test', $value, 60, 'testLib');
		//获取一个有时效性的键 $value队
		$result = DI()->redis->get_Time('test',  'testLib');

		//写入队列左边
		$result = DI()->redis->set_Lpush('test', $value,  'testLib');
		//读取队列右边
		$result = DI()->redis->get_lpop('test',  'testLib');
		//读取队列右边 如果没有读取到阻塞一定时间(阻塞时间或读取配置文件blocking的 $value)
		$result = DI()->redis->get_Brpop('test', $value,  'testLib');

		//删除一个键 $value队适用于所有
		$result = DI()->redis->del('test',  'testLib');
		//自动增长
		$result = DI()->redis->get_incr('test',  'testLib');
		//切换DB并且获得操作实例
		$result = DI()->redis->get_redis('test',  'testLib');
        */

		return $result;
	}
}
