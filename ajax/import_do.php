<?php
    require_once '../init.php';
    is_user(2);
    require_once "data.php";
	require_once "sql.php";
    
    if(empty($_POST['operate_type']) || (strlen($_POST['context']) == 0))
    {
        echo "fail";
        exit;
    }

	$conn = open_db();
    
    // 检查输入数据的正确性。
    if($_POST['operate_type'] == "check_data")
    {
        $error_line = handle_data_line(1);
        if ($error_line == 0)
        {
            echo "ok";
        }
        else
        {
            echo "fail -- " . $error_line;
        }
    }
    
    // 将数据插入数据库.
    if($_POST['operate_type'] == "update_data")
    {
        // 避免重复提交。
        if((!isset($_POST['originator'])) || (user_import_token($_POST['originator']) != 1))
        {
            $GLOBALS['log']->error("import_do.php: 有人绕开正常的流程重复提交表单.");
            echo "fail";
        }
        else
        {
            handle_data_line(2);
            // 更新成功
            alloc_import_token();
            echo "ok -- " . get_import_token(); 
        }
    }
    
    /**
     * 判断是否为“标签内保持序号”。
     */
    function is_index_inside_tag()
    {
        if (($_POST['index_inside_tag'] == "true") && (strlen($_POST['note_tags']) > 0))
        {
            return 1;
        }
        else 
        {
            return 0;
        }
    }

    /**
     * 按行读入数据并进行处理。返回0表示成功，其它值都表示有错误发生。
     * $operate_type==1, 数据校验。
     * $operate_type==2，数据输入。
     */
    function handle_data_line($operate_type)
    {
    	// 按行读入输入界面传入的批量数据。
    	$context = one_line_flag(html_encode($_POST['context']));
    	$token = strtok($context, "\r");
    	$index = 0;
        $thing_index_inside_tag = 0;
        
        // 获取标签内编号的基数。
        if (($operate_type == 2) && (is_index_inside_tag() == 1))
        {
            $thing_index_inside_tag = get_index_base_inside_tag($_POST['note_tags']);
        }
    	
    	while(($token != false) && (strlen($token) > 0))
    	{
    		$index++;
            $my_array = splite_string($token);
            if($my_array != FALSE)
            {
                // 校验数据
                if ($operate_type == 1)
                {
                    @$time_array = get_time_from_native($my_array['time']);
                    // 如果当前时间字段无法识别，则返回所在行数。
                    if($time_array['status'] != "ok")
                    {
                        return $index;
                    }
                }
                if ($operate_type == 2)
                {
                    if (is_index_inside_tag() == 1)
                    {
                        $thing_index_inside_tag++;
                        $thing_uuid = insert_thing_to_db(get_time_from_native($my_array['time']), $my_array['thing'], $thing_index_inside_tag);
                    }
                    else 
                    {
                        $thing_uuid = insert_thing_to_db(get_time_from_native($my_array['time']), $my_array['thing']);
                    }
        		    if ($thing_uuid != "")
                    {
                        insert_tag_from_input($_POST, $thing_uuid);
                    }
                    else 
                    {
                        $GLOBALS['log']->error("import_do.php: 数据插入失败. -- " . $my_array['time'] 
                            . " -- " . $my_array['thing']);
                    }
                }
            }
            else 
            {
                // 校验数据时，发现错误即返回。
                if ($operate_type == 1)
                {
                    return $index;
                }
                if ($operate_type == 2)
                {
                   $GLOBALS['log']->error("import_do.php: 时间格式错误. -- " . $token);
                }
            }
    		
    		// 下一行
    		$token = strtok("\r");
    	}
        
        return 0;
    }
	
	// exit.
	mysql_close($conn);
	$conn = null;
?>