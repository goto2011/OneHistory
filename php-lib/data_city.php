<?php
// created by duangan, 2015-5-6 -->
// support city deal function.    -->

// 朝代数组
$city = array
(
    array
    (
        // 全球性都市
        array("巴黎"),
        array("伦敦"),
        array("柏林"),
        array("罗马"),
        array("威尼斯"),
        array("维也纳"),
        array("莫斯科"),
        array("香港"),
        array("新加坡"),
        array("东京"),
        array("悉尼"),
        array("孟买"),
        array("纽约"),
        array("洛杉矶"),
        array("芝加哥"),
    ),
    array
    (
        // 外国一线
        array("阿姆斯特丹"),
        array("布鲁塞尔"),
        array("都柏林"),
        array("利物浦"),
        array("布拉格"),
        array("日内瓦"),
        array("马赛"),
        array("马德里"),
        array("里斯本"),
        array("米兰"),
        array("贝尔格莱德"),
        array("萨拉热窝"),
        array("哥本哈根"),
        array("华沙"),
        array("奥斯陆"),
        array("斯特哥尔摩"),
        array("赫尔辛基"),
        array("圣彼得堡"),
        array("基辅"),
        array("第比利斯"),
        array("安卡拉"),
        array("伊斯坦布尔"),
        array("耶路撒冷"),
        array("大马士革"),
        array("开罗"),
        array("巴格达"),
        array("德黑兰"),
        array("坎布尔"),
        array("新德里"),
        array("加德满都"),
        array("曼谷"),
        array("吉隆坡"),
        array("雅加达"),
        array("平壤"),
        array("首尔"),
        array("济州"),
        array("大阪"),
        array("马尼拉"),
        array("渥太华"),
        array("魁北克"),
        array("西雅图"),
        array("波士顿"),
        array("亚特兰大"),
        array("休斯顿"),
        array("墨西哥城"),
        array("哈瓦那"),
        array("巴拿马城"),
        array("里约"),
    ),
    array
    (
        // 中国东北
        array("哈尔滨"),
    ),
    array
    (
        // 中国华北
        array("北京"),
        array("天津"),
    ),
    array
    (
        // 中国华东
        array("上海"),
        array("南京"),
        array("杭州"),
    ),
    array
    (
        // 中国中部
        array("武汉"),
        array("长沙"),
        array("重庆"),
        array("成都"),
    ),
    array
    (
        // 中国南部
        array("广州"),
        array("深圳"),
    ),
    array
    (
        // 中国西北
        array("西安"),
        array("兰州"),
        array("乌鲁木齐"),
    ),
    array
    (
        // other
    )
);

// 返回大时期的名称
function get_big_city_name($index)
{
    switch($index)
    {
        case 1:
            return "全球性都市";
        case 2:
            return "外国一线";
        case 3:
            return "中国东北";
        case 4:
            return "中国华北";
        case 5:
            return "中国华东";
        case 6:
            return "中国中部";
        case 7:
            return "中国南部";
        case 8:
            return "中国西北";
        default:
            return "其它";
    }
}

// 获取 big id begin
function get_big_city_begin()
{
    return 1;   // 从1开始方便通过 GET 传递.
}

// 获取 big id end
function get_big_city_end()
{
    global $city;
    return count($city);
}

// 获取 small id begin
function get_small_city_begin($big_id)
{
    return 1;
}

// 获取 small id end.
function get_small_city_end($big_id)
{
    global $city;
    return count($city[$big_id - 1]);
}

// 获取朝代名称
function get_city_name($big_id, $small_id)
{
    global $city;
    return $city[$big_id - 1][$small_id - 1][0];
}

// 获取是否存在. =1 表示存在； =0表示不存在。
function city_tag_is_exist($tag_name)
{
    for ($ii = get_big_city_begin(); $ii <= get_big_city_end(); $ii++)
    {
        for ($jj = get_small_city_begin($ii); $jj <= get_small_city_end($ii); $jj)
        {
            if(get_city_name($ii, $jj) == $tag_name)
            {
                return 1;
            }
        }
    }
    
    return 0;
}


?>