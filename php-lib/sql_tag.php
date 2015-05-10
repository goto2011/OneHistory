<?php
// created by duangan, 2015-3-30 -->
// tag 相关的函数。主要是和sql相关的。    -->

require_once 'data.php';

// 获取tag list 最小值
function tag_list_min()
{
    return 1;
}

// 获取tag list 的最大值
function tag_list_max()
{
    global $tag_control;
    return count($tag_control);
}

// tag list 、tag index、tag id 对应关系。
// [0]表示数据库中的tag type；
// [1]表示标签名称；
// [2]表示是标签显示特征（0-非tag tab页；1-tag tab；2-tag 非tab；3-vip用户才显示的）。
// [3]表示是否为key tag (0不是，1是)。
// [4]表示tag 输入框的id。
$tag_control = array(
    array(-1,     "全部",              0,   0,      ""),
    array(-1,     "我的关注",          0,   0,      ""),
    array(-1,     "最新标签",          0,   0,      ""),
    array(-1,     "时间分期",          0,   1,      ""),                // vip tag.
    array(8,      "中国朝代",         1,    1,      "dynasty_tags"),    // vip tag.
    array(7,      "国家民族",         1,    1,      "country_tags"),    // vip tag.
    array(10,     "专题",             1,    1,      "topic_tags"),      // vip tag.
    array(5,      "城市地区",         1,    1,      "geography_tags"),  // vip tag.
    array(4,      "人物",             1,    1,      "person_tags"),   // vip tag.
    array(9,      "官制",             1,    0,      "office_tags"),   // vip tag.
    array(11,     "关键事件",         1,    0,      "key_tags"),
    array(3,      "出处",             1,    0,      "source_tags"),
    array(12,     "管理标签",         3,    0,      ""),
    array(1,      "事件开始",         2,    0,      "start_tags"),
    array(2,      "事件结束",         2,    0,      "end_tags"),
    array(6,      "自由标签",         1,    0,      "free_tags"),
);


// 根据排列顺序给出tag 属性。2015-5-3.
function get_tag_list_from_index($tag_index_id)
{
    global $tag_control;
    
    if($tag_index_id > count($tag_control))
    {
        return -1;
    }
    else
    {
        return $tag_control[$tag_index_id - 1];
    }
}

// 获取 tag id（数据库）。 返回-2表示非法值。
function get_tag_id_from_index($tag_index_id)
{
    $my_tag_list = get_tag_list_from_index($tag_index_id); 
    if ($my_tag_list != -1)
    {
        return $my_tag_list[0];
    }
    else 
    {
        return -2;
    }
}

// 获取 tag 名称。 返回-2表示非法值。
function get_tag_list_name_from_index($tag_index_id)
{
    $my_tag_list = get_tag_list_from_index($tag_index_id); 
    if ($my_tag_list != -1)
    {
        return $my_tag_list[1];
    }
    else 
    {
        return -2;
    }
}

// 获取显示属性。 返回-2表示非法值。
function get_tag_show_type_from_index($tag_index_id)
{
    $my_tag_list = get_tag_list_from_index($tag_index_id); 
    if ($my_tag_list != -1)
    {
        return $my_tag_list[2];
    }
    else 
    {
        return -2;
    }
}

// 获取key tag属性。 返回-2表示非法值。
function get_key_tag_type_from_index($tag_index_id)
{
    $my_tag_list = get_tag_list_from_index($tag_index_id); 
    if ($my_tag_list != -1)
    {
        return $my_tag_list[3];
    }
    else 
    {
        return -2;
    }
}

// 获取 tag input id 属性。 返回""表示非法值。
function get_tag_input_id_from_index($tag_index_id)
{
    $my_tag_list = get_tag_list_from_index($tag_index_id); 
    if ($my_tag_list != -1)
    {
        return $my_tag_list[4];
    }
    else 
    {
        return "";
    }
}

// 是否显示在tag input界面上
function is_show_input_tag($tag_index_id)
{
    $tag_show = get_tag_show_type_from_index($tag_index_id);
    
    if (($tag_show == 1) || ($tag_show == 2))
    {
        return 1;
    }
    else 
    {
        return 0;
    }
}

// 是否显示在list tab界面
function is_show_list_tab($tag_index_id)
{
    $tag_show = get_tag_show_type_from_index($tag_index_id);
    
    if (($tag_show == 0) || ($tag_show == 1))
    {
        return 1;
    }
    else 
    {
        return 0;
    }
}

