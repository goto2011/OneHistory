<?php
// created by duangan, 2015-3-30 -->
// period 相关的函数。主要是和sql相关的。    -->


// 生成 period 查询之条件字句
function get_period_where_sub($begin_year, $end_year)
{
    if(!is_infinite($begin_year) && !is_infinite($end_year))
    {
        return " from thing_time where ((year_order >= $begin_year) and (year_order <= $end_year)) ";
    }
    else if(is_infinite($begin_year) && is_infinite($end_year))
    {
        return "  ";
    }
    else if(is_infinite($begin_year))
    {
        return " from thing_time where (year_order <= $end_year) ";
    }
    else if(is_infinite($end_year))
    {
        return " from thing_time where (year_order >= $begin_year) ";
    }
}

?>