<?php
namespace Speechx\Core;
/**
 * 自定义菜单
 * author: speechx-rtzhang
 * Date: 2016/12/20
 * Time: 17:58
 */
class Menu{

	public function setMenu($menuList){
		//树形排布
        $menuList2 = $menuList;
        foreach($menuList as $key=>$menu){
            foreach($menuList2 as $k=>$menu2){
                if($menu['id'] == $menu2['pid']){
                    $menuList[$key]['sub_button'][] = $menu2;
                    unset($menuList[$k]);
                }
            }
        }
        //处理数据
        foreach($menuList as $key=>$menu){
            //处理type和code
            if(@$menu['type'] == 'view'){
                $menuList[$key]['url'] = $menu['code'];
                //处理URL。因为URL不能在转换JSON时被转为UNICODE
                $menuList[$key]['url'] = urlencode($menuList[$key]['url']);
            }else if(@$menu['type'] == 'click'){
                $menuList[$key]['key'] = $menu['code'];
            }else if(@!empty($menu['type'])){
                $menuList[$key]['key'] = $menu['code'];
                if(!isset($menu['sub_button'])) $menuList[$key]['sub_button'] = array();
            }
            unset($menuList[$key]['code']);
            //处理PID和ID
            unset($menuList[$key]['id']);
            unset($menuList[$key]['pid']);
            //处理名字。因为汉字不能在转换JSON时被转为UNICODE
            $menuList[$key]['name'] = urlencode($menu['name']);
            //处理子类菜单
            if(isset($menu['sub_button'])){
                unset($menuList[$key]['type']);
                foreach($menu['sub_button'] as $k=>$son){
                    //处理type和code
                    if($son['type'] == 'view'){
                        $menuList[$key]['sub_button'][$k]['url'] = $son['code'];
                        $menuList[$key]['sub_button'][$k]['url'] = urlencode($menuList[$key]['sub_button'][$k]['url']);
                    }else if($son['type'] == 'click'){
                        $menuList[$key]['sub_button'][$k]['key'] = $son['code'];
                    }else{
                        $menuList[$key]['sub_button'][$k]['key'] = $son['code'];
                        $menuList[$key]['sub_button'][$k]['sub_button'] = array();
                    }
                    unset($menuList[$key]['sub_button'][$k]['code']);
                    //处理PID和ID
                    unset($menuList[$key]['sub_button'][$k]['id']);
                    unset($menuList[$key]['sub_button'][$k]['pid']);
                    //处理名字。因为汉字不能在转换JSON时被转为UNICODE
                    $menuList[$key]['sub_button'][$k]['name'] = urlencode($son['name']);
                }
            }
        }
        //整理格式
        $data = array();
        $menuList = array_values($menuList);
        $data['button'] = $menuList;
        //转换成JSON
        $data = json_encode($data);
        $data = urldecode($data);
//        echo "<prev>";
//        print_r($data);
//        echo "</prev>";
        //获取ACCESS_TOKEN
        $accessToken = AccessToken::getAccessToken();
        // echo "<br/><br/><br/><br/>Token:";
        // var_dump($accessToken);
        $url = 'https://api.weixin.qq.com/cgi-bin/menu/create?access_token='.$accessToken;
        $result = Curl::CallWebServer($url, 'POST', $data);
//        echo "<br/><br/><br/><br/>";
//        var_dump($result);

        if($result['errcode'] == 0){
            return true;
        }
        return $result;
	}

	public static function delMenu(){
        //获取ACCESS_TOKEN
        $accessToken = AccessToken::getAccessToken();
        $url = 'https://api.weixin.qq.com/cgi-bin/menu/delete?access_token='.$accessToken;
        return Curl::callWebServer($url);
    }
}



?>