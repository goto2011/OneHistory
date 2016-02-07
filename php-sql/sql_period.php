<?php
// created by duangan, 2015-3-30 -->
// period 相关的函数。主要是和sql相关的。    -->


// 生成 period 查询之条件字句
function get_period_where_sub($begin_year, $end_year)
{
    if(!is_infinite($begin_year) && !is_infinite($end_year))
    {
        $thing_string = " from thing_time a where ((year_order >= $begin_year) and (year_order <= $end_year)) ";
        $join_substring = " inner join thing_time a on c.thing_UUID = a.uuid 
                and ((a.year_order >= $begin_year) and (a.year_order <= $end_year)) ";
    }
    else if(is_infinite($begin_year) && is_infinite($end_year))
    {
        $thing_string = " ";
        $join_substring = " ";
    }
    else if(is_infinite($begin_year))
    {
        $thing_string = " from thing_time a where (year_order <= $end_year) ";
        $join_substring = " inner join thing_time a on c.thing_UUID = a.uuid and a.year_order <= $end_year";
    }
    else if(is_infinite($end_year))
    {
        $thing_string = " from thing_time a where (year_order >= $begin_year) ";
        $join_substring = " inner join thing_time a on c.thing_UUID = a.uuid and a.year_order >= $begin_year ";
    }
    return array($thing_string, $join_substring);
}

?>