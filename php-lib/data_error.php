<?php
// created by duangan, 2015-8-16 -->
// support error handle function.    -->


class error_id {
    const ERROR_OK          = 1;
    const ERROR_FAIL        = 2;
    
    const ERROR_REPLAY_INPUT        = 3;
    const ERROR_PROGRASS_FAIL       = 4;
    const ERROR_TIME_FAIL           = 5;
    const ERROR_CONTEXT_EMPTY       = 6;
    
}

$error_total = array(
    "ok",                                   // 1
    "fail",                                 // 2
    
    "fail: 不要重复保存数据。",               // 3
    "fail: 请按照正常流程访问本网站。",        // 4
    "fail: 时间格式不合法。",                 // 5. 这个内容不要做修改. 因为 update_input.php succ_callback() 中将其写死.
    "fail: 内容为空。"                        // 6.
    
);

// 根据 error id 获取 error 字符串.
function get_error_string_from_id($error_id)
{
    global $error_total;
    return $error_total[$error_id - 1];
}

// 异常退出提示页面
function error_exit($exit_string)
{
    echo "<html>";
    echo "<head><meta http-equiv='Content-Type' content='text/html; charset=UTF-8'>";
    echo "<body>访问失败了！请返回上一页. </a><br /><br />";
    exit($exit_string);
    echo "</body></html>";
    echo "<script>history.go(-1);</script>";
    
    // header("refresh:1; url=../update_input.php?update_once=" . get_update_token());
    // echo "<script>history.go(-2);</script>";
}

/**
 * ajax页面异常退出返回值.
 */
function ajax_error_exit($exit_id)
{
    echo (get_error_string_from_id($exit_id));
    exit($exit_id);
}


?>