// 是否显示在检索、add tag等界面下
function is_show_search_add($tag_index_id)
{
    $tag_show = get_tag_show_type_from_index($tag_index_id);
    
    if ($tag_show == 1)
    {
        return 1;
    }
    else 
    {
        return 0;
    }
}

// 是否为vip用户才显示的tab界面
function is_vip_user_show_tab($tag_index_id)
{
    $tag_show = get_tag_show_type_from_index($tag_index_id);
    
    // 3是管理界面
    if ($tag_show == 3)
    {
        return 1;
    }
    else 
    {
        return 0;
    }
}

// 是否显示在 function-tag edit页面
function is_tag_edit_show_tab($tag_index_id)
{
    $tag_show = get_tag_show_type_from_index($tag_index_id);
    
    if (($tag_show == 1) || ($tag_show == 2))
    {
        return 1;
    }
    else 
    {
        return 0;
    }
}

// 是否是 vip tag.
function is_vip_tag_tab($tag_index_id)
{
    $tag_show = get_key_tag_type_from_index($tag_index_id);
    
    if ($tag_show == 1)
    {
        return 1;
    }
    else 
    {
        return 0;
    }
}

// 是否是"全部"tab 页
function is_total()
{
    return (get_current_list_id() == 1);
}

// 判断当前界面是否是 period
function is_period()
{
    return (get_current_list_id() == 4);
}

// 判断当前是否是 中国朝代 页面
function is_dynasty()
{
    return (get_tag_id_from_index(get_current_list_id()) == 8);
}

/* 判断当前是否是 国家民族 页面 */
function is_country()
{
    return (get_tag_id_from_index(get_current_list_id()) == 7);
}

// 判断当前是否是 专题 页面
function is_topic()
{
    return (get_tag_id_from_index(get_current_list_id()) == 10);
}

// 判断当前是否是 city 页面
function is_city()
{
    return (get_tag_id_from_index(get_current_list_id()) == 5);
}

// 判断当前是否是 person 页面
function is_person()
{
    return (get_tag_id_from_index(get_current_list_id()) == 4);
}

///////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////


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
    
    for ($ii = tag_list_min(); $ii <= tag_list_max(); $ii++)
    {
        if (is_show_input_tag($ii) == 1)
        {
            $tag_input_id = get_tag_input_id_from_index($ii);
            if(!empty($tags_array[$tag_input_id]))
            {
                $tag_id = get_tag_id_from_index($ii);
                $tags_insert_count += insert_tags($tags_array[$tag_input_id], $tag_id, $thing_uuid);
            }
        }
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

    // 插入事件-标签表. 先检查是否存在。
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
        $my_array = explode(",", $tags);
        for ($ii = 0; $ii < count($my_array); $ii++)
        {
            if (strlen($my_array[$ii]) > 0)
            {
                $index += insert_tag($my_array[$ii], $tag_type, $thing_uuid);
            }
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

        // 最新，指1天内的
        case 3:
            $sql_string = "select property_UUID, property_name, property_type from property 
                    where DATE_SUB(CURDATE(), INTERVAL 1 DAY) <= date(add_time) order by add_time DESC 
                    limit 0, " . $tags_show_limit;
            break;

        // 分期
        case 4:
            $sql_string = "select property_UUID, property_name, property_type from property
                     limit 0, " . $tags_show_limit;
            break;

        default:
            $my_tag_id = get_tag_id_from_index($list_type);
            if ($my_tag_id != -2)
            {
                $sql_string = "select property_UUID, property_name, property_type from property where property_type = $my_tag_id 
                     order by hot_index desc limit 0, " . $tags_show_limit;
            }
            else 
            {
                $GLOBALS['log']->error("error: get_tags_db() -- list_type error 。");
                return NULL;
            }
    }
    
    $result = mysql_query($sql_string);
    if ($result == FALSE)
    {
        $GLOBALS['log']->error("error: get_tags_db() -- $sql_string 。");
        $result = NULL;
    }

    return $result;
}

// 将 tag 转化为 key-value数组. 2015-4-27.
function get_tags_array($list_id)
{
    // 获取property数据表的数据
    $tags_array = array();
    
    $result = get_tags_db($list_id, 200);
    while($row = mysql_fetch_array($result))
    {
        $tags_array[$row['property_UUID']] = $row['property_name'];
    }
    
    return $tags_array;
}

