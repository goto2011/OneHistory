<?php
    require_once '../init.php';
    is_user(2);
	require_once "data.php";
    require_once "sql.php";
    
    // 1. 先确认时间格式对不对.
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
            ajax_error_exit(error_id::ERROR_PROGRASS_FAIL);
    	    }
    	
        // 2. 获取 thing uuid。
        $thing_uuid = "";
        	if(isset($_SESSION['update_input_thing_uuid']))
        	{
        		$thing_uuid = html_encode($_SESSION['update_input_thing_uuid']);
        		unset($_SESSION['update_input_thing_uuid']);
        	}
        	else
        	{
            ajax_error_exit(error_id::ERROR_PROGRASS_FAIL);
        	}
        	
        $conn = open_db();
        $update_return = 0;
    	
        	// 3. 更新事件
        $thing = html_encode($_POST['thing']);
        $is_metadata = is_metadata();
        
        $update_return = update_thing_to_db($thing_uuid, $time_array, $thing, $is_metadata, 0, 
                $_POST['death_person_count'], $_POST['hurt_person_count'], 
                $_POST['missing_person_count'], $_POST['word_count']);
        	
        	// 4. 更新tag
        	if(strlen($thing_uuid) > 0)
        	{
            insert_tag_from_input($_POST, $thing_uuid, $_POST['tags_string']);
        	}
            
        	// exit.
        	mysql_close($conn);
        	$conn = null;
        	
        	// 保存成功
        	if($update_return == 1)
        	{
                ajax_error_exit(error_id::ERROR_OK);
        	}
        	else
        	{
                ajax_error_exit(error_id::ERROR_UPDATE_FAIL);
        	}
	}
?>