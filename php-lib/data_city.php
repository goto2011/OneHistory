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
        array("长春"),
        array("沈阳"),
        array("大连"),
        array("黑河"),
        array("满洲里"),
        array("齐齐哈尔"),
        array("伊春"),
        array("佳木斯"),
        array("大庆"),
        array("牡丹江"),
        array("鸡西"),
        array("海拉尔"),
        array("哈尔滨"),
        array("白城"),
        array("四平"),
        array("吉林"),
        array("通化"),
        array("延吉"),
        array("锦州"),
        array("鞍山"),
        array("丹东"),
        array("阜新"),
        array("通辽"),
        array("赤峰"),
        array("二连浩特"),
    ),
    array
    (
        // 中国华北
        array("北京"),
        array("天津"),
        array("石家庄"),
        array("太原"),
        array("济南"),
        array("呼和浩特"),
        array("青岛"),
        array("唐山"),
        array("秦皇岛"),
        array("承德"),
        array("张家口"),
        array("保定"),
        array("邯郸"),
        array("大同"),
        array("临汾"),
        array("包头"),
        array("集宁"),
        array("德州"),
        array("淄博"),
        array("烟台"),
        array("潍坊"),
        array("威海"),
        array("济宁"),
        array("临沂"),
    ),
    array
    (
        // 中国华东
        array("上海"),
        array("南京"),
        array("杭州"),
        array("苏州"),
        array("徐州"),
        array("连云港"),
        array("徐州"),
        array("淮阴"),
        array("宁波"),
        array("金华"),
        array("温州"),
    ),
    array
    (
        // 中国中部
        array("西安"),
        array("武汉"),
        array("开封"),
        array("洛阳"),
        array("长沙"),
        array("重庆"),
        array("成都"),
        array("郑州"),
        array("合肥"),
        array("长沙"),
        array("安阳"),
        array("榆林"),
        array("延安"),
        array("铜川"),
        array("宝鸡"),
        array("汉中"),
        array("安康"),
        array("三门峡"),
        array("南阳"),
        array("漯河"),
        array("信阳"),
        array("十堰"),
        array("襄樊"),
        array("宜昌"),
        array("恩施"),
        array("黄石"),
        array("黄冈"),
        array("鄂州"),
        array("宿州"),
        array("阜阳"),
        array("蚌埠"),
        array("安庆"),
        array("芜湖"),
        array("岳阳"),
        array("常德"),
        array("株洲"),
        array("邵阳"),
        array("衡阳"),
        array("九江"),
        array("南昌"),
        array("上饶"),
        array("鹰潭"),
        array("吉安"),
        array("赣州"),
        array("万县"),
        array("绵阳"),
        array("南充"),
        array("都江堰"),
        array("宜宾"),
        array("南昌"),
        array("攀枝花"),
    ),
    array
    (
        // 中国南部
        array("广州"),
        array("深圳"),
        array("厦门"),
        array("福州"),
        array("澳门"),
        array("韶关"),
        array("梅州"),
        array("汕头"),
        array("茂名"),
        array("南平"),
        array("台北"),
        array("台南"),
        array("高雄"),
        array("海口"),
        array("三亚"),
    ),
    array
    (
        // 中国西部
        array("兰州"),
        array("乌鲁木齐"),
        array("银川"),
        array("天水"),
        array("武威"),
        array("张掖"),
        array("嘉峪关"),
        array("敦煌"),
        array("玉门"),
        array("西宁"),
        array("德令哈"),
        array("格尔木"),
        array("玉树"),
        array("乌鲁木齐"),
        array("哈密"),
        array("库尔勒"),
        array("喀什"),
        array("吐鲁番"),
        array("阿克苏"),
        array("和田"),
        array("阿勒泰"),
        array("伊宁"),
        array("若羌"),
        array("且末"),
        array("库车"),
        array("叶城"),
        array("塔城"),
        array("克拉玛依"),
        array("民丰"),
        array("拉萨"),
        array("昌都"),
        array("昆明"),
        array("个旧"),
        array("大理"),
        array("东川"),
        array("贵阳"),
        array("安顺"),
        array("遵义"),
        array("铜仁"),
        array("南宁"),
        array("桂林"),
        array("柳州"),
        array("百色"),
        array("梧州"),
        array("北海"),
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
            return "中国西部";
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
        for ($jj = get_small_city_begin($ii); $jj <= get_small_city_end($ii); $jj++)
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