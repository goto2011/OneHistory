<?php
// created by duangan, 2015-5-4 -->
// support topic deal function.    -->

// 朝代数组
$topic = array
(
    array
    (
        // 武装冲突
        array("大屠杀"),
        array("战争"),
        array("第一次世界大战"),
        array("第二次世界大战"),
        array("军事思想"),
    ),
    array
    (
        // 灾难事故犯罪
        array("饥荒"),
        array("地震"),
        array("水灾"),
        array("火灾"),
        array("空难"),
        array("交通事故"),
        array("病疫"),
        array("欧洲黑死病"),
        array("自杀"),
    ),
    array
    (
        // 科学技术
        array("发明创造"),
        array("天文"),
        array("物理"),
        array("基因"),
        array("生物"),
        array("化学"),
        array("数学逻辑学"),
        array("地理"),
    ),
    array
    (
        // 艺术文化体育
        array("文学"),
        array("小说"),
        array("书法绘画"),
        array("体育"),
        array("足球"),
    ),
    array
    (
        // 思想宗教
        array("基督教"),
        array("东正教"),
        array("犹太教"),
        array("佛教"),
        array("道教"),
        array("印度教"),
        array("其它宗教"),
        array("古希腊哲学"),
        array("中世纪哲学"),
        array("康德哲学"),
        array("经验主义哲学"),
        array("存在主义哲学"),
        array("后现代哲学"),
        array("儒家"),
        array("中国其它"),
        array("马克思主义哲学"),
    ),
    array
    (
        // 社会
        array("社会"),
    ),
    array
    (
        // 农业
        array("土地制度"),
    ),
    array
    (
        // 工商业
        array("工业"),
        array("金融业"),
        array("IT技术"),
        array("IT行业"),
    ),
    array
    (
        // 财政税收
        array("财政"),
        array("税收"),
    ),
    array
    (
        // 政治外交
        array("政治"),
        array("国际关系"),
    ),
    array
    (
        // other
    )
);

// 返回大时期的名称
function get_big_topic_name($index)
{
    switch($index)
    {
        case 1:
            return "武装冲突";
        case 2:
            return "灾难事故犯罪";
        case 3:
            return "科学技术";
        case 4:
            return "艺术文化体育";
        case 5:
            return "思想宗教";
        case 6:
            return "社会";
        case 7:
            return "农业";
        case 8:
            return "工商业";
        case 9:
            return "财政税收";
        case 10:
            return "政治外交";
        default:
            return "其它";
    }
}

// 获取 big id begin
function get_big_topic_begin()
{
    return 1;   // 从1开始方便通过 GET 传递.
}

// 获取 big id end
function get_big_topic_end()
{
    global $topic;
    return count($topic);
}

// 获取 small id begin
function get_small_topic_begin($big_id)
{
    return 1;
}

// 获取 small id end.
function get_small_topic_end($big_id)
{
    global $topic;
    return count($topic[$big_id - 1]);
}

// 获取朝代名称
function get_topic_name($big_id, $small_id)
{
    global $topic;
    return $topic[$big_id - 1][$small_id - 1][0];
}

// 获取是否存在. =1 表示存在； =0表示不存在。
function topic_tag_is_exist($tag_name)
{
    for ($ii = get_big_topic_begin(); $ii <= get_big_topic_end(); $ii++)
    {
        for ($jj = get_small_topic_begin($ii); $jj <= get_small_topic_end($ii); $jj)
        {
            if(get_topic_name($ii, $jj) == $tag_name)
            {
                return 1;
            }
        }
    }
    
    return 0;
}


?>