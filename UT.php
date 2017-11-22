<html>
<head><meta http-equiv="content-type" content="text/html;charset=utf-8" />
<link rel="shortcut icon" type="image/x-icon" href="./favicon.ico" />

<?php
    require_once 'init.php';
    is_user(1);
    require_once "data.php";
    require_once "sql.php";
    require_once 'vip_tag.php';
    require_once 'view_list.php';
    require_once 'view_update.php';
    
    // 打开数据库
    $conn = open_db();
    
    // 检查时间
    if(!empty($_POST['UT_time_string']))
    {
        $UT_ori_time = $_POST['UT_time_string'];
        $UT_time_array = get_time_from_native($UT_ori_time);
        $UT_time = get_time_string($UT_time_array['time'], $UT_time_array['time_type']) . " -- " . 
            get_time_limit_string($UT_time_array['time_limit'], $UT_time_array['time_limit_type']);
    }
    else 
    {
        // $UT_time = "a";
        $UT_time = print_item_tags_from_db("ceca07b2-6f6b-c419-0c85-54e3fdc5cbb1");
    }
?>


<title>UT</title></head><body>

<form action="" method="post">
    <input type="text" name="UT_time_string" value="<?=$UT_ori_time?>" /></p>
    <input type="submit" id="update_data" value='时间识别测试' /> <!-- 提交 -->
    <font size="4" color="red" ><?=$UT_time?></font><br>
</form>

