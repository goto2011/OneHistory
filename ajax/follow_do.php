<?php
    // created by duangan, 2015-1-26 -->
    // support follow_do.    -->
    
    require_once '../init.php';
    is_user(1);
    require_once "sql.php";
    
    if(!empty($_GET['tag_id']))
    {
        $tag_uuid = $_GET['tag_id'];
        $is_add_follow = TRUE;
    }
    else if(!empty($_GET['del_tag_id']))
    {
        $tag_uuid = $_GET['del_tag_id'];
        $is_add_follow = FALSE;
    }
    else 
    {
        echo "parameter_error";
        exit;
    }
    
    $conn = open_db();
    if($is_add_follow == TRUE)
    {
        insert_follow_to_db($tag_uuid);
    }
    else 
    {
        delete_follow_to_db($tag_uuid);
    }

    // exit.
    mysql_close($conn);
    $conn = null;
    
    echo "ok";
?>