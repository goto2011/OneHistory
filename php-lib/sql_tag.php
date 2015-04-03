<?php
// created by duangan, 2015-3-30 -->
// tag 相关的函数。主要是和sql相关的。    -->

require_once 'data_string.php';

// 根据 tag 获取 thing 条目数量
function get_thing_count_by_tag($property_UUID)
{
    $sql_string = "select count(*) from thing_time where UUID in(select thing_UUID from thing_property 
            where property_UUID = '$property_UUID')";
    
    $result = mysql_query($sql_string);
    
    if($result == FALSE)
    {
       $GLOBALS['log']->error("error: get_thing_count_by_tag() -- $sql_string 。");
       return -1;
    }
    
    $row = mysql_fetch_row($result);    // 返回一行.
    return $row[0];
}

// 根据 tag 获取 thing 表的数据
function get_thing_item_by_tag($property_UUID, $offset, $page_size)
{
    $sql_string = "select * from thing_time where UUID in(select thing_UUID from thing_property 
            where property_UUID = '$property_UUID') order by thing_time.year_order ASC limit $offset, $page_size ";
    
    $result = mysql_query($sql_string);
    if($result ==FALSE)
    {
       $GLOBALS['log']->error("error: get_thing_item_by_tag() -- $sql_string 。");
       return NULL;
    }
    
    return $result;
}

// 从界面获取多个类型的标签。
function insert_tag_from_input($tags_array, $thing_uuid)
{
    $tags_insert_count = 0;
    
    if(!empty($tags_array['start_tags']))
    {
        $tags_insert_count += insert_tags(html_encode($tags_array['start_tags']),   1, $thing_uuid);
    }
    if(!empty($tags_array['end_tags']))
    {
        $tags_insert_count += insert_tags(html_encode($tags_array['end_tags']),     2, $thing_uuid);
    }
    if(!empty($tags_array['source_tags']))
    {
        $tags_insert_count += insert_tags(html_encode($tags_array['source_tags']),  3, $thing_uuid);
    }
    if(!empty($tags_array['person_tags']))
    {
        $tags_insert_count += insert_tags(html_encode($tags_array['person_tags']),  4, $thing_uuid);
    }
    if(!empty($tags_array['geography_tags']))
    {
        $tags_insert_count += insert_tags(html_encode($tags_array['geography_tags']), 5, $thing_uuid);
    }
    if(!empty($tags_array['free_tags']))
    {
        $tags_insert_count += insert_tags(html_encode($tags_array['free_tags']),    6, $thing_uuid);
    }
    if(!empty($tags_array['country_tags']))
    {
        $tags_insert_count += insert_tags(html_encode($tags_array['country_tags']), 7, $thing_uuid);
    }
    
    return $tags_insert_count;
}

// 将单个 tag 插入数据库.
function insert_tag($tag_name, $tag_type, $thing_uuid)
{
    $tag_uuid = "";

    // 先检查是不是有重复。
    $sql_string = "select property_UUID from property 
        where property_name='$tag_name' and property_type=$tag_type";

    $result = mysql_query($sql_string);
    if($result == FALSE)
    {
        $GLOBALS['log']->error("error: insert_tag() -- $sql_string 。");
        return 0;
    }

    if (mysql_num_rows($result) == 0)
    {
        $tag_uuid = create_guid();
            
        // 如果没有就插入标签表.
        $sql_string = "insert into property(property_UUID, property_name, property_type, add_time, user_UUID)
            VALUES('$tag_uuid', '$tag_name', $tag_type, now(), '" . get_user_id() . "')";
            
        if (mysql_query($sql_string) === FALSE)
        {
            $GLOBALS['log']->error("error: insert_tag() -- $sql_string 。" . mysql_error());
            return 0;
        }
    }
    else
    {
        $row = mysql_fetch_array($result);
        $tag_uuid = $row['property_UUID'];
    }

    // 插入事件-标签表
    $sql_string = "select property_UUID from thing_property
        where thing_UUID='$thing_uuid' and property_UUID='$tag_uuid'";

    $result = mysql_query($sql_string);
    if ($result == FALSE)
    {
        $GLOBALS['log']->error("error: insert_tag() -- $sql_string 。");
        return 0;
    }

    if (mysql_num_rows($result) == 0)
    {
        $sql_string = "insert into thing_property(thing_UUID, property_UUID, add_time, user_UUID)
            VALUES('$thing_uuid', '$tag_uuid', now(), '" . get_user_id() . "')";
            
        if (mysql_query($sql_string) === FALSE)
        {
            $GLOBALS['log']->error("Error: insert_tag() -- $sql_string , " . mysql_error());
            return 0;
        }
        // 更新 tag 的 hot 指数.
        update_tag_hot_index(1, $tag_uuid);
    }
    return 1;
}

