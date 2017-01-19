<?php
namespace Speechx\Core;
/**
 * author: speechx-rtzhang
 * Date: 2016/12/23
 * Time: 14:31
 */
class DbConn
{
    private $conn = NULL;//连接对象
    private $rs = NULL;//结果集对象

    //连接数据库
    private function __construct()
    {
        $this->conn = mysql_connect(DB_HOST,DB_USER,DB_PWD);
        mysql_query("set names ".DB_CHARSET);
        mysql_select_db(DB_NAME);
    }
    //防止克隆
    private function __clone()
    {}
    //获得当前类的对象(单例设计模式)
    public static function getInstance()
    {
        static $obj = NULL;
        if($obj == NULL)
        {
            $obj = new DbConn();
        }
        return $obj;
    }
    //查询多条记录，返回值：二维数组
    public function queryAll($sql)
    {
        $result = array();//存储所有记录
        $this->rs = mysql_query($sql);
        while($row = mysql_fetch_array($this->rs))
        {
            $result[] = $row;
        }
        return $result;
    }
    //执行查询语句，返回值：一维数组
    public function queryOne($sql)
    {
        $result = NULL;//存储一条记录
        $this->rs = mysql_query($sql);
        if($row = mysql_fetch_assoc($this->rs))
        {
            $result = $row;
        }
        return $result;
    }
    //执行增、删、改语句，返回值：受影响的行数
    public function exec($sql)
    {
        mysql_query($sql);
        $row = mysql_affected_rows($this->conn);
        return $row;
    }
    //释放结果集
    private function freeResult()
    {
        mysql_free_result($this->rs);
    }
    //关闭数据库
    private function close()
    {
        mysql_close($this->conn);
    }
}
?>