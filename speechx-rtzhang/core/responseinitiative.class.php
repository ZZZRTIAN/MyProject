<?php
namespace Speechx\Core;
/**
 * 主动向用户发送信息 例如推文啊
 * author: speechx-rtzhang
 * Date: 2016/12/21
 * Time: 10:21
 */
class ResponseInitiative
{

    protected static $queryUrl = 'https://api.weixin.qq.com/cgi-bin/message/custom/send?access_token=';

    protected static $action = 'POST';

    /**
     * 发送文本消息
     * @param $tousername
     * @param $content
     * @return bool|mixed
     */
    public static function text($tousername, $content){
        //获取ACCESS_TOKEN
        $accessToken = AccessToken::getAccessToken();

        //开始
        $template = array(
            'touser'=>$tousername,
            'msgtype'=>'text',
            'text'=>array(
                'content'=>urlencode($content),
            ),
        );
        $template = urldecode(json_encode($template));

        return Curl::CallWebServer(self::$queryUrl.$accessToken, self::$action,$template);
    }

    /**
     * 语音消息
     * @param $tousername
     * @param $mediaId
     * @return string
     */
    public static function voice($tousername, $mediaId){
        //获取ACCESS_TOKEN
        $accessToken = AccessToken::getAccessToken();

        //开始
        $template = array(
            'touser'=>$tousername,
            'msgtype'=>'voice',
            'voice'=>array(
                'media_id'=>$mediaId,
            ),
        );
        $template = json_encode($template);
        return Curl::callWebServer(self::$queryUrl.$accessToken, self::$action, $template);
    }





}

?>