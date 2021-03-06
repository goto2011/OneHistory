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
    
    // 为元数据，tag_name 为空。
    if(empty($_POST['tag_name']) && ($_POST['tag_type'] != "is_metadata"))
    {
        echo "parameter_error";
        exit;
    }
    
    $conn = open_db();
    
    $add_thing_tag_number = 0;
    $tag_type = html_encode($_POST['tag_type']);
    $tag_name = html_encode($_POST['tag_name']);
    
    // 如果是新增标签
    if ($_POST['tag_type'] != "is_metadata")
    {
        // 如果标签是新的, 则插入.
        $tag_uuid = insert_tag($tag_name, $tag_type);
        
        for ($ii = 0; $ii < count($_POST['groupCheckbox']); $ii++)
        {
            $thing_uuid = html_encode($_POST['groupCheckbox'][$ii]);
            // 一个标签一个事件.
            $add_thing_tag_number += insert_thing_tag($tag_uuid, $thing_uuid);
            // 重新拼接 tag string。
            $result = get_thing_db($thing_uuid);
            while($row = mysql_fetch_array($result))
            {
                $old_tags = $row['property_types'];
            }
            $tag_types = array($tag_type);
            $update_string = update_tag_type_string($old_tags, $tag_types);
            if ($update_string != "-1")
            {
                update_tag_types_to_db($thing_uuid, $update_string);
            }
        }
        
        // 更新 tag 的 hot 指数.
        update_tag_hot_index($add_thing_tag_number, $tag_uuid);
    }
    else 
    {
        $add_thing_tag_number = update_metadata($_POST['groupCheckbox']);     
    }
    
    // exit.
    mysql_close($conn);
    $conn = null;
    
    if ($add_thing_tag_number == count($_POST['groupCheckbox']))
    {
        echo "ok";
    }
    else
    {
        $GLOBALS['log']->error("Error: list_add_tag.php, added: " .  $add_thing_tag_number . 
            ", total: " . count($_POST['groupCheckbox'])) . ".";
        echo "fail";
    }
    
    header("refresh:1; url=" . $_SERVER['HTTP_REFERER']);
?>