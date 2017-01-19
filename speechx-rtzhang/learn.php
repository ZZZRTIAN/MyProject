<?php
/**
 * author: speechx-rtzhang
 * Date: 2016/12/24
 * Time: 10:45
 */
include("init.inc.php");
include_once 'core/jsapiticket.class.php';

//$list = \Speechx\Core\Media::getMediaList('voice');
//$count = \Speechx\Core\Media::getMediaCount();
//
//echo "<pre>";
//var_dump($list);
//echo "</pre><br/><br/>";
//echo "<pre>";
//print_r($count);
//echo "</pre>";
//$smarty->assign('res',$res);

$url = "http://zhangruitiana.top/speechx-rtzhang/learn.php";
$timestamp = time();
$jsapi_ticket = \Speechx\Core\jsapiTicket::getTicket();
$nonceStr = \Speechx\Core\jsapiTicket::getRandCode();
$signature = "jsapi_ticket=".$jsapi_ticket.
    "&noncestr=".$nonceStr.
    "&timestamp=".$timestamp.
    "&url=".$url;
//var_dump($signature);
$signature = sha1($signature);
//var_dump($signature);

$smarty->assign('appid',APPID);
$smarty->assign('timestamp',$timestamp);
$smarty->assign('jsapi_ticket',$jsapi_ticket);
$smarty->assign('nonceStr',$nonceStr);
$smarty->assign('signature',$signature);

$smarty->display('learn.html');

?>
