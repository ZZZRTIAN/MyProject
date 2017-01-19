<?php
namespace Speechx\Core;
/**
 * Curl封装类
 * author: speechx-rtzhang
 * Date: 2016/12/20
 * Time: 17:58
 */

class Curl{

	private static $_ch;

	/**
     * 调用外部url
     * @param $queryUrl
     * @param $param POST参数
     * @param string $method
     * @return bool|mixed
     */
	public static function CallWebServer($queryUrl,$method='get',$param=array()){
		if (empty($queryUrl)) {
            return false;
        }
        //格式化为小写
        $method = strtolower($method);
        $res = '';
        self::_init();
        if($method == 'get'){
        	$res = self::_HttpGet($queryUrl);
        }elseif ($method == 'post') {
        	$res = self::_HttpPost($queryUrl,$param);
        }
        if (!empty($res)) {
            return json_decode($res,true);
        }
        return true;
	}

	private function _init(){
		self::$_ch = curl_init();

        curl_setopt(self::$_ch, CURLOPT_RETURNTRANSFER, true);
	}

	private function _execute(){
		$response = curl_exec(self::$_ch);
		$errno = curl_errno(self::$_ch); //cURL函数库错误码

		if($errno > 0){
			return 'ERRNO!'.$errno;
		}
		return  $response;
	}

	private function _close(){
		if (is_resource(self::$_ch)) {
			curl_close(self::$_ch);
			return true;
		}
	}

	private function _HttpGet($url){

		curl_setopt(self::$_ch, CURLOPT_URL, $url);
		curl_setopt(self::$_ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt(self::$_ch, CURLOPT_HEADER, 0);
        curl_setopt(self::$_ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt(self::$_ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt(self::$_ch, CURLOPT_SSLVERSION, 1);

        $ret = self::_execute();
        self::_close();
        return $ret;
	}

	private function _HttpPost($url,$query){

		curl_setopt(self::$_ch, CURLOPT_URL, $url);
        curl_setopt(self::$_ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt(self::$_ch, CURLOPT_HEADER, 0);
        curl_setopt(self::$_ch, CURLOPT_POST, true );
        curl_setopt(self::$_ch, CURLOPT_POSTFIELDS, $query);
        curl_setopt(self::$_ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt(self::$_ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt(self::$_ch, CURLOPT_SSLVERSION, 1);

        $ret = self::_execute();
        self::_close();
        return $ret;  
	}
}


?>