<?php

class Model_User extends PhalApi_Model_NotORM {

    public function getByUserLogin($username, $password) {
        return $this->getORM()
            ->select('*')
            ->where('name = ?', $username)
            ->where('password = ?', self::changePassword($password))
            ->fetch();
    }

    public function getByUserId($userId) {
        //查询id为$userId的所有信息
        return $this->getORM()
            ->select('*')
            ->where('id = ?', $userId)
            ->fetch();
    }

    public function getByUserIdWithCache($userId) {
        $key = 'userbaseinfo_' . $userId;
        //获取用户信息缓存
        $rs = DI()->cache->get($key);
        //获取失败，则调用 getByUserId 获取数据并设置缓存
        if ($rs === NULL) {
            $rs = $this->getByUserId($userId);
            DI()->cache->set($key, $rs, 600);
        }
        return $rs;
    }

    private function changePassword($password) {
        return md5($password);
    }

    protected function getTableName($id) {
        //Model 查询数据对应的表名（不含表前缀）
        return 'user';
    }
}
