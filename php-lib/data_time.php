<?php
// created by duangan, 2015-1-19 -->
// support time deal function.    -->

require_once 'data_number.php';

// 每月多少天.
$month_days = array(31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31);

// 判断是否为公元前
function is_bc($year_string)
{
    if (stristr($year_string, "公元前") || stristr($year_string, "前"))
    {
        return 1;
    }
    else
    {
        return 0;
    }
}

// 是否是闰年
function is_leap_year($year)
{
    return (($year % 4 == 0) && ($year % 100 != 0) || ($year % 400 == 0));
}

// 当前日期离公元1-1-1的天数(公元前的日子则返回负数).
function get_abs_days($year, $month, $day)
{
    $days = ($year - 1) * 365 + get_leaps($year);
    $days += get_year_days($year, $month, $day);
    if ($year < 0)
    {
        $days += 365;   // 没有公元0年, 所以要少算一年.
    }
    
    return $days;
}

// 返回从公元1-1-1 到当前年, 一共有多少个闰年(不包括本年).
function get_leaps($year)
{
    return $year / 4 - $year / 100 + $year / 400;
}

// 离当年1月1日的天数
function get_year_days($year, $month, $day)
{
    global $month_days;
    $my_days = 0;
    for($ii = 0; $ii < $month - 1; $ii++)
    {
        $my_days += $month_days[$ii];
    }
    if(is_leap_year($year) && ($month > 2))
    {
        $my_days++;
    }
    $my_days += $day - 1;
    return $my_days;
}

// 算当前时间星期几.
function get_weekday($year, $month, $day)
{
    // 1601-1-1 星期一.
    $interval = get_abs_days($year, $month, $day) - get_abs_days(1601, 1, 1);
    return ($interval % 7) + 1;
}

// 判断是否为中文"年月日".
function is_chinese_day($day_string)
{
    if (stristr($day_string, "月") && stristr($day_string, "日") && stristr($day_string, "年"))
    {
        return 1;
    }
    else
    {
        return 0;
    }
}

// 去掉字符串中的"年月日"汉字.
function trim_chinese_day($day_string)
{
    $temp1 = str_replace("年", "-", $day_string);
    $temp2 = str_replace("月", "-", $temp1);
    $temp3 = str_replace("日", "", $temp2);
    
    return $temp3;
}


// 将时间字符串变成数字（暂时只支持年份的变化）
function trim_time_string($time_string)
{
    $time_string = str_replace("公元前", "-", $time_string);
    $time_string = str_replace("公元", "", $time_string);
    $time_string = str_replace("前", "-", $time_string);

    return $time_string;
}

// 通过时间类型和时间字符串，获取时间数字.
// 输入:用户在 update 页面输入的时间字符串(格式做了严格限制,所以很标准)
// 输出:保存到 thing-time 表的 time 字段的数字
function get_time_number($time_string, $time_type)
{
    $my_time_number = 0;
    
    // 年月日（单位为日）
    switch ($time_type)
    {
        case 3:
            $my_time_number = time_string_to_days($time_string);
            break;
        case 4:
            $my_time_number = seconds_to_time_string($time_string);
            break;
        case 1:
        case 2:
            if(is_numeric($time_string))
            {
                $my_time_number = $time_string;
            }
            else
            {
                $my_time_number = intval($time_string);
            }
            break;
    }
    
    return $my_time_number;
}

// 根据 time 字段的时间数字,生成 year_order.
function get_year_order($time_number, $time_type)
{
    if(($time_type == 3) || ($time_type == 4))
    {
        $my_year_order = 0.0;
        $my_string = get_time_string_lite($time_number, $time_type);
        $my_array = explode("-", $my_string);
        
        if (count($my_array) == 3)
        {
            $my_year_order += $my_array[0];   // year
            $my_year_days = is_bc($my_array[0]) ? 366 : 365;
            $my_year_order += (float)get_year_days($my_array[0], $my_array[1], $my_array[2]) 
                        / $my_year_days;
        }
        // 兼容公元前的情况。
        else 
        {
            $my_year_order -= $my_array[1];   // year
            $my_year_days = is_bc($my_array[1]) ? 366 : 365;
            $my_year_order -= (float)get_year_days($my_array[1], $my_array[2], $my_array[3]) 
                        / $my_year_days;
        }
        
        return $my_year_order;
    }
    else if($time_type == 2)
    {
        return $time_number;
    }
    else 
    {
        return $time_number + 2015; // this year is 2015.
    }
}

