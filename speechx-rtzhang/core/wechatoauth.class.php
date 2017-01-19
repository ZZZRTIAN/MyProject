<?php
namespace Speechx\Core;
/**
 * author: speechx-rtzhang
 * Date: 2017/1/10
 * Time: 17:05
 */
class WeChatOAuth{

    /**
     * 获取code
     * @param $redirect_uri     将会跳转到redirect_uri/?code=CODE&state=STATE 通过GET方式获取code和state
     * @param int $state
     * @param string $scope     snsapi_base不弹出授权页面，只能获得OpenId;snsapi_userinfo弹出授权页面，可以获得所有信息
     */
    public static function getCode($redirect_uri,$state=1,$scope='snsapi_base'){
        //公众号的唯一标识
        $appid = APPID;
        //授权后重定向的回调链接地址，请使用urlencode对链接进行处理
        $redirect_uri = WECHAT_URL . $redirect_uri;
        $redirect_uri = urlencode($redirect_uri);
        //返回类型，请填写code
        $response_type = 'code';
        //构造请求微信接口的URL
        $url = 'https://open.weixin.qq.com/connect/oauth2/authorize?appid='.$appid.'&redirect_uri='
            .$redirect_uri.'&response_type='.$response_type.'&scope='.$scope.'&state='.$state.'#wechat_redirect';
        //重定向
        return $url;
//        header('Location: '.$url, true, 301);
    }

    /**
     * 利用code获取access_token,这里通过code换取的网页授权access_token,与基础支持中的access_token不同。
     * @param $code             先调用getCode()得到 $code
     * @return Array(access_token, expires_in, refresh_token, openid, scope)
     */
    public static function getAccessTokenAndOpenId($code){
        //填写为authorization_code
        $grant_type = 'authorization_code';
        //构造请求微信接口的URL
        $url = 'https://api.weixin.qq.com/sns/oauth2/access_token?appid='
            .APPID.'&secret='.APPSECRET.'&code='.$code.'&grant_type='.$grant_type.'';
        //请求微信接口, Array(access_token, expires_in, refresh_token, openid, scope)
        return Curl::CallWebServer($url);
    }

    /**
     * 拉取用户信息(需scope为 snsapi_userinfo)
     * 如果网页授权作用域为snsapi_userinfo，则此时开发者可以通过access_token和openid拉取用户信息了。
     * @param $accessToken 网页授权接口调用凭证。通过本类的第二个方法getAccessTokenAndOpenId可以获得一个数组，数组中有一个字段是access_token，就是这里的参数。注意：此access_token与基础支持的access_token不同
     * @param $openId 用户的唯一标识
     * @param $lang 返回国家地区语言版本，zh_CN 简体，zh_TW 繁体，en 英语
     *
     * @return array("openid"=>"用户的唯一标识",
    "nickname"=>'用户昵称',
    "sex"=>"1是男，2是女，0是未知",
    "province"=>"用户个人资料填写的省份"
    "city"=>"普通用户个人资料填写的城市",
    "country"=>"国家，如中国为CN",
    //户头像，最后一个数值代表正方形头像大小（有0、46、64、96、132数值可选，0代表640*640正方形头像），用户没有头像时该项为空
    "headimgurl"=>"http://wx.qlogo.cn/mmopen/g3MonUZtNHkdmzicIlibx6iaFqAc56vxLSUfpb6n5WKSYVY0ChQKkiaJSgQ1dZuTOgvLLrhJbERQQ4eMsv84eavHiaiceqxibJxCfHe/46",
    //用户特权信息，json 数组，如微信沃卡用户为chinaunicom
    "privilege"=>array("PRIVILEGE1", "PRIVILEGE2"),
    );
     */
    public static function getUserInfo($accessToken, $openId, $lang='zh_CN'){
        $queryUrl = 'https://api.weixin.qq.com/sns/userinfo?access_token='. $accessToken
            . '&openid='. $openId .'&lang='.$lang;
        return Curl::callWebServer($queryUrl);
    }



}



?>