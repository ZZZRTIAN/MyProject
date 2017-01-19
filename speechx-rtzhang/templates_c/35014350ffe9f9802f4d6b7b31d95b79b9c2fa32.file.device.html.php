<?php /* Smarty version Smarty-3.1.16, created on 2017-01-13 07:37:10
         compiled from "D:\xampp\htdocs\speechx-rtzhang\templates\device.html" */ ?>
<?php /*%%SmartyHeaderCode:145158759837167a93-34953944%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '35014350ffe9f9802f4d6b7b31d95b79b9c2fa32' => 
    array (
      0 => 'D:\\xampp\\htdocs\\speechx-rtzhang\\templates\\device.html',
      1 => 1484288776,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '145158759837167a93-34953944',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.16',
  'unifunc' => 'content_587598371f9211_74323103',
  'variables' => 
  array (
    'appid' => 0,
    'timestamp' => 0,
    'nonceStr' => 0,
    'signature' => 0,
    'openId' => 0,
    'deviceId' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_587598371f9211_74323103')) {function content_587598371f9211_74323103($_smarty_tpl) {?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>设备</title>
</head>
<body style="text-align: center">
<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<script src="./public/js/jquery-3.1.1.js"></script>
<script>
    wx.config({
        beta: true, // 开启内测接口调用，注入wx.invoke方法
        debug: true, // 开启调试模式,调用的所有api的返回值会在客户端alert出来，若要查看传入的参数，可以在pc端打开，参数信息会通过log打出，仅在pc端时才会打印。
        appId: '<?php echo $_smarty_tpl->tpl_vars['appid']->value;?>
', // 必填，公众号的唯一标识
        timestamp:'<?php echo $_smarty_tpl->tpl_vars['timestamp']->value;?>
', // 必填，生成签名的时间戳
        nonceStr: '<?php echo $_smarty_tpl->tpl_vars['nonceStr']->value;?>
', // 必填，生成签名的随机串
        signature: '<?php echo $_smarty_tpl->tpl_vars['signature']->value;?>
',// 必填，签名，见附录1
        jsApiList:  [
            'getWXDeviceTicket',

            //事件
            'onWXDeviceBindStateChange',     //设备绑定状态改变事件（解绑成功，绑定成功的瞬间，会触发）

        ]  // 必填，需要使用的JS接口列表，所有JS接口列表见附录2
    });
    wx.ready(function(){

        //设备绑定状态改变事件（解绑成功，绑定成功的瞬间，会触发）
        wx.on('onWXDeviceBindStateChange',function(res){
            //当监听到onWXDeviceBindStateChange，则表示微信客户端也同步了绑定关系。
        });

    });
    wx.error(function(res){
        alert("wx.error错误："+JSON.stringify(res));
    });

    //http://iot.weixin.qq.com/wiki/new/index.html?page=3-4-7
    //用户解除绑定  deviceId（必填）：设备id   type（必填）：获取的操作凭证类型，1:绑定设备 2:解绑设备
    function unBind(deviceId) {
//        wx.invoke('getWXDeviceTicket',{"deviceId":deviceId,"type":2,'connType':'lan'},function(res){
//            if(res.err_msg !="getWXDeviceTicket:ok"){
//                alert("获取操作凭证失败，请重试");
//                return;
//            }else{
//                alert("获取操作凭证成功");
                $.post("unbind.php",{deviceid:deviceId,openid:'<?php echo $_smarty_tpl->tpl_vars['openId']->value;?>
'},
                    function(data,status){
                        alert("数据：" + data + "\n状态：" + status);
                        location.reload();
                    }
                )
//            }
//        });
    }

</script>
<div style="margin: 0 auto;">
    <h1>我的设备</h1>
    <button onclick="unBind('<?php echo $_smarty_tpl->tpl_vars['deviceId']->value;?>
');" style="padding: 20px;font-size: 60px;">解绑</button>
</div>
</body>
</html><?php }} ?>
