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

    public function checkLogin ( $userName, $passWord )
    {
        //预定义返回数据
        $rs = [ ];

        //参数异常情况处理
        if ( empty($userName) || empty($passWord) ) {
            return $rs;
        }

        // 使用 Model 查询数据是否存在
        $model = new Model_User();
        $rs    = $model->getByUserLogin($userName, $passWord);

        return $rs;
    }

    public function getTokenByUid($userId) {
        //预定义返回数据
        $rs = [ ];

        //参数类型转换
        $userId = intval($userId);
        //参数异常情况处理
        if ( $userId <= 0 ) {
            return $rs;
        }

        // 生产 token
        $toolObj = new PhalApi_Tool();
        $token   = $toolObj::createRandStr(30);
        // 使用 Model 写入或更新登录用户 token
        $model = new Model_Token();
        if ( $model->setToken($userId, $token) )
        {
            $effctTime = $model->getValidTime();
            $rs        = [
                'uid'         => $userId,
                'token'       => $token,
                'effect_time' => $effctTime
            ];
        }
        return $rs;
    }
}
