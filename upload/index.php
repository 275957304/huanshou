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
    <h2 class="top">最强幻兽争霸赛</h2>
    <div class="tit">
        <h3 class="f36">幻兽全服排行榜</h3>
        <p id="gx">下次更新时间：2015年1月21日12时</p>
    </div>
    <div class="rank">
        <div class="thead">
            <span class="r1">排名</span>
            <span class="r2">区服</span>
            <span class="r3">角色名</span>
            <span class="r4">战斗幻兽</span>
            <span class="r5">战斗力</span>
        </div>
        <ul id="rankList">           
        </ul>
    </div>
    <a class="btn signUp" href="signUp.php">我要报名</a>

    <div class="pt">
        <div class="pt_t">活动规则</div>
        <div class="pt_info">
            <p class="t2">勇士们，请按要求填写幻兽的详细信息。还有上传可以展示幻兽战斗力的截图，以便我们核对幻兽战斗力！</p>
        </div>
    </div>

    <div class="pt">
        <div class="pt_t">活动奖励</div>
        <div class="pt_info">
            <p class="n1">官方会根据幻兽的战斗力评选，排行前3的玩家可获得“御龙至尊”称号（3天）。</p>
            <p class="n2">连续7期排行第一的勇士还可额外获得暗金升阶哥布林一只，连续30期排行第一的勇士可获得暗金幻兽一只。</p>   
        </div>
    </div>
</div>
<script type="text/javascript" src="http://images.vxinyou.com/jsCommon/jquery-1.7.2.min.js"></script>
<script type="text/javascript">
    var day_li_url  = "http://event.vxinyou.com/activity/pet/get_day_list"; // 接口域名
    var data_url = "http://event.vxinyou.com/activity/pet/get_next_update";
    var pet_id = 1; // 活动ID
    var date = "";
    $(function(){

        $.post(
            data_url,{"pet_id" : pet_id},   
            function(response) {
               if(response.success){
                    $("#gx").html("下次更新时间为："+response.next_update);
                    date = response.show_date;
               } 
            },
            "jsonp"
        );

        //排行
        $.post(
            day_li_url, // 请求地址
            { 
                "pet_id"   : pet_id, 
                "date"     : date, 
            }, 
            function(response){
                //console.log(response.data)
                if(response.success){
                    
                    if(response.data){
                        console.log(response.data.role_name)
                        $.each(response.data, function(i,n){
                            $('#rankList').append('<li><span class="r1">' + n.data.id + '</span><span class="r2">' + n.data.server_name + '</span><span class="r3">' + n.data.role_name + '</span><span class="r4">' + n.data.title + '</span><span class="r5">' + n.data.power + '</span></li>');   
                        });
                    }

                }else{
                   // alert(response.message);                    
                }
            },
            "jsonp");  

    })
</script>
</body>
</html>