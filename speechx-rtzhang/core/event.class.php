<?php
namespace Speechx\Core;
/**
 * author: speechx-rtzhang
 * Date: 2016/12/23
 * Time: 14:34
 */

class Event{

    /**
     * 事件类型
     * @param $request
     * @return array|string
     */
    public static function eventType(&$request){
        $eventKey = $request['eventkey'];
        $conn = DbConn::getInstance();
        switch ($eventKey){
            //中英互译
            case 'zy':
                $sql = "UPDATE `user` SET `state` = '2' WHERE `openid` ='".$request['fromusername']."'";
                if ($conn->exec($sql)!==false){
                    $str = "亲，你可以进行翻译了";
                }
                return ResponsePassive::text($request['fromusername'], $request['tousername'], $str);
                break;
            //鼓励孩子
            case 'encourage':
                /**将当前的标志改为 已点击菜单**/
                //现在是在事件里面
                $sql = "UPDATE `user` SET `state` = '1' WHERE `openid` ='".$request['fromusername']."'";
                if ($conn->exec($sql)!==false){
                    $str = "亲，你可以录音了";
                }
                //return 就退出了这个事件了
                return ResponsePassive::text($request['fromusername'], $request['tousername'], '亲快快鼓励您的孩子吧~~'.$str);
                break;
            //学习情况
            case 'learn':
                //创建图文消息内容
                $tuwenList[] = array('title'=>'标题1',
                    'description'=>'描述1',
                    'pic_url'=>'http://pic38.nipic.com/20140219/2531170_141850231000_2.jpg',
                    'url'=>'http://zhangruitiana.top/speechx-rtzhang/learn.php?openid='.$request['fromusername']
                );
                //$tuwenList[] = array('title'=>'标题2', 'description'=>'描述2', 'pic_url'=>'图片URL2', 'url'=>'点击跳转URL2');
                //构建图文消息格式
                $itemList = array();
                foreach ($tuwenList as $tuwen) {
                    $itemList[] = ResponsePassive::newsItem($tuwen['title'],
                        $tuwen['description'], $tuwen['pic_url'], $tuwen['url']);
                }
                return ResponsePassive::news($request['fromusername'], $request['tousername'], $itemList);
                break;
            //我的账户
            case 'my':
                //讲openid传递 web
                break;
            default:
                $content = '收到点击菜单事件，您设置的key是' . $eventKey;
                break;
        }
        return ResponsePassive::text($request['fromusername'], $request['tousername'], $content);
    }
}