<?php

include('get_ticket.php');
?>
<!doctype html>
<html lang="zh">
<head>
<meta charset="UTF-8">
<meta content="yes" name="apple-mobile-web-app-capable">
<meta content="black" name="apple-mobile-web-app-status-bar-style">
<meta content="telephone=no" name="format-detection">
<meta content="email=no" name="format-detection">
<meta name="viewport" content="width=640, user-scalable=no, target-densitydpi=device-dpi">
<meta name="keywords" content="最强幻兽争霸赛">
<title>最强幻兽争霸赛</title>
<link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
<div class="wrap">
    <div class="sign">
        <form id="userForm" action="" method="post">
            <div class="group">
                <label class="label" for="qufu">区服：</label>
                <div class="g_input">
                    <input type="text" id="qufu">
                </div>
            </div>
            <div class="group">
                <label class="label" for="userName">角色名：</label>
                <div class="g_input">
                    <input type="text" id="userName">
                </div>
            </div>
            <div class="group">
                <label class="label" for="Fighting">战斗幻兽：</label>
                <div class="g_input">
                    <input type="text" id="Fighting">
                </div>
            </div>
            <div class="group">
                <label class="label" for="combat">幻兽战斗力：</label>
                <div class="g_input">
                    <input type="text" id="combat" onkeyup="value=value.replace(/[^\d]/g,'')">
                </div>
            </div>
            <div class="group">
                <label class="label" for="gImg">幻兽截图：</label>
                <div class="g_input">
                    <a class="f_up" href="javascript:;">点击上传</a>
                    <input type="file"  name="image" id="image"  class="file">
                </div>
            </div>
            <div id="preview"></div>
            <a id="submitBtn" class="btn submit_btn" href="javascript:void(0)">确认提交</a>
        </form>
    </div>
    <div id="userInfo">
        <div class="tit u_tit f36">我的幻兽</div>
        <div class="user_info">
            <dl>
                <dt>区&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;服：</dt>
                <dd id="ui_qufu"></dd>
            </dl>
            <dl>
                <dt>角&nbsp;&nbsp;&nbsp;色&nbsp;&nbsp;&nbsp;名：</dt>
                <dd id="ui_jiaoseming"></dd>
            </dl>
            <dl>
                <dt>战&nbsp;斗&nbsp;幻&nbsp;兽：</dt>
                <dd id="ui_zdhs"></dd>
            </dl>
            <dl>
                <dt>幻兽战斗力：</dt>
                <dd id="ui_zhandouli"></dd>
            </dl>
            <dl>
                <dt>幻&nbsp;兽&nbsp;截&nbsp;图：</dt>
            </dl>
            <img src="images/loading.gif" class="u_img">
			<div class="and"></div>
        </div>
        <div class="btnBox">
            <a class="btn ranBtn" href="javascript:;">我要晒排行</a>
            <a class="btn back" href="index.php">返回首页</a>
        </div>
    </div>
</div>


<!--div id="loading">
<p style="padding:90% 0 0 65%;;"><span style="float:left; margin-right:10px;">上传中...</span><img class="load" src="images/loading.gif"></p>
</div-->

<div class="share">
     <img id="shareImg" src="images/share.png">
</div>
<div class='pop_bg'></div>
<script type="text/javascript" src="http://images.vxinyou.com/jsCommon/jquery-1.7.2.min.js"></script>
<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<script type="text/javascript" src="js/ajaxfileupload.js"></script>
<script type="text/javascript">
$(function(){
    var submit_url  = "http://event.vxinyou.com/activity/pet/submit"; // 接口域名
    var share_url  = "http://event.vxinyou.com/activity/pet/share"; 
    var pet_id = 1; // 活动ID
	//图片预览判断安桌	
	var ua = navigator.userAgent.toLowerCase();
    var isAndroid = ua.indexOf("android") > -1; //&& ua.indexOf("mobile");

    $("#submitBtn").bind("touchstart", function() {         
        var server_name = $("#qufu").val(); //区服
            if($("#qufu").val()==""){
                alert("区服不能为空");
                $("#qufu").focus();
                return false;
            };
        var role_name = $("#userName").val(); //角色名
            if($("#userName").val()==""){
                alert("角色名不能为空");
                $("#userName").focus();
                return false;
            };

        var title = $("#Fighting").val(); //战斗幻兽
            if($("#Fighting").val()==""){
                alert("战斗幻兽不能为空");
                $("#Fighting").focus();
                return false;
            };
        var power = $("#combat").val(); //幻兽战斗力
            if($("#combat").val()==""){
                alert("幻兽战斗力不能为空");
                $("#combat").focus();
                return false;
            };
        var img = $("#image").val(); //幻兽战斗力
		if(isAndroid){
			$("#submitBtn").css("background-position","0 -500px");
		}
        ajaxFileUpload();    
        


  

    //图片上传
    function ajaxFileUpload(){
        $.ajaxFileUpload({
            url:'upload.php?do=upload',//处理图片脚本
            secureuri :false,
            data : { pet_id : pet_id,name_type: 1 } ,   // pet_id  活动id  name_type  暂无实际用途
            fileElementId :'image',//file控件id
            dataType : 'json',
            success : function (data){
                if ( ! data.success)
                {
                    alert(data.msg)
                } 
				
                var image = data.data;				
				

                $.post(submit_url, 
                    { 
                        "pet_id":pet_id,
                        "server_name":server_name, 
                        "role_name":role_name, 
                        "title":title,
                        "power":power,
                        "img":image,
                    }, 
                    function(response){
                    if (response.success)
                    {

                        $("#userForm").hide();            
                        if(response.data){
                            //console.log(server_name)
                            $("#ui_qufu").html(server_name);
                            $("#ui_jiaoseming").html(role_name);
                            $("#ui_zdhs").html(title);
                            $("#ui_zhandouli").html(power);
                            $(".u_img").attr("src", "upload\/"+image);
                            //console.log(img)
                        };
                        $("#userInfo").show();
                    }
                    // else
                    // {
                    //     alert(response.message)
                    // }
                },"jsonp");




            },
            error: function(data, status, e){
                //alert(e);
                //return false; 
            }
        })
        //return false;  
        }

    
    })


    //分享

    $(".ranBtn").on("touchstart",function(){
        $(".share").show();
        $(".pop_bg").show();
    }) 

    $(".pop_bg,#shareImg").on("touchstart",function(){
        //alert("f")
        $(".share").hide();
        $(".pop_bg").hide();        
    }) 
	


    //图片预览
    function preview1(file) {
	var url = window.webkitURL.createObjectURL(file);
    $('#preview').html('<img id=imghead src="' + url + '">');
	if(isAndroid){
		//$(".and").html('<img id=imghead src="' + url + '">');
	}
	/*
    var img = new Image(), url = img.src = URL.createObjectURL(file)
    var $img = $(img)
    img.onload = function() {
            URL.revokeObjectURL(url)
            $('#preview').empty().append($img)
        }
	*/
    };
     
    $(function() {
        $('[type=file]').change(function(e) {
            var file = e.target.files[0]
            preview1(file)
        })
    })

 
})




