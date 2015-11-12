<?php
if ( ! defined('ROOT')) exit('Access denied!');

#PHP版本要大于5.1
if(version_compare(PHP_VERSION,'5.1.0','<')) exit('PHP_VERSION>5.1.0');

define('DEBUG', TRUE);
define('FILEPATH','upload/');

#程序运行模式
error_reporting(DEBUG ? E_ALL : 0);
#设置时间区域
date_default_timezone_set('PRC');

#魔法引用如果开启就先移除斜杠
@set_magic_quotes_runtime(0);
if (@get_magic_quotes_gpc())
{
	$_POST   = remove_slashes($_POST);
}

require_once(ROOT . '/function.php');

$do = isset($_REQUEST['do']) ? trim($_REQUEST['do']) : '';

header("content-type:text/html;charset=utf-8");