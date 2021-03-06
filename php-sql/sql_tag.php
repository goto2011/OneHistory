<?php
// created by duangan, 2015-3-30 -->
// tag 相关的函数。主要是和sql相关的。    -->

require_once 'data.php';

/**
 * 获取tag的检索条件子句。（此函数已失效）
 */
function get_tag_search_substring($property_UUID)
{
    // return " from thing_time where UUID in(select thing_UUID from thing_property 
    //         where property_UUID = '$property_UUID')  ";
    $thing_string = " from thing_time a 
            INNER JOIN thing_property b ON a.UUID=b.thing_UUID and b.property_UUID = '$property_UUID' ";
    $join_substring = " and c.property_UUID = '$property_UUID' 
            Inner join thing_time a on c.thing_UUID = a.uuid ";
    
    return array($thing_string, $join_substring);
}

/**
 * 遍历从 import/update 界面获取多个类型的标签，一个一个传给 insert_tags 进行存储。
 * $tags_array: tag 数组.
 * $thing_uuid: 事件id.
 */
function insert_tag_from_input($tags_array, $thing_uuid, $old_tag_string)
{
    $tags_insert_count = 0;
	$tag_types = array();
    
    // 处理“出处细节”字段
    if (isset($tags_array['source_detail']))
    {
        $source_detail = html_encode($tags_array['source_detail']);
    }
    else 
    {
        $source_detail = "";
    }
    
    for ($ii = tag_list_min(); $ii <= tag_list_max(); $ii++)
    {
        if (is_show_input_tag($ii) == 1)
        {
        		// 获取tag的key值
            $tag_key = get_tag_key_from_index($ii);
            $tag_name = html_encode($tags_array[$tag_key]);
            
            if(!empty($tag_name))
            {
            		$my_count = 0;
                $tag_type = get_tag_id_from_index($ii);
                
                // 保存“标签”+“出处细节”
                if (is_source($tag_type) && strlen($source_detail) > 0)
                {
                    $my_count = insert_tags($tag_name, $tag_type, $thing_uuid, $source_detail);
                }
				// 保存“标签”
                else 
                {
                    $my_count = insert_tags($tag_name, $tag_type, $thing_uuid);
                }
				
                if ($my_count > 0)
                {
                    $tags_insert_count += $my_count;
                    // 保存 tag type id.
                    $tag_types[] = get_tag_id_from_index($ii);
                }
            }
        }
    }// for
    
    // 2016-07-17
    if ($tags_insert_count > 0)
    {
        $update_string = update_tag_type_string($old_tag_string, $tag_types);
        if ($update_string != "-1")
        {
            // 更新出错了也要继续，所以不计较返回值。
            update_tag_types_to_db($thing_uuid, $update_string);
        }
    }
    
    return $tags_insert_count;
}

/**
 * 将 事件-标签对 插入数据库.
 * $ignore_check_exist: =true表示忽略检查 事件-标签对 是否存在。默认为false。
 */
function insert_thing_tag($tag_uuid, $thing_uuid, $ignore_check_exist = false)
{
    // step4: 检查 事件-标签对 是否存在。
    if ($ignore_check_exist == false){
        $sql_string = "select property_UUID from thing_property 
            where thing_UUID='$thing_uuid' and property_UUID='$tag_uuid' ";
    
        $result = mysql_query($sql_string);
        if ($result == FALSE)
        {
            $GLOBALS['log']->error("error: insert_thing_tag() -- $sql_string 。");
            return 0;
        }
    }

    // step5: 如果不存在则保存.
    if (($ignore_check_exist == true) || (mysql_num_rows($result) == 0))
    {
        $sql_string = "insert into thing_property(thing_UUID, property_UUID, add_time, user_UUID)
            VALUES('$thing_uuid', '$tag_uuid', now(), '" . get_user_id() . "')";
            
        if (mysql_query($sql_string) === FALSE)
        {
            $GLOBALS['log']->error("Error: insert_thing_tag() -- $sql_string , " . mysql_error());
            return 0;
        }
        
        return 1;
    }
    else 
    {
        // 已存在的算保存成功。
        return 1;
    }
}

