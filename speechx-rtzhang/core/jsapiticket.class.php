<?php
namespace Speechx\Core;
/**
 * author: speechx-rtzhang
 * Date: 2016/12/29
 * Time: 9:26
 */
class jsapiTicket{
    
    public static function getTicket(){
        //检测本地是否已经拥有access_token，并且检测access_token是否过期
        $Ticket = self::_checkTicket();
        if($Ticket === false){
            $Ticket = self::_getTicket();
        }
        return $Ticket['ticket'];
    }

    /**
     * 采用http GET方式请求获得jsapi_ticket（有效期7200秒，开发者必须在自己的服务全局缓存jsapi_ticket）
     */
    private static function _getTicket(){
        $accessToken = AccessToken::getAccessToken();
        $url = "https://api.weixin.qq.com/cgi-bin/ticket/getticket?type=jsapi&access_token=".$accessToken;
        $Ticket = Curl::CallWebServer($url);

        $Ticket['time']= time();
        $TicketJson = json_encode($Ticket);

        // // 缓存token到文件中
        $f = fopen('jsapi_ticket', 'w+');
        if(fwrite($f, $TicketJson)){
            echo "token保存成功";
        }else{
            echo "失败";
        }
        // fwrite($f, $accessTokenJson)
        fclose($f);
        // var_dump($accessToken);
        return $Ticket;
    }
    
    private static function _checkTicket(){
        $data = file_get_contents('jsapi_ticket');
        $Ticket['value'] = $data;
        if (!empty($Ticket['value'])) {
            $Ticket = json_decode($Ticket['value'],true);
            // 预留10 秒的网络延迟
            if (time() - $Ticket['time'] < $Ticket['expires_in'] - 10) {
                return $Ticket;
            }
        }
        return false;
    }

    public static function getRandCode($num = 16) {
        $arr = array ('Q','W','E','R','T','Y','U','I','O','P','A','S','D','F','G','H','J',
            'K','L','Z','X','C','V','B','N','M','q','w','e','r','t','y','u','i','o','p',
            'a','s','d','f','g','h','j','k','l','z','x','c','v','b','n','m','0','1','2',
            '3','4','5','6','7','8','9'
        );
        $str = "";
        $max = count ( $arr );
        for($i = 1; $i <= $num; $i ++) {
            $key = rand ( 0, $max - 1 );
            $str .= $arr [$key];
        }
        return $str;
    }
    
}

?>