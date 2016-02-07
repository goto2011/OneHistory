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

/*
 *  去掉待检索字符串数组中的运算符。目的是提供给高亮检索关键字使用。2016-01-27
 * 输入：待检索字符串。
 * 输出：待检索字符串数组（只含关键字，不含运算符）。
*/
function get_highline_key_string($search_key)
{
    $key_array = trim_search_string($search_key);
    
    for ($ii = 0; $ii < count($key_array); $ii++)
    {
        if ((strlen(trim($key_array[$ii])) == 0) || ($key_array[$ii] == "(") || $key_array[$ii] == ")"
            || ($key_array[$ii] == "and") || ($key_array[$ii] == "or") || ($key_array[$ii] == "+")
            || ($key_array[$ii] == "-"))
        {
            array_splice($key_array, $ii, 1); 
        }
    }
    return $key_array;
}

/*
 * 对待检索字符串进行处理。2016-01-27
 * 输入：待检索字符串。
 * 输出：待检索字符串数组（按关键字和运算符进行分解）。
*/
function trim_search_string($search_key)
{
    $search_key = trim($search_key);
    $search_key = str_replace("+", " + ", $search_key);
    $search_key = str_replace("-", " - ", $search_key);
    $search_key = str_replace("(", " ( ", $search_key);
    $search_key = str_replace(")", " ) ", $search_key);
    
    return explode(" ", $search_key);
}


/**
 * 根据关键字生成 search 查询之条件子句.
 * 这个函数涉及到"自动将事件添加vip标签"，一旦出错，问题太大。轻易不能改。
 */
function get_search_where_sub_native($search_key)
{
    $search_sub = " ";
    
    // 增加检索时间的功能。
    $time_array = get_time_from_native($search_key);
    if ($time_array['status'] == "ok")
    {
        return get_time_search_substring($time_array);
    }
    
    $key_array = trim_search_string($search_key);
    
    // 这个正则表达式是对的, 但不合乎需求.
    // $key_array = preg_split("/\s+-\(\)/", $search_key);
    
    // 如果是带运算符的检索字符串。
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
                $search_sub .= " ( a.thing like '%" . $key_array[$ii] . "%' ) ";
            }
       } // for 
    } // if
    else
    {
        for ($ii = 0; $ii < count($key_array); $ii++)
        {
            if ($ii == 0)
            {
                $search_sub .= " ( a.thing like '%" . $key_array[$ii] . "%' ) ";
            }
            else 
            {
                $search_sub .= " or ( a.thing like '%" . $key_array[$ii] . "%' ) ";
            }
        } // for
    } // else
    
    return " ( $search_sub ) ";
}
 
/**
 * 根据 关键字 生成 查询条件子句.
 * 这个函数涉及到"自动将事件添加vip标签"，一旦出错，问题太大。轻易不能改。
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
 * 基于时间检索字符串生成查询条件子句。
 */
function get_time_search_substring($time_array)
{
    if ($time_array['time_limit'] == 0)
    {
        // 年月日 和 年月日时分秒，都要精确查询。
        if (($time_array['time_type'] == 3) || ($time_array['time_type'] == 4))
        {
            return " ( a.time = " . $time_array['time'] . " and a.time_type = " . $time_array['time_type'] . " ) ";
        }
        // 年份，使用范围查询条件。
        else
        {
            return " ( a.year_order >= " . $time_array['time'] . " and a.year_order < " . ($time_array['time'] + 1) . " ) ";
        }
    }
    // 如果时间有上下限。对时间做模糊查询，因为模糊点好。
    else 
    {
        $year_order_min = get_year_order($time_array['time'] - $time_array['time_limit'], $time_array['time_type']);
        $year_order_max = get_year_order($time_array['time'] + $time_array['time_limit'], $time_array['time_type']);
        
        return " ( a.year_order >= " . $year_order_min . " and a.time <= " . $year_order_max . " ) ";
    }
}
 
 
/**
 * 根据 search条件对象 生成 search查询之条件字句.
 */
function get_search_where_sub()
{
    $where_sub = "";
    
    // 从 session 中获取查询子句。
    $search_key = search_key();

    // 获取当前所在的 tag。
    $search_tag_uuid = get_property_UUID();
    $search_tag_type = search_tag_type();
    // 获取当前所在的时期。
    $my_big = get_period_big_index();
    $my_small =  get_period_small_index();
    if (($my_big != -1) && ($my_small != -1))
    {
        $begin_year = get_begin_year($my_big, $my_small);
        $end_year = get_end_year($my_big, $my_small);
    }
    
    // 基于检索字符串获取查询子句。
    $where_sub = get_search_where_sub_native($search_key) . " ";
    
    // 增加对 tag_uuid、begin_year、end_year的支持。2015-8-4
    // tag_uuid 优先。
    if ($search_tag_uuid != "")
    {
        $search_sub = " from thing_time a inner join thing_property c on $where_sub 
            and a.uuid = c.thing_UUID and c.property_UUID = '$search_tag_uuid' ";
        $join_sub = " and c.property_UUID = '$search_tag_uuid' 
            inner join thing_time a on $where_sub and c.thing_UUID = a.uuid ";
    }
    else if ($search_tag_type > 0)
    {
        //$search_sub .= " ) and (uuid in(select thing_UUID from thing_property where property_UUID in
        //    (select property_UUID from property where property_type = $search_tag_type ))) ";
        $search_sub = " from thing_time a 
            inner join thing_property c on $where_sub and a.uuid = c.thing_UUID 
            inner join property b on b.property_UUID = c.property_UUID and b.property_type = $search_tag_type ";
        $join_sub = " and b.property_type = $search_tag_type 
            inner join thing_time a on $where_sub and c.thing_UUID = a.uuid ";
    }
    else if (($my_big != -1) && ($my_small != -1))
    {
        $where_sub = " ( $where_sub ) and a.year_order >= $begin_year and a.year_order < $end_year ";
        $search_sub = " from thing_time a where $where_sub ";
        $join_sub = " inner join thing_time a on $where_sub and c.thing_UUID = a.uuid ";
    }
    else
    {
        $search_sub = " from thing_time a where $where_sub ";
        $join_sub = " inner join thing_time a on $where_sub and c.thing_UUID = a.uuid ";;
    }
    
    return array($search_sub, $join_sub);
}

// 根据条件检索 thing 表。
function get_thing_item_by_key($search_sub, $tag_uuid)
{
    $sql_string = "select * from thing_time a $search_sub and 
        (a.uuid not in(select thing_UUID from thing_property where property_UUID='$tag_uuid'))
        order by a.year_order ASC ";
    
    $result = mysql_query($sql_string);
    if($result == FALSE)
    {
       $GLOBALS['log']->error("error: get_thing_item_by_key() -- $sql_string 。");
       return NULL;
    }
    
    return $result;
}

?>