/**
 * 将单个 tag 和对应的 事件-标签对 插入数据库.
 */
function insert_tag($tag_name, $tag_type, $source_detail = "")
{
    $tag_uuid = "";

    // step1: 先检查是不是有重复。
    $sql_string = "select property_UUID from property 
        where property_name='$tag_name' and property_type=$tag_type";

    $result = mysql_query($sql_string);
    if($result == FALSE)
    {
        $GLOBALS['log']->error("error: insert_tag() -- $sql_string 。");
        return "";
    }

    // step2: 如果是新标签就插入.
    if (mysql_num_rows($result) == 0)
    {
        $tag_uuid = create_guid();

        $sql_string = "insert into property(property_UUID, property_name, property_type, add_time, user_UUID)
            VALUES('$tag_uuid', '$tag_name', $tag_type, now(), '" . get_user_id() . "')";
            
        if (mysql_query($sql_string) === FALSE)
        {
            $GLOBALS['log']->error("error: insert_tag() -- $sql_string 。" . mysql_error());
            return "";
        }
    }
    else
    {
        $row = mysql_fetch_array($result);
        $tag_uuid = $row['property_UUID'];
    }
    
    // step3: 保存出处细节. 2015-5-24
    if(is_source($tag_type) && (strlen($source_detail) > 0))
    {
        $sql_string = "update property set detail='$source_detail' where property_UUID = '$tag_uuid' ";
        
        if (mysql_query($sql_string) === FALSE)
        {
            $GLOBALS['log']->error("error: insert_tag() -- $sql_string 。" . mysql_error());
        }
    }
    
    return $tag_uuid;
}

/**
 * 将同一个类型的多个 tag 插入数据库.
 * $tags: tag 字符串，以 ，分割多个tag.
 * $tag_type: tag 类型.
 * $thing_uuid: 事件id.
 * $source_detail: 出处细节. 可选.
 */
function insert_tags($tags, $tag_type, $thing_uuid, $source_detail = "")
{
    $index = 0;

    if(strlen($tags) > 0)
    {
        $my_array = explode(",", $tags);
        for ($ii = 0; $ii < count($my_array); $ii++)
        {
            if (strlen($my_array[$ii]) > 0)
            {
                $tag_uuid = insert_tag($my_array[$ii], $tag_type, $source_detail);
                
                if ($tag_uuid != "")
                {
                    $index += insert_thing_tag($tag_uuid, $thing_uuid);
                    
                    // 更新 tag 的 hot 指数(这样处理是ok的, 因为当前上下文下, 是一个事件对应多个标签)
                    update_tag_hot_index(1, $tag_uuid);
                }
            }
        }
    }
    
    return $index;
}

/**
 * 更新 tag 的 hot 指数.
 */
function update_tag_hot_index($add_hot_number, $tag_UUID)
{
    if ($add_hot_number == 0)
    {
        return false;
    }
    
    $sql_string = "update property set hot_index = ifNull(hot_index , 0) + " 
            . $add_hot_number . " where property_UUID = '" . $tag_UUID . "'";
    
    if (mysql_query($sql_string) === FALSE)
    {
        $GLOBALS['log']->error("Error: update_tag_hot_index() -- $sql_string , " . mysql_error());
        return false;
    }
    
    return true;
}

/**
 * 根据thing_uuid获取tags字符串.
 */
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

/**
 * 根据tag uuid 获取 出处细节.
 */
function get_sourece_detail($my_tag_uuid)
{
    if (($my_array = get_tag_from_UUID($my_tag_uuid)) != NULL)
    {
        return $my_array['detail'];
    }
    else 
    {
        return "";
    }
}

/**
 * 根据 tag uuid 获取tag type。
 */
function get_tag_type($my_tag_uuid)
{
    if (($my_array = get_tag_from_UUID($my_tag_uuid)) != NULL)
    {
        return $my_array['property_type'];
    }
    else 
    {
        return -1;
    }
}
 
 
/**
 * 根据 uuid 获取 tag 各属性.
 */
