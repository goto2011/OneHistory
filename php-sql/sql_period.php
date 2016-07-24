<?php
// created by duangan, 2015-3-30 -->
// period 相关的函数。主要是和sql相关的。    -->


/**
 * 获取各时期事件的数量。
 */
function get_thing_count_by_period()
{
    $period_count = array();
    
    $sql_string = "select ceil((year_order - 99) / 100) as period , count(uuid) as count 
            from thing_time where year_order >= -1000 group by ceil((year_order - 99) / 100) ";
    if(($result = mysql_query($sql_string)) == FALSE)
    {
        $GLOBALS['log']->error("error: get_thing_count_by_period() -- $sql_string 。");
        return NULL;
    }
    while($row = mysql_fetch_array($result))
    {
        $my_period = $row['period'];
        $my_count = $row['count'];
        $period_count[$my_period] = $my_count;
    }
    
    return $period_count;
}


// 生成 period 查询之条件字句。(此函数已失效)
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