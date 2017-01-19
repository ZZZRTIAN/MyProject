<?php
namespace Speechx\Core;
/**
 * 发送被动响应 被动回复即自动回复
 * author: speechx-rtzhang
 * Date: 2016/12/20
 * Time: 18:24
 */

class ResponsePassive{

    /**
     * 回复单文本
     * @param $fromusername
     * @param $tousername
     * @param $content
     */
    public static function text($fromusername,$tousername, $content){
        $templete = "    <xml>
		                 <ToUserName><![CDATA[%s]]></ToUserName>
		                 <FromUserName><![CDATA[%s]]></FromUserName>
		                 <CreateTime>%s</CreateTime>
                         <MsgType><![CDATA[text]]></MsgType>
                         <Content><![CDATA[%s]]></Content>
                         </xml>";
        return sprintf($templete,$fromusername, $tousername, time(), $content);
    }

    /**
     * @param $title
     * @param $description
     * @param $picUrl
     * @param $url
     * @return string
     */
    public static function newsItem($title, $description, $picUrl, $url){
        $template = "<item>
                      <Title><![CDATA[%s]]></Title>
                      <Description><![CDATA[%s]]></Description>
                      <PicUrl><![CDATA[%s]]></PicUrl>
                      <Url><![CDATA[%s]]></Url>
                    </item>";
        return sprintf($template, $title, $description, $picUrl, $url);
    }

    /**
     * @param $fromusername
     * @param $tousername
     * @param $item
     * @return string
     */
    public static function news($fromusername,$tousername,$item){
        //多条图文消息信息，默认第一个item为大图,注意，如果图文数超过10，则将会无响应
        if(count($item) >= 10){
            //
        }
        $templete = "<xml>
                        <ToUserName><![CDATA[%s]]></ToUserName>
                        <FromUserName><![CDATA[%s]]></FromUserName>
                        <CreateTime>%s</CreateTime>
                        <MsgType><![CDATA[news]]></MsgType>
                        <ArticleCount>%s</ArticleCount>
                        <Articles>
                        %s
                        </Articles>
                    </xml>";
        return sprintf($templete,$fromusername,$tousername,time(),count($item),implode($item));
    }

    /**
     * @param $fromusername
     * @param $tousername
     * @param $deviceId     设备id
     * @param $sessionid    微信客户端生成的session id 因此响应中该字段第三方需要原封不变的带回
     * @param $content      消息内容，BASE64编码 公众平台会将响应的Content字段对应的base64编码的数据发送给微信终端，微信终端会进行解码，并将解码后的数据发送给设备。
     * @return string
     */
    public static function device($fromusername,$tousername,$deviceId,$sessionid,$content){
        $templete = "<xml>
                      <ToUserName><![CDATA[%s]]></ToUserName>
                      <FromUserName><![CDATA[%s]]></FromUserName>
                      <CreateTime>%u</CreateTime>
                      <MsgType><![CDATA[%s]]></MsgType>
                      <DeviceType><![CDATA[%s]]></DeviceType>
                      <DeviceID><![CDATA[%s]]></DeviceID>
                      <SessionID>%u</SessionID>
                      <Content><![CDATA[%s]]></Content>
                     </xml>";
        return sprintf($templete,$fromusername,$tousername,time(),'device_text',DEVICETYPE,$deviceId,$sessionid,$content);
    }

}



?>