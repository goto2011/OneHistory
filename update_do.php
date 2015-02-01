<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

<?php
    require_once 'init.php';
    is_user(1);
	require_once "data.php";
    require_once "sql.php";
    
	// 避免重复提交
	if((!isset($_GET['originator'])) || (user_update_token($_GET['originator']) != 1))
	{
        $GLOBALS['log']->error("update_do.php: 有人绕开正常的流程重复提交表单.");
		error_exit("请不要重复提交表单。谢谢。");
	}
	
	if(isset($_SESSION['update_input_thing_uuid']))
	{
		$thing_uuid = $_SESSION['update_input_thing_uuid'];
		unset($_SESSION['update_input_thing_uuid']);
	}
	else
	{
		error_exit("请按照正常流程访问本网站。谢谢。");
	}
	
	if(isset($_SESSION['update_input_is_edit']))
	{
		$is_edit = $_SESSION['update_input_is_edit'];
		unset($_SESSION['update_input_is_edit']);
	}
	else
	{
		error_exit("请按照正常流程访问本网站。谢谢。");
	}
?>

<title></title>
</head>
<body>

<?php
	$conn = open_db();
	
	// 1. 读入输入界面传入的更新数据。
    $time_array = array("status"=>"init", "time"=>0, "time_type"=>2, 
                    "time_limit"=>0, "time_limit_type"=>1);
	$thing = $_GET['thing'];
	$time_array['time'] = get_time_number($_GET['time'], $_GET['time_type']);
	$time_array['time_type']  = $_GET['time_type'];
	$time_array['time_limit'] = $_GET['time_limit'];
	$time_array['time_limit_type'] = $_GET['time_limit_type'];
    $time_array['status'] = "ok";
	
	$update_flag = 0;
	
	// 新增
	if($is_edit == 0)
	{
		$thing_uuid = insert_thing_to_db($time_array, $thing);
	}
	// 更新
	else
	{
		$update_flag = update_thing_to_db($thing_uuid, $time_array, $thing);
	}
	
	// 2.保存tags
	if(strlen($thing_uuid) > 0)
	{
		$index = 0;
		$index += insert_tags($_GET['start_tags'] , 1, $thing_uuid);
		$index += insert_tags($_GET['end_tags'] , 2, $thing_uuid);
		$index += insert_tags($_GET['source_tags'] , 3, $thing_uuid);
		$index += insert_tags($_GET['person_tags'] , 4, $thing_uuid);
		$index += insert_tags($_GET['geography_tags'] , 5, $thing_uuid);
		$index += insert_tags($_GET['free_tags'] , 6, $thing_uuid);
		$index += insert_tags($_GET['country_tags'] , 7, $thing_uuid);
		
		// echo "$index tags finished. <br/>";
	}
	
	// exit.
	mysql_close($conn);
	$conn = null;
	
	// 保存成功
	if (($is_edit == 0) && (strlen($thing_uuid) > 0))
	{
		echo "<p style='font-weight:bold;'>保存成功！</p>";
		alloc_update_token();
		header("refresh:1; url=./update_input.php?update_once=" . get_update_token());
	}
	else if(($is_edit == 1) && ($update_flag == 1))
	{
		echo "<p style='font-weight:bold;'>更新成功！</p>";
		echo "<script>history.go(-2);</script>";
	}
	else
	{
		echo "<p style='font-weight:bold;'>保存失败！返回修改. </p>";
		header("refresh:1; Location:.getenv('HTTP_REFERER')");
	}
	
?>

</body>
</html>

