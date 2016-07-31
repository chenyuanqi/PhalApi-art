<?php
/**
 * PhalApi_Filter_SimpleToken 简单的token拦截
 *
 * @package     PhalApi\Filter
 * @link        http://www.chenyuanqi.com/
 * @author      vikey <vikey@chenyuanqi.com> 2016-07-31
 */

class PhalApi_Filter_SimpleToken implements PhalApi_Filter {

    protected $signName;

    public function __construct ( $signName = 'token' )
    {
        $this->signName = $signName;
    }

    public function check ()
    {

        $allParams = DI()->request->getAll();
        $service   = isset($allParams[ 'service' ]) ? $allParams[ 'service' ] : '';
        if ( empty($allParams) || self::isNotVerify($service) )
        {
            return;
        }

        $sign = isset($allParams[ $this->signName ]) ? $allParams[ $this->signName ] : '';
        unset($allParams[ $this->signName ]);

        $expectTime = DI()->notorm->token->select('valid_time')->where('token = ?', $sign)->fetch();

        if ( !$expectTime || $expectTime < time() )
        {
            DI()->logger->debug('Wrong Sign', [ 'needTime' => (int)$expectTime ]);
            throw new PhalApi_Exception_BadRequest(T('wrong sign'), 6);
        }
    }

    private function isNotVerify($service) {
        $rs = 0;
        if(!$service) {
            return $rs;
        }

        $whiteConf = DI()->config->get('app.apiWhiteService');
        if(in_array(ucwords($service, '.'), $whiteConf))
        {
            $rs = 1;
        }
        return $rs;
    }

}
