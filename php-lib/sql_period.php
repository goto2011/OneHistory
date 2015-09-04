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

// 获取 period 查询子句
function get_period_substring($begin_year, $end_year, $offset, $page_size)
{
    return " from thing_time " . get_period_where_sub($begin_year, $end_year)
        . " order by thing_time.year_order ASC limit $offset, $page_size ";
}

?>