<?php
namespace Speechx;
/**
 * author: speechx-rtzhang
 * Date: 2017/1/11
 * Time: 14:50
 */
use Speechx\Core\DbConn;
use Speechx\Core\Device;

include_once 'autoloader.php';
include_once 'config.php';

Autoloader::register();

$openid = $_POST['openid'];
$deviceid = $_POST['deviceid'];

$res = Device::UnBind($deviceid, $openid);

$conn = DbConn::getInstance();
$sql = "UPDATE `user` SET `device_id` ='0' WHERE `openid`='".$openid."'";

if ($conn->exec($sql)!==false && $res['base_resp']['errmsg']=='ok'){
    echo '解绑成功';
}else{
    echo '失败';
}


?>