// 根据时间（数字）和类型，获得时间字符串的简化版
// 输入: thing-time 表的 time 字段的数字
// 输出: 显示在 update 页面时间字段的字符串(格式很标准).
function get_time_string_lite($time_number, $time_type)
{
    $my_time_string = "";

    if(($time_type == 1) || ($time_type == 2))
    {
        $my_time_string = $time_number;
    }
    // “年月日”格式
    else if($time_type == 3)
    {
        $string_array = explode("/", days_to_time_string($time_number));
        $my_time_string = "$string_array[2]-$string_array[0]-$string_array[1]";
    }
    // “年月日 时分秒”格式
    else
    {
        $my_time_string = seconds_to_time_string($time_number);
    }

    return $my_time_string;
}

// 将大于1亿的数字转换成1亿多少的字符串，将大于1万的数字转化为1万多少。
function get_chiness_unit($number)
{
    if ($number > 100000000)
    {
        return (float)($number / 100000000) . "亿";
    }
    else if($number > 10000)
    {
        return (float)($number / 10000) . "万";
    }
    else 
    {
        return $number;
    }
}

// 根据时间（数字）和类型，获得时间字符串(目的是显示在页面上)
// 输入: thing-time 表的 time 字段的数字
// 输出: 显示在 item_list 界面上的时间字符串, 目的是方便使用者识别, 所以加入汉字. 格式化程度很低.
function get_time_string($time_number, $time_type)
{
     $my_time_string = "";
    
     if($time_type == 1)
     {
        $my_year = abs($time_number);
        $my_time_string = "距今" . get_chiness_unit($my_year) . "年前";
     }
     else if($time_type == 2)
     {
        if($time_number < 0)
        {
            $my_time_string = "公元前" . abs($time_number) . "年";
        }
        else
        {
            if ($time_number < 1000)
            {
                $my_time_string = "公元" . $time_number . "年";
            }
            else 
            {
                $my_time_string = $time_number . "年";
            }
        }
     }
     // “年月日”格式
     else if($time_type == 3)
     {
        $string_array = explode("/", days_to_time_string($time_number));
          
        if($string_array[2] > 1000)
        {
            $my_time_string = "$string_array[2]-$string_array[0]-$string_array[1]";
        }
        else if(($string_array[2] < 1000) && ($string_array[2] > 0))
        {
            $my_time_string = "公元$string_array[2]年-$string_array[0]月-$string_array[1]日";
        }
        else if($string_array[2] < 0)
        {
            $my_time_string = "公元前" . abs($string_array[2]) . "年-$string_array[0]月-$string_array[1]日";
        }
     }
     // “年月日 时分秒”格式
     else
     {
        $my_time_string = seconds_to_time_string($time_number);
     }
    
     return $my_time_string;
}

// 根据时间（数字）和类型，获得时间上下限字符串(目的是显示在页面上)
function get_time_limit_string($time_limit, $time_limit_type)
{
    $my_time_limit = "";
    
    if (empty($time_limit) || ($time_limit == 0))
    {
        return $my_time_limit;
    }
    
    $my_time_limit = "±";
    switch ($time_limit_type)
    {
        case 1:
            $my_time_limit .= get_chiness_unit($time_limit) . "年";
            break;
        case 2:
            $my_time_limit .= $time_limit . "日";
            break;
        case 3:
            $my_time_limit .= $time_limit . "秒";
            break;
        default:
            $my_time_limit .= "";
    }
    return $my_time_limit;
}

