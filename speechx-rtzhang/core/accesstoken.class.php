<?php
namespace Speechx\Core;
/**
 * author: speechx-rtzhang
 * Date: 2016/12/20
 * Time: 17:58
 */
class AccessToken{

	public static function getAccessToken(){
		//检测本地是否已经拥有access_token，并且检测access_token是否过期
        $accessToken = self::_checkAccessToken();
        if($accessToken === false){
            $accessToken = self::_getAccessToken();
        }
        // $accessToken = self::_getAccessToken();
        // echo "<br/><br/><br/><br/>";
        // var_dump($accessToken);
        return $accessToken['access_token'];
	}

	private static function _getAccessToken(){
		$url = 'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid='.APPID.'&secret='.APPSECRET;
		// var_dump($url);
        $accessToken = Curl::CallWebServer($url);

        $accessToken['time'] = time();
        $accessTokenJson = json_encode($accessToken);

        // // 缓存token到文件中
        $f = fopen('access_token', 'w+');
        if(fwrite($f, $accessTokenJson)){
        	//echo "token保存成功";
        }else{
        	echo "失败";
        }
        // fwrite($f, $accessTokenJson)
        fclose($f);
        // var_dump($accessToken);
        return $accessToken;
	}
	/*获取缓存起来的token  检验token 过期则重新获取*/
	private static function _checkAccessToken(){
		$data = file_get_contents('access_token');
		$accessToken['value'] = $data;
		if (!empty($accessToken['value'])) {
			$accessToken = json_decode($accessToken['value'],true);
			 // 预留10 秒的网络延迟  
			if (time() - $accessToken['time'] < $accessToken['expires_in'] - 10) {
				return $accessToken;
			}
		}
		return false;
	}

}

?>