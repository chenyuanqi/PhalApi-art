<?php

class Api_User extends PhalApi_Api {

    public function getRules() {
        return array(
            'getBaseInfo' => array(
                'userId' => array('name' => 'user_id', 'type' => 'int', 'min' => 1, 'require' => true, 'desc' => '用户ID'),
            ),
            'getMultiBaseInfo' => array(
            'userIds' => array('name' => 'user_ids', 'type' => 'array', 'format' => 'explode', 'require' => true, 'desc' => '用户ID，多个以逗号分割'),
        ),
        );
    }

    /**
     * 获取用户基本信息
     * @desc 用于获取单个用户基本信息
     * @return int code 操作码，0表示成功， 1表示用户不存在
     * @return object info 用户信息对象
     * @return int info.id 用户ID
     * @return string info.name 用户名字
     * @return string info.note 用户来源
     * @return string msg 提示信息
     */
    public function getBaseInfo() {
        //定义返回数据初始结构
        $rs = array('code' => 0, 'msg' => '', 'info' => array());

        //使用 Domain 领域层获取用户相关信息
        $domain = new Domain_User();
        $info = $domain->getBaseInfo($this->userId);

        //数据异常情况处理
        if (empty($info)) {
            //记录 logger
            DI()->logger->debug('user not found', $this->userId);

            //返回信息构造
            $rs['code'] = 1;
            $rs['msg']  = T('user not exists');
            return $rs;
        }

        //数据正常情况
        $rs['info'] = $info;

        return $rs;
    }

    /**
     * 批量获取用户基本信息
     * @desc 用于获取多个用户基本信息
     * @return int code 操作码，0表示成功
     * @return array list 用户列表
     * @return int list[].id 用户ID
     * @return string list[].name 用户名字
     * @return string list[].note 用户来源
     * @return string msg 提示信息
     */
    public function getMultiBaseInfo() {
        $rs = array('code' => 0, 'msg' => '', 'list' => array());

        $domain = new Domain_User();
        foreach ($this->userIds as $userId) {
            $rs['list'][] = $domain->getBaseInfo($userId);
        }

        return $rs;
    }
}
