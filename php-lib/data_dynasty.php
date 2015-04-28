<?php
// created by duangan, 2015-4-19 -->
// support dynasty deal function.    -->

// 朝代数组
$dynasty = array
(
    array
    (
        // 24个。
        array("夏朝"),
        array("商朝"),
        array("周朝"),
        array("东周"),
        array("秦朝"),
        array("汉朝"),
        array("新朝"),
        array("东汉"),
        array("三国"),
        array("西晋"),
        array("东晋"),
        array("南北朝"),
        array("隋朝"),
        array("唐朝"),
        array("五代十国"),
        array("宋朝"),
        array("南宋"),
        array("明朝"),
        array("清朝"),
        array("中华民国"),
        array("中华人民共和国"),
        array("中华民国(台湾)"),
    ),
    array
    (
        // 22 
        array("周国"),
        array("鲁国"),
        array("齐国"),
        array("田齐"),
        array("晋国"),
        array("曲沃"),
        array("秦国"),
        array("楚国"),
        array("燕国"),
        array("宋国"),
        array("卫国"),
        array("陈国"),
        array("蔡国"),
        array("曹国"),
        array("郑国"),
        array("吴国"),
        array("越国"),
        array("杞国"),
        array("赵国"),
        array("魏国"),
        array("韩国"),
        array("中山国"),
        array("其它候国"),
    ),
    array
    (
        // 37
        array("辽东郡"),
        array("乐浪郡"),
        array("前赵"),
        array("成汉"),
        array("前凉"),
        array("后赵"),
        array("前燕"),
        array("前秦"),
        array("后燕"),
        array("后秦"),
        array("西秦"),
        array("后凉"),
        array("南凉"),
        array("南燕"),
        array("西凉"),
        array("北凉"),
        array("胡夏"),
        array("北燕"),
        array("前仇池"),
        array("后仇池"),
        array("宕昌"),
        array("邓至"),
        array("冉魏"),
        array("谯蜀"),
        array("桓楚"),
        array("翟魏"),
        array("代"),
        array("西燕"),
        array("宇文部"),
        array("段部"),
        array("北魏"),
        array("东魏"),
        array("西魏"),
        array("北齐"),
        array("北周"),
        array("南朝宋"),
        array("南朝齐"),
        array("南朝梁"),
        array("南朝陈"),
        array("辽"),
        array("西夏"),
        array("金国"),
        array("后梁"),
        array("后唐"),
        array("后晋"),
        array("后汉"),
        array("后周"),
        array("南唐"),
        array("吴越"),
        array("闽"),
        array("北汉"),
        array("前蜀"),
        array("后蜀"),
        array("荆南"),
        array("南楚"),
        array("南汉"),
        array("中华苏维埃共和国"),
        array("伪满洲国"),
    ),
    array
    (
        // 19
        array("戎"),
        array("东胡"),
        array("粛慎"),
        array("匈奴"),
        array("鲜卑"),
        array("大月氏"),
        array("乌桓"),
        array("扶余"),
        array("氐"),
        array("羌"),
        array("羯"),
        array("丁零"),
        array("柔然"),
        array("突厥"),
        array("吐蕃"),
        array("吐谷浑"),
        array("鉄勒"),
        array("回纥"),
        array("契丹"),
        array("党项"),
        array("高句丽"),
        array("女真"),
        array("准噶尔汗国"),
    ),
    array
    (
        // 18
        array("朝鲜"),
        array("南越国"),
        array("弁韩"),
        array("马韩"),
        array("辰韩"),
        array("百济"),
        array("新罗"),
        array("高丽"),
        array("蒙古"),
        array("元朝"),
        array("帖木儿帝国"),
        array("日本"),
    ),
    array
    (
        
    )
);

// 返回大时期的名称
function get_big_dynasty_name($index)
{
    switch($index)
    {
        case 1:
            return "正朔朝代";
            break;
        case 2:
            return "春秋战国列国";
            break;
        case 3:
            return "地方政权";
            break;
        case 4:
            return "周边少数民族";
            break;
        case 5:
            return "周边独立政权";
            break;
        default:
            return "其它";
    }
}

// 获取 big id begin
function get_big_dynasty_begin()
{
    return 1;   // 从1开始方便通过 GET 传递.
}

// 获取 big id end
function get_big_dynasty_end()
{
    global $dynasty;
    return count($dynasty);
}

// 获取 small id begin
function get_small_dynasty_begin($big_id)
{
    return 1;
}

// 获取 small id end.
function get_small_dynasty_end($big_id)
{
    global $dynasty;
    return count($dynasty[$big_id - 1]);
}

// 获取朝代名称
function get_dynasty_name($big_id, $small_id)
{
    global $dynasty;
    return $dynasty[$big_id - 1][$small_id - 1][0];
}


?>