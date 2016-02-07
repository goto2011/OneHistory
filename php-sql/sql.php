<?php
// created by duangan, 2014-12-28 -->
// support data deal function.    -->

require_once "functions.php";
require_once "config.php";

require_once "sql_config.php";
require_once "sql_tag.php";
require_once "sql_thing.php";
require_once "sql_search.php";
require_once "sql_user.php";
require_once "sql_period.php";
require_once "sql_follow.php";
require_once "sql_factory.php";

////////////////////////////////// 1.数据库管理 begin //////////////////////////
// 打开数据库
function open_db()
{
    global $db_host;
    global $db_username;
    global $db_password;
    global $db_name;
	$conn = @mysql_connect($db_host, $db_username, $db_password) or die("数据库链接错误!");
	mysql_select_db($db_name, $conn);	       // 打开数据库
	mysql_query("set names 'UTF8'");           // 使用utf8中文编码
	
	return $conn;
}

// 将数据库查询到的多条记录集一次放入一个数组（通用接口，暂时没有使用）
function mysql_fetch_all($result)
{
	if(!is_resource($result))
	{
		$GLOBALS['log']->error('$result 不是一个有效的资源');
		return false;
	}
	while($row = mysql_fetch_assoc($result))
	{
		$arr[]=$row;
	}
	return $arr;
}
////////////////////////////////// 1.数据库管理 end //////////////////////////

?>