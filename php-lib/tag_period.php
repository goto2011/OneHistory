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
        array("文明前期", -1600, -1000),
    ),
    array
    (
        array("公元前10世纪", -1000, -900, "-10"),
        array("公元前9世纪", -900, -800, "-9"),
        array("公元前8世纪", -800, -700, "-8"),
        array("公元前7世纪", -700, -600, "-7"),
        array("公元前6世纪", -600, -500, "-6"),
        array("公元前5世纪", -500, -400, "-5"),
        array("公元前4世纪", -400, -300, "-4"),
        array("公元前3世纪", -300, -200, "-3"),
        array("公元前2世纪", -200, -100, "-2"),
        array("公元前1世纪", -100, 0, "-1"),
    ),
    array
    (
        array("公元1世纪", 1, 100, "-0"),
        array("2世纪", 100, 200, "1"),
        array("3世纪", 200, 300, "2"),
        array("4世纪", 300, 400, "3"),
        array("5世纪", 400, 500, "4"),
        array("6世纪", 500, 600, "5"),
        array("7世纪", 600, 700, "6"),
        array("8世纪", 700, 800, "7"),
        array("9世纪", 800, 900, "8"),
        array("10世纪", 900, 1000, "9"),
    ),
    array
    (
        array("11世纪", 1000, 1100, "10"),
        array("12世纪", 1100, 1200, "11"),
        array("13世纪", 1200, 1300, "12"),
        array("14世纪", 1300, 1400, "13"),
        array("15世纪", 1400, 1500, "14"),
        array("16世纪", 1500, 1600, "15"),
        array("17世纪", 1600, 1700, "16"),
        array("18世纪", 1700, 1800, "17"),
        array("19世纪", 1800, 1900, "18"),
        array("20世纪", 1900, 2000, "19"),
    ),
    array
    (
        array("21世纪", 2000, date("Y") + 1, "20"),
        array("未来", date("Y") + 1, log(0), "21"),
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
            return "其它";
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

// 获取 世纪序号.
function get_century_index($big_id, $small_id)
{
    global $period;
    return $period[$big_id - 1][$small_id - 1][3];
}

?>