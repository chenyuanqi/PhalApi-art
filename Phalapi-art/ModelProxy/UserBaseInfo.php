<?php
/**
 * @author dogstar <chanzonghuang@gmail.com> 2015-02-22
 */

class ModelProxy_UserBaseInfo extends PhalApi_ModelProxy {

	protected function doGetData($query) {
		//调用 Model 获取数据
		$model = new Model_User();

		return $model->getByUserId($query->id);
	}

	protected function getKey($query) {
		//设置缓存 key
		return 'userbaseinfo_' . $query->id;
	}

	protected function getExpire($query) {
		//设置缓存过期时间，单位 s（秒）
		return 600;
	}
}
