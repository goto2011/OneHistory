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
 * 根据 note tag 获取当前的index的基数。
 */
function get_index_base_inside_tag($note_tags)
{
    // 根据 $note_tags 获得对应tag的uuid。暂时不考虑多个 note tag的情况。
    $tag_uuid = get_tag_uuid_from_name($note_tags, get_note_tag_id());
    if ($tag_uuid == "")
    {
        return 0;
    }
    
    // 获取对应 note tag名下现存最大的 index值。如果没有，就返回零。
    $sql_string = "select max(thing_index) from thing_time where uuid in 
        (select thing_UUID from thing_property where property_UUID = '$tag_uuid')";
       
    $result = mysql_query($sql_string);
   
    if($result == FALSE)
    {
       $GLOBALS['log']->error("error: get_tag_uuid_from_name() -- $sql_string 。");
       return 0;
    }
   
    $row = mysql_fetch_row($result);    // 返回一行.
    if ($row[0] == "")
    {
        return 0;
    }
    
    return $row[0];
}
 
 
/**
 * 将事件-时间数据写入数据库. 
 * @return: 返回时间的uuid。
 */
function insert_thing_to_db($time_array, $thing, $thing_index = 0)
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
    
    // 检查事件内容是否已存在。
    $thing_uuid = thing_context_is_exist($thing);
    if ($thing_uuid != "")
    {
        update_thing_to_db($thing_uuid, $time_array, $thing, $thing_index);
        return $thing_uuid;
    }

    $thing_uuid = create_guid();
    $sql_string = "INSERT INTO thing_time(uuid, time, time_type, time_limit, time_limit_type, 
       thing, add_time, public_tag, user_UUID, year_order, thing_index) VALUES('$thing_uuid', '$time', $time_type, 
       $time_limit, $time_limit_type, '$thing', now(), 1, '" . get_user_id() . "', $year_order, $thing_index)";
    
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
            if ($my_tag_id > 0)
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

// 获取事件 查询子句。
function get_thing_substring($list_type, $offset, $page_size)
{
    $order_sub = " order by thing_time.year_order ASC, thing_time.thing_index ASC limit $offset, $page_size ";
    
    switch ($list_type)
    {
        // 全部条目
        case 1:
            $sql_string = " from thing_time $order_sub";
            break;
    
        // 我的关注
        case 2:
            $sql_string = " from thing_time where UUID in(select thing_UUID from thing_property 
                where property_UUID in(select property_UUID from follow
                where user_UUID = '" . get_user_id() . "')) $order_sub ";
            break;
            
        // 最新，指7天内的
        case 3:
            $sql_string = " from thing_time where UUID in(select thing_UUID from thing_property 
                where property_UUID in(select property_UUID from property 
                where DATE_SUB(CURDATE(), INTERVAL 1 DAY) <= date(add_time))) $order_sub ";
            break;

        // 分期
        case 4:
            $sql_string = " from thing_time $order_sub";
            break;

        default:
            $my_tag_id = get_tag_id_from_index($list_type);
            if ($my_tag_id > 0)
            {
                $sql_string = " from thing_time where UUID in(select thing_UUID from thing_property
                    where property_UUID in(select property_UUID from property where property_type = $my_tag_id)) $order_sub ";
            }
            else
            {
                $GLOBALS['log']->error("error: get_thing_substring() -- list_type error 。");
                return "";
            }
    }
    return $sql_string;
}

/**
 * 完成 事件、标签、事件-标签对的三表联合查询。
 */
function get_thing_tag_prompt($thing_substring, &$tag_id_array, &$tag_param_array)
{
    // step1: 获取当前页的事件相关 tag id。(以 thing_UUID 为key。)
    $tag_id_result = get_tag_id_array_from_thing_substring($thing_substring);
    while($my_tag_id_row = mysql_fetch_array($tag_id_result))
    {
        if (!array_key_exists($my_tag_id_row['thing_UUID'], $tag_id_array))
        {
            $tag_id_array[$my_tag_id_row['thing_UUID']][0] = $my_tag_id_row['property_UUID'];
        }
        else 
        {
            $array_index = count($tag_id_array[$my_tag_id_row['thing_UUID']]);
            $tag_id_array[$my_tag_id_row['thing_UUID']][$array_index] = $my_tag_id_row['property_UUID'];
        }
    }
    
    // step2: 获取当前页的事件相关 tag 属性。(以 tag id 为key。)
    $tag_param_result = get_tag_param_array_from_thing_substring($thing_substring);
    while($my_tag_param_row = mysql_fetch_array($tag_param_result))
    {
        if (!array_key_exists($my_tag_param_row['property_UUID'], $tag_param_array))
        {
            $tag_param_array[$my_tag_param_row['property_UUID']][0] = $my_tag_param_row['property_type'];
            $tag_param_array[$my_tag_param_row['property_UUID']][1] = $my_tag_param_row['property_name'];
        }
    }
   
    // step3: 获取当前页的事件。
    $result = get_thing_item_db($thing_substring);
    
    return $result;
}

// 获取 thing 表的数据。
function get_thing_item_db($thing_substring)
{
    $sql_string = " select * $thing_substring ";
    
    $result = mysql_query($sql_string);
    if($result == FALSE)
    {
        $GLOBALS['log']->error("error: get_thing_item_db() -- $sql_string 。");
        return NULL;
    }
    
    return $result;
}

?>