<?php
    // 激活断言，并设置它为 quiet
    assert_options(ASSERT_ACTIVE, 1);
    assert_options(ASSERT_WARNING, 0);
    assert_options(ASSERT_QUIET_EVAL, 1);
    
    // 显示当前时间
    echo "测试时间: " . date("Y-m-d G:i:s") . "</br></br>";
    
    // print_r(array)
    // var_dump(array)  -- 更强大，还能打印每个字段的数据类型。
    
    $error_case_count = 0;
    
    //创建处理函数
    function my_assert_handler($file, $line, $code, $desc = null)
    {
        global $error_case_count;
        $error_case_count++;
        
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
    
    // debug zone.
    // ok--0---18500--1--0--1
    assert('UT_get_time_from_native("距今1.85万年前", -18500, 1, 0, 1)');
    
    ///////////////////////// UT begin /////////////////////////////////////
    //////////////////////// 1.字符串分割 ///////////////////////////////////
    echo "1.字符串分割</br>";
    
    function UT_string_compare($ori, $check)
    {
        return (trim($ori) === trim($check));
    }
    $context = "1840年1月5日，道光二十年，前湖广总督林则徐正式就任两广总督。
1838年12月31日，林则徐奉命为钦差大臣，赴广州查办海口禁烟事务，节制广东水师。
1841年7月，道光二十一年，汉口、江夏水灾，灾民10余万，仕商设粥场救济。";

    $context_array = array
    (
        "1840年1月5日，道光二十年，前湖广总督林则徐正式就任两广总督。",
        "1838年12月31日，林则徐奉命为钦差大臣，赴广州查办海口禁烟事务，节制广东水师。",
        "1841年7月，道光二十一年，汉口、江夏水灾，灾民10余万，仕商设粥场救济。",
    );
    
    static $context_index = 0;
    $token = strtok(html_encode(one_line_flag($context)), "\r");
    while(($token != false) && (strlen($token) > 0))
    {
        assert('UT_string_compare($token, $context_array[$context_index++])');
        $token = strtok("\r");
    }
    
    function UT_splite_string($token, $time, $thing)
    {
        $my_array = splite_string($token);
        return (($my_array['time'] == $time) && ($my_array['thing'] == $thing));
    }
    assert('UT_splite_string("2016-01-16 19:00:00，周口店北京人", "2016-01-16 19:00:00", "周口店北京人")');
    assert('UT_splite_string("2016-01-16 19:00:00, 周口店北京人", "2016-01-16 19:00:00", " 周口店北京人")');
    
    assert('UT_splite_string("前730000年，周口店北京人", "前730000年", "周口店北京人")');
    assert('UT_splite_string("前2100，禹建立,夏朝。", "前2100", "禹建立,夏朝。")');
    assert('UT_splite_string("前730000年,周口店，北京人", "前730000年", "周口店，北京人")');
    assert('UT_splite_string("前2100,禹建立，夏朝。", "前2100", "禹建立，夏朝。")');
    assert('UT_splite_string("距今1.25万年前，在北极留下石器痕迹的巨兽猎人是最早进入北极圈的人类。这些能够适应寒冷气候的猎人显然至少在距今1.5万年前穿越了西伯利亚和白令海峡。"
        , "距今1.25万年前", "在北极留下石器痕迹的巨兽猎人是最早进入北极圈的人类。这些能够适应寒冷气候的猎人显然至少在距今1.5万年前穿越了西伯利亚和白令海峡。")');
    assert('UT_splite_string("距今1.85万年前，人类可能第一次到达了美洲。", "距今1.85万年前", "人类可能第一次到达了美洲。")');
        
    // assert('UT_splite_string("前2100：禹建立夏朝；夏朝。", "前2100", "禹建立夏朝；夏朝。")');
    // assert('UT_splite_string("前730000年:周口店,北京人", "前730000年", "周口店,北京人")');
    // assert('UT_splite_string("前2100:禹建立夏朝，夏朝。", "前2100", "禹建立夏朝，夏朝。")');
    
    //////////////////////// 2.时间识别 ///////////////////////////////////
    // time_type: 1:距今年; 2:公元年; 3:年月日; 4:年月日 时分秒.
    // time_limit_type: 1:年; 2:日; 3:秒.
    // array("status"=>"init", "time"=>0, "time_type"=>2, "time_limit"=>0, "time_limit_type"=>1, "is_bc"=>0);
    echo "2.时间识别</br>";
    
    assert('days_to_time_string(time_string_to_days("-1975-10-3")) == "10/3/-1975"');
    assert('days_to_time_string(time_string_to_days("2015-10-3")) == "10/3/2015"');
    
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
            echo "Status--" . $my['status'] . "; Time--" . $my['time'] . "; Time_type--" . $my['time_type'] 
                . "; Time_limit--" . $my['time_limit'] . "; Time_limit_type-" . $my['time_limit_type'] 
                . " --- </br>";
            return FALSE;
        }
    }
    
    function UT_get_current_year($check)
    {
        if (get_current_year() == $check)
        {
            return TRUE;
        }
        else 
        {
            echo get_current_year() . "</br>";
            return FALSE;
        }
    }
    
    assert('UT_get_current_year(2017)');
    assert('UT_get_time_from_native("31000年前", -31000, 1, 0, 1)');
    assert('UT_get_time_from_native("310 00年前", -31000, 1, 0, 1)');
    assert('UT_get_time_from_native("3.5亿年前", -350000000, 1, 0, 1)');
    assert('UT_get_time_from_native("400.65万年前", -4006500, 1, 0, 1)');
    assert('UT_get_time_from_native("400. 65万年前", -4006500, 1, 0, 1)');
    assert('UT_get_time_from_native("1.85万年前", -18500, 1, 0, 1)');
    assert('UT_get_time_from_native("1.25万年前", -12500, 1, 0, 1)');
    assert('UT_get_time_from_native("12500年前", -12500, 1, 0, 1)');
    
    assert('UT_get_time_from_native("距今31000年前", -31000, 1, 0, 1)');
    assert('UT_get_time_from_native("距今310 00年前", -31000, 1, 0, 1)');
    assert('UT_get_time_from_native("距今3.5亿年前", -350000000, 1, 0, 1)');
    assert('UT_get_time_from_native("距今400.65万年前", -4006500, 1, 0, 1)');
    assert('UT_get_time_from_native("距今400. 65万年前", -4006500, 1, 0, 1)');
    assert('UT_get_time_from_native("距今1.85万年前", -18500, 1, 0, 1)');
    assert('UT_get_time_from_native("距今1.25万年前", -12500, 1, 0, 1)');
    assert('UT_get_time_from_native("距今12500年前", -12500, 1, 0, 1)');
    assert('UT_get_time_from_native("距今7000年前", -7000, 1, 0, 1)');
    
    assert('UT_get_time_from_native("7000年前", -7000, 1, 0, 1)');
    assert('UT_get_time_from_native("公元前7000年", -7000, 2, 0, 1)');
    
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
    
    // 中文时间
    assert('UT_get_time_from_native("一八八〇年十月二十三日", time_string_to_days("1880-10-23"), 3, 0, 1)');
    assert('UT_get_time_from_native("一九二〇", 1920, 2, 0, 1)');
    assert('UT_get_time_from_native("一九四二年九月十一日十九时", 
            time_string_to_seconds("1942-9-11 19:00:00"), 4, 0, 3)');
    
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
    
    assert('UT_get_time_from_native("２０１０年１０月２８日",  time_string_to_days("2010-10-28"), 3, 0, 1)');
    assert('UT_get_time_from_native("２０１０年２月１１日",   time_string_to_days("2010-2-11"), 3, 0, 1)');
    assert('UT_get_time_from_native("２０１０年９月２5日",    time_string_to_days("2010-9-25"), 3, 0, 1)');
    assert('UT_get_time_from_native("一",    1, 2, 0, 1)');
    assert('UT_get_time_from_native("二",    2, 2, 0, 1)');
    assert('UT_get_time_from_native("三",    3, 2, 0, 1)');
    assert('UT_get_time_from_native("四",    4, 2, 0, 1)');
    assert('UT_get_time_from_native("一百",    100, 2, 0, 1)');
    assert('UT_get_time_from_native("九十九",    99, 2, 0, 1)');
    assert('UT_get_time_from_native("九十八",    98, 2, 0, 1)');
    assert('UT_get_time_from_native("九十七",    97, 2, 0, 1)');
    assert('UT_get_time_from_native("１",    1, 2, 0, 1)');
    assert('UT_get_time_from_native("２",    2, 2, 0, 1)');
    assert('UT_get_time_from_native("３",    3, 2, 0, 1)');
    assert('UT_get_time_from_native("４",    4, 2, 0, 1)');
    assert('UT_get_time_from_native("５",    5, 2, 0, 1)');
    assert('UT_get_time_from_native("６",    6, 2, 0, 1)');
    assert('UT_get_time_from_native("７",    7, 2, 0, 1)');
    assert('UT_get_time_from_native("８",    8, 2, 0, 1)');
    assert('UT_get_time_from_native("９",    9, 2, 0, 1)');
    assert('UT_get_time_from_native("一〇",  10, 2, 0, 1)');
    
    assert('UT_get_time_from_native("一九○○年",    1900, 2, 0, 1)');
    assert('UT_get_time_from_native("一九○四",    1904, 2, 0, 1)');
    assert('UT_get_time_from_native("一九三○年",    1930, 2, 0, 1)');
    assert('UT_get_time_from_native("一○○年",    100, 2, 0, 1)');
    
    assert('UT_get_time_from_native("一九ΟΟ年",    1900, 2, 0, 1)');
    assert('UT_get_time_from_native("一九Ο四",    1904, 2, 0, 1)');
    assert('UT_get_time_from_native("一九三Ο年",    1930, 2, 0, 1)');
    assert('UT_get_time_from_native("一ΟΟ年",    100, 2, 0, 1)');
    
    assert('UT_get_time_from_native("一九零零年",    1900, 2, 0, 1)');
    assert('UT_get_time_from_native("一九零四",    1904, 2, 0, 1)');
    assert('UT_get_time_from_native("一九三零年",    1930, 2, 0, 1)');
    assert('UT_get_time_from_native("一零零年",    100, 2, 0, 1)');

    assert('UT_get_time_from_native("一百年",    100, 2, 0, 1)');
        
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
    assert('UT_get_time_from_native("公元前30世纪后期",        -2915, 2, 15, 1)');
    
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
    assert('UT_get_time_from_native("一九三六年八月十九日五时二十五分", time_string_to_seconds("1936-8-19 5:25:00"), 4, 0, 3)');
    
    assert('UT_get_time_from_native("2004年2月11日11点", time_string_to_seconds("2004-2-11 11:00:00"), 4, 0, 3)');
    assert('UT_get_time_from_native("2004年2月11日11点35分", time_string_to_seconds("2004-2-11 11:35:00"), 4, 0, 3)');
    assert('UT_get_time_from_native("2004年2月23日6点10分", time_string_to_seconds("2004-2-23 6:10:00"), 4, 0, 3)');
    assert('UT_get_time_from_native("2004年3月1日23点20分59秒", time_string_to_seconds("2004-3-1 23:20:59"), 4, 0, 3)');
    assert('UT_get_time_from_native("2004年6月9日10点0分", time_string_to_seconds("2004-6-9 10:00:00"), 4, 0, 3)');
    assert('UT_get_time_from_native("一九三六年八月十九日五点二十五分", time_string_to_seconds("1936-8-19 5:25:00"), 4, 0, 3)');
    
    assert('UT_get_time_from_native("2016-01-16 19:00:00", time_string_to_seconds("2016-01-16 19:00:00"), 4, 0, 3)');
    assert('UT_get_time_from_native("2004-02-11 11:00:00", time_string_to_seconds("2004-02-11 11:00:00"), 4, 0, 3)');
    assert('UT_get_time_from_native("2004-2-11 11:35:00", time_string_to_seconds("2004-2-11 11:35:00"), 4, 0, 3)');
    assert('UT_get_time_from_native("2004-2-23 6:10:00", time_string_to_seconds("2004-2-23 6:10:00"), 4, 0, 3)');
    assert('UT_get_time_from_native("2004-2-2 16:10:00", time_string_to_seconds("2004-2-2 16:10:00"), 4, 0, 3)');
    assert('UT_get_time_from_native("2004-3-1 23:20:59", time_string_to_seconds("2004-3-1 23:20:59"), 4, 0, 3)');
    assert('UT_get_time_from_native("2004-6-9 10:00:00", time_string_to_seconds("2004-6-9 10:00:00"), 4, 0, 3)');
    
    // 凌晨、上午、中午、下午、晚上
    assert('UT_get_time_from_native("2004年2月11日凌晨", time_string_to_seconds("2004-2-11 3:00:00"), 4, 3600*3, 3)');
    assert('UT_get_time_from_native("2004年2月11日上午", time_string_to_seconds("2004-2-11 9:00:00"), 4, 3600*3, 3)');
    assert('UT_get_time_from_native("2004年2月11日中午", time_string_to_seconds("2004-2-11 12:30:00"), 4, 1800, 3)');
    assert('UT_get_time_from_native("2004年2月11日下午", time_string_to_seconds("2004-2-11 15:00:00"), 4, 3600*3, 3)');
    assert('UT_get_time_from_native("2004年2月11日晚上", time_string_to_seconds("2004-2-11 21:00:00"), 4, 3600*3, 3)');
    
    assert('UT_get_time_from_native("2004-2-11凌晨", time_string_to_seconds("2004-2-11 3:00:00"), 4, 3600*3, 3)');
    assert('UT_get_time_from_native("2004-2-11上午", time_string_to_seconds("2004-2-11 9:00:00"), 4, 3600*3, 3)');
    assert('UT_get_time_from_native("2004-2-11中午", time_string_to_seconds("2004-2-11 12:30:00"), 4, 1800, 3)');
    assert('UT_get_time_from_native("2004-2-11下午", time_string_to_seconds("2004-2-11 15:00:00"), 4, 3600*3, 3)');
    assert('UT_get_time_from_native("2004-2-11晚上", time_string_to_seconds("2004-2-11 21:00:00"), 4, 3600*3, 3)');
    
    assert('UT_get_time_from_native("2004年2月11日凌晨2点", time_string_to_seconds("2004-2-11 2:00:00"), 4, 0, 3)');
    assert('UT_get_time_from_native("2004年2月11日早晨8点", time_string_to_seconds("2004-2-11 8:00:00"), 4, 0, 3)');
    assert('UT_get_time_from_native("2004年2月11日上午10点", time_string_to_seconds("2004-2-11 10:00:00"), 4, 0, 3)');
    assert('UT_get_time_from_native("2004年2月11日下午2点", time_string_to_seconds("2004-2-11 14:00:00"), 4, 0, 3)');
    assert('UT_get_time_from_native("2004年2月11日下午14点", time_string_to_seconds("2004-2-11 14:00:00"), 4, 0, 3)');
    assert('UT_get_time_from_native("2004年2月11日晚上9点", time_string_to_seconds("2004-2-11 21:00:00"), 4, 0, 3)');
    assert('UT_get_time_from_native("2004年2月11日中午12点", time_string_to_seconds("2004-2-11 12:00:00"), 4, 0, 3)');
    
    assert('UT_get_time_from_native("1920年12月31日凌晨0点20分59秒", time_string_to_seconds("1920-12-31 0:20:59"), 4, 0, 3)');
    assert('UT_get_time_from_native("1920年12月31日早晨9点32分09秒",  time_string_to_seconds("1920-12-31 9:32:09"), 4, 0, 3)');
    assert('UT_get_time_from_native("1920年12月31日上午10点", time_string_to_seconds("1920-12-31 10:00:00"), 4, 0, 3)');
    assert('UT_get_time_from_native("1920年12月31日下午6点",  time_string_to_seconds("1920-12-31 18:00:00"), 4, 0, 3)');
    assert('UT_get_time_from_native("1920年12月31日下午1点", time_string_to_seconds("1920-12-31 13:00:00"), 4, 0, 3)');
    assert('UT_get_time_from_native("1920年12月31日晚上11点30分",  time_string_to_seconds("1920-12-31 23:30:00"), 4, 0, 3)');
    assert('UT_get_time_from_native("1920年12月31日中午12点半", time_string_to_seconds("1920-12-31 12:30:00"), 4, 0, 3)');
    
    // assert('UT_get_time_from_native("19390901",      time_string_to_days("19390901"), 3, 0, 1)'); // 不支持。
    
    //////////////////////// 3.不应该识别成时间的字符串 ///////////////////////////////////
    echo "3.不应该识别成时间的字符串</br>";
    
    function UT_valid_time_string($time_string)
    {
        $my = get_time_from_native($time_string);
        if ($my['status'] == "fail")
        {
            return TRUE;
        }
        else 
        {
            echo $my['status'] . "--" . $my['time'] . "--" . $my['time_type'] . "--" . $my['time_limit'] 
                . "--" . $my['time_limit_type'] . " --- ";
            return FALSE;
        }
    }
    assert('UT_valid_time_string("那一年")');
    assert('UT_valid_time_string("月")');
    assert('UT_valid_time_string("日")');
    assert('UT_valid_time_string("0年")');
    assert('UT_valid_time_string("零年")');
    assert('UT_valid_time_string("Ο年")');
    assert('UT_valid_time_string("○年")');
    assert('UT_valid_time_string("0")');
    assert('UT_valid_time_string("零")');
    assert('UT_valid_time_string("Ο")');
    assert('UT_valid_time_string("○")');
    assert('UT_valid_time_string("夏威夷")');
    assert('UT_valid_time_string("上半年")');
    assert('UT_valid_time_string("世纪")');
    assert('UT_valid_time_string("二季度")');
    assert('UT_valid_time_string("五月份")');
    assert('UT_valid_time_string("早晨")');
    assert('UT_valid_time_string("五月份")');
    assert('UT_valid_time_string("年初")');
    assert('UT_valid_time_string("时间")');
    assert('UT_valid_time_string("时钟")');
    assert('UT_valid_time_string("分钟")');
    assert('UT_valid_time_string("秒钟")');
    
    
    //////////////////////// 4.闰年识别 ///////////////////////////////////
    echo "4.闰年识别</br>";
    
    assert('is_leap_year(1980)');
    assert('!is_leap_year(1981)');
    assert('!is_leap_year(1900)');
    assert('is_leap_year(2000)');
    assert('is_leap_year(2016)');
    
    //////////////////////// 5.星期识别 ///////////////////////////////////
    echo "5.星期识别</br>";
    assert('get_weekday(2015, 1, 24) == 6');
    assert('get_weekday(2016, 1, 28) == 4');
    assert('get_weekday(1997, 6, 2) == 1');
    
    //////////////////////// 6.模式识别. 太少！ ///////////////////////////////////
    echo "6.模式识别</br>";
    assert('preg_match("/^[\w\-\.]+@[\w\-\.]+(\.\w+)+$/", "likecat@gmail.com")');
    assert('preg_match("/^[\w\-\.]+@[\w\-\.]+(\.\w+)+$/", "451877089@qq.com")');
    
    //////////////////////// 7.时间顺序数识别. ///////////////////////////////////
    echo "7.时间顺序数识别</br>";
    
    function UT_get_year_order($time_number, $time_type, $check)
    {
        if (float_cmp(get_year_order($time_number, $time_type), $check, 8) == FALSE)
        {
            echo get_year_order($time_number, $time_type) . "</br>";
            return FALSE;
        }
        return TRUE;
    }
    
    assert('UT_get_year_order(-5000, 1, "-2983")');
    assert('UT_get_year_order(-85000, 1, "-82983")');
    assert('UT_get_year_order(-85000000, 1, "-84997983")');
    assert('UT_get_year_order(-18220000000, 1, "-18219997983")');
    assert('UT_get_year_order(-18220000000, 2, "-18220000000")');
    assert('UT_get_year_order(-1822, 2, "-1822")');
    assert('UT_get_year_order(654, 2, "654")');
    assert('UT_get_year_order(654, 3, "-4712.7917808219")');
    assert('UT_get_year_order(1132240, 3, "-1614.904109589")');
    assert('UT_get_year_order(1732240, 3, "30.613698630137")');
    assert('UT_get_year_order(2222654, 3, "1373.2931506849")');
    assert('UT_get_year_order(2451654, 3, "2000.2630136986")');
    assert('UT_get_year_order(2457585, 3, "2016.501369863")');
    assert('UT_get_year_order(3222654, 3, "4111.1452054795")');
    assert('UT_get_year_order(-1822, 4, "1970")');
    assert('UT_get_year_order(654, 4, "1970")');
    assert('UT_get_year_order(1132240, 4, "1970.0356164384")');
    assert('UT_get_year_order(17322400, 4, "1970.5479452055")');
    assert('UT_get_year_order(222265400, 4, "1977.0410958904")');
    assert('UT_get_year_order(245165400, 4, "1977.7671232877")');
    assert('UT_get_year_order(1457554000, 4, "2016.1890410959")');
    assert('UT_get_year_order(322265400000, 4, "12182.180821918")');
    
    // assert('UT_get_year_order("2015-1-2", 2015.002739726)');
    // assert('UT_get_year_order("2015-6-31", 2015.495890411)');
    // assert('UT_get_year_order("2015-11-31", 2015.9150684932)');
    // assert('UT_get_year_order("2015-12-31", 2015.997260274)');
    
    //////////////////////// 8.检索条件生成. 太少！ ///////////////////////////////////
    echo "8.检索条件生成</br>";
    
    function UT_get_search_where_sub_native($ori, $check)
    {
        $search_where = trim(get_search_where_sub_native($ori));
        $search_where = str_replace("  ", " ", $search_where);
        $search_where = str_replace("  ", " ", $search_where);
        if ($search_where !== trim($check))
        {
            echo $search_where . "</br>";
            return FALSE;
        }
        else 
        {
            return TRUE;
        }
    }
    // echo get_search_where_sub_native("蒋介石 or 毛泽东") . "<br />";
    
    $check_string = "( ( a.thing like '%中国%' ) or ( a.thing like '%首都%' ) or ( a.thing like '%财政%' ) )";
    assert('UT_get_search_where_sub_native("中国 首都 财政", $check_string)');
    
    $check_string = "( ( a.thing like '%中国%' ) and ( a.thing like '%首都%' ) and ( a.thing like '%财政%' ) )";
    assert('UT_get_search_where_sub_native("中国 and 首都 and 财政", $check_string)');
    
    $check_string = "( ( a.thing like '%蒋介石%' ) or ( a.thing like '%毛泽东%' ) )";
    assert('UT_get_search_where_sub_native("蒋介石 or 毛泽东", $check_string)');
    
    $check_string = "( ( a.thing like '%唐朝%' ) and ( a.thing like '%诗人%' ) and not ( a.thing like '%李白%' ) )";
    assert('UT_get_search_where_sub_native("唐朝 and 诗人 - 李白", $check_string)');
    
    $check_string = "( ( a.thing like '%唐朝%' ) and ( a.thing like '%诗人%' ) and not ( a.thing like '%李白%' ) )";
    assert('UT_get_search_where_sub_native("唐朝 and 诗人 - 李白", $check_string)');
    
    $check_string = "( ( a.thing like '%唐朝%' ) or ( a.thing like '%诗人%' ) or ( a.thing like '%李白%' ) )";
    assert('UT_get_search_where_sub_native("唐朝 + 诗人 + 李白", $check_string)');
    
    $check_string = "( a.time = 2420069 and a.time_type = 3 )";
    assert('UT_get_search_where_sub_native("1913-10-15", $check_string)');
    
    $check_string = "( a.time = 1381809695 and a.time_type = 4 )";
    assert('UT_get_search_where_sub_native("2013-10-15 12:01:35", $check_string)');
    
    $check_string = "( a.year_order >= 1913.1616438356 and a.year_order <= 1913.4109589041 )";
    assert('UT_get_search_where_sub_native("1913年春天", $check_string)');
    $check_string = "( a.year_order >= 1913.4109589041 and a.year_order <= 1913.6602739726 )";
    assert('UT_get_search_where_sub_native("1913年夏天", $check_string)');
    $check_string = "( a.year_order >= 1913.6630136986 and a.year_order <= 1913.9123287671 )";
    assert('UT_get_search_where_sub_native("1913年秋天", $check_string)');
    $check_string = "( a.year_order >= 1913.9150684932 and a.year_order <= 1914.1643835616 )";
    assert('UT_get_search_where_sub_native("1913年冬天", $check_string)');
    $check_string = "( a.year_order >= 1913 and a.year_order <= 1913.4931506849 )";
    assert('UT_get_search_where_sub_native("1913年上半年", $check_string)');
    $check_string = "( a.year_order >= 1913.498630137 and a.year_order <= 1913.9945205479 )";
    assert('UT_get_search_where_sub_native("1913年下半年", $check_string)');
    $check_string = "( a.year_order >= -476.16438356164 and a.year_order <= -476.41369863014 )";
    assert('UT_get_search_where_sub_native("公元前476年春天", $check_string)');
    $check_string = "( a.year_order >= -476.41369863014 and a.year_order <= -476.66301369863 )";
    assert('UT_get_search_where_sub_native("公元前476年夏天", $check_string)');
    $check_string = "( a.year_order >= -476.66575342466 and a.year_order <= -476.91506849315 )";
    assert('UT_get_search_where_sub_native("公元前476年秋天", $check_string)');
    $check_string = "( a.year_order >= -476.91780821918 and a.year_order <= -475.16438356164 )";
    assert('UT_get_search_where_sub_native("公元前476年冬天", $check_string)');
    $check_string = "( a.year_order >= -477.99726027397 and a.year_order <= -476.49589041096 )";
    assert('UT_get_search_where_sub_native("公元前476年上半年", $check_string)');
    $check_string = "( a.year_order >= -476.50136986301 and a.year_order <= -476.99726027397 )";
    assert('UT_get_search_where_sub_native("公元前476年下半年", $check_string)');
    $check_string = "( a.year_order >= 1913.7452054795 and a.year_order <= 1913.8301369863 )";
    assert('UT_get_search_where_sub_native("1913-10", $check_string)');
    $check_string = "( a.year_order >= 1913 and a.year_order < 1914 )";
    assert('UT_get_search_where_sub_native("1913", $check_string)');
    $check_string = "( a.year_order >= -221 and a.year_order < -220 )";
    assert('UT_get_search_where_sub_native("公元前221", $check_string)');
    $check_string = "( a.year_order >= -1720 and a.year_order < -1719 )";
    assert('UT_get_search_where_sub_native("-1720", $check_string)');
    $check_string = "( a.year_order >= -2600000 and a.year_order < -2599999 )";
    assert('UT_get_search_where_sub_native("260万年前", $check_string)');
    $check_string = "( a.year_order >= -4556000000 and a.year_order < -4555999999 )";
    assert('UT_get_search_where_sub_native("45.56亿年前", $check_string)');

    //////////////////////// 9.中文数字互转 ///////////////////////////////////
    echo "9.中文数字互转</br>";
    
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
    assert('UT_chinese_to_number("一九八九", 1989)');
    assert('UT_chinese_to_number("一二三四五六七八九", 123456789)');
    assert('UT_chinese_to_number("１２３４５６７８９", 123456789)');
    assert('UT_chinese_to_number("一二三四五六七八九零Ο", 12345678900)');
    assert('UT_chinese_to_number("十九", 19)');
    assert('UT_chinese_to_number("二十", 20)');
    assert('UT_chinese_to_number("二十一", 21)');
    assert('UT_chinese_to_number("一百", 100)');
    assert('UT_chinese_to_number("192Ο", 1920)');
    
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
    // assert('UT_number_to_chinese(1989, "一九八九")');
    // assert('UT_number_to_chinese(123456789, "一二三四五六七八九")');
    // assert('UT_number_to_chinese(12345678900, "一二三四五六七八九ΟΟ")');
    assert('UT_number_to_chinese(1, "一")');
    assert('UT_number_to_chinese(10, "十")');
    assert('UT_number_to_chinese(19, "十九")');
    assert('UT_number_to_chinese(20, "二十")');
    assert('UT_number_to_chinese(21, "二十一")');
    // assert('UT_number_to_chinese(101, "一百零一")');
    
    //////////////////////// 10.显示在 item_list 中的时间格式 ///////////////////////////////////
    echo "10.显示在 item_list 中的时间格式</br>";
    
    function UT_get_time_string($time_number, $time_type, $check)
    {
        if (get_time_string($time_number, $time_type) != $check)
        {
            echo get_time_string($time_number, $time_type) . " - " . $check . "</br>";
            return FALSE;
        }
        return TRUE;
    }
    assert('UT_get_time_string(-5000, 1, "距今5000年前")');
    assert('UT_get_time_string(-85000, 1, "距今8.5万年前")');
    assert('UT_get_time_string(-85000000, 1, "距今8500万年前")');
    assert('UT_get_time_string(-18220000000, 1, "距今182.2亿年前")');
    assert('UT_get_time_string(-18220000000, 2, "公元前18220000000年")');
    assert('UT_get_time_string(-1822, 2, "公元前1822年")');
    assert('UT_get_time_string(654, 2, "654年")');
    assert('UT_get_time_string(654, 3, "公元前4712年-10月-16日")');
    assert('UT_get_time_string(1132240, 3, "公元前1614年-11月-27日")');
    assert('UT_get_time_string(1732240, 3, "30-8-13")');
    assert('UT_get_time_string(2222654, 3, "1373-4-18")');
    assert('UT_get_time_string(2451654, 3, "2000-4-6")');
    assert('UT_get_time_string(2457554, 3, "2016-6-1")');
    assert('UT_get_time_string(3222654, 3, "4111-2-23")');
    assert('UT_get_time_string(-1822, 4, "1970-1-1 07:29:38")');
    assert('UT_get_time_string(654, 4, "1970-1-1 08:10:54")');
    assert('UT_get_time_string(1132240, 4, "1970-1-14 10:30:40")');
    assert('UT_get_time_string(17322400, 4, "1970-7-20 19:46:40")');
    assert('UT_get_time_string(222265400, 4, "1977-1-16 20:23:20")');
    assert('UT_get_time_string(245165400, 4, "1977-10-8 21:30:00")');
    assert('UT_get_time_string(1457554000, 4, "2016-3-10 04:06:40")');
    assert('UT_get_time_string(322265400000, 4, "12182-3-8 22:40:00")');
    assert('UT_get_time_string(1436319000, 4, "2015-7-8 09:30:00")');
    
    
    //////////////////////// 11.死伤人数 ///////////////////////////////////
    echo "11.死伤、失踪人数；字数</br>";
    
    function UT_print_person_count($death_person_count, $hurt_person_count, 
        $missing_person_count, $word_count, $check)
    {
        if (print_person_count($death_person_count, $hurt_person_count, $missing_person_count, $word_count)
            != $check)
        {
            echo print_person_count($death_person_count, $hurt_person_count, $missing_person_count, $word_count)
                . " --- " . $check . "</br>";
            return FALSE;
        }
        return TRUE;
    }
    assert('UT_print_person_count(1, 0, 0, 0, "死-1")');
    assert('UT_print_person_count(1, 2, 3, 0, "死-1;伤-2;失踪-3")');
    assert('UT_print_person_count(0, 2, 3, 0, "伤-2;失踪-3")');
    assert('UT_print_person_count(1, 0, 3, 0, "死-1;失踪-3")');
    assert('UT_print_person_count(1, 2, 0, 0, "死-1;伤-2")');
    assert('UT_print_person_count(1, 2, 3, 0, "死-1;伤-2;失踪-3")');
    assert('UT_print_person_count(0, 0, 3, 0, "失踪-3")');
    assert('UT_print_person_count(0, 0, 0, 4, "字数-4")');
    
    
    
    //////////////////////// 12.Main page tab ///////////////////////////////////
    echo "12.检查主页面各tab 页的顺序</br>";
    
    function UT_get_tag_id_from_index($tag_index, $check)
    {
        $tag_type = get_tag_id_from_index($tag_index);
        if ($tag_type != $check)
        {
            echo " -- " . $tag_type . " -- " . $check . " --</br>";
            return FALSE;
        }
        return TRUE;
    }
    
    assert('UT_get_tag_id_from_index(1, -1)');
    assert('UT_get_tag_id_from_index(2, -4)');
    assert('UT_get_tag_id_from_index(3, 4)');
    assert('UT_get_tag_id_from_index(4, 15)');
    assert('UT_get_tag_id_from_index(5, 16)');
    assert('UT_get_tag_id_from_index(6, 7)');
    assert('UT_get_tag_id_from_index(7, 8)');
    assert('UT_get_tag_id_from_index(8, 10)');
    assert('UT_get_tag_id_from_index(9, 3)');
    assert('UT_get_tag_id_from_index(10, 13)');
    assert('UT_get_tag_id_from_index(11, 6)');
    assert('UT_get_tag_id_from_index(12, 12)');
    assert('UT_get_tag_id_from_index(13, 12)');
    assert('UT_get_tag_id_from_index(14, -100)');
    assert('UT_get_tag_id_from_index(15, -100)');
    assert('UT_get_tag_id_from_index(16, -100)');
    assert('UT_get_tag_id_from_index(17, -100)');


    //////////////////////// 13.标签类型数组 ///////////////////////////////////
    echo "13.标签类型数组</br>";
	function UT_tag_types_to_string($tag_types, $check)
	{
		$result = tag_types_to_string($tag_types);
		if($result != $check)
		{
			echo " -- " . $result . "</br> -- " . $check . " --</br>";
			return FALSE;
		}
		return TRUE;
	}
    function UT_update_tag_type_string($old_tag_string, $tag_types, $check)
    {
        $result = update_tag_type_string($old_tag_string, $tag_types);
        if ($result == "-1") $result = $old_tag_string;
        
        if($result != $check)
        {
            echo " -- " . $result . "</br> -- " . $check . " --</br>";
            return FALSE;
        }
        return TRUE;
    }
    
    $tag_types = array(3, 10, 9, 7);
	assert('UT_tag_types_to_string($tag_types, "-a3-a10-a9-a7")');
    $tag_types = array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20);
    assert('UT_tag_types_to_string($tag_types, "-a1-a2-a3-a4-a5-a6-a7-a8-a9-a10-a11-a12-a13-a14-a15-a16-a17-a18-a19-a20")');
    
    $old_tag_string = "";
    $tag_types = array(3, 10, 9, 7);
    assert('UT_update_tag_type_string($old_tag_string, $tag_types, "-a3-a10-a9-a7")');
    $old_tag_string = "-a3-a10-a9-a7";
    $tag_types = array(3, 10, 9, 7);
    assert('UT_update_tag_type_string($old_tag_string, $tag_types, "-a3-a10-a9-a7")');
    $old_tag_string = "--a9-a7-a3-a10";
    $tag_types = array(3, 10, 9, 7);
    assert('UT_update_tag_type_string($old_tag_string, $tag_types, "--a9-a7-a3-a10")');
    $old_tag_string = "-a7-a3-a10";
    $tag_types = array(3, 10, 9, 7);
    assert('UT_update_tag_type_string($old_tag_string, $tag_types, "-a7-a3-a10-a9")');
    $old_tag_string = "-a3-a7-a3-a10";
    $tag_types = array(3, 10, 9, 7, 8, 7, 9, 7 , 8, 7, 7, 2, 3, 5, 5, 5);
    assert('UT_update_tag_type_string($old_tag_string, $tag_types, "-a3-a7-a3-a10-a9-a8-a2-a5")');
    $old_tag_string = "-a3-a7-a3-a10";
    $tag_types = array(3, 7);
    assert('UT_update_tag_type_string($old_tag_string, $tag_types, "-a3-a7-a3-a10")');
	
    
    //////////////////////// 14.VIP tag ///////////////////////////////////
    echo "14.VIP 标签</br>";
    
    // 参数：$tag_index 为 tab id，即下标。
    function UT_vip_tag_search_to_db($tag_type, $index_big, $index_small, $check)
    {
        $search_sub = "Param error.";
        $my_vip_tag = vip_tag_struct_init($tag_type);
        if ($my_vip_tag != NULL) {
            $search_sub = get_vip_tag_substring($my_vip_tag, $index_big, $index_small);
            $vip_tag_name = get_vip_tag_name($my_vip_tag, $index_big, $index_small);
        }
        
        $search_sub = trim($search_sub);
        $search_sub = str_replace("  ", " ", $search_sub);
        $search_sub = str_replace("  ", " ", $search_sub);
        
        if (trim($check) !== $search_sub) {
            echo " -- " . $tag_type . " -- " . $vip_tag_name . " --</br>";
            echo $search_sub . "</br>";
            echo trim($check) . "</br>";
            return FALSE;
        } else {
            return TRUE;
        }
    }
    
    // 检查时间格式
    function UT_vip_tag_time_format($time_field, $error_message)
    {
        if ($my_time != 0) {
            $time_array = get_time_from_native($my_time); 
            if ($time_array['status'] != "ok") {
                return FALSE;
            }
        }
        return TRUE;
    }

    // 检查每个 vip tag的格式
    function UT_vip_tag_format_single($vip_tag_group, $big_id, $small_id)
    {
        $my_vip_tag = $vip_tag_group->get_vip_tag($big_id, $small_id);
        $vip_tag_name = $vip_tag_group->get_tag_name($big_id, $small_id);
        $show_flag = $vip_tag_group->get_tag_show_flag($big_id, $small_id);
        $search_flag = $vip_tag_group->get_tag_search_flag($big_id, $small_id);
        
        // 1. 检查是否有空串
        for ($ii = 0; $ii < count($my_vip_tag); $ii++) {
            if (trim($my_vip_tag[$ii]) == "") {
                echo " -- " . $big_id . " -- " . $small_id . " has a NULL field. --</br>" . $vip_tag_name;
                return FALSE;
            }
        }
        // 2. show flag
        if (($show_flag != "super") && ($show_flag != "normal") && ($show_flag != "hide")) {
            echo " -- " . $big_id . " -- " . $small_id . " show flag is error1. --</br>" . $vip_tag_name;
            return FALSE;
        }
        // 3. search flag
        if (($search_flag != "sigle-key") && ($search_flag != "multe-key") 
            && ($search_flag != "key-time") && ($search_flag != "key-time3")
            && ($search_flag != "tag-time")) {
            echo " -- " . $big_id . " -- " . $small_id . " search flag is error. --</br>" . $vip_tag_name;
            return FALSE;
        }
        // 4. 单个字段
        if (count($my_vip_tag) == 1) {
            if (($show_flag != "normal") || ($search_flag != "sigle-key")) {
                echo " -- " . $big_id . " -- " . $small_id . " show flag is error2. --</br>" . $vip_tag_name;
                return FALSE;
            }
        }
        // 5. 2个字段
        if (count($my_vip_tag) == 2) {
            if ((($show_flag != "super") && ($show_flag != "hide")) || ($search_flag != "sigle-key"))  {
                echo " -- " . $big_id . " -- " . $small_id . " show flag is error3. --</br>" . $vip_tag_name;
                return FALSE;
            }
        }
        // 6. 2个时间字段
        if ($search_flag == "key-time") {
            if (UT_vip_tag_time_format($vip_tag_group->get_key_time_begin_year($big_id, $small_id)) == FALSE) {
                echo " -- " . $big_id . " -- " . $small_id . " time field is error1. --</br>" . $vip_tag_name;
                return FALSE;
            }
            if (UT_vip_tag_time_format($vip_tag_group->get_key_time_end_year($big_id, $small_id)) == FALSE) {
                echo " -- " . $big_id . " -- " . $small_id . " time field is error2. --</br>" . $vip_tag_name;
                return FALSE;
            }
        }
        
        if ($search_flag == "tag-time") {
            if (UT_vip_tag_time_format($vip_tag_group->get_tag_time_begin_year($big_id, $small_id)) == FALSE) {
                echo " -- " . $big_id . " -- " . $small_id . " time field is error3. --</br>" . $vip_tag_name;
                return FALSE;
            }
            if (UT_vip_tag_time_format($vip_tag_group->get_tag_time_end_year($big_id, $small_id)) == FALSE) {
                echo " -- " . $big_id . " -- " . $small_id . " time field is error4. --</br>" . $vip_tag_name;
                return FALSE;
            }
        }
        // 7. 3个时间字段
        if ($search_flag == "key-time3") {
            if (UT_vip_tag_time_format($vip_tag_group->get_key_time_begin_year($big_id, $small_id)) == FALSE) {
                echo " -- " . $big_id . " -- " . $small_id . " time field is error5. --</br>" . $vip_tag_name;
                return FALSE;
            }
            if (UT_vip_tag_time_format($vip_tag_group->get_key_time_big_day($big_id, $small_id)) == FALSE) {
                echo " -- " . $big_id . " -- " . $small_id . " time field is error6. --</br>" . $vip_tag_name;
                return FALSE;
            }
            if (UT_vip_tag_time_format($vip_tag_group->get_key_time_end_year($big_id, $small_id)) == FALSE) {
                echo " -- " . $big_id . " -- " . $small_id . " time field is error7. --</br>" . $vip_tag_name;
                return FALSE;
            }
        }
        return TRUE;
    }

    // 检查数组中的重复。
    function find_repeat_in_array($array)
    {
        // 获取去掉重复数据的数组 
        $unique_arr = array_unique($array); 
        // 获取重复数据的数组 
        $repeat_arr = array_diff_assoc($array, $unique_arr); 
        return $repeat_arr; 
    }
    // 检查同类型 vip tag是否有重复。
    function UT_vip_tag_find_repeat($vip_tag_names)
    {
        $repeat_arr = find_repeat_in_array($vip_tag_names);
        if (count($repeat_arr) > 0) {
            echo " -- " . " find repeat vip tag. --</br>";
            var_dump($repeat_arr);
            return FALSE;
        }
        return TRUE;
    }
    
    // 测试开始
    for ($mm = tag_list_min(); $mm <= tag_list_max(); $mm++)
    {
        unset($vip_tag_name_array);
        $vip_tag_name_array = array();
        
        if ((is_vip_tag_tab($mm) == 1) && (is_show_input_tag($mm) == 1))
        {
            $tag_type = get_tag_id_from_index($mm);
            // echo "2-" . $tag_type . "-";
            $vip_tag_group = vip_tag_struct_init($tag_type);
            
            echo " -- tag_type: " . $mm . " --</br>";
            
            for ($ii = $vip_tag_group->get_big_begin(); $ii <= $vip_tag_group->get_big_end() - 1; $ii++)
            {
                for ($jj = $vip_tag_group->get_small_begin($ii); $jj <= $vip_tag_group->get_small_end($ii); $jj++)
                {
                    assert('UT_vip_tag_format_single($vip_tag_group, $ii, $jj)');
                    
                    array_push($vip_tag_name_array, $vip_tag_group->get_tag_name($ii, $jj));
                    /*
                    $search_sub = get_vip_tag_substring($my_vip_tag, $ii, $jj, $tag_type);
                    if ($search_sub != "")
                    {
                        echo "\$check = \" $search_sub \";" . "</br>";
                        echo "assert('UT_vip_tag_search_to_db($mm, $ii, $jj, \$check)');</br>";
                    }
                    */
                }
            }
            // 检查同类型 vip tag是否有重复。
            assert('UT_vip_tag_find_repeat($vip_tag_name_array)');
        }
    }

    echo "</br>";
    
    echo "<nobr style='color:red; '>Error case count: " . $error_case_count . "!</nobr>";
    
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
