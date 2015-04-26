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

// 将事件-时间数据写入数据库
function insert_thing_to_db($time_array, $thing)
{
    if ($time_array['status'] != "ok")
    {
        $GLOBALS['log']->error("error: insert_thing_to_db() -- time array error.");
        return "";
    }
    
    $time = $time_array['time'];
    $time_type = $time_array['time_type'];
    $time_limit = $time_array['time_limit'];
    $time_limit_type = $time_array['time_limit_type'];
    $year_order = get_year_order($time, $time_type);

    $thing_uuid = create_guid();
    $sql_string = "INSERT INTO thing_time(uuid, time, time_type, time_limit, time_limit_type, 
       thing, add_time, public_tag, user_UUID, year_order) VALUES('$thing_uuid', '$time', $time_type, 
       $time_limit, $time_limit_type, '$thing', now(), 1, '" . get_user_id() . "', $year_order)";
    
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

// 将事件的更新数据写入数据库
// 返回值: 成功返回1, 失败返回0.
function update_thing_to_db($thing_uuid, $time_array, $thing)
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
        time_limit = $time_limit, time_limit_type = $time_limit_type , year_order = $year_order 
        where uuid = '$thing_uuid' ";
    
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

        // add, 2015-4-19
        // 中国朝代标签
        case 3:
            $sql_string = "select count(*) from thing_time where UUID in(select thing_UUID from thing_property
                where property_UUID in(select property_UUID from property
                where property_type = 8))";
            break;

        // add, 2015-4-19
        // 官制
        case 4:
            $sql_string = "select count(*) from thing_time where UUID in(select thing_UUID from thing_property
                where property_UUID in(select property_UUID from property
                where property_type = 9))";
            break;

        // 最新，指1天内的
        case 5:
            $sql_string = "select count(*) from thing_time where UUID in(select thing_UUID from thing_property
                    where property_UUID in(select property_UUID from property
                    where DATE_SUB(CURDATE(), INTERVAL 1 DAY) <= date(add_time)))";
            break;

        // add, 2015-4-19
        // 事件类型
        case 6:
            $sql_string = "select count(*) from thing_time where UUID in(select thing_UUID from thing_property
                where property_UUID in(select property_UUID from property
                where property_type = 10))";
            break;

        // 分期
        case 7:
            $sql_string = "select count(*) from thing_time";
            break;

        // 事件始终
        case 8:
            $sql_string = "select count(*) from thing_time where UUID in(select thing_UUID from thing_property
                where property_UUID in(select property_UUID from property
                where property_type = 1 or property_type = 2))";
            break;

        // 人物
        case 9:
            $sql_string = "select count(*) from thing_time where UUID in(select thing_UUID from thing_property
                where property_UUID in(select property_UUID from property
                where property_type = 4))";
            break;

        // 地理
        case 10:
            $sql_string = "select count(*) from thing_time where UUID in(select thing_UUID from thing_property
                where property_UUID in(select property_UUID from property
                where property_type = 5))";
            break;

        // 出处
        case 11:
            $sql_string = "select count(*) from thing_time where UUID in(select thing_UUID from thing_property
                where property_UUID in(select property_UUID from property
                where property_type = 3))";
            break;
            
        // 国家民族
        case 12:
            $sql_string = "select count(*) from thing_time where UUID in(select thing_UUID from thing_property
                where property_UUID in(select property_UUID from property
                where property_type = 7))";
            break;
            
        // 自由标签
        case 13:
            $sql_string = "select count(*) from thing_time where UUID in(select thing_UUID from thing_property
                where property_UUID in(select property_UUID from property
                where property_type = 6))";
            break;
        default:
            $GLOBALS['log']->error("error: get_thing_count() -- list_type error 。");
            return -1;
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

        // add, 2015-4-19
        // 中国朝代标签
        case 3:
            $sql_string = "select * from thing_time
                where UUID in(select thing_UUID from thing_property 
                where property_UUID in(select property_UUID from property
                where property_type = 8)) $order_sub ";
            break;

        // add, 2015-4-19
        // 官制
        case 4:
            $sql_string = "select * from thing_time
                where UUID in(select thing_UUID from thing_property 
                where property_UUID in(select property_UUID from property
                where property_type = 9)) $order_sub ";
            break;
    
        // 最新，指7天内的
        case 5:
            $sql_string = "select * from thing_time where UUID in(select thing_UUID from thing_property 
                where property_UUID in(select property_UUID from property 
                where DATE_SUB(CURDATE(), INTERVAL 1 DAY) <= date(add_time))) $order_sub ";
            break;
    
        // add, 2015-4-19
        // 事件类型
        case 6:
            $sql_string = "select * from thing_time
                where UUID in(select thing_UUID from thing_property 
                where property_UUID in(select property_UUID from property
                where property_type = 10)) $order_sub ";
            break;
    
        // 分期
        case 7:
            $sql_string = "select * from thing_time $order_sub";
            break;
    
        // 事件
        case 8:
            $sql_string = "select * from thing_time where UUID in(select thing_UUID from thing_property 
                where property_UUID in(select property_UUID from property 
                where property_type = 1 or property_type = 2)) $order_sub ";
            break;
    
        // 人物
        case 9:
            $sql_string = "select * from thing_time
                where UUID in(select thing_UUID from thing_property 
                where property_UUID in(select property_UUID from property
                where property_type = 4)) $order_sub ";
            break;
    
        // 地理
        case 10:
            $sql_string = "select * from thing_time 
                where UUID in(select thing_UUID from thing_property
                where property_UUID in(select property_UUID from property
                where property_type = 5)) $order_sub ";
            break;
    
        // 出处
        case 11:
            $sql_string = "select * from thing_time 
                where UUID in(select thing_UUID from thing_property
                where property_UUID in(select property_UUID from property
                where property_type = 3)) $order_sub ";
            break;

        // 国家民族
        case 12:
            $sql_string = "select * from thing_time
                where UUID in(select thing_UUID from thing_property
                where property_UUID in(select property_UUID from property
                where property_type = 7)) $order_sub ";
            break;

        // 国家民族
        case 13:
            $sql_string = "select * from thing_time
                where UUID in(select thing_UUID from thing_property
                where property_UUID in(select property_UUID from property
                where property_type = 6)) $order_sub ";
            break;
            
        default:
            $GLOBALS['log']->error("error: get_thing_item_db() -- list_type error 。");
            return NULL;
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