var debug     = false;
var appId     = "<?php echo $appid; ?>";
var timestamp = "<?php echo $timestamp; ?>";
var nonceStr  = "<?php echo $nonceStr; ?>";
var signature = "<?php echo $signature; ?>";
var jsApiList = ["onMenuShareTimeline", "onMenuShareAppMessage", "onMenuShareQQ", "onMenuShareWeibo"];

var  title = '最强幻兽争霸赛'; // 分享标题
var  desc = '神兽在手，格斗我有。'; // 分享描述
var  link ='http://gd.vxinyou.com/zt/zq_huanshou/'; // 分享链接
var  imgUrl = 'http://gd.vxinyou.com/zt/zq_huanshou/images/s.png'; // 分享图标
  
wx.config({
    debug     : debug, // 
    appId     : appId, // 必填，公众号的唯一标识
    timestamp : timestamp, // 必填，生成签名的时间戳
    nonceStr  : nonceStr, // 必填，生成签名的随机串
    signature : signature,// 必填，签名，见附录1
    jsApiList : jsApiList // 必填，需要使用的JS接口列表，所有JS接口列表见附录2
});


wx.ready(function () {

    // 在这里调用 API
    
    // 判断当前客户端版本是否支持指定JS接口
    wx.checkJsApi({
        jsApiList: jsApiList, // 需要检测的JS接口列表，所有JS接口列表见附录2,
        success: function(res) {

            if ( ! (res.checkResult.onMenuShareTimeline && res.checkResult.onMenuShareAppMessage && res.checkResult.onMenuShareQQ && res.checkResult.onMenuShareWeibo))
            {
                wx.hideOptionMenu();
                // alert('菜单已被隐藏');
            }
            else
            {
                // alert('接口可以使用');
            }
        }
    });

    // 分享到朋友圈
    wx.onMenuShareTimeline({
        title: title, // 分享标题
        link: link, // 分享链接
        imgUrl: imgUrl, // 分享图标
        success: function () { 
            // 用户确认分享后执行的回调函数
        },
        fail: function () { 
        },
        cancel: function () { 
            // 用户取消分享后执行的回调函数
        }
    });

    // 分享给朋友
    wx.onMenuShareAppMessage({
        title: title, // 分享标题
        desc: desc, // 分享描述
        link: link, // 分享链接
        imgUrl: imgUrl, // 分享图标
        type: '', // 分享类型,music、video或link，不填默认为link
        dataUrl: '', // 如果type是music或video，则要提供数据链接，默认为空
        success: function () { 
            // 用户确认分享后执行的回调函数
        },
        fail: function () { 
        },        
        cancel: function () { 
            // 用户取消分享后执行的回调函数
        }
    });

    // 分享到QQ
    wx.onMenuShareQQ({
        title: title, // 分享标题
        desc: desc, // 分享描述
        link: link, // 分享链接
        imgUrl: imgUrl, // 分享图标
        success: function () { 
           // 用户确认分享后执行的回调函数
        },
        fail: function () { 
        },        
        cancel: function () { 
           // 用户取消分享后执行的回调函数
        }
    });

    // 分享到腾讯微博
    wx.onMenuShareWeibo({
        title: title, // 分享标题
        desc: desc, // 分享描述
        link: link, // 分享链接
        imgUrl: imgUrl, // 分享图标
        success: function () { 
           // 用户确认分享后执行的回调函数
        },
        fail: function () { 
        },        
        cancel: function () { 
            // 用户取消分享后执行的回调函数
        }
    });

});


</script>
<script>
var _hmt = _hmt || [];
(function() {
  var hm = document.createElement("script");
  hm.src = "//hm.baidu.com/hm.js?bd1f415a5ecec287f62338ca5ccd8d13";
  var s = document.getElementsByTagName("script")[0]; 
  s.parentNode.insertBefore(hm, s);
})();
</script>

</body>
</html>