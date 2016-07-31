<?php

class Api_User extends PhalApi_Api {

    public function getRules() {
        return array(
            'getBaseInfo' => array(
                'userId' => array('name' => 'user_id', 'type' => 'int', 'min' => 1, 'require' => true, 'desc' => '用户ID'),
                'email'  => array('name' => 'email', 'type' => 'email', 'isEmail' => 1, 'require' => true, 'desc' => '用户邮箱'),
            ),
            //getMultiBaseInfo：接口方法名
            'getMultiBaseInfo' => array(
                /**
                 * @param string  userIds 接口方法中使用的参数名
                 * @param string  type    数据类型，如 int,float,array 等
                 * @param string  format  格式化处理方法（如下 explode 将处理 user_ids 以英文逗号分割为数组形式）
                 * @param mixed   default 参数默认值
                 * @param boolean require 参数是否必须，值为 true 或者 false
                 * @param string  desc    参数的描述，用于接口文档
                 */
                'userIds' => array('name' => 'user_ids', 'type' => 'array', 'format' => 'explode', 'default'=> '', 'require' => true, 'desc' => '用户ID，多个以逗号分割'),
            ),
            //userLogin：用户登录
            'userLogin' => array(
                'user' => array('name' => 'username', 'type' => 'string', 'min' => 6, 'max' => 20, 'require' => true, 'desc' => '用户登录名称'),
                'pwd'  => array('name' => 'password', 'type' => 'string', 'require' => true, 'desc' => '用户登录密码'),
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

    /**
     * 用户登录
     * @desc 用于用户登录验证并获取登录口令
     * @return int info.uid 用户 id
     * @return string info.token       登录token
     * @return string info.effect_time 登录有效时间
     */
    public function userLogin() {
        //定义返回数据初始结构
        $rs = array('code' => 0, 'msg' => '', 'info' => array());
        //使用 Domain 领域层校验用户登录信息的有效性
        $domain = new Domain_User();
        $info = $domain->checkLogin($this->user, $this->pwd);

        //数据异常情况处理
        if (empty($info)) {
            //记录 logger
            DI()->logger->debug('login fail!', $this->user);

            //返回信息构造
            $rs['code'] = 1;
            $rs['msg']  = T('login fail!');
            return $rs;
        }

        //登录正常，获取 token 返回
        $rs['info'] = $domain->getTokenByUid($info['id']);

        return $rs;
    }
}