function get_tag_from_UUID($tag_UUID)
{
    $sql_string = "select * from property where property_UUID='$tag_UUID' limit 0,1";
    
    $result = mysql_query($sql_string); 
    if($result == FALSE)
    {
        $GLOBALS['log']->error("error: get_tag_from_UUID() -- $tag_UUID -- $sql_string 。");
        return NULL;
    }
    
    $row = mysql_fetch_array($result);
    return $row;
}

/**
 * 获取排序子句。
 * $order_type: 排序方式。
 *      =0：按hot_index排序，默认值。 
 *      =1：按标题排序，即汉字、字母序。
 */
function get_order_substring($order_type)
{
    if ($order_type == 0){
        return " order by hot_index desc ";
    } else if ($order_type == 1){
        return " order by convert(property_name using gbk) ASC ";
    }
}

/**
 * 将tag数据表的返回值组装成json字符串。只包含 tag_uuid, tag_name
 * 如果出现数据异常，则返回 urldecode("fail")。
 */
function get_json_from_tags_db($tags_db)
{
    if($tags_db == NULL){
        return urldecode("fail");
    } else {
        $tags_name = array();
        $ii = 0;
        while($row = mysql_fetch_array($tags_db))
        {
            // $tags_name[$row['property_UUID']] = iconv("gb2312", "utf-8", $row['property_name']);
            // $tags_name[$row['property_UUID']] = urlencode($row['property_name']);
            $tags_name[$ii] = array($row['property_UUID'], urlencode($row['property_name']));
            $ii++;
        }
        $json_string = json_encode($tags_name);
        if ($json_string == FALSE) {
            return urldecode("fail");
        } else {
            return urldecode($json_string);
        }
    }
}

/**
 * 根据当前 tag_tree_type 获取父 tag_tree_type。
 */
function get_parent_tag_tree_type($tag_tree_type_id)
{
    // 中国皇帝，上级为3：中国王朝
    if ($tag_tree_type_id == 4) return 3;
    // 中国皇帝年号，上级为4：中国皇帝
    if ($tag_tree_type_id == 5) return 4;
    // 外国王朝，上级为6：外国国家
    if ($tag_tree_type_id == 7) return 6;
    // 外国皇帝（含国王、女王、元首、总统、总理、首相等），上级为7：外国王朝
    if ($tag_tree_type_id == 8) return 7;
    // 中国城市，上级为9：中国省份，直辖市无上级
    if ($tag_tree_type_id == 10) return 9;
    // 外国城市，上级为6：外国国家
    if ($tag_tree_type_id == 11) return 6;
    // 中国人，上级为9：中国省份
    if ($tag_tree_type_id == 12) return 9;
    // 外国人，上级为6：外国国家
    if ($tag_tree_type_id == 13) return 6;
    // 中国组织，上级为10：中国城市
    if ($tag_tree_type_id == 14) return 10;
    // 外国组织，上级为11：外国城市
    if ($tag_tree_type_id == 15) return 11;
    
    return 0;
}

/**
 * 按指定的 tag_tree_type 获取tags。
 */
function get_tags_by_tree_type($tag_tree_type_id)
{
    if (!is_valid_tag_tree_type($tag_tree_type_id)) {
        return NULL;
    }
     
    $sql_string = "select property_UUID, property_name, property_type, hot_index from 
         property where tag_tree_type = " . $tag_tree_type_id . get_order_substring(1);
        
    $result = mysql_query($sql_string);
    if ($result == FALSE) {
        $GLOBALS['log']->error("error: get_tags_by_tree_type() -- $sql_string 。");
        $result = NULL;
    }

    return $result;
}
 
/**
 * 获取符合条件的tags.
 * $tag_type: tag 类型
 * $tags_show_limit: 数量
 * $order_type: 排序方式。
 *      =0：按hot_index排序，默认值。 
 *      =1：按标题排序，即字母序。
 */
