<?php

class Model_Token extends PhalApi_Model_NotORM {

    public function setToken($uid, $token) {
        // 唯一字段
        $unique = array(
            'uid' => $uid
        );

        // 记录不存在则写入
        $insert = array(
            'uid' => $uid,
            'token' => $token,
            'valid_time' => self::getValidTime()
        );

        // 记录存在则更新
        $update = array(
            'token' => $token,
            'valid_time' => self::getValidTime()
        );
        return $this->getORM()
            ->insert_update($unique, $insert, $update);
    }

    public function getValidTime() {
        return time() + 86400;
    }

    protected function getTableName($id) {
        //Model 查询数据对应的表名（不含表前缀）
        return 'token';
    }
}
