<?php
    // created by duangan, 2015-2-4 -->
    // support to do time list add tag.    -->
    
    require_once '../init.php';
    is_user(2);
    require_once "sql.php";
    require_once "data.php";
    
    // thing_uuid list.
    if(empty($_POST['groupCheckbox']))
    {
        echo "parameter_error";
        exit;
    }
    
    if(empty($_POST['tag_type']))
    {
        echo "parameter_error";
        exit;
    }
    
    if(empty($_POST['tag_name']))
    {
        echo "parameter_error";
        exit;
    }
    
    $conn = open_db();
    
    $ok_count = 0;
    $tag_type = html_encode($_POST['tag_type']);
    $tag_name = html_encode($_POST['tag_name']);
    
    for ($ii = 0; $ii < count($_POST['groupCheckbox']); $ii++)
    {
        $thing_uuid = html_encode($_POST['groupCheckbox'][$ii]);
        $ok_count += insert_tag($tag_name, $tag_type, $thing_uuid);
    }
    
    // exit.
    mysql_close($conn);
    $conn = null;
    
    if ($ok_count == count($_POST['groupCheckbox']))
    {
        echo "ok";
    }
    else 
    {
        echo "fail";
    }
    
    header("refresh:1; url=" . $_SERVER['HTTP_REFERER']);
?>