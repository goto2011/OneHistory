<?php
// created by duangan, 2015-3-30 -->
// thing 相关的函数。主要是和sql相关的。    -->

// 根据thing uuid获取thing各项属性。
function get_thing_db($thing_uuid)
{
    $sql_string = "select * from thing_time where uuid='$thing_uuid'";
    $result = mysql_query($sql_string);
    if ($result == FALSE)
    {
        $GLOBALS['log']->error("error: get_thing_db() -- $sql_string 。");
    }
    
    return $result;
}

/**
 * 检查当前事件内容是否已存在。
 */
function thing_context_is_exist($thing_content)
{
    $sql_string = "select uuid from thing_time where thing='$thing_content'";
    $result = mysql_query($sql_string);
    if ($result == FALSE)
    {
        $GLOBALS['log']->error("error: thing_context_is_exist() -- $sql_string 。");
        return "";
    }
    $row = mysql_fetch_row($result);
    
    return $row[0];
}

/**
 * 根据
 */
function get_index_inside_tag($note_tags, $index)
{
    
}
 
 
/**
 * 将事件-时间数据写入数据库. 
 * @return: 返回时间的uuid。
 */
function insert_thing_to_db($time_array, $thing, $note_tags = "", $index = 0)
{
    if ($time_array['status'] != "ok")
    {
        $GLOBALS['log']->error("error: insert_thing_to_db() -- time array error.");
        return "";
    }
    
    $thing_uuid = "";
    $time = $time_array['time'];
    $time_type = $time_array['time_type'];
    $time_limit = $time_array['time_limit'];
    $time_limit_type = $time_array['time_limit_type'];
    $year_order = get_year_order($time, $time_type);
    
    if ((strlen($note_tags) > 0) && ($index > 0))
    {
        $my_thing_index = get_index_inside_tag($note_tags, $index);
    }
    else
    {
        $my_thing_index = 0;  
    }
    
    // 检查事件内容是否已存在。
    $thing_uuid = thing_context_is_exist($thing);
    if ($thing_uuid != "")
    {
        update_thing_to_db($thing_uuid, $time_array, $thing, $my_thing_index);
        return $thing_uuid;
    }

    $thing_uuid = create_guid();
    $sql_string = "INSERT INTO thing_time(uuid, time, time_type, time_limit, time_limit_type, 
       thing, add_time, public_tag, user_UUID, year_order, thing_index) VALUES('$thing_uuid', '$time', $time_type, 
       $time_limit, $time_limit_type, '$thing', now(), 1, '" . get_user_id() . "', $year_order, $my_thing_index)";
    
    if (mysql_query($sql_string) === TRUE)
    {
        return $thing_uuid;
    }
    else
    {
        $GLOBALS['log']->error("error: insert_thing_to_db() -- $sql_string 。" . mysql_error());
        return "";
    }
}

/**
 * 将事件的更新数据写入数据库.
 * @return: 成功返回1, 失败返回0.
 */
function update_thing_to_db($thing_uuid, $time_array, $thing, $thing_index = 0)
{
    if ($time_array['status'] != "ok")
    {
        $GLOBALS['log']->error("error: update_thing_to_db() -- time array error.");
        return 0;
    }
    
    $time = $time_array['time'];
    $time_type = $time_array['time_type'];
    $time_limit = $time_array['time_limit'];
    $time_limit_type = $time_array['time_limit_type'];
    $year_order = get_year_order($time, $time_type);
    
    // 保存数据
    $sql_string = "UPDATE thing_time set time = '$time', time_type = $time_type, thing = '$thing', 
        time_limit = $time_limit, time_limit_type = $time_limit_type , year_order = $year_order , 
        thing_index = $thing_index where uuid = '$thing_uuid' ";
    
    if (mysql_query($sql_string) === TRUE)
    {
        return 1;
    }
    else
    {
        $GLOBALS['log']->error("error: update_thing_to_db() -- $sql_string 。" . mysql_error());
        return 0;
    }
}

// 根据 list type 给出符合条件的条目数量。
function get_thing_count($list_type)
{
    switch ($list_type)
    {
        // 全部条目
        case 1:
            $sql_string = "select count(*) from thing_time";
            break;

        // 我的关注
        case 2:
            $sql_string = "select count(*) from thing_time where UUID in(select thing_UUID from thing_property
                where property_UUID in(select property_UUID from follow
                where user_UUID = '" . get_user_id() . "'))";
            break;

        // 最新标签，指1天内的
        case 3:
            $sql_string = "select count(*) from thing_time where UUID in(select thing_UUID from thing_property
                    where property_UUID in(select property_UUID from property
                    where DATE_SUB(CURDATE(), INTERVAL 1 DAY) <= date(add_time)))";
            break;

        // 事件分期
        case 4:
            $sql_string = "select count(*) from thing_time";
            break;

        default:
            $my_tag_id = get_tag_id_from_index($list_type);
            if ($my_tag_id != -2)
            {
                $sql_string = "select count(*) from thing_time where UUID in(select thing_UUID from thing_property
                    where property_UUID in(select property_UUID from property
                    where property_type = $my_tag_id))";
            }
            else
            {
                echo "string";    $GLOBALS['log']->error("error: get_thing_count() -- list_type error 。");
                return -1;
            }
    }

    $result = mysql_query($sql_string);
    if ($result == FALSE)
    {
        $GLOBALS['log']->error("error: get_thing_count() -- $sql_string 。");
        return -1;
    }

    $row = mysql_fetch_row($result);    // 返回一行.
    return $row[0];
}

// 获取 thing 表的字段
function get_thing_item_db($list_type, $offset, $page_size)
{
    $order_sub = " order by thing_time.year_order ASC limit $offset, $page_size ";
    
    switch ($list_type)
    {
        // 全部条目
        case 1:
            $sql_string = "select * from thing_time $order_sub";
            break;
    
        // 我的关注
        case 2:
            $sql_string = "select * from thing_time where UUID in(select thing_UUID from thing_property 
                where property_UUID in(select property_UUID from follow
                where user_UUID = '" . get_user_id() . "')) $order_sub ";
            break;
            
        // 最新，指7天内的
        case 3:
            $sql_string = "select * from thing_time where UUID in(select thing_UUID from thing_property 
                where property_UUID in(select property_UUID from property 
                where DATE_SUB(CURDATE(), INTERVAL 1 DAY) <= date(add_time))) $order_sub ";
            break;

        // 分期
        case 4:
            $sql_string = "select * from thing_time $order_sub";
            break;

        default:
            $my_tag_id = get_tag_id_from_index($list_type);
            if ($my_tag_id != -2)
            {
                $sql_string = "select * from thing_time where UUID in(select thing_UUID from thing_property
                    where property_UUID in(select property_UUID from property where property_type = $my_tag_id)) $order_sub ";
            }
            else
            {
                $GLOBALS['log']->error("error: get_thing_item_db() -- list_type error 。");
                return NULL;
            }
    }
    
    $result = mysql_query($sql_string);
    if($result == FALSE)
    {
        $GLOBALS['log']->error("error: get_thing_item_db() -- $sql_string 。");
        return NULL;
    }
    
    return $result;
}

?>