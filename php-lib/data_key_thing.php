<?php
// created by duangan, 2015-5-6 -->
// support key thing deal function.    -->

// 关键事件数组
$key_thing = array
(
    array
    (
        // 中国古代
        array("大禹治水"),
        array("百家争鸣"),
        array("礼崩乐坏"),
        array("统一六国"),
        array("焚书坑儒"),
        array("陈胜吴广起义"),
        array("楚汉相争"),
        array("七王之乱"),
        array("汉武帝开西域"),
        array("党锢之祸"),
        array("昆阳之战"),
        array("黄巾军起义"),
        array("官渡之战"),
        array("赤壁之战"),
        array("八王之乱"),
        array("永嘉之祸"),
        array("冉魏灭胡"),
        array("淝水之战"),
        array("参合陂之战"),
        array("侯景之乱"),
        array("三武灭佛"),
        
        array("玄武门之变"),
        array("贞观之治"),
        array("武周代唐"),
        array("怛罗斯战役"),
        array("安史之乱"),
        array("牛李党争"),
        array("唐代藩镇"),
        array("甘露之变"),
        array("黄巢起义"),
        array("白马之祸"),
        array("陈桥兵变"),
        array("高梁河之战"),
        array("杯酒释兵权"),
        array("澶渊之盟"),
        array("庆历新政"),
        array("王安石变法"),
        array("卡特万之战"),
        array("靖康之难"),
        array("绍兴和议"),
        array("蒙古三次西征"),
        array("元灭宋"),
        array("明灭元"),
        array("靖难之变"),
        array("土木堡之变"),
        array("夺门之变"),
        array("张居正变法"),
        array("灭倭寇"),
        array("东林党"),
        array("辽东抗清"),
        array("清灭明"),
        
    ),
    array
    (
        // 中国近现代
        array("利玛窦规矩"),
        array("鸦片战争"),
        太平天国
        湘军
        甲午战争
        百日维新
        义和团
        东南自保
        清末新政
        array("辛亥革命"),
        array("二次革命"),
        array("北伐"),
        array("五次反围剿"),
        array("西安事变"),
        array("抗日战争"),
        array("南京大屠杀"),
        array("重庆谈判"),
        array("解放战争"),
        array("二二八事件"),
        array("朝鲜战争"),
        array("三反五反"),
        array("土地改革"),
        array("反右派"),
        array("大饥荒"),
        array("文化大革命"),
        array("改革开放"),
        array("台湾十大建设"),
        array("美丽岛事件"),
        array("辜汪会谈"),
        array("中国国民党"),
        array("中国共产党"),
        array("民主进步党"),
    ),
    array
    (
        // 世界古代
        array("两河流域-发现农业"),
        array("埃及建国"),
        array("希腊理性之光"),
        array("罗马帝国"),
        array("蛮族入侵"),
        array("基督教兴起"),
        array("十字军东征"),
        array("伊斯兰教兴起"),
        array("地中海城市帝国"),
        array("英国大宪章"),
        array("文艺复兴"),
        array("科技革命"),
        array("英国革命"),
        array("美国革命"),
        array("法国革命"),
        
    ),
    array
    (
        // 世界近现代
        array("第一次世界大战"),
        array("第二次世界大战"),
        array("登上月球"),
    ),
    array
    (
        // 社会热点
        array(""),
        array(""),
        array(""),
    ),
    array
    (
        // other
    )
);

// 返回大时期的名称
function get_big_key_thing_name($index)
{
    switch($index)
    {
        case 1:
            return "中国古代";
        case 2:
            return "中国近现代";
        case 3:
            return "世界古代";
        case 4:
            return "世界近现代";
        case 5:
            return "社会热点";
        default:
            return "其它";
    }
}

// 获取 big id begin
function get_big_key_thing_begin()
{
    return 1;   // 从1开始方便通过 GET 传递.
}

// 获取 big id end
function get_big_key_thing_end()
{
    global $key_thing;
    return count($key_thing);
}

// 获取 small id begin
function get_small_key_thing_begin($big_id)
{
    return 1;
}

// 获取 small id end.
function get_small_key_thing_end($big_id)
{
    global $key_thing;
    return count($key_thing[$big_id - 1]);
}

// 获取朝代名称
function get_key_thing_name($big_id, $small_id)
{
    global $key_thing;
    return $key_thing[$big_id - 1][$small_id - 1][0];
}

// 获取是否存在. =1 表示存在； =0表示不存在。
function key_thing_tag_is_exist($tag_name)
{
    for ($ii = get_big_key_thing_begin(); $ii <= get_big_key_thing_end(); $ii++)
    {
        for ($jj = get_small_key_thing_begin($ii); $jj <= get_small_key_thing_end($ii); $jj++)
        {
            if(get_key_thing_name($ii, $jj) == $tag_name)
            {
                return 1;
            }
        }
    }
    
    return 0;
}


?>