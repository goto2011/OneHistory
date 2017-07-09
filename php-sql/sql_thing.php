<?php
// created by duangan, 2015-3-30 -->
// thing 相关的函数。主要是和sql相关的。    -->


/**
 * 判断是否为“标签内保持序号”。
 */
function is_index_inside_tag()
{
    if (($_POST['index_inside_tag'] == "true") && (strlen($_POST['note_tags']) > 0))
    {
        return 1;
    }
    else
    {
        return 0;
    }
}

/**
 * 判断是否为“元数据”。
 */
 function is_metadata()
 {
    if ($_POST['is_metadata'] == "true")
    {
        return 1;
    }
    else
    {
        return 0;
    }
 }
 
 /**
  * 写入“元数据”标志位。
  */
function update_metadata($thing_uuids)
{
    $my_stirng = "";
    for ($ii = 0; $ii < count($thing_uuids); $ii++)
    {
        $my_stirng .= "'" . html_encode($thing_uuids[$ii]) . "',";
    }
    // 去掉最后的分隔符
    $my_stirng = substr($my_stirng, 0 ,strlen($my_stirng) - 1);
    
    $sql_string = "UPDATE thing_time set is_metadata = 1 where uuid in($my_stirng)";
    
    if (mysql_query($sql_string) === TRUE)
    {
        return count($thing_uuids);
    }
    else
    {
        $GLOBALS['log']->error("error: update_metadata() -- $sql_string 。" . mysql_error());
        return 0;
    }
}