// 将多个 tag 插入数据库
function insert_tags($tags, $tag_type, $thing_uuid)
{
    $index = 0;

    if(strlen($tags) > 0)
    {
        $token = strtok($tags, ",");
            
        while(($token != false) && (strlen($token) > 0))
        {
            $index += insert_tag($token, $tag_type, $thing_uuid);
            $token = strtok(",");
        }
    }
    
    return $index;
}

// 更新 tag 的 hot 指数
function update_tag_hot_index($add_hot_number, $tag_UUID)
{
    $sql_string = "update property set hot_index = ifNull(hot_index , 0) + " 
            . $add_hot_number . " where property_UUID = '" . $tag_UUID . "'";
    
    if (mysql_query($sql_string) === FALSE)
    {
        $GLOBALS['log']->error("Error: $sql_string , " . mysql_error());
        return false;
    }
    
    return true;
}


// 根据thing_uuid获取tags字符串
function get_tags_name($thing_uuid, $tag_type)
{
    $property_name_array[] = null;
    
    $sql_string = "select property_name from property where property_type=$tag_type and
        property_UUID in (select property_UUID from thing_property where thing_UUID='$thing_uuid')";

    $result = mysql_query($sql_string);
    if ($result == FALSE)
    {
        $GLOBALS['log']->error("error: get_tags_name() -- $sql_string 。");
        return NULL;
    }
        
    while($row = mysql_fetch_array($result))
    {
        $property_name_array[] = $row['property_name'];
    }
    
    return $property_name_array;
}

// 根据 uuid 获取name(此函数只允许 list_control.php.)
function get_tag_name_from_UUID($tag_UUID)
{
    $property_name = "";
    $sql_string = "select property_name from property where property_UUID='$tag_UUID' limit 0,1";
    
    $result = mysql_query($sql_string); 
    if($result == FALSE)
    {
        $GLOBALS['log']->error("error: get_tag_name() -- $tag_UUID -- $sql_string 。");
        return NULL;
    }
        
    while($row = mysql_fetch_array($result))
    {
        $property_name = $row['property_name'];
    }
    
    return $property_name;
}

// 获取符合条件的tags。
function get_tags_db($list_type, $tags_show_limit)
{
    switch ($list_type)
    {
        // 全部条目
        case 1:
            // 全部条目容许显示的 tag 数量翻倍.
            $sql_string = "select property_UUID, property_name, property_type from property order by hot_index desc
                     limit 0, " . ($tags_show_limit * 2);
            break;

        // 我的关注
        case 2:
            $sql_string = "select property_UUID, property_name, property_type from property 
                    where property_UUID in(select property_UUID from follow
                    where user_UUID = '" . get_user_id() . "') order by hot_index desc
                    limit 0, " . $tags_show_limit;
            break;

        // 我的小组(暂无功能)
        case 3:
            $sql_string = "select property_UUID, property_name, property_type from property order by hot_index desc 
                     limit 0, " . $tags_show_limit;
            break;

        // 最热门(此项删除)
        case 4:
            $sql_string = "select property_UUID, property_name, property_type from property order by hot_index desc
                     limit 0, " . $tags_show_limit;
            break;

        // 最新，指1天内的
        case 5:
            $sql_string = "select property_UUID, property_name, property_type from property 
                    where DATE_SUB(CURDATE(), INTERVAL 1 DAY) <= date(add_time) order by add_time DESC 
                    limit 0, " . $tags_show_limit;
            break;

        // 无标签, 不需要这条.
        case 6:
            return NULL;
            break;

        // 时代
        case 7:
            $sql_string = "select property_UUID, property_name, property_type from property
                     limit 0, " . $tags_show_limit;
            break;

        // 事件
        case 8:
            $sql_string = "select property_UUID, property_name, property_type from property 
                    where property_type = 1 or property_type = 2  order by hot_index desc
                    limit 0, " . $tags_show_limit;
            break;

        // 人物
        case 9:
            $sql_string = "select property_UUID, property_name, property_type from property where property_type = 4 
                     order by hot_index desc limit 0, " . $tags_show_limit;
            break;

        // 地理
        case 10:
            $sql_string = "select property_UUID, property_name, property_type from property where property_type = 5 
                     order by hot_index desc limit 0, " . $tags_show_limit;
            break;

        // 出处
        case 11:
            $sql_string = "select property_UUID, property_name, property_type from property where property_type = 3 
                     order by hot_index desc limit 0, " . $tags_show_limit;
            break;
            
        // 国家民族
        case 12:
            $sql_string = "select property_UUID, property_name, property_type from property where property_type = 7 
                     order by hot_index desc limit 0, " . $tags_show_limit;
            break;

        // 事件特征
        case 13:
            $sql_string = "select property_UUID, property_name, property_type from property where property_type = 6 
                     order by hot_index desc limit 0, " . $tags_show_limit;
            break;
        default:
            $GLOBALS['log']->error("error: get_tags_db() -- list_type error 。");
            return NULL;
    }
    
    $result = mysql_query($sql_string);
    if ($result == FALSE)
    {
        $GLOBALS['log']->error("error: get_tags_db() -- $sql_string 。");
        $result = NULL;
    }

    return $result;
}

