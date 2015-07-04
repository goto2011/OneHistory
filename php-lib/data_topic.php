<?php
// created by duangan, 2015-5-4 -->
// support topic deal function.    -->

// 朝代数组
$topic = array
(
    array
    (
        // 历史
        array("历史学"),
        array("考古"),
        array("分子遗传学"),
        array("地质年代"),
        array("中国年号"),
        array("中学历史年表"),
        array("全国重点文物保护单位"),
    ),
    array
    (
        // 史前史
        array("古人类遗址"),
        array("人类文明遗址"),
        array("石器时代"),
        array("青铜时代"),
        array("铁器时代"),
        array("磁山文化"),
        array("仰韶文化"),
        array("红山文化"),
        array("龙山文化"),
        array("大汶口文化"),
        array("二里头文化"),
        array("河姆渡文化"),
        array("三星堆文化"),
        array("良渚文化"),
    ),
    array
    (
        // 死亡
        array("大屠杀"),
        array("战争"),
        array("国际冲突"),
        array("国内冲突"),
        array("饥荒"),
        array("地震"),
        array("水灾"),
        array("火灾"),
        array("空难"),
        array("矿难"),
        array("交通事故"),
        array("病疫"),
        array("自杀"),
        array("谋杀"),
        array("死刑"),
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
        array("数学"),
        array("逻辑学"),
        array("地理"),
        array("医学"),
        array("诺贝尔奖"),
        array("中医"),
    ),
    array
    (
        // 艺术文化体育
        array("文学"),
        array("小说"),
        array("音乐"),
        array("美术"),
        array("雕像"),
        array("电影"),
        array("电视剧"),
        array("书法"),
        array("体育"),
        array("足球"),
        array("奥运会"),
        array("奥斯卡奖"),
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
        array("萨满教"),
        array("其它宗教"),
        
        array("古希腊哲学"),
        array("中世纪哲学"),
        array("康德哲学"),
        array("经验主义哲学"),
        array("存在主义哲学"),
        array("后现代哲学"),
        array("儒家"),
        array("中国其它哲学"),
        array("马克思主义哲学"),
        array("军事思想"),
    ),
    array
    (
        // 人文社会
        array("社会"),
        array("婚嫁情感"),
        array("伦理学"),
        array("心理学"),
        array("经济学"),
        array("社会学"),
        array("户口"),
    ),
    array
    (
        // 经济
        array("农业"),
        array("土地制度"),
        array("水利"),
        
        array("工业"),
        array("金融业"),
        array("IT技术"),
        array("IT行业"),
        array("私有制"),
        array("公有制"),
    ),
    array
    (
        // 政治外交
        array("政治"),
        array("民主"),
        array("选举"),
        array("宪法"),
        array("国家制度"),
        array("财政"),
        array("税收"),
        array("法律"),
        array("犯罪"),
        array("国际关系"),
        array("战略思想"),
        array("条约"),
        array("殖民"),
        array("奴隶"),
        array("建国"),
        array("统一"),
        array("分裂"),
        array("起义"),
        array("复辟"),
        array("叛乱"),
    ),
    array
    (
        // 中国政治问题
        array("皇权"),
        array("太子"),
        array("宰相"),
        array("中央和地方官制"),
        array("科举"),
        array("监察"),
        array("宗室"),
        array("土地"),
        array("奴婢"),
        array("士族"),
        array("外戚"),
        array("权臣"),
        array("宦官"),
        array("大臣杀皇帝"),
        array("皇帝杀大臣"),
        array("以少胜多"),
        array("中兴"),
        array("禅让"),
        array("边患"),
        array("党争"),
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
            return "历史";
        case 2:
            return "史前史";
        case 3:
            return "死亡";
        case 4:
            return "科学技术";
        case 5:
            return "艺术文化体育";
        case 6:
            return "思想宗教";
        case 7:
            return "人文社会";
        case 8:
            return "经济";
        case 9:
            return "政治外交";
        case 10:
            return "中国政治问题";
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
        for ($jj = get_small_topic_begin($ii); $jj <= get_small_topic_end($ii); $jj++)
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