// 根据thing uuid获取thing各项属性。
function get_thing_db($thing_uuid)
{
    $sql_string = "select * from thing_time where uuid='$thing_uuid'";
    $result = mysql_query($sql_string);
    if ($result == FALSE)
    {
        $GLOBALS['log']->error("error: get_thing_db() -- $sql_string 。");
        return "";
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
function insert_thing_to_db($time_array, $thing, $is_metadata = 0, $thing_index = 0)
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
        // 如果存在，则更新事件属性。
        update_thing_to_db($thing_uuid, $time_array, $thing, $thing_index);
        return $thing_uuid;
    }

    $thing_uuid = create_guid();
    $sql_string = "INSERT INTO thing_time(uuid, time, time_type, time_limit, time_limit_type, 
       thing, add_time, public_tag, user_UUID, year_order, thing_index, is_metadata) 
       VALUES('$thing_uuid', '$time', $time_type, 
       $time_limit, $time_limit_type, '$thing', now(), 1, '" . get_user_id() . 
       "', $year_order, $thing_index, $is_metadata)";
    
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
 * $is_metadata: 可选参数，是否是元数据。
 * @$thing_index: 可选参数，事件在笔记标签中的序号。默认值为0。
 * @return: 成功返回1, 失败返回0.
 */
function update_thing_to_db($thing_uuid, $time_array, $thing, $is_metadata = 0, 
    $thing_index = 0, $death_person_count = 0, $hurt_person_count = 0, 
    $missing_person_count = 0, $word_count = 0)
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
    if ($thing_index > 0)
    {
        $sql_string = "UPDATE thing_time set time = '$time', time_type = $time_type, thing = '$thing', 
            time_limit = $time_limit, time_limit_type = $time_limit_type , year_order = $year_order , 
            thing_index = $thing_index , 
            is_metadata = $is_metadata , 
            related_number1 = $death_person_count , 
            related_number2 = $hurt_person_count , 
            related_number3 = $missing_person_count , 
            related_number4 = $word_count
            where uuid = '$thing_uuid' ";
    }
    else 
    {
        $sql_string = "UPDATE thing_time set time = '$time', time_type = $time_type, thing = '$thing', 
            time_limit = $time_limit, time_limit_type = $time_limit_type , year_order = $year_order , 
            is_metadata = $is_metadata , 
            related_number1 = $death_person_count , 
            related_number2 = $hurt_person_count , 
            related_number3 = $missing_person_count , 
            related_number4 = $word_count 
            where uuid = '$thing_uuid' ";
    }
    
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

/**
 * 给查询子句增加排序、分页。
 * $sql_object: 根据显示对象的不同，order string使用不同的参数。检索和标签时，
 * $offset, $page_size: 分页。
 */
function add_order_page_substring($sql_object, $offset, $page_size)
{
    // return $thing_substring . 
    //     " order by thing_time.year_order ASC, thing_time.thing_index ASC limit $offset, $page_size ";
    if (($sql_object == sql_object::CONST_SEARCH) || ($sql_object == sql_object::CONST_TAG))
    {
        return " order by a.is_metadata DESC, a.year_order ASC, a.thing_index ASC limit $offset, $page_size ";
    }
    else 
    {
        return " order by a.year_order ASC, a.thing_index ASC limit $offset, $page_size ";
    }
}

/**
 * 根据 substring 条件，获取事件数量。
*/
function get_thing_count($sql_object, $sql_param)
{
    $sql_string = get_sql_qurey($sql_object, sql_type::CONST_GET_THING_COUNT, $sql_param);
    $result = mysql_query($sql_string);
    
    if($result == FALSE)
    {
       $GLOBALS['log']->error("error: get_thing_count() -- $sql_string 。");
       return -1;
    }
    
    $row = mysql_fetch_row($result);    // 返回一行.
    return $row[0];
}

// 获取事件 查询子句。（此函数已失效）
function get_thing_substring($tag_id)
{
    switch ($tag_id)
    {
        // 全部条目
        case tab_type::CONST_TOTAL:
            $thing_string = " from thing_time a ";
            $join_substring = " inner join thing_time a on c.thing_UUID = a.uuid ";
            break;
    
        // 我的关注
        case tab_type::CONST_MY_FOLLOW:
            $thing_string = " from thing_time a inner join thing_property c on a.UUID = c.thing_UUID 
                inner join follow e on e.property_UUID = c.property_UUID 
                and e.user_UUID = '" . get_user_id() . "' ";
                
            $join_substring = " inner join thing_time a on c.thing_UUID = a.uuid 
                inner join follow e on e.property_UUID = b.property_UUID 
                and e.user_UUID = '" . get_user_id() . "' ";
            break;
            
        // 最新，指7天内新建的标签(暂时删除)
        case tab_type::CONST_NEWEST:
            $thing_string = " from thing_time a join thing_property c on a.UUID = c.thing_UUID  
                inner join property b on b.property_UUID = c.property_UUID 
                and DATE_SUB(CURDATE(), INTERVAL 1 WEEK) <= date(b.add_time) ";
                
            $join_substring = " and DATE_SUB(CURDATE(), INTERVAL 1 WEEK) <= date(b.add_time)
                inner join thing_time a on c.thing_UUID = a.uuid ";
            break;

        // 分期
        case tab_type::CONST_PERIOD:
            $thing_string = " from thing_time a ";
            $join_substring = " inner join thing_time a on c.thing_UUID = a.uuid ";
            break;

        default:
            if ($tag_id > 0)
            {
                $thing_string = " from thing_time a inner join thing_property c on c.thing_UUID = a.UUID
                        inner join property b on b.property_UUID = c.property_UUID 
                        and b.property_type = $tag_id ";
                
                $join_substring = " and b.property_type = $tag_id 
                        inner join thing_time a on c.thing_UUID = a.uuid ";
            }
            else
            {
                $GLOBALS['log']->error("error: get_thing_substring() -- tag_id error 。");
                return "";
            }
    }

    return array($thing_string, $join_substring);
}

/**
 * 完成 事件、标签、事件-标签对的三表联合查询。
 * 返回 sql 语句是为了打印log，因为这个函数是整个系统的瓶颈。
 * $sql_object：对象类型
 * $sql_param：查询条件
 * $order_substring：排序子句
 * &$tag_id_array：输出 tag id
 * &$tag_param_array：输出tag parameter
 * return: $sql_string，返回sql语句，方便外层在超时时打印。
 */
function get_thing_tag_prompt($sql_object, $sql_param, $order_substring, &$tag_id_array, 
        &$tag_param_array)
{
    // step1: 获取当前页的事件相关 tag id。(以 thing_UUID 为key。)
    $sql_string = "";
    $tag_id_result = get_tag_param_array_from_thing($sql_object, $sql_param, $order_substring, $sql_string);
    // $GLOBALS['log']->error(date('H:i:s') . "-" . "Step22");
    
    if($tag_id_result == NULL)
    {
        $GLOBALS['log']->error("error: get_thing_tag_prompt().");
        return $sql_string;
    }
    
    while($my_tag_id_row = mysql_fetch_array($tag_id_result))
    {
        // 保存 thing uuid 和 tag uuid 的对应关系。
        // 下标是 thing uuid。一个 thing uuid 对应多个 tag uuid。
        if (!array_key_exists($my_tag_id_row['thing_UUID'], $tag_id_array))
        {
            $tag_id_array[$my_tag_id_row['thing_UUID']][0] = $my_tag_id_row['property_UUID'];
        }
        else
        {
            $array_index = count($tag_id_array[$my_tag_id_row['thing_UUID']]);
            $tag_id_array[$my_tag_id_row['thing_UUID']][$array_index] = $my_tag_id_row['property_UUID'];
        }
        
        // 保存 tag uuid 和 tag type、名称、hot_index 的对应关系。
        // 下标是 tag uuid。一个 tag uuid 对应一个 tag type。
        if (!array_key_exists($my_tag_id_row['property_UUID'], $tag_param_array))
        {
            $tag_param_array[$my_tag_id_row['property_UUID']][0] = $my_tag_id_row['property_type'];
            $tag_param_array[$my_tag_id_row['property_UUID']][1] = $my_tag_id_row['property_name'];
            $tag_param_array[$my_tag_id_row['property_UUID']][2] = $my_tag_id_row['hot_index'];
        }
    }
    
    return $sql_string;
}

// 获取 thing 表的数据。
function get_thing_item_db($sql_object, $sql_param, $order_substring)
{
    $sql_string = get_sql_qurey($sql_object, sql_type::CONST_GET_THING_ITEMS, $sql_param) 
        . " " . $order_substring;
    
    $result = mysql_query($sql_string);
    if($result == FALSE)
    {
        $GLOBALS['log']->error("error: get_thing_item_db() -- $sql_string 。");
        return NULL;
    }
    // $GLOBALS['log']->error("error: test -- $sql_string 。");
    
    return $result;
}

?>