<?php
// created by duangan, 2015-3-30 -->
// search 相关的函数。主要是和sql相关的。    -->

// 判断查询字符串是否为复杂查询串.
function is_complex_search($search_key)
{
    if ((stristr($search_key, "(")) || (stristr($search_key, ")")) || (stristr($search_key, "and"))
        || (stristr($search_key, "or")) || (stristr($search_key, "-")) || (stristr($search_key, "+")))
    {
        return true;
    }
    else 
    {
        return false;
    }
}

/**
 * 根据关键字生成 search 查询之条件子句.
 * 这个函数涉及到"自动将事件添加vip标签"，一旦出错问题太大。轻易不能改。
 */
function get_search_where_sub_native($search_key)
{
    $search_sub = "";
    
    $search_key = trim($search_key);
    $search_key = str_replace("+", " + ", $search_key);
    $search_key = str_replace("-", " - ", $search_key);
    $search_key = str_replace("(", " ( ", $search_key);
    $search_key = str_replace(")", " ) ", $search_key);
    
    $key_array = explode(" ", $search_key);
    // 这个正则表达式是对的, 但不合乎需求.
    // $key_array = preg_split("/\s+-\(\)/", $search_key);
    
    if (is_complex_search($search_key))
    {
        for ($ii = 0; $ii < count($key_array); $ii++)
        {
            if (strlen(trim($key_array[$ii])) == 0)
            {
                continue;
            }
            else if ($key_array[$ii] == "(")
            {
                $search_sub .= " ( ";
            }
            else if ($key_array[$ii] == ")")
            {
                $search_sub .= " ) ";
            }
            else if ($key_array[$ii] == "and")
            {
                $search_sub .= " and ";
            }
            else if (($key_array[$ii] == "or") || ($key_array[$ii] == "+"))
            {
                $search_sub .= " or ";
            }
            else if ($key_array[$ii] == "-")
            {
                $search_sub .= " and not ";
            }
            else
            {
                $search_sub .= " ( thing like '%" . $key_array[$ii] . "%' ) ";
            }
       } // for 
    } // if
    else
    {
        for ($ii = 0; $ii < count($key_array); $ii++)
        {
            if ($ii == 0)
            {
                $search_sub .= " ( thing like '%" . $key_array[$ii] . "%' ) ";
            }
            else 
            {
                $search_sub .= " or ( thing like '%" . $key_array[$ii] . "%' ) ";
            }
        } // for
    } // else
    
    return $search_sub;
}
 
/**
 * 根据 关键字 生成 查询条件子句.
 * 这个函数涉及到"自动将事件添加vip标签"，一旦出错问题太大。轻易不能改。
 */
function get_search_where_sub_by_key($search_key)
{
    return " where (" . get_search_where_sub_native($search_key) . ") ";
}

/**
 * 根据 key-time 生成 查询条件子句。
 */
function get_search_where_sub_by_key_time($search_key, $begin_year, $end_year)
{
    return " where ((" . get_search_where_sub_native($search_key) . ") and ((year_order >= $begin_year) and (year_order <= $end_year))) ";
}

/**
 * 根据 tag-time 生成 查询条件子句。
 */
function get_search_where_sub_by_tag_time($key_uuid, $begin_year, $end_year)
{
    if ($key_uuid != "")
    {
        return " where (uuid in(select thing_UUID from thing_property where property_UUID = '$key_uuid') "
            . " and ((year_order >= $begin_year) and (year_order <= $end_year))) ";
    }
}
 
/**
 * 根据 search条件对象 生成 search查询之条件字句.
 */
function get_search_where_sub($enable_time_search = TRUE)
{
    $search_sub = " from thing_time where (";
    
    // 从 session 中获取查询子句。
    $search_key = search_key();
    $search_tag_uuid = get_property_UUID();
    $search_tag_type = search_tag_type();
    
    $my_big = get_period_big_index();
    $my_small =  get_period_small_index();
    if (($my_big != -1) && ($my_small != -1))
    {
        $begin_year = get_begin_year($my_big, $my_small);
        $end_year = get_end_year($my_big, $my_small);
    }
    
    // 增加检索时间的功能。
    if ($enable_time_search == TRUE)
    {
        $time_array = get_time_from_native($search_key);
        if ($time_array['status'] == "ok")
        {
            if ($time_array['time_limit'] == 0)
            {
                // 年月日 和 年月日时分秒，都要精确查询。
                if (($time_array['time_type'] == 3) || ($time_array['time_type'] == 4))
                {
                    $search_sub .= " time = " . $time_array['time'] . " and time_type = " . $time_array['time_type'] . " ) ";
                }
                // 年份，使用范围查询条件。
                else
                {
                    $search_sub .= " year_order >= " . $time_array['time'] . " and year_order < " . ($time_array['time'] + 1) . " ) ";
                }
            }
            // 如果时间有上下限.
            else 
            {
                $search_sub .= " time >= " . ($time_array['time'] - $time_array['time_limit']) 
                    . " and time < " . ($time_array['time'] + $time_array['time_limit']) 
                    . " and time_type = " . $time_array['time_type'] . " ) ";
            }
            
            return $search_sub; 
        }
    }
    
    $search_sub .= get_search_where_sub_native($search_key) . " ";
    
    // 增加对 tag_uuid、begin_year、end_year的支持。2015-8-4
    // tag_uuid 优先。
    if ($search_tag_uuid != "")
    {
        $search_sub .= " ) and (uuid in(select thing_UUID from thing_property where property_UUID = '$search_tag_uuid')) ";
    }
    else if (($my_big != -1) && ($my_small != -1))
    {
        $search_sub .= " ) and ((year_order >= $begin_year) and (year_order < $end_year)) ";
    }
    else if ($search_tag_type > 0)
    {
        $search_sub .= " ) and (uuid in(select thing_UUID from thing_property where property_UUID in
            (select property_UUID from property where property_type = $search_tag_type ))) ";
    }
    else
    {
        $search_sub .= " ) ";
    }
    
    return $search_sub;
}

// 根据条件检索 thing 表。
function get_thing_item_by_key($search_sub, $tag_uuid)
{
    $sql_string = "select * from thing_time $search_sub and 
        (uuid not in(select thing_UUID from thing_property where property_UUID='$tag_uuid'))
         order by thing_time.year_order ASC ";
    
    $result = mysql_query($sql_string);
    if($result == FALSE)
    {
       $GLOBALS['log']->error("error: get_thing_item_by_key() -- $sql_string 。");
       return NULL;
    }
    
    return $result;
}

?>