// 获取property数据表的数据
function get_tags_from_thing_UUID($thing_UUID)
{
    $sql_string = "select property_UUID, property_name, property_type from property where property_UUID in(
            select property_UUID from thing_property where thing_UUID = '$thing_UUID')";
    $result = mysql_query($sql_string);
    if($result == FALSE)
    {
        $GLOBALS['log']->error("error: get_tags_from_thing_UUID() -- $sql_string 。");
        return NULL;
    }
    
    return $result;
}

// 重新计算 thing 的时间轴指数
function re_calc_year_order()
{
    $sql_string = "update thing_time set year_order=time where time_type=2";
    if (!mysql_query($sql_string))
    {
        $GLOBALS['log']->error("error: re_calc_year_order() -- $sql_string 。");
        return 0;
    }
    
    $sql_string = "update thing_time set year_order=time+2015 where time_type=1";
    if (!mysql_query($sql_string))
    {
        $GLOBALS['log']->error("error: re_calc_year_order() -- $sql_string 。");
        return 0;
    }
    
    $sql_string = "select UUID, time, time_type from thing_time where time_type = 3 or time_type = 4";
    $result = mysql_query($sql_string);
    if ($result)
    {
        while($row = mysql_fetch_array($result))
        {
            $sql_string = "update thing_time set year_order=" . get_year_order($row['time'], 
                $row['time_type']) . " where UUID = '" . $row['UUID'] . "' ";
            if (!mysql_query($sql_string))
            {
                $GLOBALS['log']->error("error: re_calc_year_order() -- $sql_string 。");
                return 0;
            }
        }
    }
    else 
    {
        $GLOBALS['log']->error("error: re_calc_year_order() -- $sql_string 。");
        return 0;
    }
    
    return 1;
}

// 重新计算tag热门指数
function re_calc_tag_hot_index()
{
    $tag_uuids = array();
    
    $sql_string = "select property_UUID from property";
    
    $result = mysql_query($sql_string);
    if ($result == FALSE)
    {
        $GLOBALS['log']->error("error: re_calc_tag_hot_index() -- $sql_string 。");
        return 0;
    }
        
    while($row = mysql_fetch_array($result))
    {
        $tag_uuids[] = $row['property_UUID'];
    }
    
    foreach ($tag_uuids as $tag_uuid)
    {
        $my_hot_index = 0;
        
        // 关联了多少的thing。
        $sql_string = "select count(*) from thing_property where property_UUID='$tag_uuid'";
        $result = mysql_query($sql_string);
        if ($result == FALSE)
        {
            $GLOBALS['log']->error("error: re_calc_tag_hot_index() -- $sql_string 。");
            return 0;
        }
        $row = mysql_fetch_row($result);
        $my_hot_index += $row[0];
        
        // 被多少人关注
        $sql_string = "select count(*) from follow where property_UUID='$tag_uuid'";
        $result = mysql_query($sql_string);
        if ($result == FALSE)
        {
            $GLOBALS['log']->error("error: re_calc_tag_hot_index() -- $sql_string 。");
            return 0;
        }
        $row = mysql_fetch_row($result);
        $my_hot_index += get_follow_hot_rate() * $row[0];
        
        // 更新
        $sql_string = "update property set hot_index = $my_hot_index where property_UUID = '$tag_uuid'";
        
        if (mysql_query($sql_string) === FALSE)
        {
            $GLOBALS['log']->error("error: re_calc_tag_hot_index() -- $sql_string 。");
            return 0;
        }
    }

    return 1;
}



?>