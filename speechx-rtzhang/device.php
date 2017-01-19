<?php
/**
 * author: speechx-rtzhang
 * Date: 2017/1/5
 * Time: 15:20
 */

include("init.inc.php");
include_once 'core/jsapiticket.class.php';
include_once 'core/wechatoauth.class.php';

$code = $_GET['code'];
$arr = \Speechx\Core\WeChatOAuth::getAccessTokenAndOpenId($code);
$smarty->assign("openId",$arr['openid']);

$conn = \Speechx\Core\DbConn::getInstance();
$sql = "SELECT `device_id` FROM `user` WHERE `openid`='".$arr['openid']."'";
$arr = $conn->queryOne($sql);
if (!isset($arr) || $arr['device_id']=='0'){
    //账号未绑定
    $smarty->display('_device.html');
    exit();
}


$url = 'http://zhangruitiana.top'.$_SERVER["REQUEST_URI"];
$timestamp = time();
$jsapi_ticket = \Speechx\Core\jsapiTicket::getTicket();
$nonceStr = \Speechx\Core\jsapiTicket::getRandCode();
$signature = "jsapi_ticket=".$jsapi_ticket."&noncestr=".$nonceStr."&timestamp=".$timestamp."&url=".$url;
$signature = sha1($signature);


$smarty->assign("deviceId",$arr['device_id']);
$smarty->assign('appid',APPID);
$smarty->assign('timestamp',$timestamp);
$smarty->assign('jsapi_ticket',$jsapi_ticket);
$smarty->assign('nonceStr',$nonceStr);
$smarty->assign('signature',$signature);

$smarty->display('device.html');

?>