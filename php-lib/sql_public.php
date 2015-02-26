<?php
// created by duangan, 2015-2-25 -->
// 放那些时间系统和论坛都要访问的sql函数。    -->


// 根据 user_uuid 获取 thing 的数量
function get_thing_count_by_user($user_uuid, $sql_query_func)
{
    if (function_exists($sql_query_func))
    {
        $sql_string = "select count(*) from thing_time where user_UUID = '$user_uuid'";
        
        $result = $sql_query_func($sql_string);
        
        if($result == FALSE)
        {
           $GLOBALS['log']->error("error: get_thing_count_by_user() -- $sql_string 。");
           return -1;
        }
        
        $row = mysql_fetch_row($result);    // 返回一行.
        return $row[0];
    }
    else
    {
        return 0;
    }
}


// 根据 user_uuid 获取 tag 的数量
function get_tag_count_by_user($user_uuid)
{
    $sql_string = "select count(*) from property where user_UUID = '$user_uuid'";
    
    $result = mysql_query($sql_string);
    
    if($result == FALSE)
    {
       $GLOBALS['log']->error("error: get_tag_count_by_user() -- $sql_string 。");
       return -1;
    }
    
    $row = mysql_fetch_row($result);    // 返回一行.
    return $row[0];
}


// 根据 user_uuid 获取 thing_tag 的数量
function get_thing_tag_count_by_user($user_uuid)
{
    $sql_string = "select count(*) from thing_property where user_UUID = '$user_uuid'";
    
    $result = mysql_query($sql_string);
    
    if($result == FALSE)
    {
       $GLOBALS['log']->error("error: get_thing_tag_count_by_user() -- $sql_string 。");
       return -1;
    }
    
    $row = mysql_fetch_row($result);    // 返回一行.
    return $row[0];
}



?>