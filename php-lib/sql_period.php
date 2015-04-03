<?php
// created by duangan, 2015-3-30 -->
// period 相关的函数。主要是和sql相关的。    -->


// 生成 period 查询之条件字句
function get_period_where_sub($begin_year, $end_year)
{
    if(!is_infinite($begin_year) && !is_infinite($end_year))
    {
        return " where ((year_order >= $begin_year) and (year_order <= $end_year)) ";
    }
    else if(is_infinite($begin_year) && is_infinite($end_year))
    {
        return "  ";
    }
    else if(is_infinite($begin_year))
    {
        return " where (year_order <= $end_year) ";
    }
    else if(is_infinite($end_year))
    {
        return " where (year_order >= $begin_year) ";
    }
}


// 根据 period 获取 thing 条目的数量
function get_thing_count_by_period($begin_year, $end_year)
{
    $sql_string = "select count(*) from thing_time " 
        . get_period_where_sub($begin_year, $end_year);
        
    $result = mysql_query($sql_string);
    
    if($result == FALSE)
    {
       $GLOBALS['log']->error("error: get_thing_count_by_period() -- $sql_string 。");
       return -1;
    }
    
    $row = mysql_fetch_row($result);    // 返回一行.
    return $row[0];
}


// 根据 period 获取 thing 表的数据
function get_thing_item_by_period($begin_year, $end_year, $offset, $page_size)
{
    $sql_string = "select * from thing_time " . get_period_where_sub($begin_year, $end_year)
        . " order by thing_time.year_order ASC limit $offset, $page_size ";
    
    $result = mysql_query($sql_string);
    if($result ==FALSE)
    {
       $GLOBALS['log']->error("error: get_thing_item_by_period() -- $sql_string 。");
       return NULL;
    }
    
    return $result;
}

?>