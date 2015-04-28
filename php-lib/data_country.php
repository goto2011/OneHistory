<?php
// created by duangan, 2015-4-27 -->
// support country deal function.    -->

// 朝代数组
$country = array
(
    array
    (
        // 史前文明(建立国家或王权前)
        array("古人类遗址"),
        array("远东文明遗址"),
        array("西方文明遗址"),
        array("其它地区文明遗址"),
    ),
    array
    (
        // 中东北非中亚
        array("古埃及"),
        array("古苏美尔"),
        array("古赫梯"),
        array("古巴比伦"),
        array("古腓尼基"),
        array("古伊朗"),
        array("古叙利亚"),
        array("阿拉伯"),
        array("奥斯曼"),
        array("埃及"),
        array("利比亚"),
        array("摩洛哥"),
        array("以色列"),
        array("阿富汗"),
        array("亚美尼亚"),
        array("阿塞拜疆"),
        array("塞浦路斯"),
        array("格鲁吉亚"),
        array("伊朗"),
        array("伊拉克"),
        array("约旦"),
        array("科威特"),
        array("黎巴嫩"),
        array("巴勒斯坦"),
        array("卡塔尔"),
        array("沙特阿拉伯"),
        array("叙利亚"),
        array("土耳其"),
        array("阿联"),
        array("也门"),
        array("中亚五斯坦"),
    ),
    array
    (
        // 亚洲
        array("古中国"),
        array("古印度"),
        array("印度"),
        array("日本"),
        array("朝鲜"),
        array("韩国"),
        array("孟加拉国"),
        array("柬埔寨"),
        array("印尼"),
        array("老挝"),
        array("马来西亚"),
        array("马尔代夫"),
        array("泰国"),
        array("越南"),
        array("蒙古"),
        array("缅甸"),
        array("尼泊尔"),
        array("巴基斯坦"),
        array("菲律宾"),
        array("新加坡"),
        array("斯里兰卡"),
    ),
    array
    (
        // 欧洲
        array("古米诺斯"),
        array("古希腊"),
        array("古罗马"),
        array("日耳曼人"),
        array("古拜占庭"),
        array("神圣罗马帝国"),
        array("奥匈帝国"),
        array("德国"),
        array("英国"),
        array("法国"),
        array("俄罗斯"),
        array("意大利"),
        array("阿尔巴尼亚"),
        array("奥地利"),
        array("比利时"),
        array("保加利亚"),
        array("前南诸国"),
        array("捷克"),
        array("丹麦"),
        array("爱沙尼亚"),
        array("芬兰"),
        array("希腊"),
        array("匈牙利"),
        array("冰岛"),
        array("爱尔兰"),
        array("荷兰"),
        array("挪威"),
        array("瑞典"),
        array("波兰"),
        array("葡萄牙"),
        array("西班牙"),
        array("罗马尼亚"),
        array("瑞士"),
        array("乌克兰"),
        array("波罗的海三国"),
    ),
    array
    (
        // 非洲
        array("班图人文明"),
        array("黑人文明"),
        array("马里帝国"),
        array("埃塞俄比亚帝国"),
        array("南非"),
        array("阿尔及利亚"),
        array("刚果（金）"),
        array("刚果"),
        array("布隆迪"),
        array("安哥拉"),
        array("埃塞俄比亚"),
        array("肯尼亚"),
        array("尼日利亚"),
        array("卢旺达"),
        array("索马里"),
        array("苏丹"),
        array("津巴布韦"),
        array("马达加斯加"),
    ),
    array
    (
        // 美洲
        array("古玛雅"),
        array("古安第斯"),
        array("古墨西哥"),
        array("爱斯基摩"),
        array("美国"),
        array("墨西哥"),
        array("加拿大"),
        array("中美洲"),
        array("古巴"),
        array("危地马拉"),
        array("尼加拉瓜"),
        array("阿根廷"),
        array("玻利维亚"),
        array("巴西"),
        array("智利"),
        array("哥伦比亚"),
        array("厄瓜多尔"),
        array("巴拉圭"),
        array("秘鲁"),
        array("乌拉圭"),
        array("委内瑞拉"),
    ),
    array
    (
        // 大洋洲等
        array("古波利尼西亚"),
        array("澳大利亚"),
        array("新西兰"),
        array("巴布亚新几内亚"),
    ),
    array
    (
        // other
    )
);

// 返回大时期的名称
function get_big_country_name($index)
{
    switch($index)
    {
        case 1:
            return "史前文明(建立国家或王权前)";
            break;
        case 2:
            return "中东北非中亚";
            break;
        case 3:
            return "欧洲";
            break;
        case 4:
            return "亚洲";
            break;
        case 5:
            return "非洲";
            break;
        case 6:
            return "美洲";
            break;
        case 7:
            return "大洋洲等";
            break;
        default:
            return "其它";
    }
}

// 获取 big id begin
function get_big_country_begin()
{
    return 1;   // 从1开始方便通过 GET 传递.
}

// 获取 big id end
function get_big_country_end()
{
    global $country;
    return count($country);
}

// 获取 small id begin
function get_small_country_begin($big_id)
{
    return 1;
}

// 获取 small id end.
function get_small_country_end($big_id)
{
    global $country;
    return count($country[$big_id - 1]);
}

// 获取朝代名称
function get_country_name($big_id, $small_id)
{
    global $country;
    return $country[$big_id - 1][$small_id - 1][0];
}


?>