// 用最野蛮的方法获取月份
function get_month($date_string)
{
    if(stristr($date_string, "十二月") || stristr($date_string, "12月"))return 12;
    if(stristr($date_string, "十一月") || stristr($date_string, "11月"))return 11;
    if(stristr($date_string, "十月") || stristr($date_string, "10月"))return 10;
    if(stristr($date_string, "九月") || stristr($date_string, "9月"))return 9;
    if(stristr($date_string, "八月") || stristr($date_string, "8月"))return 8;
    if(stristr($date_string, "七月") || stristr($date_string, "7月"))return 7;
    if(stristr($date_string, "六月") || stristr($date_string, "6月"))return 6;
    if(stristr($date_string, "五月") || stristr($date_string, "5月"))return 5;
    if(stristr($date_string, "四月") || stristr($date_string, "4月"))return 4;
    if(stristr($date_string, "三月") || stristr($date_string, "3月"))return 3;
    if(stristr($date_string, "二月") || stristr($date_string, "2月"))return 2;
    if(stristr($date_string, "一月") || stristr($date_string, "1月"))return 1;
    
    return 0;
}

// 从批量数字字符串中获取时间子串
function get_time_from_native($native_string)
{
    // time_type: 1:距今年; 2:公元年; 3:年月日; 4:年月日 时分秒.
    // time_limit_type: 1:年; 2:日; 3:秒.
    $time_array = array("status"=>"init", "time"=>0, "time_type"=>2, 
                    "time_limit"=>0, "time_limit_type"=>1, "is_bc"=>0);
    
    // step 1: 搞定"距今 ... 年前"这种时间表达.
    if (stristr($native_string, "年前"))
    {
        if(stristr($native_string, "亿"))
        {
            $time_array['time'] = 0 - 100000000 * floatval($native_string);
        }
        else if(stristr($native_string, "万"))
        {
            $time_array['time'] = 0 - 10000 * floatval($native_string);
        }
        else 
        {
            $time_array['time'] = 0 - floatval($native_string);
        }
        $time_array['time_type'] = 1;    /// 距今年
        $time_array['time_limit'] = 0;
        $time_array['time_limit_type'] = 1;
        $time_array['status'] = "ok";
        
        return $time_array;
    }
    
    // step 2: 搞定"公元"和"公元前"
    // 注意,这里修改了$native_string.
    if (is_bc($native_string))
    {
        $time_array['is_bc'] = 1;
    }
    $native_string = trim_time_string($native_string);
    
    // step 3: 搞定单个整数的情况. 单个整数指年份。
    if(is_numeric($native_string) && !strstr($native_string, "."))
    {
        $time_array['time'] = (int)$native_string;
        $time_array['time_type'] = 2;    /// 公元年
        $time_array['time_limit'] = 0;
        $time_array['time_limit_type'] = 1;
        $time_array['status'] = "ok";
        
        return $time_array;
    }
    
    // step 4: 搞定"年-月-日", 以及"Y-M-D". 分割线也支持"/"和".".
    $my_string = "";
    $my_days = 0;
    $day_is_empty = 0;
    if (is_chinese_day($native_string))
    {
        $my_string = trim_chinese_day($native_string);
    }
    else 
    {
        $my_string = $native_string;
    }
    $my_time_array = get_time_array($my_string);
    
    // 处理公元前的年份
    if(empty($my_time_array[0]) && count($my_time_array) == 4)
    {
        $my_year = 0 - (int)$my_time_array[1];
        $my_days = juliantojd($my_time_array[2], $my_time_array[3], $my_year);
    }
    else if(count($my_time_array) == 3)
    {
        $my_days = juliantojd($my_time_array[1], $my_time_array[2], $my_time_array[0]);
    }
    // 只有年月，没有日的情况.
    else if (count($my_time_array) == 2 && is_numeric($my_time_array[0]) && is_numeric($my_time_array[1]))
    {
        $my_days = juliantojd($my_time_array[1], 15, $my_time_array[0]);
        $day_is_empty = 1;
    }
    
    if($my_days != 0)
    {
        $time_array['time'] = $my_days;
        $time_array['time_type'] = 3;    /// 年月日
        if ($day_is_empty == 0)
        {
            $time_array['time_limit'] = 0;
            $time_array['time_limit_type'] = 1;
        }
        else
        {
            $time_array['time_limit'] = 15;
            $time_array['time_limit_type'] = 2;
        }
        
        $time_array['status'] = "ok";
        
        return $time_array;
    }
    
    // step 5: 搞定只有年的情况.
    $my_year = 0;
    $my_month = 0;
    $my_day = 0;
    if (stristr($native_string, "年"))
    {
        $my_year = intval(trim_time_string($native_string));
    }
    
    // step 6: 搞定有年-月的情况
    if (stristr($native_string, "月"))
    {
        $my_month = get_month($native_string);
        if (stristr($native_string, "上旬"))
        {
            $my_day = 5;
            $time_array['time_limit'] = 5;
        }
        else if (stristr($native_string, "中旬"))
        {
            $my_day = 15;
            $time_array['time_limit'] = 5;
        }
        else if (stristr($native_string, "下旬"))
        {
            $my_day = 25;
            $time_array['time_limit'] = 5;
        }
        else
        {
            $my_day = 15;
            $time_array['time_limit'] = 15;
        }
        
        $time_array['time'] = juliantojd($my_month, $my_day, $my_year);
        $time_array['time_type'] = 3;    /// 年月日
        $time_array['time_limit_type'] = 2;  // 日
        $time_array['status'] = "ok";
        
        return $time_array;
    }
    
    // step 7: 搞定上半年/下半年
    if (stristr($native_string, "半年"))
    {
        if (stristr($native_string, "上半年"))
        {
            $my_month = 3;
            $my_day = 31;
        }
        else if (stristr($native_string, "下半年"))
        {
            $my_month = 9;
            $my_day = 30;
            $time_array['time_limit'] = 90;
        }
        $time_array['time'] = juliantojd($my_month, $my_day, $my_year);
        $time_array['time_type'] = 3;    /// 年月日
        $time_array['time_limit'] = 90;
        $time_array['time_limit_type'] = 2;  // 日
        $time_array['status'] = "ok";
        
        return $time_array;
    }
    
    // step 8: 搞定1-4季度
    if (stristr($native_string, "季度"))
    {
        if (stristr($native_string, "一季度") || (stristr($native_string, "1季度")))
        {
            $my_month = 2;
        }
        else if (stristr($native_string, "二季度") || (stristr($native_string, "2季度")))
        {
            $my_month = 5;
        }
        else if (stristr($native_string, "三季度") || (stristr($native_string, "3季度")))
        {
            $my_month = 8;
        }
        else if (stristr($native_string, "四季度") || (stristr($native_string, "4季度")))
        {
            $my_month = 11;
        }
        $my_day = 15;
        $time_array['time'] = juliantojd($my_month, $my_day, $my_year);
        $time_array['time_type'] = 3;    /// 年月日
        $time_array['time_limit'] = 45;  // 日
        $time_array['time_limit_type'] = 2;  // 日
        $time_array['status'] = "ok";
        
        return $time_array;
    }
    
    // step 9: 搞定春夏秋冬四季
    $is_season = 0;
    if (stristr($native_string, "春"))
    {
        $my_month = 4;
        $is_season = 1;
    }
    else if (stristr($native_string, "夏"))
    {
        $my_month = 7;
        $is_season = 1;
    }
    else if (stristr($native_string, "秋"))
    {
        $my_month = 10;
        $is_season = 1;
    }
    else if (stristr($native_string, "冬"))
    {
        $my_year = $my_year + 1;
        $my_month = 1;
        $is_season = 1;
    }
    if ($is_season == 1)
    {
        $my_day = 15;
        $time_array['time'] = juliantojd($my_month, $my_day, $my_year);
        $time_array['time_type'] = 3;    /// 年月日
        $time_array['time_limit'] = 45;
        $time_array['time_limit_type'] = 2;  // 日
        $time_array['status'] = "ok";
        
        return $time_array;
    }
    
    // step 10: 搞定只有"年"的情况(到这里还没有识别完, 肯定只有年了)
    if (stristr($native_string, "年"))
    {
        $time_array['time'] = $my_year;
        $time_array['time_type'] = 2;    /// 公元年
        $time_array['time_limit'] = 0;
        $time_array['time_limit_type'] = 1;  // 年
        $time_array['status'] = "ok";
        
        return $time_array;
    }
    
    // step 11: 搞定世纪
    if (stristr($native_string, "世纪"))
    {
        $my_year = $temp1 = str_replace("世纪", "", $native_string);
        if (is_numeric($my_year))
        {
            if ($time_array['is_bc'] == 1)
            {
                $time_array['time'] = $my_year * 100 + 50;
            }
            else 
            {
                $time_array['time'] = $my_year * 100 - 50;
            }
            $time_array['time_type'] = 2;    /// 年
            $time_array['time_limit'] = 50;
            $time_array['time_limit_type'] = 1;  // 年
            $time_array['status'] = "ok";
            
            return $time_array;
        }
        else
        {
	        $my_year2 = chinese_to_number($my_year);
            if ($my_year2 != 0)
            {
                if ($time_array['is_bc'] == 1)
                {
                    $time_array['time'] = $my_year2 * 100 + 50;
                }
                else 
                {
                    $time_array['time'] = $my_year2 * 100 - 50;
                }
                $time_array['time_type'] = 2;    /// 年
                $time_array['time_limit'] = 50;
                $time_array['time_limit_type'] = 1;  // 年
                $time_array['status'] = "ok";
                
                return $time_array;
            }
        }
    }
    
    // step 12: 最后保底
    if(strtotime($native_string) == TRUE)
    {
        // 13 是两种历法的差距.
        $time_array['time'] = unixtojd(strtotime($native_string)) + 13;
        $time_array['time_type'] = 3;    /// 年月日
        $time_array['time_limit'] = 0;
        $time_array['time_limit_type'] = 1;  // 年
        $time_array['status'] = "ok";
        
        return $time_array;
    }
    else 
    {
        $time_array['status'] = "fail";
        return $time_array;
    }
}

