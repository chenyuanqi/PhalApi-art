<?php
/**
 * PhalApi_Request_Formatter_Int 校验邮箱
 *
 * @package     PhalApi\Request
 * @license     http://www.phalapi.net/license GPL 协议
 * @link        http://www.phalapi.net/
 * @author      vikey <vikey@chenyuanqi.com> 2016-07-23
 */

class PhalApi_Request_Formatter_Email extends PhalApi_Request_Formatter_Base implements PhalApi_Request_Formatter {


    /**
     * 对邮箱进行格式化校验
     *
     * @param  mixed $value string 变量值
     * @param  array $rule  string 规则
     * @return int/string   邮箱是否正常
     *
     */
    public function parse($value, $rule) {
        if(isset($rule['isEmail'])) {
            $validate = filter_var($value, FILTER_VALIDATE_EMAIL);
            if(!$validate){
                throw new PhalApi_Exception_BadRequest(T('Email format is not correct!'));
            }
        }
        return $value;
    }
}
