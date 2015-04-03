<?php
    require_once '../init.php';
    is_user(2);
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
		$thing_uuid = html_encode($_SESSION['update_input_thing_uuid']);
		unset($_SESSION['update_input_thing_uuid']);
	}
	else
	{
		error_exit("请按照正常流程访问本网站。谢谢。");
	}
	
	if(isset($_SESSION['update_input_is_edit']))
	{
		$is_edit = html_encode($_SESSION['update_input_is_edit']);
		unset($_SESSION['update_input_is_edit']);
	}
	else
	{
		error_exit("请按照正常流程访问本网站。谢谢。");
	}

	$conn = open_db();
	
	// 1. 读入输入界面传入的更新数据。
    $thing = html_encode($_GET['thing']);
    
    $time_array = array("status"=>"init", "time"=>0, "time_type"=>2, 
                    "time_limit"=>0, "time_limit_type"=>1);
	$time_array['time'] = get_time_number(html_encode($_GET['time']), html_encode($_GET['time_type']));
	$time_array['time_type']  = html_encode($_GET['time_type']);
    if (empty($_GET['time_limit']))
    {
        $time_array['time_limit'] = 0;
    }
    else 
    {
        $time_array['time_limit'] = html_encode($_GET['time_limit']);
    }
	$time_array['time_limit_type'] = html_encode($_GET['time_limit_type']);
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
        insert_tag_from_input($_GET, $thing_uuid);
		// echo "$index tags finished. <br/>";
	}
	
	// exit.
	mysql_close($conn);
	$conn = null;
	
	// 保存成功
	if (($is_edit == 0) && (strlen($thing_uuid) > 0))
	{
		echo "ok";
		alloc_update_token();
		header("refresh:1; url=../update_input.php?update_once=" . get_update_token());
	}
	else if(($is_edit == 1) && ($update_flag == 1))
	{
		echo "ok";
		echo "<script>history.go(-2);</script>";
	}
	else
	{
		echo "fail";
		echo "<script>history.go(-2);</script>";
	}
	
?>