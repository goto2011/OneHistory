<?php
// created by duangan, 2015-1-30 -->
// support period deal function.    -->

// 时期数组
$period = array
(
    array
    (
        array("人类之前", log(0), -2600001),   // log(0) 表示无穷远.
        array("农业之前", -2600000, -12001),
        array("文明初期", -12000, -1600),
        array("文明前期", -1600, -1001),
    ),
    array
    (
        array("公元前10世纪", -1000, -901),
        array("公元前9世纪", -900, -801),
        array("公元前8世纪", -800, -701),
        array("公元前7世纪", -700, -601),
        array("公元前6世纪", -600, -501),
        array("公元前5世纪", -500, -401),
        array("公元前4世纪", -400, -301),
        array("公元前3世纪", -300, -201),
        array("公元前2世纪", -200, -101),
        array("公元前1世纪", -100, -1),
    ),
    array
    (
        array("公元1世纪", 1, 99),
        array("公元2世纪", 100, 199),
        array("公元3世纪", 200, 299),
        array("公元4世纪", 300, 399),
        array("公元5世纪", 400, 499),
        array("公元6世纪", 500, 599),
        array("公元7世纪", 600, 699),
        array("公元8世纪", 700, 799),
        array("公元9世纪", 800, 899),
        array("公元10世纪", 900, 999),
    ),
    array
    (
        array("11世纪", 1000, 1099),
        array("12世纪", 1100, 1199),
        array("13世纪", 1200, 1299),
        array("14世纪", 1300, 1399),
        array("15世纪", 1400, 1499),
        array("16世纪", 1500, 1599),
        array("17世纪", 1600, 1699),
        array("18世纪", 1700, 1799),
        array("19世纪", 1800, 1899),
        array("20世纪", 1900, 1999),
    ),
    array
    (
        array("21世纪", 2000, date("Y") + 1),
        array("未来", 2016, log(0)),
    ),
);

// 返回大时期的名称
function get_big_period_name($index)
{
    switch($index)
    {
        case 1:
            return "史前时代";
            break;
        case 2:
            return "前一千纪";
            break;
        case 3:
            return "一千纪";
            break;
        case 4:
            return "二千纪";
            break;
        case 5:
            return "三千纪";
            break;
        default:
            return "奇葩";
    }
}

// 获取 big id begin
function get_big_id_begin()
{
    return 1;   // 从1开始方便通过 GET 传递.
}

// 获取 big id end
function get_big_id_end()
{
    global $period;
    return count($period);
}

// 获取 small id begin
function get_small_id_begin($big_id)
{
    return 1;
}

// 获取 small id end.
function get_small_id_end($big_id)
{
    global $period;
    return count($period[$big_id - 1]);
}

// 获取 时期名称
function get_period_name($big_id, $small_id)
{
    global $period;
    return $period[$big_id - 1][$small_id - 1][0];
}

// 获取 时期begin year.
function get_begin_year($big_id, $small_id)
{
    global $period;
    return $period[$big_id - 1][$small_id - 1][1];
}

// 获取 时期 end year.
function get_end_year($big_id, $small_id)
{
    global $period;
    return $period[$big_id - 1][$small_id - 1][2];
}

?>