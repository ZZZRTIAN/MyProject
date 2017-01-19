<?php
namespace Speechx\Core;
/**
 * author: speechx-rtzhang
 * Date: 2016/12/20
 * Time: 18:19
 */

class WechatRequest{

    /**
     * @descrpition 分发请求
     * @param $request
     * @return string
     */
    private static $conn;

    public function switchType($request){
        $data = array();
        $str = "";
        foreach ($request as $key =>$value){
            $str .=$key.":".$value."\n";
        }
        ResponseInitiative::text($request['open_id'], $str);

        if (isset($request['device_id'])){
            switch ($request['msg_type']){
                case 'bind':
                    $data = self::eventBind($request);
                    break;
                case 'unbind':
                    $data = self::eventUnbind($request);
                    break;
                default:
                    return ResponsePassive::text($request['fromusername'], $request['tousername'], '收到未知的消息，我不知道怎么处理');
                    break;
            }
        }

        switch ($request['msgtype']) {
        /** 微信服务器接收 **/
            //事件
            case 'event':
                $request['event'] = strtolower($request['event']);
                switch ($request['event']) {
                    //关注
                    case 'subscribe':
                        //普通关注
                        $data = self::eventSubscribe($request);
                        //二维码关注

                        break;
                    //取消关注
                    case 'unsubscribe':
                        $data = self::eventUnSubscribe($request);
                        break;
                    //自定义菜单 - 点击菜单拉取消息时的事件推送
                    case 'click':
                        $data = Event::eventType($request);
                        break;
                }
                break;
            //文本
            case 'text':
                $data = self::text($request);
                break;
            //图像
            case 'image':
                
                break;
            //语音
            case 'voice':
                $data = self::voice($request);
                break;
            //视频
            case 'video':
                
                break;
            //小视频
            case 'shortvideo':
                
                break;
            //位置
            case 'location':
                
                break;
            //链接
            case 'link':
                
                break;
            default:
                return ResponsePassive::text($request['fromusername'], $request['tousername'], '收到未知的消息，我不知道怎么处理');
                break;
        }
        return $data;
    }


    /**
     * @descrpition 文本
     * @param $request
     * @return array
     */
    public static function text(&$request){
        $content = '收到文本消息';

        if (self::stateType($request['fromusername'])['state']==2){

            $apihost = "http://fanyi.youdao.com/";
            $apimethod = "openapi.do?";
            $apiparams = array('keyfrom'=>"speechx-rtzhang",
                'key'=>"1102135283",
                "type"=>"data",
                "doctype"=>"json",
                "version"=>"1.1",
                "q"=>$request['content']);
            $url = $apihost.$apimethod.http_build_query($apiparams);
            $youdao = Curl::CallWebServer($url);

            $result = "";
            switch ($youdao['errorCode']){
                case 0:
                    if (isset($youdao['basic'])){
                        $result .= $request['content']."  [".$youdao['basic']['phonetic']."]\n";
                        foreach ($youdao['basic']['explains'] as $value) {
                            $result .= $value."\n";
                        }
                    }else{
                        $result .= $youdao['translation'][0];
                    }
                    break;
                default:
                    $result = "系统错误：错误代码：".$youdao['errorCode'];
                    break;
            }
            $content = trim($result);
        }

        return ResponsePassive::text($request['fromusername'], $request['tousername'], $content);
    }

    /**
     * @descrpition 语音
     * @param $request
     * @return array
     */
    public static function voice(&$request){
        /*if (判断标志 当前的标志 是否是已点击菜单){
            $str ='你点击了菜单了';
            //将语音内容保存下来
        }else{
            //如果当前 标志为 未点击菜单
            //告诉用户
        }*/

//        $mediaId = $request['MediaId'];
//        $str = serialize($request);
//        $arr = WeixinFile::saveFile($request['MediaId']);
        $fromusername = $request['fromusername'];
        $content = '这是直接发送所收到语音';

        if (self::stateType($fromusername)['state']==1){
            $mediaId = $request['mediaid'];
            $res = Media::download($mediaId,'./download/'.$fromusername,time().'.mp3');
            $content = '这是点击菜单后发送所收到语音,保存路径为：'.$res['save_path'];
            $sql2 = "UPDATE `user` SET `state` = '0' WHERE `openid` ='".$fromusername."'";
            self::$conn->exec($sql2);
        }

        return ResponsePassive::text($request['fromusername'], $request['tousername'], $content);
    }

    /**
     * @descrpition 关注
     * @param $request
     * @return array
     */
    public static function eventSubscribe(&$request){
        $conn = DbConn::getInstance();
        $content ='干嘛关注我';
        $sql = "INSERT INTO `user` (`id`, `openid`) VALUES (NULL, '".$request['fromusername']."')";
        if ($conn->exec($sql)!== false){
            $content = '欢迎您关注我们的微信，将为您竭诚服务.'.$request['fromusername'];
        }

        return ResponsePassive::text($request['fromusername'], $request['tousername'], $content);
    }

    /**
     * @descrpition 退订
     * @param $request
     */
    public static function eventUnSubscribe(&$request){
        //删除设备。删除用户信息？？？？

    }

    /**
     * <xml>
        <ToUserName><![CDATA[%s]]></ToUserName>     接收方（公众号）的user name
        <FromUserName><![CDATA[%s]]></FromUserName> 发送方（微信用户）的user name
        <CreateTime>%u</CreateTime>                 消息创建时间，消息后台生成
        <MsgType><![CDATA[%s]]></MsgType>           消息类型：device_event
        <DeviceType><![CDATA[%s]]></DeviceType>     设备类型，目前为“公众账号原始ID”
        <DeviceID><![CDATA[%s]]></DeviceID>         设备ID，第三方提供
        <Content><![CDATA[%s]]></Content>
        <SessionID>%lu</SessionID>
        <MsgID>%lu</MsgID>
        <OpenID><![CDATA[%s]]></OpenID>
        </xml>
     *    微信   ====》   第三方url
     * @descrpition 设备绑定
     * @param $request
     */
    public static function eventBind(&$request){
        //被动回复消息，由微信通过局域网传到设备

        //数据库的操作   为openid添加设备
        $conn = DbConn::getInstance();
        $sql = "UPDATE `user` SET `device_id` ='".$request['device_id']."' WHERE `openid`='".$request['open_id']."'";
        if ($conn->exec($sql)!== false){
            $msg = Device::transMsg($request['device_id'], $request['open_id'],'1' );
            $str = "";
            foreach ($msg as $key =>$value){
                $str .=$key.":".$value."\n";
            }
            return ResponseInitiative::text($request['open_id'],'绑定成功！'.$str);
        }
        return ResponseInitiative::text($request['open_id'],'绑定失败！');
    }

    /**
     * @descrpition 设备解绑
     * @param $request
     */
    public static function eventUnbind(&$request){
        //被动回复消息，由微信通过局域网传到设备

        //数据库的操作   为openid删除设备
        $conn = DbConn::getInstance();
        $sql = "UPDATE `user` SET `device_id` ='0' WHERE `openid`='".$request['open_id']."'";
        if ($conn->exec($sql)!== false){
            return ResponseInitiative::text($request['open_id'],'解绑成功！');
        }
        return ResponseInitiative::text($request['open_id'],'解绑成功！');
    }

    /**
     * @param $openid
     * @return array|null
     */
    public static function stateType($openid){
        self::$conn = DbConn::getInstance();
        $sql = "SELECT `state` FROM `user` WHERE `openid` ='".$openid."'";
        $res = self::$conn->queryOne($sql);
        return $res;
    }

}