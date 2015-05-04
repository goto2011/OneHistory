<?php
    // created by duangan, 2015-1-26 -->
    // support follow_do.    -->
    
    require_once '../init.php';
    is_user(2);
    require_once "sql.php";
    require_once "data.php";
    
    // 关注标签
    if(!empty($_GET['follow_tag']))
    {
        $tag_uuid = html_encode($_GET['follow_tag']);
        $function_type = 1;
    }
    // 取消关注
    else if(!empty($_GET['un_follow_tag']))
    {
        $tag_uuid = html_encode($_GET['un_follow_tag']);
        $function_type = 2;
    }
    // 删除标签
    else if(!empty($_GET['delete_tag']))
    {
        // 检查用户权限是否满足，及指定tag是否可删除。
        if(is_deleter())
        {
            $tag_uuid = html_encode($_GET['delete_tag']);
            $function_type = 3;
            
            if (tag_is_vip($tag_uuid) == 1)
            {
                echo "vip_tag_delete_error";
                exit;
            }
        }
        else 
        {
            echo "parameter_error";
            exit;
        }
    }
    else 
    {
        echo "parameter_error";
        exit;
    }
    
    $conn = open_db();
    if($function_type == 1)
    {
        insert_follow_to_db($tag_uuid);
    }
    else if($function_type == 2)
    {
        un_follow_to_db($tag_uuid);
    }
    else if($function_type == 3)
    {
        delete_tag_to_db($tag_uuid);
    }

    // exit.
    mysql_close($conn);
    $conn = null;
    
    echo "ok";
    header("refresh:1; url=" . $_SERVER['HTTP_REFERER']);
?>