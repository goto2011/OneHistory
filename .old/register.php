<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

<?php
	if(!isset($_POST['submit']))
	{
	    header("Location:login.html");
	}
	$user_name = $_POST['user_name'];
	$password = $_POST['password'];
    @$email = $_POST['email'];
	
	//注册信息判断
	if(!preg_match('/^[\w\x80-\xff]{3,15}$/', $user_name))
	{
	    exit('错误：用户名不符合规定。<a href="javascript:history.back(-1);">返回</a>');
	}
	
	if(strlen($password) < 6)
	{
	    exit('错误：密码长度不符合规定。<a href="javascript:history.back(-1);">返回</a>');
	}
	
	// email地址检验
	if(!empty($email))
    {
    	if(!preg_match("/^[\w\-\.]+@[\w\-\.]+(\.\w+)+$/", $email))
    	{
    	   exit('错误：电子邮箱格式错误。<a href="javascript:history.back(-1);">返回</a>');
    	}
    }
	
    require_once 'init.php';
    require_once "data.php";
	require_once "sql.php";
	
	// 打开数据库
	$conn = open_db();
	
	if(check_user_exist($user_name) == 1)
	{
	    echo '错误：用户名 ',$user_name,' 已存在。<a href="javascript:history.back(-1);">返回</a>';
	    exit;
	}
	
	//写入数据
	if(insert_user($user_name, $password, $email) == 1)
	{
	    exit('用户注册成功！点击<a href="login.html">此处 登录</a>');
	}
	else
	{
	    echo '抱歉！注册用户失败。点击<a href="javascript:history.back(-1);">此处 返回</a> 重试';
	}
	
	// exit
	mysql_close($conn);
	$conn = null;
?>