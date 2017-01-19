<?php
namespace Speechx;
/**
 * author: speechx-rtzhang
 * Date: 2016/12/20
 * Time: 17:58
 */

/**
 * 服务器配置
 */
define("TOKEN", "zrt");
define("ENCODING_AES_KEY", "");

/**
 * 开发者配置
 */
define("WECHAT_URL", 'http://zhangruitiana.top/speechx-rtzhang/');
define("APPID", "wx71a7612c1a56b9ac" );
define("APPSECRET", "529102b77614ab7e85a059a64245c863");
define("DEVICETYPE",'gh_2c2a6f676293');

/**
 * 配置下载语音的路径
 */
define("SPATH","" );

/**
 * 数据库配置
 */
define("DB_TYPE","mysql" );      //数据库类型
define("DB_HOST","localhost" );      // 服务器地址
define("DB_NAME","speechx-wx" );      // 数据库名
define("DB_USER","root" );      // 用户名
define("DB_PWD","root" );       // 密码
define("DB_PORT","3306" );      // 端口
define("DB_CHARSET", "utf-8");   // 数据库编码默认采用utf8


?>