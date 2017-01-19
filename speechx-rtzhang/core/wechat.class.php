<?php
namespace Speechx\Core;
/**
 * author: speechx-rtzhang
 * Date: 2016/12/20
 * Time: 17:58
 */

class Wechat{

    /**
     * 以数组的形式保存微信服务器每次发来的请求
     * @var array
     */
    private $request;

    public function __construct($token){
        // 消息真假性验证
        if ($this->isValid() && $this->validateSignature($token)) {
            return $_GET['echostr'];
        }
        $file_in = file_get_contents('php://input');
        if (json_decode($file_in)){
            $arr = json_decode($file_in,true);
        }else{
            //接受并解析微信中心POST发送XML数据  simplexml_load_string() 函数把 XML 字符串载入对象中。  第二个参数规定新对象的 class。
            $arr = (array) simplexml_load_string($file_in, 'SimpleXMLElement', LIBXML_NOCDATA);
        }
        //将数组键名转换为小写
        $this->request = array_change_key_case($arr, CASE_LOWER);
    }

    /**
     * 分析消息类型，并分发给对应的函数
     * @return void
     */
    public function run() {
        return WechatRequest::switchType($this->request);
    }

    /**
     * 判断此次请求是否为验证请求
     * @return boolean
     */
    private function isValid(){
        return isset($_GET['echostr']);
    }

    /**
     * 判断验证请求的签名信息是否正确
     * @param string $token 验证信息
     * @return bool
     */

    private function validateSignature($token) {
        $signature = $_GET['signature'];
        $timestamp = $_GET['timestamp'];
        $nonce = $_GET['nonce'];
        $signatureArray = array($token, $timestamp, $nonce);
        sort($signatureArray, SORT_STRING);
        return sha1(implode($signatureArray)) == $signature;
    }


    //第一次接入需要调用次方法验证
    public function checkSignature()
    {
        $signature = $_GET["signature"];
        $timestamp = $_GET["timestamp"];
        $nonce = $_GET["nonce"];

        $token = TOKEN;
        $tmpArr = array($token, $timestamp, $nonce);
        sort($tmpArr, SORT_STRING);
        $tmpStr = implode( $tmpArr );
        $tmpStr = sha1( $tmpStr );

        if( $tmpStr == $signature ){
            echo $_GET['echostr'];
            return true;
        }else{
            return false;
        }
    }
    function is_not_json($str){
        return is_null(json_decode($str));
    }
}

?>