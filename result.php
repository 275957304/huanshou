<?php
include('get_ticket.php');
$testId = 2;
$logId = $_REQUEST['log_id'];
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
<meta name="keywords" content="神准测试：和胡歌一起旺桃花">
<title>神准测试：和胡歌一起旺桃花</title>
<link rel="stylesheet" type="text/css" href="css/style.css">
<script type="text/javascript" src="http://images.vxinyou.com/jsCommon/jquery-1.7.2.min.js"></script>
<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
</head>
<body>
<div class="result">
    <div class="re_txt">
        <h3>你的桃花运就在</h3>
        <p id="reName" class="f6"></p>
        <p class="r_txt"></p>
        <a id="shareBtn" href="javascrip:;">分享给朋友一起涨桃花</a>
        <a class="b_ad" href="http://ml.vxinyou.com/zt/ceshiti/down/index.php">99%的男生在游戏里泡到了女神</a>
 
    </div>
</div>
<div class="share">请点击右上角菜单选择“分享朋友圈”</div>
<div class='pop_bg'></div>
<script type="text/javascript">
    var test_id = '<?php echo $testId ?>';
    var log_id = '<?php echo $logId ?>'; 
    var shareLink = 'http://ml.vxinyou.com/zt/ceshiti/share.php?test_id=<?php echo $testId ?>&log_id=<?php echo $logId ?>';
    var submit_url = 'http://event.vxinyou.com/activity/test/get_result';
    var wH = $(window).height();
    $(function(){
        $(".result").css("height",wH);
        $.post(
            submit_url,
            { 
                "test_id"  : test_id,
                "log_id"   : log_id,
            },   
            function(response) {
                if (response.success){
                    var text = response.result.result_share;
                    var data = text.split('\r\n');
                    var rN = data[0].split('：');
                    //console.log(rN.length);
                    //console.log(data[1]);
                   $("#reName").html(rN[1]);
                   $(".r_txt").html(data[1]);

                    switch (rN[1])
                    {
                        case "电影院":
                            $(".result").addClass("a");
                        break;
                        case "海滩":
                            $(".result").addClass("b");
                        break;
                        case "沙漠":
                            $(".result").addClass("c");
                        break;
                        case "古城小道":
                            $(".result").addClass("d");
                        break;
                        case "餐厅":
                            $(".result").addClass("e");
                        break;
                        case "登山":
                            $(".result").addClass("f");
                        break;
                        case "湖泊":
                            $(".result").addClass("g");
                        break;
                        case "工作学习地点":
                            $(".result").addClass("h");
                        break;
                        case "商场":
                            $(".result").addClass("i");
                        break;
                        case "书屋":
                            $(".result").addClass("j");
                        break;
                        case "寺庙":
                            $(".result").addClass("k");
                        break;
                        case "归乡的旅程中":
                            $(".result").addClass("l");
                        break;
                    }

                }
                
            },
            "jsonp"
        );


        //分享
        $("#shareBtn").on("touchstart",function(){
            $(".share").show();
            $(".pop_bg").show();
        }) 

        $(".pop_bg,.share").on("touchstart",function(){
            //alert("f")
            $(".share").hide();
            $(".pop_bg").hide();        
        })

		
		

        //分享接口代码 
        var debug     = false;
        var appId     = "<?php echo $appid; ?>";
        var timestamp = "<?php echo $timestamp; ?>";
        var nonceStr  = "<?php echo $nonceStr; ?>";
        var signature = "<?php echo $signature; ?>";
        var jsApiList = ["onMenuShareTimeline", "onMenuShareAppMessage", "onMenuShareQQ", "onMenuShareWeibo"];

        var  title = '古法占卜桃花运！让你甩掉“何以琛”找寻你的专属恋人！'; // 分享标题
        var  desc = '古法占卜桃花运！让你甩掉“何以琛”找寻你的专属恋人！'; // 分享描述
        var  link =  shareLink; // 分享链接
        var  imgUrl = 'http://images.vxinyou.com/ml/images/s.jpg'; // 分享图标

         
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
                    // 以键值对的形式返回，可用的api值true，不可用为false
                    // 如：{"checkResult":{"chooseImage":true},"errMsg":"checkJsApi:ok"}
                    // alert('判断当前客户端版本是否支持指定JS接口');
                    // alert("分享到朋友圈 : "+(res.checkResult.onMenuShareTimeline?"可以使用":"不能使用"));
                    // alert("分享给朋友 : "+(res.checkResult.onMenuShareAppMessage?"可以使用":"不能使用"));
                    // alert("分享到QQ : "+(res.checkResult.onMenuShareQQ?"可以使用":"不能使用"));
                    // alert("分享到腾讯微博 : "+(res.checkResult.onMenuShareWeibo?"可以使用":"不能使用"));
                    
                    // 无法使用分享则隐藏菜单
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
                    //alert(title);
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


    });
</script>
<script>
var _hmt = _hmt || [];
(function() {
  var hm = document.createElement("script");
  hm.src = "//hm.baidu.com/hm.js?8b496f21669266204353c5a1ec4babf0";
  var s = document.getElementsByTagName("script")[0]; 
  s.parentNode.insertBefore(hm, s);
})();
</script>

</body>
</html>