// 将年月日字符串转化为字符串数组。
function get_time_array($time_string)
{
    $my_string = str_replace("/", "-", $time_string);
    $my_string = str_replace(".", "-", $my_string);
    
    return explode("-", $my_string);
}

// 将“年月日”转成天数（时间范围从公元前4713年1月1日开始）
// 入参为: "2014-1-19"
function time_string_to_days($time_string)
{
    $my_days = 0;
    
    $my_string = str_replace("/", "-", $time_string);
    $my_string = str_replace(".", "-", $my_string);
    $string_array = explode("-", $my_string);
    
    // 处理公元前的年份
    if(empty($string_array[0]) && count($string_array) == 4)
    {
        $my_year = 0 - $string_array[1];
        $my_days = juliantojd($string_array[2], $string_array[3], $my_year);
    }
    else if(count($string_array) == 3)
    {
        $my_days = juliantojd($string_array[1], $string_array[2], $string_array[0]);
    }
    
    return $my_days;
}

// 将天数转成“年月日”字符串
function days_to_time_string($days_count)
{
    return jdtojulian($days_count);
}

// 将“年月日 时分秒”转成秒数（只支持1970年1月1日之后。肯定不够用，等以后扩展）
function time_string_to_seconds($time_string)
{
    return strtotime($time_string);
}

// 将秒数转成将“年月日 时分秒”
function seconds_to_time_string($seconds_count)
{
    return date("Y-m-d h:i:s", $seconds_count);
}


?>