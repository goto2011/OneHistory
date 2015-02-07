<?php
// created by duangan, 2015-1-25 -->
// support init function.    -->

    @session_start();

    set_include_path('.'.PATH_SEPARATOR.dirname(__FILE__).'/'  
        .PATH_SEPARATOR.dirname(__FILE__).'/php-lib/' 
        .PATH_SEPARATOR.dirname(__FILE__).'/ajax/' 
        .PATH_SEPARATOR.dirname(__FILE__).'/plog/'  
        .PATH_SEPARATOR.dirname(__FILE__).'/fluxbb/'  
        .PATH_SEPARATOR.dirname(__FILE__).'/fluxbb/include/' 
        .PATH_SEPARATOR.get_include_path());
     
     // 设置时区为北京时间.
     Date_default_timezone_set("PRC");
     
    // 打开 log 系统.
    require_once 'plog.php';
    Plog::set_config(include 'config.php');
    $log = Plog::factory(__FILE__);
    
    // 检查用户是否登录。如果没有则进入登陆界面。
    function is_user($is_need_check)
    {
        if ($is_need_check == 1)
        {
            if(!isset($_SESSION['user_id']))
            {
                header("Location:login.html");
                exit;
            }
        }
    }
?>