<?php
/*
 * get方式請求資源
 *
 * @param  string  $url  請求的url
 * @return string  返回的內容
 */
function http_get($url)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_URL, $url);
    $response =  curl_exec($ch);
    curl_close($ch);
    return $response;
}

function randomstr($length = 16){
    $chars = '123456789abcdefghijklmnpqrstuvwxyzABCDEFGHIJKLMNPQRSTUVWXYZ';
    $hash = '';
    $max = strlen($chars) - 1;
    for($i = 0; $i < $length; $i++) {
        $hash .= $chars[mt_rand(0, $max)];
    }
    return $hash;
}

/*
 * 说明：获取完整URL
 *
 * @param  void
 * @return string  URL
 */
function curPageURL()
{
    $pageURL = 'http';

    if ($_SERVER["HTTPS"] == "on")
    {
        $pageURL .= "s";
    }
    $pageURL .= "://";

    if ($_SERVER["SERVER_PORT"] != "80")
    {
        $pageURL .= $_SERVER["SERVER_NAME"] . ":" . $_SERVER["SERVER_PORT"] . $_SERVER["REQUEST_URI"];
    }
    else
    {
        $pageURL .= $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];
    }
    return $pageURL;
}

include(dirname(__FILE__) . '/CacheMemcache.class.php');

$key    = "MLSD_WEIXIN_JSAPI_TICKET";
$appid  = 'wx4017370269f048b0';
$secret = '625b51560e56e7e2e86739b543c466b0';

$timestamp = time();
$nonceStr  = randomstr(16);

$result = $memcache->get($key);

if (empty($result))
{
    $getTokenApi = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid={$appid}&secret={$secret}";

    $data = http_get($getTokenApi);

    $data = json_decode(trim($data), TRUE);

    $accessToken = $data['access_token'];

    if ($accessToken)
    {
        $getJsapiTicketApi = "https://api.weixin.qq.com/cgi-bin/ticket/getticket?access_token={$accessToken}&type=jsapi";

        $data = http_get($getJsapiTicketApi);
        
        $data = json_decode(trim($data), TRUE);
        
        if ($data['ticket'])
        {
            $memcache->set($key, $data['ticket'], 5400); // 有效时间1.5小时
        }
        else
        {
            exit('request jsapi_ticket failed !');
        }
    }
    else 
    {
        exit('request access_token failed !');
    }
    // die('get from weixin api : ' . $memcache->get($key));
}
else
{
    // die('get from memcache : ' . $memcache->get($key));
}

$string1 = "jsapi_ticket=".$memcache->get($key)."&noncestr={$nonceStr}&timestamp={$timestamp}&url=".curPageURL();

$signature = sha1($string1);

?>