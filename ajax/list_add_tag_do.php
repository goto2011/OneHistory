<?php
    // created by duangan, 2015-2-4-->
    // support to do time list add tag.    -->
 
    
    require_once '../init.php';
    is_user(1);
    require_once "sql.php";
    
    if(empty($_POST['operate_type']))
    {
        echo "parameter_error";
        exit;
    }
    
    $conn = open_db();
    

    // exit.
    mysql_close($conn);
    $conn = null;
    
?>