function get_tags_db($tag_type, $tags_show_limit, $order_type = 0)
{
    switch ($tag_type)
    {
        // 全部条目
        case tab_type::CONST_TOTAL:
            // 全部条目容许显示的 tag 数量翻倍.
            // 全部中不显示“出处”标签。
            $sql_string = "select property_UUID, property_name, property_type, hot_index from 
                    property where property_type != 3 " . get_order_substring($order_type) . 
                    "limit 0, " . ($tags_show_limit * 2);
            break;

        // 我的关注
        case tab_type::CONST_MY_FOLLOW:
            $sql_string = "select property_UUID, property_name, property_type, hot_index from property 
                    where property_UUID in(select property_UUID from follow
                    where user_UUID = '" . get_user_id() . "') " . get_order_substring($order_type) . 
                    "limit 0, " . $tags_show_limit;
            break;

        // 最新，指1周内的(不再使用)
        case tab_type::CONST_NEWEST:
            $sql_string = "select property_UUID, property_name, property_type, hot_index from property 
                    where DATE_SUB(CURDATE(), INTERVAL 1 WEEK) <= date(add_time) order by add_time DESC 
                    limit 0, " . $tags_show_limit;
            break;

        // 分期
        case tab_type::CONST_PERIOD:
            $sql_string = "select property_UUID, property_name, property_type, hot_index from property
                     limit 0, " . $tags_show_limit;
            break;

        // tag type
        default:
            if ($tag_type > 0)
            {
                $sql_string = "select property_UUID, property_name, property_type, hot_index 
                    from property where property_type = $tag_type " . get_order_substring($order_type) . 
                    " limit 0, " . $tags_show_limit;
            }
            else 
            {
                $GLOBALS['log']->error("error: get_tags_db() -- tag_type error 。");
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

/**
 * 将 tag 转化为 key-value数组. 2015-4-27.
 */
function get_tags_array($list_id)
{
    // 获取property数据表的数据
    $tags_name = array();
    $tags_hot = array();
    
    // 2015-5-28, 临时修改为10000，当前情况已经满足。
    $result = get_tags_db($list_id, 10000);
    while($row = mysql_fetch_array($result))
    {
        $tags_name[$row['property_UUID']] = $row['property_name'];
        $tags_hot[$row['property_UUID']] = $row['hot_index'];
    }
    
    return array($tags_name, $tags_hot);
}

/**
 * 从 vip tag name 找对应的 tag UUID。
 * 参数：is_need_delete：表示知道后是否删除, =1删除，=0不删除。
 * 返回空串表示没找到。
 */
function search_tag_from_array($tag_name, &$tags_array, $is_need_delete)
{
    $my_uuid = "";
    
    $my_uuid = array_search($tag_name, $tags_array);
    if (($my_uuid != "") && ($is_need_delete == 1))
    {
        // 显示一个即从数组中去掉。
        unset($tags_array[$my_uuid]);
    }
    
    return $my_uuid;
}

/**
 * 根据 thing 检索子句获取相关的 tag 属性。
 */
function get_tags_from_search($sql_param, &$sql_string)
{
    $sql_string = get_sql_qurey(sql_object::CONST_SEARCH, sql_type::CONST_GET_SEARCH_TAGS, $sql_param);
    
    $result = mysql_query($sql_string);
    if($result == FALSE)
    {
        $GLOBALS['log']->error("error: get_tags_from_search() -- $sql_string 。");
        return NULL;
    }
    // $GLOBALS['log']->error("test: get_tag_param_array_from_thing() -- $sql_string 。");
    
    return $result;
}

/**
 * 根据 thing 检索子句获取相关的 tag 属性。
 */
function get_tag_param_array_from_thing($sql_object, $sql_param, $order_substring, &$sql_string)
{
    $sql_string = get_sql_qurey($sql_object, sql_type::CONST_GET_TAGS, $sql_param, $order_substring);
    
    $result = mysql_query($sql_string);
    if($result == FALSE)
    {
        $GLOBALS['log']->error("error: get_tag_param_array_from_thing() -- $sql_string 。");
        return NULL;
    }
    // $GLOBALS['log']->error("test: get_tag_param_array_from_thing() -- $sql_string 。");
    
    return $result;
}

/**
 * 获取property数据表的数据.
 */
function get_tags_from_thing_UUID($thing_UUID)
{
    $sql_string = "select property_UUID, property_name, property_type, hot_index from property 
            where property_UUID in(
            select property_UUID from thing_property where thing_UUID = '$thing_UUID')";
    $result = mysql_query($sql_string);
    if($result == FALSE)
    {
        $GLOBALS['log']->error("error: get_tags_from_thing_UUID() -- $sql_string 。");
        return NULL;
    }
    
    return $result;
}

/**
 * 重新计算 thing 的时间轴指数.
 */
function re_calc_year_order()
{
    $sql_string = "update thing_time set year_order=time where time_type=2";
    if (!mysql_query($sql_string))
    {
        $GLOBALS['log']->error("error: re_calc_year_order() -- $sql_string 。");
        return 0;
    }
    
    $sql_string = "update thing_time set year_order=time+" . get_current_year() . " where time_type=1 ";
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

/**
 * 重新计算tag热门指数.
 */
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

/**
 * 保存 tag 的各项属性
 */
function save_tag_params($tag_id, $begin_time, $big_day, $end_time, $tag_tree_type, $parent_tag)
{
    $sql_string = "update property set tag_begin = $begin_time, tag_bigday = $big_day, 
        tag_end = $end_time, tag_tree_type = $tag_tree_type, parent_tag = '$parent_tag'
        where property_UUID = '" . $tag_id . "'";
    
    if (mysql_query($sql_string) === FALSE)
    {
        $GLOBALS['log']->error("Error: save_tag_params() -- $sql_string , " . mysql_error());
        return false;
    }
    
    return true;
}
 
/**
 * 计算单个事件的标签类型映射. 2016-07-22
 * return: 1 成功；0 失败。
 */
function update_thing_tag_map($thing_uuid) 
{
    // $GLOBALS['log']->error("update_thing_tag_map() -- $thing_uuid .");
    
    $tag_types = array();
    
    // 1.获取当前事件的所有标签的类型
    $sql_string = "select property_type from property b where exists ( select property_UUID from 
        thing_property c where b.property_UUID=c.property_UUID and c.thing_UUID='$thing_uuid')";
    $result = mysql_query($sql_string);
    if ($result == FALSE)
    {
        $GLOBALS['log']->error("error: re_add_thing_tag_map() -- $sql_string 。");
        return 0;
    }
    
    // 2.拼接字符串
    while($row = mysql_fetch_array($result))
    {
        $tag_types[] = $row['property_type'];
    }
    $my_string = tag_types_to_string($tag_types);
    unset($tag_types);
    
    // 3.更新到数据库
    if (update_tag_types_to_db($thing_uuid, $my_string) == 0)
    {
        return 0;
    }
    // $GLOBALS['log']->error("update_thing_tag_map() -- ok .");
    return 1;
}
 
/**
 * 计算全部事件-标签类型映射. 2016-07-17
 */
function re_add_thing_tag_map()
{
	// 1.遍历所有事件
    $sql_string = " select uuid from thing_time ";
	$result = mysql_query($sql_string);
    if ($result == FALSE)
    {
        $GLOBALS['log']->error("error: re_add_thing_tag_map() -- $sql_string 。");
        return 0;
    }
	
	while($row = mysql_fetch_array($result))
    {
        // 失败1个，则马上返回失败。
        if (update_thing_tag_map($row['uuid']) == 0)
        {
            return 0;
        }
    }
    
	return 1;
}

/**
 * 将指定thing uuid 和 tag types字符串，保存到数据库中。2016-07-17
 */
function update_tag_types_to_db($thing_uuid, $tag_string)
{
    $sql_string = "update thing_time set property_types = '$tag_string' where uuid = '$thing_uuid'";
    if (mysql_query($sql_string) == FALSE)
    {
        $GLOBALS['log']->error("error: update_tag_types_to_db() -- $sql_string 。");
        return 0;
    }
    return 1;
}
 
/**
 * 输入tag 类型数组，返回tag类型字符串. 2016-07-17
 */
function tag_types_to_string($tag_types)
{
	$my_string = "";
	
	foreach ($tag_types as $tag_type)
	{
		$my_string .= "-" . tag_type_to_string($tag_type);
	}
	return $my_string;
}

/**
 * 输入单个tag 类型，返回tag类型字符串. 2016-07-17
 */
function tag_type_to_string($tag_type)
{
	return "a" . trim($tag_type);
}

/**
 * 根据旧的tag类型字符串，和新的数组，生成新的tag类型字符。2016-07-17
 * 返回 “-1”说明不需要刷新。
 */
 function update_tag_type_string($old_tag_string, $tag_types)
 {
 	$result_stirng = "";
 	// 如果旧的字符串为空，则说明是新建。
 	if($old_tag_string == "")
	{
		return tag_types_to_string($tag_types);
	}
	else 
	{
		foreach ($tag_types as $tag_type)
		{
			$my_string = tag_type_to_string($tag_type);
            // 如果不存在，则添加。
			if (strstr($old_tag_string . $result_stirng, $my_string) === FALSE)
			{
				$result_stirng .= "-" . $my_string;
			}
		}
	}
	if ($result_stirng != "")
	{
		return $old_tag_string . $result_stirng;
	}
    // “-1”说明不需要刷新.
	else 
	{
		return "-1";
	}
 }
 
/**
 * 删除指定标签.
 */
function delete_tag_to_db($tag_uuid)
{
    // $GLOBALS['log']->error("delete_tag_to_db() -- $tag_uuid .");
    $thing_uuids = array();
    
    // 0. 更新事件-tag类型映射
    $sql_string = "select thing_UUID from thing_property where property_UUID = '$tag_uuid'";
    $result = mysql_query($sql_string);
    if ($result == FALSE)
    {
        $GLOBALS['log']->error("error: delete_tag_to_db() -- $sql_string 。");
        return 0;
    }
    
    while($row = mysql_fetch_array($result))
    {
        $thing_uuids[] = $row['thing_UUID'];
    }
    
    // 1. 删除标签相关的标签-事件对
    $sql_string = "delete from thing_property where property_UUID = '$tag_uuid'";
    if (mysql_query($sql_string) === FALSE)
    {
        $GLOBALS['log']->error("error: delete_tag_to_db() -- $sql_string 。");
        return 0;
    }
    
    // 2. 更新事件-tag类型映射
    foreach ($thing_uuids as $thing_uuid)
    {
        if (update_thing_tag_map($thing_uuid) == 0)
        {
            return 0;
        }
    }
    
    // 3.删除标签相关的关注记录
    $sql_string = "delete from follow where property_UUID = '$tag_uuid'";
    if (mysql_query($sql_string) === FALSE)
    {
        $GLOBALS['log']->error("error: delete_tag_to_db() -- $sql_string 。");
        return 0;
    }    
    
    // 4. 删除标签
    $sql_string = "delete from property where property_UUID = '$tag_uuid'";
    if (mysql_query($sql_string) === FALSE)
    {
        $GLOBALS['log']->error("error: delete_tag_to_db() -- $sql_string 。");
        return 0;
    }
    
    return 1;
}

/**
 * 判断是否是正确的 tag_tree_type
 */
function is_valid_tag_tree_type($tag_tree_type)
{
    return (($tag_tree_type >= 3) && ($tag_tree_type <= 15));
}

/**
 * 根据tag uuid 获取 tag类型 和 tag名称.
 * 返回值为一个数组，[0]为类型, [1]是名称。
 */
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

/**
 * 判断当前tag 是否是出处。2015-8-3
 */
function is_source_from_id($tag_uuid)
{
    $tag_array = array();
    $tag_array = get_tag_from_tag_uuid($tag_uuid);
    
    return is_source($tag_array[0]);
}

/**
 * 检查指定tag id是否为关键tag。
 * 返回值：=1 表示是，=0表示不是。
 */
function tag_is_vip($tag_uuid)
{
    $GLOBALS['log']->error("tag_is_vip(): " . $tag_uuid);
    
    $tag_array = array();
    // 获取 tag类型 和 tag名称.
    $tag_array = get_tag_from_tag_uuid($tag_uuid);
    
    // 通过 tag type id 判断是否为 vip type.
    if(is_vip_tag_tab($tag_array[0]))
    {
        $my_vip_tag = vip_tag_struct_init($tag_array[0]);
        if ($my_vip_tag != null)
        {
            if ($my_vip_tag->tag_is_exist($tag_array[1]) == 1)
            {
                return 1;
            }
        }
    }
    return 0;
}

/**
 * 按index获取 一组vip tag。
 */
function get_vip_tag_group($tag_index) 
{
    // 根据下标 判断是否是 vip tag.
    if(is_vip_tag_tab($tag_index))
    {
        $tag_type = get_tag_id_from_index($tag_index);
        if ($tag_type < 0)
        {
            $GLOBALS['log']->error("error: get_vip_tag_group() -- $tag_type 。");
            return NULL;
        }
        // 初始化 vip tag
        $my_vip_tag = vip_tag_struct_init($tag_type);
        if ($my_vip_tag == NULL)
        {
            $GLOBALS['log']->error("error: get_vip_tag_group() -- vip_tag_struct_init NULL 。");
        }
        
        return $my_vip_tag;
    }
    return NULL;
}
 
/**
 * 获取指定vip tag 的数量。
 */
function get_vip_tag_count($vip_tag_object)
{
    $tag_count = 0;
    for ($ii = $vip_tag_object->get_big_begin(); $ii <= $vip_tag_object->get_big_end() - 1; $ii++)
    {
        $tag_count += $vip_tag_object->get_small_end($ii);
    }
    
    return $tag_count;
}
 
/**
 * 将vip tag 作为关键字自动检索。（最重要函数，每次修改都要慎之又慎。）
 * $vip_tag_object：vip tag 对象。
 * 返回值：返回vip tag name 表示成功。
 *      返回 “okok”表示step已经到头。
 */
function vip_tag_search_to_db($vip_tag_object, $tag_index, $step)
{
    $my_curr_step = 0;
    $tag_type = get_tag_id_from_index($tag_index);
    for ($ii = $vip_tag_object->get_big_begin(); $ii <= $vip_tag_object->get_big_end() - 1; $ii++)
    {
        for ($jj = $vip_tag_object->get_small_begin($ii); $jj <= $vip_tag_object->get_small_end($ii); $jj++)
        {
            $my_curr_step++;
            if ($my_curr_step == $step) {
                // 根据 vip tag的属性生成sql语句。
                $search_sub = get_vip_tag_substring($vip_tag_object, $ii, $jj, $tag_type);
                // $GLOBALS['log']->error($search_sub);
                if ($search_sub != "")
                {
                    $my_tag_name = $vip_tag_object->get_tag_name($ii, $jj);
                    $GLOBALS['log']->error($search_sub . " - " . $my_tag_name);
                    tag_search_to_db($search_sub, $my_tag_name, $tag_type);
                    $GLOBALS['log']->error($my_tag_name . " finished.");
                    return $my_tag_name;
                }
            }
        }
    }
    return "okok";
}

/**
 * 获取 vip tag 名称。
 * 参数：$tag_index：下标。
 */
function get_vip_tag_name($vip_tag_struct, $index_big, $index_small)
{
    if($vip_tag_struct != NULL)
    {
        return $vip_tag_struct->get_tag_name($index_big, $index_small);
    }
    return "";
}
 
 
/**
 * 根据vip tag各属性生成查询子句
 */
function get_vip_tag_substring($vip_tag_struct, $index_big, $index_small, $tag_type)
{
    $search_sub = "";
    $my_search_flag = $vip_tag_struct->get_tag_search_flag($index_big, $index_small);
    
    if ($my_search_flag == "sigle-key")
    {
        $search_key = $vip_tag_struct->get_tag_single_key($index_big, $index_small);
        if ($search_key != "")
        {
            $search_sub = get_search_where_sub_by_key($search_key);
        }
    }
    else if($my_search_flag == "multe-key")
    {
        $search_key = $vip_tag_struct->get_tag_multe_key($index_big, $index_small);
        if ($search_key != "")
        {
            $search_sub = get_search_where_sub_by_key($search_key);
        }
    }
    else if($my_search_flag == "key-time")
    {
        $search_key = $vip_tag_struct->get_key_time_key($index_big, $index_small);
        $begin_year = $vip_tag_struct->get_key_time_begin_year($index_big, $index_small);
        $end_year = $vip_tag_struct->get_key_time_end_year($index_big, $index_small);
        if (($search_key != "") && ($begin_year != 0) && ($end_year != 0))
        {
            $search_sub = get_search_where_sub_by_key_time($search_key, $begin_year, $end_year);
        }
    }
    // 中国、骑马民族专用。
    else if($my_search_flag == "tag-time")
    {
        $search_tag = get_tag_uuid_from_name($vip_tag_struct->get_tag_time_tag($index_big, 
            $index_small), $tag_type);
        $begin_year = $vip_tag_struct->get_tag_time_begin_year($index_big, $index_small);
        $end_year = $vip_tag_struct->get_tag_time_end_year($index_big, $index_small);
        if (($search_tag != "") && ($begin_year != 0) && ($end_year != 0))
        {
            $search_sub = get_search_where_sub_by_tag_time($search_tag, $begin_year, $end_year);
        }
    }
    
    return $search_sub;
}

/**
 * 将 tag 作为关键字自动检索。
 */
function tag_search_to_db($search_sub, $tag_name, $tag_type)
{
    // 1. 如果标签是新的, 则插入.
    $tag_uuid = insert_tag($tag_name, $tag_type);
    // $GLOBALS['log']->error("test2 - " . $search_sub);
    
    if ($tag_uuid != "")
    {
        $add_thing_tag_number = 0;
        
        // 2. 生成检索条件。获取符合条件的 thing 表结果集.
        // vip tag的检索不可能是时间，所以 $enable_time_search 设置为 FALSE。
        $db_result = get_thing_item_by_key($search_sub, $tag_uuid);
        
        // 3. 如果结果集不为空，则检查该事件是否打过指定标签。如果没有，则打上。
        if ($db_result != NULL)
        {
            while($row = mysql_fetch_array($db_result))
            {
                $thing_uuid = $row['uuid'];
                
                if (strlen($thing_uuid) > 0)
                {
                    // 第三个参数 true 表示忽略在插入前检查 事件-标签对 是否存在，目的是提高性能。
                    $add_thing_tag_number += insert_thing_tag($tag_uuid, $thing_uuid, true);
                }
            }
        }// if
        
        // 更新 tag 的 hot 指数(这样处理是ok的, 因为当前上下文下, 是一个标签对应多个事件)
        update_tag_hot_index($add_thing_tag_number, $tag_uuid);
    }// if
}

/**
 * 根据tag name和 tag type 获得 tag uuid。
 * @return: 返回""表示数据库中没有对应数据。
 */
function get_tag_uuid_from_name($tag_name, $tag_type)
{
    $sql_string = "select property_UUID from property where property_type = $tag_type 
        and property_name = '$tag_name'";
       
    $result = mysql_query($sql_string);
   
    if($result == FALSE)
    {
       $GLOBALS['log']->error("error: get_tag_uuid_from_name() -- $sql_string 。");
       return "";
    }
   
    $row = mysql_fetch_row($result);    // 返回一行.
    if ($row == NULL)
    {
        return "";
    }
    
    return $row[0];
}

?>