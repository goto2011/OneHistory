<?php
    // created by duangan, 2015-1-27-->
    // support system_manager_do.    -->
 
    
    require_once '../init.php';
    is_user(2);
    require_once "sql.php";
    
    if(empty($_GET['operate_type']))
    {
        echo "parameter_error";
        exit;
    }
    
    $conn = open_db();
    
    // 计算时间轴指数
    if($_GET['operate_type'] == "re_calc_year_order")
    {
        if (re_calc_year_order() == 1)
        {
            echo "ok";
        }
        else
        {
            echo "fail";
        }
    }
    
    // 计算tag热门指数
    else if ($_GET['operate_type'] == "re_calc_tag_hot_index")
    {
        if (re_calc_tag_hot_index() == 1)
        {
            echo "ok";
        }
        else
        {
            echo "fail";
        }
    }
    
    // 自动将事件添加vip标签
    else if($_GET['operate_type'] == "re_thing_add_vip_tag")
    {
        if (vip_tag_search_to_db() == 1)
        {
            echo "ok";
        }
        else
        {
            echo "fail";
        }
    }

    // exit.
    mysql_close($conn);
    $conn = null;
    
?>