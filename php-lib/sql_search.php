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
 * 生成 search 查询之条件字句.
 */
function get_search_where_sub($search_param, $enable_time_search = TRUE)
{
    $search_sub = " where (";
    $search_key = search_key();
    $search_tag_uuid = search_tag_uuid();
    $begin_year = search_begin_year();
    $end_year = search_end_year();
    
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
                    $search_sub .= " time = " . $time_array['time'] . " and time_type = " . $time_array['time_type'] . " ";
                }
                // 年份，使用范围查询条件。
                else
                {
                    $search_sub .= " year_order >= " . $time_array['time'] . " and year_order < " . ($time_array['time'] + 1) . " ";
                }
            }
            else 
            {
                $search_sub .= " time >= " . ($time_array['time'] - $time_array['time_limit']) 
                    . " and time < " . ($time_array['time'] + $time_array['time_limit']) 
                    . " and time_type = " . $time_array['time_type'] . " ";
            }
            
            return $search_sub; 
        }
    }
    
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
    
    // 增加对 tag_uuid、begin_year、end_year的支持。2015-8-4
    // tag_uuid 优先。
    if ($search_tag_uuid != "")
    {
        $search_sub .= " ) and (uuid in(select property_UUID from property where property_UUID = '$search_tag_uuid')) ";
    }
    else if (($begin_year != -1) && ($end_year != -1))
    {
        $search_sub .= " ) and ((year_order >= $begin_year) and (year_order < $end_year)) ";
    }
    else 
    {
        $search_sub .= " ) ";
    }
    
    return $search_sub;
}

// 根据检索条件获取满足条件的条目的数量.
function get_thing_count_by_search($search_param)
{
    $sql_string = "select count(*) from thing_time " . get_search_where_sub($search_param);
    $result = mysql_query($sql_string);
    
    if($result == FALSE)
    {
       $GLOBALS['log']->error("error: get_thing_count_by_search() -- $sql_string 。");
       return -1;
    }
    
    $row = mysql_fetch_row($result);    // 返回一行.
    return $row[0];
}

// 根据检索条件获取 thing 表的数据
function get_thing_item_by_search($search_param, $offset, $page_size)
{
    $sql_string = "select * from thing_time " . get_search_where_sub($search_param) .
         " order by thing_time.year_order ASC limit $offset, $page_size ";
    
    $result = mysql_query($sql_string);
    if($result == FALSE)
    {
       $GLOBALS['log']->error("error: get_thing_item_by_search() -- $sql_string 。");
       return NULL;
    }
    
    return $result;
}

// 根据检索条件获取 thing 表的全部数据
function get_thing_item_by_search_total($search_key, $enable_time_search = TRUE)
{
    $sql_string = "select * from thing_time " . get_search_where_sub($search_key, $enable_time_search) .
         " order by thing_time.year_order ASC ";
    
    $result = mysql_query($sql_string);
    if($result == FALSE)
    {
       $GLOBALS['log']->error("error: get_thing_item_by_search_total() -- $sql_string 。");
       return NULL;
    }
    
    return $result;
}

?>