<html>
<head><meta http-equiv="content-type" content="text/html;charset=utf-8" />
<link rel="shortcut icon" type="image/x-icon" href="./favicon.ico" />

<title>UT</title></head><body>
<?php
    require_once 'init.php';
    is_user(1);
	require_once "data.php";
    require_once "sql.php";
    
    
    // debug zone.
    // get_time_from_native("前632.4");
    // echo Date("Y-m-d H:i:s", strtotime("2004-2-11 11:35")) . "</br>";
    // echo time_string_to_seconds("2004-2-11 11:35:00") . "</br>";
    // get_time_from_native("2004年2月11日11时35分");
    // get_time_from_native("2004-2-2 16:10:00");

    
    // 激活断言，并设置它为 quiet
    assert_options(ASSERT_ACTIVE, 1);
    assert_options(ASSERT_WARNING, 0);
    assert_options(ASSERT_QUIET_EVAL, 1);
    
    //创建处理函数
    function my_assert_handler($file, $line, $code, $desc = null)
    {
        echo "$file --- $line --- '' $code ''";
        if ($desc) {
            echo "<nobr style='color:red; '>:  $desc</nobr>";
        }else {
            echo "<nobr style='color:red; '>:  FAIL !!!</nobr>";
        }
        echo "<br />";
    }
    // 设置回调函数
    assert_options(ASSERT_CALLBACK, 'my_assert_handler');
    
    ///////////////////////// UT begin /////////////////////////
    ///////////////////////// dock /////////////////////////
        
    function UT_get_time_from_native($time_string, $time, $time_type, 
                                $time_limit, $time_limit_type)
    {
        $my = get_time_from_native($time_string);
        if ((($time == $my['time']) && ($time_type == $my['time_type']) 
            && ($time_limit == $my['time_limit']) && ($time_limit_type == $my['time_limit_type'])))
        {
            return TRUE;
        }
        else 
        {
            echo $my['time'] . "--" . $my['time_type'] . "--" . $my['time_limit'] 
                . "--" . $my['time_limit_type'] . "<-";
            return FALSE;
        }
    }
    
    function UT_splite_string($token, $time, $thing)
    {
        $my_array = splite_string($token);
        return (($my_array['time'] == $time) && ($my_array['thing'] == $thing));
    }
    
    function UT_get_year_order($date_string, $year_order)
    {
        return float_cmp(get_year_order(get_time_number($date_string, 3), 3), $year_order, 8);
    }
    
    function UT_chinese_to_number($chinese_str, $number)
    {
        if ($number != chinese_to_number($chinese_str))
        {
            echo chinese_to_number($chinese_str) . " -- ";
            return FALSE;
        }
        else
        {
            return TRUE;
        }
    }
    
    function UT_number_to_chinese($number, $chinese_str)
    {
        if ($chinese_str != number_to_chinese($number))
        {
            echo number_to_chinese($number) . " -- ";
            return FALSE;
        }
        else
        {
            return TRUE;
        }
    }
    ///////////////////////// UT zone /////////////////////////
    
    UT_splite_string("前730000年，周口店北京人", "前730000年", "周口店北京人");
    UT_splite_string("前7500年，彭头山文化，最早出现稻谷的中国史前文化", "前7500年", "彭头山文化，最早出现稻谷的中国史前文化");
    UT_splite_string("前7000年，裴李岗文化", "前7000年", "裴李岗文化");
    UT_splite_string("前6000年，磁山文化", "前6000年", "磁山文化");
    UT_splite_string("前3000年，龙山文化", "前3000年", "龙山文化");
    UT_splite_string("前2100，禹建立夏朝。", "前2100", "禹建立夏朝。");
    
    UT_splite_string("前730000年,周口店北京人", "前730000年", "周口店北京人");
    UT_splite_string("前7500年,彭头山文化，最早出现稻谷的中国史前文化", "前7500年", "彭头山文化，最早出现稻谷的中国史前文化");
    UT_splite_string("前7000年,裴李岗文化", "前7000年", "裴李岗文化");
    UT_splite_string("前6000年,磁山文化", "前6000年", "磁山文化");
    UT_splite_string("前3000年,龙山文化", "前3000年", "龙山文化");
    UT_splite_string("前2100,禹建立夏朝。", "前2100", "禹建立夏朝。");
    
    UT_splite_string("前730000年：周口店,北京人", "前730000年", "周口店,北京人");
    UT_splite_string("前7500年：彭头山文化，最早出现稻谷的中国史前文化", "前7500年", "彭头山文化，最早出现稻谷的中国史前文化");
    UT_splite_string("前7000年：裴李岗文化", "前7000年", "裴李岗文化");
    UT_splite_string("前6000年：磁山文化：是个好文化", "前6000年", "磁山文化：是个好文化");
    UT_splite_string("前3000年：龙山文化", "前3000年", "龙山文化");
    UT_splite_string("前2100：禹建立夏朝，夏朝。", "前2100", "禹建立夏朝，夏朝。");
    
    UT_splite_string("前730000年:周口店,北京人", "前730000年", "周口店,北京人");
    UT_splite_string("前7500年:彭头山文化，最早出现稻谷的中国史前文化", "前7500年", "彭头山文化，最早出现稻谷的中国史前文化");
    UT_splite_string("前7000年:裴李岗文化", "前7000年", "裴李岗文化");
    UT_splite_string("前6000年:磁山文化：是个好文化", "前6000年", "磁山文化：是个好文化");
    UT_splite_string("前3000年:龙山文化", "前3000年", "龙山文化");
    UT_splite_string("前2100:禹建立夏朝，夏朝。", "前2100", "禹建立夏朝，夏朝。");
    
    UT_splite_string("前900年：凯尔特人出现在英格兰；爱尔兰文明出现。", "前900年", "凯尔特人出现在英格兰；爱尔兰文明出现。");
    
    echo "</br>";
    
    // time_type: 1:距今年; 2:公元年; 3:年月日; 4:年月日 时分秒.
    // time_limit_type: 1:年; 2:日; 3:秒.
    // $time_array = array("time"=>0, "time_type"=>2, "time_limit"=>0, "time_limit_type"=>1);
    
    assert('days_to_time_string(time_string_to_days("-1975-10-3")) == "10/3/-1975"');
    assert('days_to_time_string(time_string_to_days("2015-10-3")) == "10/3/2015"');
    assert('UT_get_time_from_native("31000年前", -31000, 1, 0, 1)');
    assert('UT_get_time_from_native("310 00年前", -31000, 1, 0, 1)');
    assert('UT_get_time_from_native("3.5亿年前", -350000000, 1, 0, 1)');
    assert('UT_get_time_from_native("400.65万年前", -4006500, 1, 0, 1)');
    assert('UT_get_time_from_native("400. 65万年前", -4006500, 1, 0, 1)');
    assert('UT_get_time_from_native("1876年", 1876, 2, 0, 1)');
    assert('UT_get_time_from_native("1876 年", 1876, 2, 0, 1)');
    assert('UT_get_time_from_native("1955年7月1日", time_string_to_days("1955-7-1"), 3, 0, 1)');
    assert('UT_get_time_from_native("195 5年7月 1日", time_string_to_days("1955-7-1"), 3, 0, 1)');
    assert('UT_get_time_from_native("1955-7-1", time_string_to_days("1955-7-1"), 3, 0, 1)');
    assert('UT_get_time_from_native("1 955 -7 -1", time_string_to_days("1955-7-1"), 3, 0, 1)');
    assert('UT_get_time_from_native("1955/7/1", time_string_to_days("1955-7-1"), 3, 0, 1)');
    assert('UT_get_time_from_native("7/1/1986", time_string_to_days("1986-7-1"), 3, 0, 1)');
    assert('UT_get_time_from_native("1955年7月", time_string_to_days("1955-7-15"), 3, 15, 2)');
    assert('UT_get_time_from_native("195 5年 7 月", time_string_to_days("1955-7-15"), 3, 15, 2)');
    
    assert('UT_get_time_from_native("5/5/1986", time_string_to_days("1986-5-5"), 3, 0, 1)');
    assert('UT_get_time_from_native("5/ 5/ 1986", time_string_to_days("1986-5-5"), 3, 0, 1)');
    assert('UT_get_time_from_native("9/14/1991", time_string_to_days("1991-9-14"), 3, 0, 1)');
    
    assert('UT_get_time_from_native("公元前33年1月", time_string_to_days("-33-1-15"), 3, 15, 2)');
    assert('UT_get_time_from_native("公元前832年12月", time_string_to_days("-832-12-15"), 3, 15, 2)');
    assert('UT_get_time_from_native("公元前1955年7月", time_string_to_days("-1955-7-15"), 3, 15, 2)');
    assert('UT_get_time_from_native("公元前 1955年 7月", time_string_to_days("-1955-7-15"), 3, 15, 2)');
    assert('UT_get_time_from_native("公元前1955年7月15日", time_string_to_days("-1955-7-15"), 3, 0, 1)');
    
    assert('UT_get_time_from_native("前1955年7月", time_string_to_days("-1955-7-15"), 3, 15, 2)');
    assert('UT_get_time_from_native("前1955年7月15日", time_string_to_days("-1955-7-15"), 3, 0, 1)');
    assert('UT_get_time_from_native("前1955 年7 月1 5日", time_string_to_days("-1955-7-15"), 3, 0, 1)');
    
    assert('UT_get_time_from_native("1955年一月下旬", time_string_to_days("1955-1-25"), 3, 5, 2)');
    assert('UT_get_time_from_native("1955 年一 月下 旬", time_string_to_days("1955-1-25"), 3, 5, 2)');
    assert('UT_get_time_from_native("1955年二月下旬", time_string_to_days("1955-2-25"), 3, 5, 2)');
    assert('UT_get_time_from_native("1955年三月下旬", time_string_to_days("1955-3-25"), 3, 5, 2)');
    assert('UT_get_time_from_native("1955年四月下旬", time_string_to_days("1955-4-25"), 3, 5, 2)');
    assert('UT_get_time_from_native("1955年五月下旬", time_string_to_days("1955-5-25"), 3, 5, 2)');
    assert('UT_get_time_from_native("1955年六月下旬", time_string_to_days("1955-6-25"), 3, 5, 2)');
    assert('UT_get_time_from_native("1955年七月下旬", time_string_to_days("1955-7-25"), 3, 5, 2)');
    assert('UT_get_time_from_native("1955年八月下旬", time_string_to_days("1955-8-25"), 3, 5, 2)');
    assert('UT_get_time_from_native("1955年九月下旬", time_string_to_days("1955-9-25"), 3, 5, 2)');
    assert('UT_get_time_from_native("1955年十月下旬", time_string_to_days("1955-10-25"), 3, 5, 2)');
    assert('UT_get_time_from_native("1955年十一月下旬", time_string_to_days("1955-11-25"), 3, 5, 2)');
    assert('UT_get_time_from_native("1955年十二月下旬", time_string_to_days("1955-12-25"), 3, 5, 2)');
    assert('UT_get_time_from_native("1955年1月下旬", time_string_to_days("1955-1-25"), 3, 5, 2)');
    assert('UT_get_time_from_native("19 55年 1月 下 旬", time_string_to_days("1955-1-25"), 3, 5, 2)');
    assert('UT_get_time_from_native("1955年2月下旬", time_string_to_days("1955-2-25"), 3, 5, 2)');
    assert('UT_get_time_from_native("1955年3月下旬", time_string_to_days("1955-3-25"), 3, 5, 2)');
    assert('UT_get_time_from_native("1955年4月下旬", time_string_to_days("1955-4-25"), 3, 5, 2)');
    assert('UT_get_time_from_native("1955年5月下旬", time_string_to_days("1955-5-25"), 3, 5, 2)');
    assert('UT_get_time_from_native("1955年6月下旬", time_string_to_days("1955-6-25"), 3, 5, 2)');
    assert('UT_get_time_from_native("1955年7月下旬", time_string_to_days("1955-7-25"), 3, 5, 2)');
    assert('UT_get_time_from_native("1955年8月下旬", time_string_to_days("1955-8-25"), 3, 5, 2)');
    assert('UT_get_time_from_native("1955年9月下旬", time_string_to_days("1955-9-25"), 3, 5, 2)');
    assert('UT_get_time_from_native("1955年10月下旬", time_string_to_days("1955-10-25"), 3, 5, 2)');
    assert('UT_get_time_from_native("1955年11月下旬", time_string_to_days("1955-11-25"), 3, 5, 2)');
    assert('UT_get_time_from_native("1955年12月下旬", time_string_to_days("1955-12-25"), 3, 5, 2)');
    
    assert('UT_get_time_from_native("1955年7月上旬", time_string_to_days("1955-7-5"), 3, 5, 2)');
    assert('UT_get_time_from_native("1955年12月上旬", time_string_to_days("1955-12-5"), 3, 5, 2)');
    assert('UT_get_time_from_native("1955年一月中旬", time_string_to_days("1955-1-15"), 3, 5, 2)');
    assert('UT_get_time_from_native("1750年上半年", time_string_to_days("1750-3-31"), 3, 90, 2)');
    assert('UT_get_time_from_native("234年下半年", time_string_to_days("234-9-30"), 3, 90, 2)');
    assert('UT_get_time_from_native("1234年一季度", time_string_to_days("1234-2-15"), 3, 45, 2)');
    assert('UT_get_time_from_native("1234年第一季度", time_string_to_days("1234-2-15"), 3, 45, 2)');
    assert('UT_get_time_from_native("1234年二季度", time_string_to_days("1234-5-15"), 3, 45, 2)');
    assert('UT_get_time_from_native("1234年第二季度", time_string_to_days("1234-5-15"), 3, 45, 2)');
    assert('UT_get_time_from_native("1234年三季度", time_string_to_days("1234-8-15"), 3, 45, 2)');
    assert('UT_get_time_from_native("1234年第三季度", time_string_to_days("1234-8-15"), 3, 45, 2)');
    assert('UT_get_time_from_native("1234年四季度", time_string_to_days("1234-11-15"), 3, 45, 2)');
    assert('UT_get_time_from_native("1234年第四季度", time_string_to_days("1234-11-15"), 3, 45, 2)');
    assert('UT_get_time_from_native("1234年 第一 季度", time_string_to_days("1234-2-15"), 3, 45, 2)');
    assert('UT_get_time_from_native("1234年春天", time_string_to_days("1234-4-15"), 3, 45, 2)');
    assert('UT_get_time_from_native("1234年 春天", time_string_to_days("1234-4-15"), 3, 45, 2)');
    assert('UT_get_time_from_native("1234年春季", time_string_to_days("1234-4-15"), 3, 45, 2)');
    assert('UT_get_time_from_native("1234年春", time_string_to_days("1234-4-15"), 3, 45, 2)');
    assert('UT_get_time_from_native("1234年夏", time_string_to_days("1234-7-15"), 3, 45, 2)');
    assert('UT_get_time_from_native("1234年秋", time_string_to_days("1234-10-15"), 3, 45, 2)');
    assert('UT_get_time_from_native("1234年冬", time_string_to_days("1235-1-15"), 3, 45, 2)');
    
    assert('UT_get_time_from_native("前386年", -386, 2, 0, 1)');
    assert('UT_get_time_from_native("前 386年", -386, 2, 0, 1)');
    assert('UT_get_time_from_native("前2100", -2100, 2, 0, 1)');
    assert('UT_get_time_from_native("公元前2100", -2100, 2, 0, 1)');
    assert('UT_get_time_from_native("12", 12, 2, 0, 1)');
    assert('UT_get_time_from_native("17年", 17, 2, 0, 1)');
    assert('UT_get_time_from_native("1913", 1913, 2, 0, 1)');
    assert('UT_get_time_from_native("1950年12月19日", time_string_to_days("1950-12-19"), 3, 0, 1)');
    assert('UT_get_time_from_native("195 0 年 12 月 1 9 日", time_string_to_days("1950-12-19"), 3, 0, 1)');
    
    assert('UT_get_time_from_native("公元前15世纪",      -1450, 2, 50, 1)');
    assert('UT_get_time_from_native("公元前十五世纪",    -1450, 2, 50, 1)');
    assert('UT_get_time_from_native("公 元 前 十 五 世 纪",    -1450, 2, 50, 1)');
    assert('UT_get_time_from_native("前15世纪",          -1450, 2, 50, 1)');
    assert('UT_get_time_from_native("前十五世纪",        -1450, 2, 50, 1)');
    assert('UT_get_time_from_native("公元前70世纪",      -6950, 2, 50, 1)');
    assert('UT_get_time_from_native("公元前七十世纪",    -6950, 2, 50, 1)');
    assert('UT_get_time_from_native("公元前1世纪",       -50, 2, 50, 1)');
    assert('UT_get_time_from_native("公元1世纪",         50, 2, 50, 1)');
    assert('UT_get_time_from_native("公元一世纪",        50, 2, 50, 1)');
    assert('UT_get_time_from_native("公元17世纪",        1650, 2, 50, 1)');
    
    assert('UT_get_time_from_native("1939-9-1",      time_string_to_days("1939-9-1"), 3, 0, 1)');
    assert('UT_get_time_from_native("1939/9/1",      time_string_to_days("1939/9/1"), 3, 0, 1)');
    assert('UT_get_time_from_native("1939.09.01",    time_string_to_days("1939.09.01"), 3, 0, 1)');
    assert('UT_get_time_from_native(" 1 9 3 9 . 0 9 . 0 1 ",    time_string_to_days("1939.09.01"), 3, 0, 1)');
    assert('UT_get_time_from_native("1939.9.1",    time_string_to_days("1939-9-1"), 3, 0, 1)');
    assert('UT_get_time_from_native("1939-09",    time_string_to_days("1939-09-15"), 3, 15, 2)');
    assert('UT_get_time_from_native("1939.09",    time_string_to_days("1939-09-15"), 3, 15, 2)');
    assert('UT_get_time_from_native("1939-9",    time_string_to_days("1939-9-15"), 3, 15, 2)');
    assert('UT_get_time_from_native("1919.6",    time_string_to_days("1919-6-15"), 3, 15, 2)');
    assert('UT_get_time_from_native("1932",    1932, 2, 0, 1)');
    assert('UT_get_time_from_native("前900年",    -900, 2, 0, 1)');
    assert('UT_get_time_from_native("-900年",    -900, 2, 0, 1)');
    assert('UT_get_time_from_native("公元前2000年",    -2000, 2, 0, 1)');
    assert('UT_get_time_from_native("前54年",    -54, 2, 0, 1)');
    assert('UT_get_time_from_native("192Ο年", 1920, 2, 0, 1)');
    assert('UT_get_time_from_native("192Ο-1Ο-2Ο", time_string_to_days("1920-10-20"), 3, 0, 1)');
    
    assert('UT_get_time_from_native("前1955年一月", time_string_to_days("-1955-1-15"), 3, 15, 2)');
    assert('UT_get_time_from_native("前1955年1月", time_string_to_days("-1955-1-15"), 3, 15, 2)');
    assert('UT_get_time_from_native("前1955.1", time_string_to_days("-1955-1-15"), 3, 15, 2)');
    assert('UT_get_time_from_native("1955年一月", time_string_to_days("1955-1-15"), 3, 15, 2)');
    assert('UT_get_time_from_native("1955年1月", time_string_to_days("1955-1-15"), 3, 15, 2)');
    assert('UT_get_time_from_native("1955.1", time_string_to_days("1955-1-15"), 3, 15, 2)');
    
    assert('UT_get_time_from_native("公元1955年初", time_string_to_days("1955-1-15"), 3, 15, 2)');
    assert('UT_get_time_from_native("公元1955年底", time_string_to_days("1955-12-15"), 3, 15, 2)');
    assert('UT_get_time_from_native("1955年一月初", time_string_to_days("1955-1-5"), 3, 5, 2)');
    assert('UT_get_time_from_native("1955年一月底", time_string_to_days("1955-1-25"), 3, 5, 2)');
    
    assert('UT_get_time_from_native("3 October 2005", time_string_to_days("2005-10-3"), 3, 0, 1)');
    assert('UT_get_time_from_native("3rd October 2005", time_string_to_days("2005-10-3"), 3, 0, 1)');
    assert('UT_get_time_from_native("23rd October  2005", time_string_to_days("2005-10-23"), 3, 0, 1)');
    assert('UT_get_time_from_native("January 17, 2002", time_string_to_days("2002-1-17"), 3, 0, 1)');
    assert('UT_get_time_from_native("January 17th, 2002", time_string_to_days("2002-1-17"), 3, 0, 1)');
    assert('UT_get_time_from_native("January  17 ,  2002", time_string_to_days("2002-1-17"), 3, 0, 1)');
    assert('UT_get_time_from_native("January  17th,  2002", time_string_to_days("2002-1-17"), 3, 0, 1)');
    assert('UT_get_time_from_native("3 Oct 2005", time_string_to_days("2005-10-3"), 3, 0, 1)');
    assert('UT_get_time_from_native("3rd Oct 2005", time_string_to_days("2005-10-3"), 3, 0, 1)');
    assert('UT_get_time_from_native("23rd Oct 2005", time_string_to_days("2005-10-23"), 3, 0, 1)');
    assert('UT_get_time_from_native("Jan 17, 2002", time_string_to_days("2002-1-17"), 3, 0, 1)');
    assert('UT_get_time_from_native("Jan 17th, 2002", time_string_to_days("2002-1-17"), 3, 0, 1)');
    assert('UT_get_time_from_native("01/03/2009", time_string_to_days("2009-1-3"), 3, 0, 1)');
    
    assert('UT_get_time_from_native("前五十四年",    -54, 2, 0, 1)');
    assert('UT_get_time_from_native("一九八四",    1984, 2, 0, 1)');
    assert('UT_get_time_from_native("一九八四年",    1984, 2, 0, 1)');
    assert('UT_get_time_from_native("一九八四年七月十五日",    time_string_to_days("1984-7-15"), 3, 0, 1)');
    assert('UT_get_time_from_native("一九八四年十一月十五日",    time_string_to_days("1984-11-15"), 3, 0, 1)');
    assert('UT_get_time_from_native("一九八四年十一月",    time_string_to_days("1984-11-15"), 3, 15, 2)');
    assert('UT_get_time_from_native("一二三四年春季", time_string_to_days("1234-4-15"), 3, 45, 2)');
    
    assert('UT_get_time_from_native("20世纪前期",        1915, 2, 15, 1)');
    assert('UT_get_time_from_native("20世纪中期",        1950, 2, 20, 1)');
    assert('UT_get_time_from_native("20世纪中叶",        1950, 2, 20, 1)');
    assert('UT_get_time_from_native("20世纪后期",        1985, 2, 15, 1)');
    assert('UT_get_time_from_native("20世纪初",        1905, 2, 5, 1)');
    assert('UT_get_time_from_native("20世纪末",        1995, 2, 5, 1)');
    
    assert('UT_get_time_from_native("公元一世纪前期",      15, 2, 15, 1)');
    assert('UT_get_time_from_native("公元一世纪中期",      50, 2, 20, 1)');
    assert('UT_get_time_from_native("公元一世纪中叶",      50, 2, 20, 1)');
    assert('UT_get_time_from_native("公元一世纪后期",      85, 2, 15, 1)');
    assert('UT_get_time_from_native("公元一世纪初",        05, 2, 5, 1)');
    assert('UT_get_time_from_native("公元一世纪末",        95, 2, 5, 1)');
    
    assert('UT_get_time_from_native("公元前十五世纪前期",      -1485, 2, 15, 1)');
    assert('UT_get_time_from_native("公元前十五世纪中期",      -1450, 2, 20, 1)');
    assert('UT_get_time_from_native("公元前十五世纪中叶",      -1450, 2, 20, 1)');
    assert('UT_get_time_from_native("公元前十五世纪后期",      -1415, 2, 15, 1)');
    assert('UT_get_time_from_native("公元前十五世纪初",        -1495, 2, 5, 1)');
    assert('UT_get_time_from_native("公元前十五世纪末",        -1405, 2, 5, 1)');
    
    assert('UT_get_time_from_native("公元前20世纪前期",      -1985, 2, 15, 1)');
    assert('UT_get_time_from_native("公元前20世纪中期",      -1950, 2, 20, 1)');
    assert('UT_get_time_from_native("公元前20世纪中叶",      -1950, 2, 20, 1)');
    assert('UT_get_time_from_native("公元前20世纪后期",      -1915, 2, 15, 1)');
    assert('UT_get_time_from_native("公元前20世纪初",        -1995, 2, 5, 1)');
    assert('UT_get_time_from_native("公元前20世纪末",        -1905, 2, 5, 1)');
    
    assert('UT_get_time_from_native("前632.4", time_string_to_days("-632-4-15"), 3, 15, 2)');
    
    // 年月日 时分秒
    assert('UT_get_time_from_native("2004年2月11日11时", time_string_to_seconds("2004-2-11 11:00:00"), 4, 0, 3)');
    assert('UT_get_time_from_native("2004年2月11日11时35分", time_string_to_seconds("2004-2-11 11:35:00"), 4, 0, 3)');
    assert('UT_get_time_from_native("2004年2月23日6时10分", time_string_to_seconds("2004-2-23 6:10:00"), 4, 0, 3)');
    assert('UT_get_time_from_native("2004年3月1日23时20分59秒", time_string_to_seconds("2004-3-1 23:20:59"), 4, 0, 3)');
    assert('UT_get_time_from_native("2004年6月9日10时0分", time_string_to_seconds("2004-6-9 10:00:00"), 4, 0, 3)');
    
    assert('UT_get_time_from_native("2004-2-11 11:00:00", time_string_to_seconds("2004-2-11 11:00:00"), 4, 0, 3)');
    assert('UT_get_time_from_native("2004-2-11 11:35:00", time_string_to_seconds("2004-2-11 11:35:00"), 4, 0, 3)');
    assert('UT_get_time_from_native("2004-2-23 6:10:00", time_string_to_seconds("2004-2-23 6:10:00"), 4, 0, 3)');
    assert('UT_get_time_from_native("2004-2-2 16:10:00", time_string_to_seconds("2004-2-2 16:10:00"), 4, 0, 3)');
    assert('UT_get_time_from_native("2004-3-1 23:20:59", time_string_to_seconds("2004-3-1 23:20:59"), 4, 0, 3)');
    assert('UT_get_time_from_native("2004-6-9 10:00:00", time_string_to_seconds("2004-6-9 10:00:00"), 4, 0, 3)');
    
    
    echo "</br>";
    
    // assert('UT_get_time_from_native("19390901",      time_string_to_days("19390901"), 3, 0, 1)'); // 不支持。
    
    assert('is_leap_year(1980)');
    assert('!is_leap_year(1981)');
    assert('!is_leap_year(1900)');
    assert('is_leap_year(2000)');
    assert('is_leap_year(2016)');
    
    assert('get_weekday(2015, 1, 24) == 6');
    
    assert('preg_match("/^[\w\-\.]+@[\w\-\.]+(\.\w+)+$/", "likecat@gmail.com")');
    assert('preg_match("/^[\w\-\.]+@[\w\-\.]+(\.\w+)+$/", "451877089@qq.com")');
    
    assert('UT_get_year_order("2015-1-2", 2015.002739726)');
    assert('UT_get_year_order("2015-6-31", 2015.495890411)');
    assert('UT_get_year_order("2015-11-31", 2015.9150684932)');
    assert('UT_get_year_order("2015-12-31", 2015.997260274)');
    // echo get_year_order(get_time_number("-581-1-15", 3), 3);
    
    echo "</br>";
    
    assert("is_infinite(log(0))");
    
    echo get_search_where_sub("中国 and 首都 and 财政") . "<br />";
    echo get_search_where_sub("蒋介石 or 毛泽东") . "<br />";
    echo get_search_where_sub("唐朝 and 诗人 - 李白") . "<br />";
    echo get_search_where_sub("唐朝 and ( 诗人 - ( 李白 or 杜甫 ) )") . "<br />";
    
    echo "</br>";
    
    $context = "1840年1月5日，道光二十年，前湖广总督林则徐正式就任两广总督。
