<?php
// created by duangan, 2015-1-25 -->
// support init function.    -->

    @session_start();

    set_include_path('.'.PATH_SEPARATOR.dirname(__FILE__).'/'  
        .PATH_SEPARATOR.dirname(__FILE__).'/php-lib/' 
        .PATH_SEPARATOR.dirname(__FILE__).'/php-sql/' 
        .PATH_SEPARATOR.dirname(__FILE__).'/ajax/' 
        .PATH_SEPARATOR.dirname(__FILE__).'/plog/'  
        .PATH_SEPARATOR.dirname(__FILE__).'/bbs/'  
        .PATH_SEPARATOR.dirname(__FILE__).'/bbs/include/' 
        .PATH_SEPARATOR.get_include_path());
     
    // 设置时区为北京时间.
    Date_default_timezone_set("PRC");
    
    // 打开 log 系统.
    require_once 'plog.php';
    Plog::set_config(include 'plog_config.php');
    $log = Plog::factory(__FILE__);
    
    
    require_once "list_control.php";
    require_once "sql_user.php";
    
    // 如果用户没有登陆, 则进入登录界面.
    // $login_type: 1表示根目录下登陆；2表示子目录下登陆；3表示不需要账号即可访问的页面。
    function is_user($login_type)
    {
        if(user_is_login() == 0)
        {
            if ($login_type == 1)
            {
                header("Location:./login.php");
            }
            else if ($login_type == 2)
            {
                header("Location:../login.php");
            }
            else if ($login_type == 3)
            {
                
            }
        }
    }
    
    // 用户登陆处理
    function user_login($user_name, $user_UUID, $user_right)
    {
        // 用户信息写入后台。
        user_login_succ($user_name, $user_UUID, $user_right);
        
        // 界面参数重新初始化.
        list_control_reinit();
    }
?>