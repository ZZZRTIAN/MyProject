<?php
namespace Speechx;
/**
 * author: speechx-rtzhang
 * Date: 2016/12/20
 * Time: 17:57
 */
use Speechx\Core\Wechat;
use Speechx\Core\WeChatOAuth;

include_once __DIR__.'/config.php';
include_once __DIR__.'/autoloader.php';
include_once __DIR__.'/core/wechatoauth.class.php';

Autoloader::register();

/**
 * 自定义菜单  重新验证的时候要注释掉
 */
//$menuList = array(
//    array('id'=>'1', 'pid'=>'',  'name'=>'功能', 'type'=>'', 'code'=>''),
//    array('id'=>'2', 'pid'=>'1',  'name'=>'中英互译', 'type'=>'click', 'code'=>'zy'),
//    array('id'=>'3', 'pid'=>'1',  'name'=>'单词修炼', 'type'=>'view', 'code'=>'http://zhangruitiana.top/'),
//    array('id'=>'4', 'pid'=>'1',  'name'=>'跟读训练', 'type'=>'click', 'code'=>'gd'),
//    array('id'=>'5', 'pid'=>'1',  'name'=>'情景对话', 'type'=>'click', 'code'=>'qj'),
//    array('id'=>'6', 'pid'=>'',  'name'=>'点读笔', 'type'=>'', 'code'=>''),
//    array('id'=>'7', 'pid'=>'6',  'name'=>'设备绑定', 'type'=>'view', 'code'=>WeChatOAuth::getCode('device.php')),
//    array('id'=>'8', 'pid'=>'6',  'name'=>'设备状态', 'type'=>'view', 'code'=>WeChatOAuth::getCode('device.php')),
//    array('id'=>'9', 'pid'=>'6',  'name'=>'教材下载', 'type'=>'view', 'code'=>'http://zhangruitiana.top/'),
//    array('id'=>'10', 'pid'=>'6',  'name'=>'学习情况', 'type'=>'click', 'code'=>'learn'),
//    array('id'=>'11', 'pid'=>'6',  'name'=>'鼓励孩子', 'type'=>'click', 'code'=>'encourage'),
//    array('id'=>'12', 'pid'=>'',  'name'=>'关于我们', 'type'=>'', 'code'=>''),
//    array('id'=>'13', 'pid'=>'12',  'name'=>'我的账户', 'type'=>'view', 'code'=>'http://zhangruitiana.top/'),
//    array('id'=>'14', 'pid'=>'12',  'name'=>'APP下载', 'type'=>'view', 'code'=>'http://zhangruitiana.top/'),
//    array('id'=>'15', 'pid'=>'12',  'name'=>'功能介绍', 'type'=>'view', 'code'=>'http://zhangruitiana.top/'),
//    array('id'=>'16', 'pid'=>'12',  'name'=>'常见问题', 'type'=>'view', 'code'=>'http://zhangruitiana.top/'),
//);
//\Speechx\Core\Menu::setMenu($menuList);
// \Speechx\Core\Menu::delMenu();
include_once 'core/wechat.class.php';
$wechat = new Wechat(TOKEN);
//$wechat->checkSignature();
//
echo $wechat->run();




?>