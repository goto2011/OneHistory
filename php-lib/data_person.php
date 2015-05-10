<?php
// created by duangan, 2015-5-8 -->
// support person deal function.    -->

// 朝代数组
$person = array
(
    array
    (
        // 科学家
        array("爱因斯坦"),
        array("牛顿"),
        array("伦琴"),
        array("洛伦兹"),
        array("塞曼"),
        array("贝可勒尔"),
        array("居里夫人"),
        array("瑞利"),
        array("汤姆孙"),
        array("马可尼"),
        array("巴克拉"),
        array("普朗克"),
        array("玻尔"),
        array("赫兹"),
        array("霍金"),
        array("費曼"),
        array("麦克斯韦"),
    ),
    array
    (
        // 文学家
        array("曹雪芹"),
        array("李白"),
        array("杜甫"),
    ),
    array
    (
        // 艺术家
        array("达芬奇"),
        array("米开朗基罗"),
        array("齐白石"),
    ),
    array
    (
        // 人文思想家
        array("孔子"),
        array("老子"),
    ),
    array
    (
        // 宗教人士
        array("耶稣"),
        array("默罕默德"),
        array("释迦摩尼"),
    ),
    array
    (
        // 工商界
        array("乔布斯"),
        array("盖茨"),
        array("福特"),
    ),
    array
    (
        // 政治家
        array("武则天"),
        array("和珅"),
        array("慈禧太后"),
        array("袁世凯"),
        array("孙中山"),
        array("黄兴"),
        array("蒋介石"),
        array("毛泽东"),
        array("邓小平"),
        array("周恩来"),
    ),
    array
    (
        // 军事家
        array("白起"),
        array("孙武"),
        array("岳飞"),
    ),
    array
    (
        // 体育运动
        array("刘翔"),
    ),
    array
    (
        // other
    )
);

// 返回大时期的名称
function get_big_person_name($index)
{
    switch($index)
    {
        case 1:
            return "科学家";
        case 2:
            return "文学家";
        case 3:
            return "艺术家";
        case 4:
            return "人文思想家";
        case 5:
            return "宗教人士";
        case 6:
            return "工商界人士";
        case 7:
            return "政治家";
        case 8:
            return "军事家";
        case 9:
            return "体育运动";
        default:
            return "其它";
    }
}

// 获取 big id begin
function get_big_person_begin()
{
    return 1;   // 从1开始方便通过 GET 传递.
}

// 获取 big id end
function get_big_person_end()
{
    global $person;
    return count($person);
}

// 获取 small id begin
function get_small_person_begin($big_id)
{
    return 1;
}

// 获取 small id end.
function get_small_person_end($big_id)
{
    global $person;
    return count($person[$big_id - 1]);
}

// 获取朝代名称
function get_person_name($big_id, $small_id)
{
    global $person;
    return $person[$big_id - 1][$small_id - 1][0];
}

// 获取是否存在. =1 表示存在； =0表示不存在。
function person_tag_is_exist($tag_name)
{
    for ($ii = get_big_person_begin(); $ii <= get_big_person_end(); $ii++)
    {
        for ($jj = get_small_person_begin($ii); $jj <= get_small_person_end($ii); $jj)
        {
            if(get_person_name($ii, $jj) == $tag_name)
            {
                return 1;
            }
        }
    }
    
    return 0;
}


?>