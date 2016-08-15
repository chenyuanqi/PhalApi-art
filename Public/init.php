<?php
/**
 * 统一初始化
 */
 
/** ---------------- 根目录定义，自动加载 ---------------- **/
//时区设置
date_default_timezone_set('Asia/Shanghai');

//定义根目录
defined('API_ROOT') || define('API_ROOT', dirname(__FILE__) . '/..');

//框架文件及扩展文件注册
require_once API_ROOT . '/PhalApi/PhalApi.php';
$loader = new PhalApi_Loader(API_ROOT, 'Library');

/** ---------------- 注册&初始化 基本服务组件 ---------------- **/

//自动加载，DI 依赖注入
DI()->loader = $loader;

//加载 Demo 目录
//DI()->loader->addDirs("Demo");

//配置
DI()->config = new PhalApi_Config_File(API_ROOT . '/Config');
/**
 * DI 读取配置的使用示例：
 * DI()->config->get("app.apiCommonRules");
 *
 */

//调试模式，$_GET['__debug__']可自行改名，输出调试信息
DI()->debug = !empty($_GET['__debug__']) ? true : DI()->config->get('sys.debug');

//日志纪录
DI()->logger = new PhalApi_Logger_File(API_ROOT . '/Runtime', PhalApi_Logger::LOG_LEVEL_DEBUG | PhalApi_Logger::LOG_LEVEL_INFO | PhalApi_Logger::LOG_LEVEL_ERROR);
/**
 * 日志操作示例：
 * DI()->logger->info('This is a info level log!', array());
 * DI()->logger->debug('This is a debug level log!', array());
 * DI()->logger->error('This is a error level log!', array());
 *
 */

//数据操作 - 基于NotORM，$_GET['__sql__']可自行改名，输出 sql 信息
DI()->notorm = new PhalApi_DB_NotORM(DI()->config->get('dbs'), !empty($_GET['__sql__']));
//注册从（读）库
DI()->slave = function (){
    return new PhalApi_DB_NotORM(DI()->config->get('slave'), !empty($_GET['__sql__']));
};

//翻译语言包设定
if(empty($_GET['lang']) || 'en' != $_GET['lang'])
{
    SL('zh_cn');
}
else
{
    SL('en');
}

/** ---------------- 定制注册 可选服务组件 ---------------- **/

//签名验证服务
DI()->filter = 'PhalApi_Filter_SimpleToken';

/**
//签名验证服务
DI()->filter = 'PhalApi_Filter_SimpleMD5';
 */

/**
//缓存 - Memcache/Memcached
DI()->cache = function () {
    return new PhalApi_Cache_Memcache(DI()->config->get('sys.mc'));
};
 */
/**
 * 文件缓存
 * DI()->cache = new PhalApi_Cache_File(array(
 *     'path' => API_ROOT."/Runtime/data"
 * ));
 */

/**
//支持JsonP的返回
if (!empty($_GET['callback'])) {
    DI()->response = new PhalApi_Response_JsonP($_GET['callback']);
}
 */
