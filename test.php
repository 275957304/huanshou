
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>ajax上传测试</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!-- 引入jqury和上传js -->
<script type="text/javascript" src="http://images.vxinyou.com/jsCommon/jquery-1.7.2.min.js"></script>
<script type="text/javascript" src="js/ajaxfileupload.js"></script>

<script type="text/javascript">

$(function(){

    $("#do_submit").click(function(){
	    $.ajaxFileUpload({
	        url:'upload.php?do=upload',//处理图片脚本
	        secureuri :false,
	        data : { pet_id : 1,name_type: 1 } ,   // pet_id  活动id  name_type  暂无实际用途
	        fileElementId :'image',//file控件id
	        dataType : 'json',
	        success : function (data){
	            if ( ! data.success)
	            {
	            	alert(data.msg)
	            }

	            var image = data.data;
	        },
	        error: function(data, status, e){
	            alert(e);
	        }
		})
		return false;
    });

    return false;
});

</script>


</head>

<body>   
<hr />
<h4>提交</h4>
图片11：<input type="text" name="dddd" value=""/>
图片：<input type="file" name="image" id="image" value=""/>
<p><input id="do_submit" type="button" value="提交" /></p>

</body>
</html>