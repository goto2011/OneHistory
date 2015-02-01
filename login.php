<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

<?php
    require_once 'init.php';
    require_once "sql.php";
    require_once "data.php";
    require_once "list_control.php";
    require_once "list_search.php";

	//注销登录
	if(@$_GET['action'] == "logout")
	{
	    unset($_SESSION['user_id']);
        unset($_SESSION['user_right']);
	    unset($_SESSION['user_name']);
	    echo '已退出登陆！点击<a href="login.html">此处 登录</a>';
	    exit;
	}
	
	//登录
	if(!isset($_POST['submit']))
	{
		header("Location:login.html");
	}
    
	// 打开数据库
	$conn = open_db();
	
	//检测用户名及密码是否正确
	$user_array = user_validate(htmlspecialchars($_POST['user_name']), $_POST['password']);
	
	// exit
	mysql_close($conn);
	$conn = null;
    
	if($user_array['user_UUID'] != "")
	{
	    //登录成功
	    $_SESSION['user_name'] = $_POST['user_name'];
	    $_SESSION['user_id'] = $user_array['user_UUID'];
        $_SESSION['user_right'] = $user_array['user_right'];
	    
        // 初始化界面参数.
        set_current_list(1);
        for ($ii = 1; $ii <= get_list_count(); $ii++)
        {
            list_param_init($ii);
        }
        search_param_init();
        
	    echo $_POST['user_name'] . ", 欢迎您！<a href='item_frame.php'>请进入" .  
	           get_system_name() . "系统. " . get_system_version() . "</a>";
        header("refresh:1; url=./item_frame.php");
	    exit;
	} 
	else 
	{
	    $GLOBALS['log']->error("登陆失败! user_name: " . $_POST['user_name']);
	    exit('登录失败！点击此处 <a href="javascript:history.back(-1);">返回</a> 重试');
	}
?>