// 检查tag array中是否有指定name的key。参数 is_need_delete 表示知道后是否删除, =1删除，=0不删除。
// 返回空串表示没找到。
function search_tag_from_array($tag_name, &$tags_array, $is_need_delete)
{
    $my_uuid = "";
    
    $my_uuid = array_search($tag_name, $tags_array);
    if (($my_uuid != "") && ($is_need_delete == 1))
    {
        unset($tags_array[$my_uuid]);
    }
    
    return $my_uuid;
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


// 删除指定标签
function delete_tag_to_db($tag_uuid)
{
    // 1. 删除标签相关的标签-事件对
    $sql_string = "delete from thing_property where property_UUID = '$tag_uuid'";
    if (mysql_query($sql_string) === FALSE)
    {
        $GLOBALS['log']->error("error: delete_tag_to_db() -- $sql_string 。");
        return 0;
    }
    
    // 2.删除标签相关的关注记录
    $sql_string = "delete from follow where property_UUID = '$tag_uuid'";
    if (mysql_query($sql_string) === FALSE)
    {
        $GLOBALS['log']->error("error: delete_tag_to_db() -- $sql_string 。");
        return 0;
    }    
    
    // 3. 删除标签
    $sql_string = "delete from property where property_UUID = '$tag_uuid'";
    if (mysql_query($sql_string) === FALSE)
    {
        $GLOBALS['log']->error("error: delete_tag_to_db() -- $sql_string 。");
        return 0;
    }
    
    return 1;
}

// 根据tag uuid 获取tag名称和tag类型。返回值为一个数组，[0]为类型, [1]是名称.
function get_tag_from_tag_uuid($tag_uuid)
{
    $sql_string = "select property_type,property_name from property where property_UUID='$tag_uuid'";

    $result = mysql_query($sql_string);
    if($result == FALSE)
    {
        $GLOBALS['log']->error("error: get_tag_from_tag_uuid() -- $sql_string 。");
        return 0;
    }
    
    $row = mysql_fetch_array($result);
    
    return array($row['property_type'], $row['property_name']);
}

// 检查指定tag是否为关键tag。=1 表示是，=0表示不是。
/*
    array(8,      "中国朝代",         1,    1,      "dynasty_tags"),    // key tag.
    array(7,      "国家民族",         1,    1,      "country_tags"),    // key tag.
    array(10,     "专题",             1,    1,      "topic_tags"),      // key tag.
    array(5,      "城市地区",         1,    1,      "geography_tags"),  // key tag.
    array(4,      "人物",             1,    1,      "person_tags"),     // key tag.
 */
function tag_is_vip($tag_uuid)
{
    $tag_array = array();
    $tag_array = get_tag_from_tag_uuid($tag_uuid);
    
    if (($tag_array[0] == 8) && (country_tag_is_exist($tag_array[1]) == 1))
    {
        return 1;
    }
    
    if (($tag_array[0] == 7) && (dynasty_tag_is_exist($tag_array[1]) == 1))
    {
        return 1;
    }
    
    if (($tag_array[0] == 10) && (topic_tag_is_exist($tag_array[1]) == 1))
    {
        return 1;
    }
    
    if (($tag_array[0] == 5) && (city_tag_is_exist($tag_array[1]) == 1))
    {
        return 1;
    }
    
    if (($tag_array[0] == 4) && (person_tag_is_exist($tag_array[1]) == 1))
    {
        return 1;
    }
    
    return 0;
}

// 将vip tag 作为关键字自动检索。-1表示失败。
/*
    array(8,      "中国朝代",         1,    1,      "dynasty_tags"),    // key tag.
    array(7,      "国家民族",         1,    1,      "country_tags"),    // key tag.
    array(10,     "专题",             1,    1,      "topic_tags"),      // key tag.
    array(5,      "城市地区",         1,    1,      "geography_tags"),  // key tag.
    array(4,      "人物",             1,    1,      "person_tags"),     // key tag.
 */
function vip_tag_search_to_db()
{
    // dynasty_tags
    for ($ii = get_big_dynasty_begin(); $ii <= get_big_dynasty_end() - 1; $ii++)
    {
        for ($jj = get_small_dynasty_begin($ii); $jj <= get_small_dynasty_end($ii); $jj++)
        {
            $tag_name = get_dynasty_name($ii, $jj);
            
            // 1. 生成检索条件。获取符合条件的thing 表结果集
            $db_result = get_thing_item_by_search_total($tag_name);
            
            // 2. 如果结果集不为空，则检查该事件是否打过指定标签。如果没有，则打上。
            if ($db_result != NULL)
            {
                while($row = mysql_fetch_array($db_result))
                {
                    $thing_uuid = "";
                    $thing_uuid = $row['uuid'];
                    
                    if (strlen($thing_uuid) > 0)
                    {
                        insert_tag($tag_name, 8, $thing_uuid);
                    }
                }
            }
        }
    }
    
    
    return 1;
}

?>