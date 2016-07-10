<?php

class Domain_User {

    public function getBaseInfo($userId) {
        //预定义返回数据
        $rs = array();

        //参数类型转换
        $userId = intval($userId);
        //参数异常情况处理
        if ($userId <= 0) {
            return $rs;
        }

		// 版本1：简单的获取
        $model = new Model_User();
        $rs = $model->getByUserId($userId);

		// 版本2：使用单点缓存/多级缓存 (应该移至Model层中)
		/**
        $model = new Model_User();
        $rs = $model->getByUserIdWithCache($userId);
		*/

		// 版本3：缓存 + 代理

		$query = new PhalApi_ModelQuery();
		$query->id = $userId;
		$modelProxy = new ModelProxy_UserBaseInfo();
		$rs = $modelProxy->getData($query);


        return $rs;
    }
}
