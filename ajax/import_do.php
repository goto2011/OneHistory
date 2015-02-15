<?php
    require_once '../init.php';
    is_user(2);
	require_once "data.php";
	require_once "sql.php";
    
	// 避免重复提交
	if((!isset($_POST['originator'])) || (user_import_token($_POST['originator']) != 1))
	{
	    $GLOBALS['log']->error("import_do.php: 有人绕开正常的流程重复提交表单.");
		error_exit("请不要重复提交表单。谢谢。");
	}

	$conn = open_db();

	// 按行读入输入界面传入的批量数据。
	$context = html_encode($_POST['context']);
	$token = strtok($context, "\r");
	$line_total = substr_count($context, "\r");
	$index = 0;
	
	while(($token != false) && (strlen($token) > 0))
	{
		$index++;
        $my_array = splite_string($token);
        if($my_array != FALSE)
        {
		    insert_thing_to_db(get_time_from_native($my_array['time']), $my_array['thing']);
        }
        else 
        {
            $GLOBALS['log']->error("import_do.php: 时间格式错误. -- " . $token);
        }
		
		// 下一行
		$token = strtok("\r");
	}
	
	// exit.
	mysql_close($conn);
	$conn = null;
    
    // 导入成功
    echo "ok";
    alloc_import_token();
    header("refresh:1; url=../import_input.php?import_once=" . get_import_token());
?>