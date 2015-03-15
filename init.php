<?php
// created by duangan, 2015-1-25 -->
// support init function.    -->

    @session_start();

    set_include_path('.'.PATH_SEPARATOR.dirname(__FILE__).'/'  
        .PATH_SEPARATOR.dirname(__FILE__).'/php-lib/' 
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
    
    // 如果用户没有登陆, 则进入登录界面.
    function is_user($login_type)
    {
        if(user_is_login() == 0)
        {
            if ($login_type == 1)
            {
                header("Location:./login.php");
            }
            else 
            {
                header("Location:../login.php");
            }
        }
    }
    
    // 检查用户是否登录.
    function user_is_login()
    {
        if(!isset($_SESSION['user_id']))
        {
            // 清除状态.
            user_logout();
            return 0;
        }
        else 
        {
        	return 1;
        }
    }
    
    require_once "list_control.php";
    require_once "list_search.php";
    
    // 用户登陆处理
    function user_login($user_name, $user_UUID, $user_right)
    {
        //登录成功
        $_SESSION['user_name'] = $user_name;
        $_SESSION['user_id'] = $user_UUID;
        $_SESSION['user_right'] = $user_right;
        
        // 初始化界面参数.
        set_current_list(1);
        for ($ii = 1; $ii <= get_list_count(); $ii++)
        {
            list_param_init($ii);
        }
        search_param_init();
    }
    
    // 退出
    function user_logout()
    {
        unset($_SESSION['user_id']);
        unset($_SESSION['user_right']);
        unset($_SESSION['user_name']);
    }
?>