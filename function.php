<?php
/*
 * 创建文件夹
 *
 * @param	string	$dir	路径
 * @param	integer	$mode	文件夹权限
 * @return	boolean
 */
function mk_dir($dir, $mode = 0777) 
{
    if ( ! is_dir($dir)) 
    {
        mk_dir(dirname($dir));
        mkdir($dir);
    }
}

/*
 * 上传文件
 *
 * @param	object	$upload	上传对象，可是单个或者数组
 * @param	boolean	$target	上传目标
 * @param	string	$ext	允许上传的文件后缀用逗号分隔
 * @param	integer	$size	上传大小（单位M）
 * @param	string	$rename	重命名
 * @return	string
 */
function upload($upload, $target = './', $exts = 'jpg,gif,torrent,zip,rar,7z,doc,docx,xls,xlsx,ppt,pptx,mp3,wma,swf,flv,txt', $size = 20, $rename = '')
{
	mk_dir($target);

	if (is_array($upload['name']))
	{
		$return = array();

		foreach ($upload["name"] as $k => $v)
		{
			if ( ! empty($upload['name'][$k]))
			{
				$ext = get_ext($upload['name'][$k]);

				if (strpos($exts,$ext) !== false && $upload['size'][$k] < $size * 1024 * 1024)
				{
					$name = empty($rename) ? upload_name($ext) : upload_rename($rename,$ext);

					if (upload_move($upload['tmp_name'][$k],$target.$name))
					{
						$return[] = $name;
					}
				}
			}
		}

		return $return;
	}
	else
	{
		$return = '';

		if ( ! empty($upload['name']))
		{
			$ext = get_ext($upload['name']);

			if(strpos($exts,$ext) !== false && $upload['size'] < $size * 1024 * 1024)
			{
				$name = empty($rename) ? upload_name($ext) : upload_rename($rename,$ext);

				if (upload_move($upload['tmp_name'], $target . $name))
				{
					$return = $name;
				}
			}
		}
	}

	return $return;
}

function tt($f)
{
	if ( file_exists($f))
	{
		echo 'y';
	}
	else
	{
		echo 'n';
	}
}

/*
 * 移动上传文件
 *
 * @param	string	$from	文件来源
 * @param	string	$target 移动目标地
 * @return	boolean
 */
function upload_move($from, $target= '')
{
	if (function_exists("move_uploaded_file"))
	{
		if (move_uploaded_file($from, $target))
		{
			@chmod($target,0755);

			return true;
		}
	}
	elseif (copy($from, $target))
	{
		@chmod($target, 0755);

		return true;
	}

	return false;
}

function upload_name($ext)
{
	$name = date('YmdHis');

	for ($i=0; $i < 3; $i++)
	{
		$name.= chr(mt_rand(97, 122));
	}

	$name = strtoupper(md5($name)) . "." . $ext;

	return (string)$name;
}

function upload_rename($rename, $ext)
{
	$name = $rename . "." . $ext;

	return (string)$name;
}

/*
 * 获取文件后缀名
 *
 * @param	string $filename 文件名
 * @return	string
 */
function get_ext($filename)
{
	if(!empty($filename))
	{
		$tmp = explode(".",strtolower($filename));
		return $tmp[1];
	}
}