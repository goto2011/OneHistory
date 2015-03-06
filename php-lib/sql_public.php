<?php
// created by duangan, 2015-2-25 -->
// 放那些时间系统和论坛都要访问的sql函数。    -->

// 根据 user_uuid 获取 thing 的数量
function get_thing_count_by_user($user_ids, $sql_query_func)
{
    if ((count($user_ids) == 0) && (!function_exists($sql_query_func)))
    {
        return null;
    }
    
    $add_thing = array();
    foreach ($user_ids as $user_id)
    {
        $sql_string = "select count(*) from thing_time where user_UUID = '$user_id'";
        $result = $sql_query_func($sql_string);
        
        if($result == FALSE)
        {
           $GLOBALS['log']->error("error: get_thing_count_by_user() -- $sql_string 。");
        }
        else 
        {
            $row = mysql_fetch_row($result);    // 返回一行.
            $add_thing[$user_id] = $row[0];
        }
    }
    
    return $add_thing;
}

// 根据 user_uuid 获取 tag 的数量
function get_tag_count_by_user($user_ids, $sql_query_func)
{
    if ((count($user_ids) == 0) && (!function_exists($sql_query_func)))
    {
        return null;
    }
    
    $add_tag = array();
    foreach ($user_ids as $user_id)
    {
        $sql_string = "select count(*) from property where user_UUID = '$user_id'";
        $result = $sql_query_func($sql_string);
        
        if($result == FALSE)
        {
           $GLOBALS['log']->error("error: get_tag_count_by_user() -- $sql_string 。");
        }
        else 
        {
            $row = mysql_fetch_row($result);    // 返回一行.
            $add_tag[$user_id] = $row[0];
        }
    }
    return $add_tag;
}


// 根据 user_uuid 获取 thing_tag 的数量
function get_thing_tag_count_by_user($user_ids, $sql_query_func)
{
    if ((count($user_ids) == 0) && (!function_exists($sql_query_func)))
    {
        return null;
    }
    
    $add_thing_tag = array();
    foreach ($user_ids as $user_id)
    {
        $sql_string = "select count(*) from thing_property where user_UUID = '$user_id'";
        $result = $sql_query_func($sql_string);
        
        if($result == FALSE)
        {
           $GLOBALS['log']->error("error: get_thing_tag_count_by_user() -- $sql_string 。");
        }
        else 
        {
            $row = mysql_fetch_row($result);    // 返回一行.
            $add_thing_tag[$user_id] = $row[0];
        }
    }
    return $add_thing_tag;
}



?>