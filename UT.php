<head><meta http-equiv="content-type" content="text/html;charset=utf-8" />
<title>UT</title></head><body>
<?php
    require_once 'init.php';
    is_user(1);
	require_once "data.php";
    
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
    
    function UT_get_time_from_native($time_string, $time, $time_type, 
                                $time_limit, $time_limit_type)
    {
        $my = get_time_from_native($time_string);
        // print_r($my);
        // echo "<br />";
        return (($time == $my['time']) && ($time_type == $my['time_type']) 
            && ($time_limit == $my['time_limit']) && ($time_limit_type == $my['time_limit_type']));
    }
    
    function UT_splite_string($token, $time, $thing)
    {
        $my_array = splite_string($token);
        return (($my_array['time'] == $time) && ($my_array['thing'] == $thing));
    }
    
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
    
    assert('days_to_time_string(time_string_to_days("-1975-10-3")) == "10/3/-1975"');
    assert('days_to_time_string(time_string_to_days("2015-10-3")) == "10/3/2015"');
    
    assert('UT_get_time_from_native("31000年前", -31000, 1, 0, 1)');
    assert('UT_get_time_from_native("3.5亿年前", -350000000, 1, 0, 1)');
    assert('UT_get_time_from_native("1876年", 1876, 2, 0, 1)');
    assert('UT_get_time_from_native("1955年7月1日", time_string_to_days("1955-7-1"), 3, 0, 1)');
    assert('UT_get_time_from_native("1955-7-1", time_string_to_days("1955-7-1"), 3, 0, 1)');
    assert('UT_get_time_from_native("1955/7/1", time_string_to_days("1955-7-1"), 3, 0, 1)');
    assert('UT_get_time_from_native("7/1/1986", time_string_to_days("1986-7-1"), 3, 0, 1)');
    assert('UT_get_time_from_native("1955年7月", time_string_to_days("1955-7-15"), 3, 15, 2)');
    
    assert('UT_get_time_from_native("公元前1955年7月", time_string_to_days("-1955-7-15"), 3, 15, 2)');
    assert('UT_get_time_from_native("公元前1955年7月15日", time_string_to_days("-1955-7-15"), 3, 0, 1)');
    
    assert('UT_get_time_from_native("前1955年7月", time_string_to_days("-1955-7-15"), 3, 15, 2)');
    assert('UT_get_time_from_native("前1955年7月15日", time_string_to_days("-1955-7-15"), 3, 0, 1)');
    assert('UT_get_time_from_native("1955年7月下旬", time_string_to_days("1955-7-25"), 3, 5, 2)');
    assert('UT_get_time_from_native("1955年12月上旬", time_string_to_days("1955-12-5"), 3, 5, 2)');
    assert('UT_get_time_from_native("1955年1月中旬", time_string_to_days("1955-1-15"), 3, 5, 2)');
    assert('UT_get_time_from_native("1750年上半年", time_string_to_days("1750-3-31"), 3, 90, 2)');
    assert('UT_get_time_from_native("234年下半年", time_string_to_days("234-9-30"), 3, 90, 2)');
    assert('UT_get_time_from_native("1234年第一季度", time_string_to_days("1234-2-15"), 3, 45, 2)');
    
    assert('UT_get_time_from_native("前386年", -386, 2, 0, 1)');
    assert('UT_get_time_from_native("前2100", -2100, 2, 0, 1)');
    assert('UT_get_time_from_native("17年", 17, 2, 0, 1)');
    assert('UT_get_time_from_native("1913", 1913, 2, 0, 1)');
    assert('UT_get_time_from_native("1950年12月19日", time_string_to_days("1950-12-19"), 3, 0, 1)');
    
    assert('is_leap_year(1980)');
    assert('!is_leap_year(1981)');
    assert('!is_leap_year(1900)');
    assert('is_leap_year(2000)');
    assert('is_leap_year(2016)');
    
    assert('get_weekday(2015, 1, 24) == 6');
    
    assert('preg_match("/^[\w\-\.]+@[\w\-\.]+(\.\w+)+$/", "likecat@gmail.com")');
    assert('preg_match("/^[\w\-\.]+@[\w\-\.]+(\.\w+)+$/", "451877089@qq.com")');
    
    echo get_year_order(get_time_number("2015-1-2", 3), 3) . "<br/>";
    echo get_year_order(get_time_number("2015-6-31", 3), 3) . "<br/>";
    echo get_year_order(get_time_number("2015-11-31", 3), 3) . "<br/>";
    echo get_year_order(get_time_number("2015-12-31", 3), 3) . "<br/>";
    
    assert("is_infinite(log(0))");
    
    print_r(explode(" ", "中国 首都 财政"));
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
