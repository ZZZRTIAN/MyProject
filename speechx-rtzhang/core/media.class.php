<?php
namespace Speechx\Core;
/**
 * author: speechx-rtzhang
 * Date: 2016/12/26
 * Time: 10:39
 */
class Media{

    /**
     * 下载发送的语音消息 到指定文件夹
     * @param $mediaId
     * @param string $save_dir
     * @param string $filename
     * @return array|bool
     */
    public static function download($mediaId,$save_dir='',$filename=''){
    	$accessToken = AccessToken::getAccessToken();
		$url = "http://file.api.weixin.qq.com/cgi-bin/media/get?access_token=$accessToken&media_id=$mediaId";

		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_HEADER, 0);    
		curl_setopt($ch, CURLOPT_NOBODY, 0);    //只取body头
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$package = curl_exec($ch);
		$httpinfo = curl_getinfo($ch);
		curl_close($ch);
		$fileInfo = array_merge(array('header' => $httpinfo), array('body' => $package)); 
		 
		if(trim($save_dir)==''){
            $save_dir='./';
        }
        if(0!==strrpos($save_dir,'/')){
            $save_dir.='/';
        }

        if(!file_exists($save_dir)&&!mkdir($save_dir,0777,true)){
            return false;
        }

		$local_file = fopen($save_dir.$filename, 'w');
		if (false !== $local_file){
		      if (false !== fwrite($local_file, $fileInfo["body"])) {
		          fclose($local_file);
		      }
		}
		return array('file_name'=>$filename,'save_path'=>$save_dir.$filename);
    }

    /**
     * 添加永久素材
     *
     * 公众号的素材库保存总数量有上限：图文消息素材、图片素材上限为5000，其他类型为1000。
     *
        素材的格式大小等要求与公众平台官网一致：
        图片（image）: 2M，支持bmp/png/jpeg/jpg/gif格式
        语音（voice）：2M，播放长度不超过60s，mp3/wma/wav/amr格式
        视频（video）：10MB，支持MP4格式
        缩略图（thumb）：64KB，支持JPG格式
     * @param $file_info     文件信息
     * @param $type          类型
     * @param $title         素材的标题
     * @param $introduction  素材的描述
     * @return {
                "media_id":MEDIA_ID,
                "url":URL
                }
     */
    public static function addMaterial($file_info,$type){
        $accessToken = AccessToken::getAccessToken();
        $url = 'http://file.api.weixin.qq.com/cgi-bin/media/upload?access_token='.$accessToken.'&type='.$type;
        $data = array(
            "media"=>"@".$file_info['filename'],
            "form-data"=>$file_info
        );
        return Curl::CallWebServer($url,'post',json_encode($data));
    }

    /**
     * 获取永久素材的列表
     * @param $type    素材的类型，图片（image）、视频（video）、语音 （voice）、图文（news）
     * @param $offset  从全部素材的该偏移位置开始返回，0表示从第一个素材 返回
     * @param $count   返回素材的数量，取值在1到20之间
     * @return
     * {
            "total_count": TOTAL_COUNT,
            "item_count": ITEM_COUNT,
            "item": [{
                "media_id": MEDIA_ID,
                "name": NAME,
                "update_time": UPDATE_TIME,
                "url":URL
                },
            //可能会有多个素材
            ]
        }
     */
    public static function getMediaList($type,$offset=0,$count=20){
        $accessToken = AccessToken::getAccessToken();
        $url = "https://api.weixin.qq.com/cgi-bin/material/batchget_material?access_token=".$accessToken;
        $data = array(
            'type'=>$type,
            'offset'=>$offset,
            'count'=>$count
        );
        return Curl::CallWebServer($url,'post',json_encode($data));
    }

    /**
     * 获取素材总数
     * @return
     * {
        "voice_count":COUNT,
        "video_count":COUNT,
        "image_count":COUNT,
        "news_count":COUNT
        }
     *
     */
    public static function getMediaCount(){
        $accessToken = AccessToken::getAccessToken();
        $url = "https://api.weixin.qq.com/cgi-bin/material/get_materialcount?access_token=".$accessToken;
        return Curl::CallWebServer($url);
    }


}


?>