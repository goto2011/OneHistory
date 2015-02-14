<?php
    // created by duangan, 2015-2-4 -->
    // support to do time list add tag.    -->
    
    require_once '../init.php';
    is_user(2);
    require_once "sql.php";
    
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
    $tag_type = $_POST['tag_type'];
    $tag_name = $_POST['tag_name'];
    
    for ($ii = 0; $ii < count($_POST['groupCheckbox']); $ii++)
    {
        $thing_uuid = $_POST['groupCheckbox'][$ii];
        $ok_count += insert_tag($tag_name, $tag_type, $thing_uuid);
    }
    
    if ($ok_count == count($_POST['groupCheckbox']))
    {
        echo "ok";
    }
    else 
    {
        echo "fail";
    }

    // exit.
    mysql_close($conn);
    $conn = null;
    
?>