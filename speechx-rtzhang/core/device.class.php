<?php
namespace Speechx\Core;
/**
 * 设备相关 API
 * https://api.weixin.qq.com/device/ 下的API为设备相关API， 测试号可以调用，正式服务号需要申请权限后才能调用。
 *
 * author: speechx-rtzhang
 * Date: 2017/1/3
 * Time: 11:45
 */
class Device{

    /**
     * 批量授权/更新设备属性
     * 授权后设备才能进行绑定操作
     * $arr[] = deviceList("","","");先调用，再调用此方法
     * @param $devices      设备属性列表
     * @param $isCreate     是否首次授权： true 首次授权； false 更新设备属性
     * @return string
     */
    public static function authorize($devices) {
        $accessToken = AccessToken::getAccessToken();
        $url = "https://api.weixin.qq.com/device/authorize_device?access_token=".$accessToken;

        $arr = array(
            "device_num"=>count($devices),
            "device_list"=>$devices,
            "op_type"=>1
        );
        $arrJson = json_encode($arr);
        return $arrJson;
    }

    /**
     * 第三方发送设备状态消息给设备主人的微信终端。
     * @param $deviceID
     * @param $openID
     * @param $device_status
     * @return bool|mixed
     */
    public static function transMsg($deviceID,$openID,$device_status){
        $accessToken = AccessToken::getAccessToken();
        $url = "https://api.weixin.qq.com/device/transmsg?access_token=".$accessToken;
        $arr = array(
            "device_type"=>DEVICETYPE,
            "device_id"=>$deviceID,
            "open_id"=>$openID,
            "msg_type"=> "2",
            "device_status"=>$device_status
        );
        $arrJson = json_encode($arr);
        return Curl::CallWebServer($url,'post',$arrJson);
    }


    /**
     * 设备状态查询
     * @param $device_id
     *
     * {
     *      "errcode":0,
     *      "errmsg":"ok",
     *      "status":2,
     *      "status_info":"bind"
     *  }
     * 设备状态，目前取值如下： 0：未授权  1：已经授权（尚未被用户绑定） 2：已经被用户绑定 3：属性未设置
     */
    public static function getState($device_id){
        $accessToken = AccessToken::getAccessToken();
        $url = "https://api.weixin.qq.com/device/device/get_stat?access_token=".$accessToken."&device_id=".$device_id;
        return Curl::CallWebServer($url);
    }

    /**
     * 获取设备绑定的openid
     * @param $device_type  设备类型，目前为“公众账号原始ID”
     * @param $device_id    设备的deviceid
     */
    public static function getOpenId($device_type,$device_id){
        $accessToken = AccessToken::getAccessToken();
        $url = "https://api.weixin.qq.com/device/get_openid?access_token=".$accessToken."&device_type=".$device_type."&device_id=".$device_id;
    }

    /**
     * 设备绑定
     * @param $ticket       绑定操作合法性的凭证（由微信后台生成，第三方H5通过客户端jsapi获得）
     * @param $device_id    设备id
     * @param $openid       用户对应的openid
     * @return bool|mixed
     * 成功的Json返回结果：{base_resp:{"errcode": 0,"errmsg":"ok"}}
     * 失败的Json返回示例: {base_resp:{"errcode": -1,"errmsg":"system error"}}
     *
     * Curl::CallWebServer 已解码json
     */
    public static function Bind($ticket,$device_id,$openid){
        $accessToken = AccessToken::getAccessToken();
        $url = "https://api.weixin.qq.com/device/bind?access_token=".$accessToken;
        $arr = array(
            "ticket"=>$ticket,
            "device_id"=>$device_id,
            "openid"=>$openid
        );
        $arrJson = json_encode($arr);
        return Curl::CallWebServer($url,'post',$arrJson);
    }

    /**
     * 设备解绑
     * @param $ticket       绑定操作合法性的凭证（由微信后台生成，第三方H5通过客户端jsapi获得）
     * @param $device_id    设备id
     * @param $openid       用户对应的openid
     * @return bool|mixed
     * 成功的Json返回结果：{base_resp:{"errcode": 0,"errmsg":"ok"}}
     * 失败的Json返回示例: {base_resp:{"errcode": -1,"errmsg":"system error"}}
     *
     * Curl::CallWebServer 已解码json
     */
    public static function UnBind($device_id,$openid){
        $accessToken = AccessToken::getAccessToken();
        $url = "https://api.weixin.qq.com/device/compel_unbind?access_token=".$accessToken;
        $arr = array(
//            "ticket"=>$ticket,
            "device_id"=>$device_id,
            "openid"=>$openid
        );
        $arrJson = json_encode($arr);
        return Curl::CallWebServer($url,'post',$arrJson);
    }

    
    public static function deviceList($deviceId,$mac,$auth_key){
        $arr = array(
            "id"=>$deviceId,
            "mac"=>$mac,
            "connect_protocol"=>4,
            "auth_key"=>$auth_key,
            "close_strategy"=>1,       //断开策略，目前支持： 1：退出公众号页面时即断开连接 2：退出公众号之后保持连接不断开
            "conn_strategy"=>1,        //连接策略，1：（第1bit置位）在公众号对话页面，不停的尝试连接设备
                                        //        4：（第3bit置位）处于非公众号页面（如主界面等），微信自动连接。
            "crypt_method"=>1,         //auth加密方法，目前支持两种取值： 0：不加密 1：AES加密
            "auth_ver"=>1,
            "manu_mac_pos"=>-1,
            "ser_mac_pos"=>-2,
            "ble_simple_protocol"=>0
        );
        return $arr;
    }

}


?>