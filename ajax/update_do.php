<?php
    require_once '../init.php';
    is_user(2);
	require_once "data.php";
    require_once "sql.php";
    
    // 先确认时间格式对不对.
    $time_array = get_time_from_native(html_encode($_POST['time']));
    if ($time_array['status'] != "ok")
    {
        ajax_error_exit(error_id::ERROR_TIME_FAIL);
    }
    else
    {
        if (empty($_POST['time_limit']))
        {
            $time_array['time_limit'] = 0;
        }
        else 
        {
            $time_array['time_limit'] = html_encode($_POST['time_limit']);
        }
        $time_array['time_limit_type'] = html_encode($_POST['time_limit_type']);
    
    	// 避免重复提交
    	if((!isset($_POST['originator'])) || (user_update_token($_POST['originator']) != 1))
    	{
            $GLOBALS['log']->error("update_do.php: 有人绕开正常的流程重复提交表单.");
            ajax_error_exit(error_id::ERROR_PROGRASS_FAIL);
    	}
    	
    	if(isset($_SESSION['update_input_thing_uuid']))
    	{
    		$thing_uuid = html_encode($_SESSION['update_input_thing_uuid']);
    		unset($_SESSION['update_input_thing_uuid']);
    	}
    	else
    	{
            ajax_error_exit(error_id::ERROR_PROGRASS_FAIL);
    	}
    	
    	if(isset($_SESSION['update_input_is_edit']))
    	{
    		$is_edit = html_encode($_SESSION['update_input_is_edit']);
    		unset($_SESSION['update_input_is_edit']);
    	}
    	else
    	{
            ajax_error_exit(error_id::ERROR_PROGRASS_FAIL);
    	}
    
    	$conn = open_db();
        $update_return = 0;
    	
    	// 1. 读入输入界面传入的更新数据。
        $thing = html_encode($_POST['thing']);
        
    	if($is_edit == 0)
    	{
            // 新增(不再提供该功能)
    		// $thing_uuid = insert_thing_to_db($time_array, $thing);
    	}
    	else
    	{
            // 更新
    		$update_return = update_thing_to_db($thing_uuid, $time_array, $thing);
    	}
    	
    	// 2.保存tags
    	if(strlen($thing_uuid) > 0)
    	{
            insert_tag_from_input($_POST, $thing_uuid);
    	}
        
    	// exit.
    	mysql_close($conn);
    	$conn = null;
    	
    	// 保存成功
    	if (($is_edit == 0) && (strlen($thing_uuid) > 0))
    	{
            ajax_error_exit(error_id::ERROR_OK);
    	}
    	else if(($is_edit == 1) && ($update_return == 1))
    	{
            ajax_error_exit(error_id::ERROR_OK);
    	}
    	else
    	{
            ajax_error_exit(error_id::ERROR_FAIL);
    	}
	}
?>