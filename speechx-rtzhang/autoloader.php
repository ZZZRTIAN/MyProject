<?php
namespace Speechx;
/**
 * 自动载入函数
 * author: speechx-rtzhang
 * Date: 2016/12/20
 * Time: 18:19
 */
class Autoloader{
    
	const NAMESPACE_PREFIX = 'Speechx\\';
    /**
     * 向PHP注册在自动载入函数
     */
    public static function register(){
        spl_autoload_register(array(new self, 'autoload'));
    }

    /**
     * 根据类名载入所在文件
     */
    public static function autoload($className){
        $namespacePrefixStrlen = strlen(self::NAMESPACE_PREFIX);
        if(strncmp(self::NAMESPACE_PREFIX, $className, $namespacePrefixStrlen) === 0){
            $className = strtolower($className);
            $filePath = str_replace('\\', DIRECTORY_SEPARATOR, substr($className, $namespacePrefixStrlen));
//            echo $filePath;
            $filePath = realpath(__DIR__ . (empty($filePath) ? '' : DIRECTORY_SEPARATOR) . $filePath . '.class.php');
            if(file_exists($filePath)){
                require_once $filePath;
            }else{
                echo $filePath;
            }
        }
    }
}

?>