1838年12月31日，林则徐奉命为钦差大臣，赴广州查办海口禁烟事务，节制广东水师。
1841年7月，道光二十一年，汉口、江夏水灾，灾民10余万，仕商设粥场救济。";
    $token = strtok(html_encode(one_line_flag($context)), "\r");
    while(($token != false) && (strlen($token) > 0))
    {
        echo $token . " -- <br />";
        $token = strtok("\r");
    }
    
    echo "</br>";
    
    print_r(explode(",", "123, 456"));
    print_r(explode(",", "123 456"));
    print_r(explode(",", ""));
    print_r(explode(",", "123 , "));
    echo "</br>";
    
    echo "</br>";
    
    assert('UT_chinese_to_number("一九八九", 1989)');
    assert('UT_chinese_to_number("一二三四五六七八九", 123456789)');
    assert('UT_chinese_to_number("一二三四五六七八九零Ο", 12345678900)');
    assert('UT_chinese_to_number("十九", 19)');
    assert('UT_chinese_to_number("二十", 20)');
    assert('UT_chinese_to_number("二十一", 21)');
    // assert('UT_chinese_to_number("一百零一", 101)');
    assert('UT_chinese_to_number("192Ο", 1920)');
    
    // assert('UT_number_to_chinese(1989, "一九八九")');
    // assert('UT_number_to_chinese(123456789, "一二三四五六七八九")');
    // assert('UT_number_to_chinese(12345678900, "一二三四五六七八九ΟΟ")');
    assert('UT_number_to_chinese(19, "十九")');
    assert('UT_number_to_chinese(20, "二十")');
    assert('UT_number_to_chinese(21, "二十一")');
    // assert('UT_number_to_chinese(101, "一百零一")');
    
    
    echo "</br>";
    
?>

</body>
</html>

<!--  site: www.w3school.com.cn/tiy/t.asp

<html><body>

<script type="text/javascript">
// 被测试函数
function check_date(time_value)
{
	var r = time_value.match(/^(\d{1,4})(-|\/)(\d{1,2})\2(\d{1,2})$/);
	if(r == null)return false;
	
	var d = new Date(r[1], r[3]-1, r[4]);
	return ((d.getFullYear()==r[1]) && ((d.getMonth()+1)==r[3]) && (d.getDate()==r[4]));
}

function test()
{
var test = document.getElementById("time").value;
document.getElementById("time_alert").innerHTML = check_date(test);
document.getElementById("time_alert").style.display = "inline";
}
</script>

<input type="text" id="time" /></p>
<input type="submit" onclick="test()" /></p>
<div id="time_alert" style="display:none"></div>

</body></html>

-->
