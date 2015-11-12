<?php
define('ROOT',dirname($_SERVER['SCRIPT_FILENAME']));
require_once ROOT . '/config.php';

switch ($do)
{
	case 'upload': 
		echo up();
	break;

	default :
	echo ''; die;
}

//  文件名字  活动id  时间  随机数
function getFilename($id, $type = 0)
{
	$name  = $id . '_' . date('YmdHis');
	$name .= '_' . rand(1000,9999);

	return $name;
}

// 上传文件
function up()
{
	$petId    = $_REQUEST['pet_id'];
	$nameType = empty($_REQUEST['name_type']) ? 0 : $_REQUEST['name_type'];
	$dirPath  = ROOT . '/' . FILEPATH; // 文件夹路径

	$fileName = getFilename($petId);

	// 检测参数是否完成
	if ( ! isset($petId) || empty($petId) || ! isset($_FILES['image']['name']) || empty($_FILES['image']['name']))
	{
		return showReturn('上传参数错误');
	}

	if ( ! is_dir($dirPath))
	{
		mk_dir($dirPath); // 文件夹不存在创建
	}

	// 上传文件
	$fileName = upload($_FILES['image'], $dirPath, 'jpg,gif,png', 5, $fileName);
	// 检测上传后文件是否存在。不存在便错误
	if ( ! file_exists($dirPath . $fileName))
	{
		return showReturn('上传文件错误');
	}

	return showReturn('ok', TRUE, 'json', $fileName);
}

// 返回函数
function showReturn($msg, $type = FALSE, $dataType = 'json', $data = array())
{
	$array = array();

	$array['success'] = $type;
	$array['msg'] = empty($msg) ? '未知错误' : $msg;

	if ( ! empty($data))
	{
		$array['data'] = $data;
	}

	return ($dataType == 'json') ? json_encode($array) : $array;
}