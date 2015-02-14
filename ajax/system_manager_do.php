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

    // exit.
    mysql_close($conn);
    $conn = null;
    
?>