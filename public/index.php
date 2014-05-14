<?php
//ini_set('display_errors', 'On');
//error_reporting(E_ALL & ~E_NOTICE);
error_reporting(E_ERROR | E_WARNING | E_PARSE);

define('ROOT_PATH', dirname(dirname(__FILE__)));
define('APP_PATH', ROOT_PATH.'/application');
define('LIB_PATH', APP_PATH.'/library');
define('TPL_PATH', APP_PATH.'/views');
define('CONF_PATH', APP_PATH.'/conf');
define('LANG_PATH', '/data1/www/privdata/ug.weibo.com');
define('__START_TIME__', microtime(1));
define('COOKIE_CONF_PATH', LIB_PATH.'/SinaSSO/cookie.conf');
date_default_timezone_set('Asia/Chongqing');
//防止ie6页面缓存
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Last-Modified: ".gmdate("D, d M Y H:i:s")." GMT");
header("Cache-Control: no-cache, must-revalidate");
header("Pramga: no-cache");

$app = new Yaf_Application(APP_PATH . '/conf/Yaf_Application.ini');
$app->bootstrap()->run();
