<?php
// created by duangan, 2015-03-30 -->
// follow 相关的函数。主要是和sql相关的。    -->

// 判断当前 tag 是否已关注
function is_followed($tag_uuid)
{
    $user_id = get_user_id();
    
    $sql_string = "select * from follow where property_UUID = '$tag_uuid' 
        and user_UUID = '$user_id'";
    if(($result = mysql_query($sql_string)) == FALSE)
    {
        $GLOBALS['log']->error("error: is_followed() -- $sql_string 。");
        return FALSE;
    }
    
    if (mysql_num_rows($result) > 0)
    {
        return TRUE;
    }
    else
    {
        return FALSE;
    }
}

// 获取多少人已关注.
function get_follows_count($tag_uuid)
{
    $sql_string = "select count(user_UUID) from follow where property_UUID = '$tag_uuid'";
    if(($result = mysql_query($sql_string)) == FALSE)
    {
        $GLOBALS['log']->error("error: get_follows_count() -- $sql_string 。");
        return -1;
    }
    $row = mysql_fetch_row($result);    // 返回一行.
    return $row[0];
}

// 将 follow 信息保存到数据库中去。return 1, ok；return 0，fail。
function insert_follow_to_db($tag_uuid)
{
    $user_id = get_user_id();
    // 是否已关注.
    if(is_followed($tag_uuid) == FALSE)
    {
        $sql_string = "INSERT INTO follow(property_UUID, user_UUID, add_time)
            VALUES('$tag_uuid', '$user_id', now())";
        
        if(mysql_query($sql_string))
        {
            // 完成加分.
            update_tag_hot_index(get_follow_hot_rate(), $tag_uuid);
            return 1;
        }
        else
        {
            $GLOBALS['log']->error("error: insert_follow_to_db() -- $sql_string 。");
            return 0;
        }
    }
    else 
    {
        return 0;
    }
}

// 删除 follow 信息。return 1, ok；return 0，fail。
function un_follow_to_db($tag_uuid)
{
    $user_id = get_user_id();
    if(is_followed($tag_uuid) == TRUE)
    {
        $sql_string = "delete from follow where property_UUID = '$tag_uuid' and user_UUID = '$user_id'";
        if(mysql_query($sql_string))
        {
            // 完成减分.
            update_tag_hot_index(0 - get_follow_hot_rate(), $tag_uuid);
            return 1;
        }
        else
        {
            $GLOBALS['log']->error("error: un_follow_to_db() -- $sql_string 。");
            return 0;
        }
    }
    else 
    {
        return 0;
    }
}

?>