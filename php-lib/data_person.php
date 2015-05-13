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
        array("法拉第"),
        array("巴斯德"),
        array("伽俐略"),
        array("亚里士多德"),
        array("达尔文"),
        array("欧几里德"),
        array("哥白尼"),
        array("拉瓦锡"),
        array("胡克"),
        array("海森堡"),
        array("弗莱明"),
        array("哈维"),
        array("孟德尔"),
        array("伦琴"),
        array("欧拉"),
        array("开普勒"),
        
    ),
    array
    (
        // 文学
        array("荷马"),
        array("莎士比亚"),
        
        array("屈原"),
        array("李白"),
        array("杜甫"),
        array("曹雪芹"),
        array("罗贯中"),
    ),
    array
    (
        // 艺术体育
        array("达芬奇"),
        array("贝多芬"),
        array("巴赫"),
        array("毕加索"),
        array("米开朗基罗"),
        
        array("齐白石"),
        array("刘翔"),
    ),
    array
    (
        // 人文思想家
        array("柏拉图"),
        array("亚里士多德"),
        array("洛克"),
        array("亚当·斯密"),
        array("奥古斯丁"),
        array("笛卡尔"),
        array("卢梭"),
        array("马尔萨斯"),
        array("培根"),
        array("伏尔泰"),
        array("马基维利亚"),
        array("弗洛伊德"),
        array("马克思"),
        
        array("孔子"),
        array("老子"),
        array("孟子"),
        array("墨子"),
        array("杨朱学派"),
        array("惠施"),
        array("公孙龙"),
        array("邓析子"),
        array("庄子"),
        array("司马迁"),
        array("刘向"),
        array("刘歆"),
        array("朱熹"),
        array("王阳明"),
    ),
    array
    (
        // 宗教人士
        array("耶稣"),
        array("圣保罗"),
        array("摩西"),
        array("马丁·路德"),
        array("加尔文"),
        array("默罕默德"),
        array("释迦摩尼"),
        array("摩尼"),
        
    ),
    array
    (
        // 工商界
        array("古腾堡"),
        array("瓦特"),
        array("莱特兄弟"),
        array("爱迪生"),
        array("贝尔"),
        array("乔布斯"),
        array("盖茨"),
        array("福特"),
    ),
    array
    (
        // 外国政治人物
        array("凯撒"),
        array("亚历山大大帝"),
        array("君士坦丁大帝"),
        array("成吉思汗"),
        array("乌尔班二世"),
        array("欧麦尔"),
        array("阿育王"),
        array("哥伦布"),
        array("达·伽马"),
        array("查理曼"),
        array("塞鲁士大帝"),
        array("克伦威尔"),
        array("华盛顿"),
        array("玻利瓦尔"),
        array("弗朗西斯科·皮扎诺"),
        array("荷南多·科尔特斯"),
        array("伊莎贝拉一世"),
        array("威廉大帝"),
        array("托马斯·杰佛逊"),
        array("彼得大帝"),
        array("伊丽莎白女王一世"),
        array("查士丁尼一世"),
        
        array("列宁"),
        array("斯大林"),
        
        array("希特勒"),
        array("肯尼迪"),
    ),
    array
    (
        // 中国先秦
        array("鲧"),
        array("禹"),
        array("启"),
        array("太康"),
        array("羿"),
        array("少康"),
        array("杼"),
        array("桀"),
        array("契"),
        array("汤"),
        array("太甲"),
        array("盘庚"),
        array("武丁"),
        array("帝辛"),
        array("武庚"),
        array("箕子"),
        array("微子启"),
        array("季历"),
        array("周文王"),
        array("周武王"),
        array("周公"),
        array("周成王"),
        array("周昭王"),
        array("周穆王"),
        array("周懿王"),
        array("周厉王"),
        array("周宣王"),
        array("周幽王"),
        array("周携王"),
        array("周平王"),
        array("郑庄公"),
        array("齐桓公"),
        array("宋襄公"),
        array("楚成王"),
        array("晋文公"),
        array("秦穆公"),
        array("楚庄王"),
        array("吴王阖闾"),
        array("越王勾践"),
        array("孙武"),
        array("伍子胥"),
        array("西施"),
        array("魏文侯"),
        array("魏成子"),
        array("李悝"),
        array("乐羊"),
        array("吴起"),
        array("西门豹"),
        array("公仲连"),
        array("楚悼王"),
        array("邹忌"),
        array("田忌"),
        array("孙膑"),
        array("申不害"),
        array("商鞅"),
        array("魏惠王"),
        array("齐威王"),
        array("庞涓"),
        array("秦孝公"),
        array("燕昭王"),
        array("赵武灵王"),
        array("田单"),
        array("白起"),
        array("范雎"),
        array("秦昭王"),
        array("廉颇"),
        array("王龁"),
        array("赵括"),
        array("信陵君"),
        array("平原君"),
        array("春申君"),
        array("孟尝君"),
        array("吕不韦"),
        array("乐毅"),
        array("张仪"),
        array("公孙衍"),
        array("李冰"),
        array("韩非子"),
        array("王翦"),
        array("李牧"),
        array("荆轲"),
        array("太子丹"),
        array("王贲"),
        array("项燕"),
    ),
    array
    (
        // 中国秦汉晋南北朝
        array("秦始皇"),
        array("李斯"),
        array("尉缭"),
        array("蒙恬"),
        array("史禄"),
        array("赵佗"),
        array("赵高"),
        array("胡亥"),
        array("章邯"),
        array("项梁"),
        array("项羽"),
        array("陈胜"),
        array("吴广"),
        array("子婴"),
        array("刘邦"),
        array("田荣"),
        array("陈婴"),
        array("英布"),
        array("范增"),
        array("张良"),
        array("萧何"),
        array("韩信"),
        array("英布"),
        array("彭越"),
        array("李左车"),
        array("郦食其"),
        array("蒯通"),
        array("龙且"),
        array("灌婴"),
        array("吕后"),
        array("周勃"),
        array("陈平"),
        array("汉文帝"),
        array("汉景帝"),
        array("晁错"),
        array("周亚夫"),
        array("刘濞"),
        array("汉武帝"),
        array("主父偃"),
        array("卫青"),
        array("霍去病"),
        array("董仲舒"),
        array("汉昭帝"),
        array("霍光"),
        array("汉宣帝"),
        array("汉元帝"),
        array("申屠圣"),
        array("徒苏令"),
        array("汉成帝"),
        array("赵飞燕"),
        array("赵过"),
        array("氾胜之"),
        array("孔仅"),
        array("东郭咸阳"),
        array("桑弘羊"),
        array("王凤"),
        array("王莽"),
        array("冒顿单于"),
        array("张骞"),
        array("张汤"),
        array("光武帝"),
        array("窦固"),
        array("窦宪"),
        array("班超"),
        array("汉明帝"),
        array("邓骘"),
        array("汉顺帝"),
        array("梁冀"),
        array("汉桓帝"),
        array("汉灵帝"),
        array("何进"),
        array("袁绍"),
        array("董卓"),
        array("张让"),
        array("汉献帝"),
        array("王允"),
        array("吕布"),
        array("李傕"),
        array("郭汜"),
        array("曹操"),
        array("张既"),
        array("崔实"),
        array("蔡伦"),
        array("张衡"),
        array("张仲景"),
        array("华佗"),
        array("张角"),
        array("孙权"),
        array("刘备"),
        array("刘禅"),
        array("诸葛亮"),
        array("关羽"),
        array("张飞"),
        array("司马昭"),
        array("司马炎"),
        array("刘焉"),
        array("陈寿"),
        array("皇甫嵩"),
        array("卢植"),
        array("朱儁"),
        array("张鲁"),
        array("丁原"),
        array("桥瑁"),
        array("孙坚"),
        array("王允"),
        array("贾诩"),
        array("马腾"),
        array("韩遂"),
        array("刘表"),
        array("张绣"),
        array("张济"),
        array("孙策"),
        array("袁术"),
        array("刘璋"),
        array("公孙瓒"),
        array("陶谦"),
        array("公孙度"),
        array("士燮"),
        array("陈登"),
        array("袁尚"),
        array("袁谭"),
        array("袁熙"),
        array("公孙康"),
        array("周瑜"),
        array("张昭"),
        array("曹仁"),
        array("鲁肃"),
        array("庞统"),
        array("黄忠"),
        array("魏延"),
        array("李严"),
        array("赵云"),
        array("张任"),
        array("马超"),
        array("夏侯渊"),
        array("张郃"),
        array("吕蒙"),
        array("李典"),
        array("陆逊"),
        array("司马懿"),
        array("杨仪"),
        array("姜維"),
        array("顾雍"),
        array("诸葛恪"),
        array("孙亮"),
        array("孙峻"),
        array("锺会"),
        array("邓艾"),
        array("羊祜"),
        
   
 ),
    array
    (
        // 中国隋唐五代
        array("隋文帝"),
        array("武则天"),
    ),
    array
    (
        // 中国宋辽夏金元
        array("和珅"),
    ),
    array
    (
        // 中国明清
    ),
    array
    (
        // 中国晚晴民国
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
        // 中国现代
        array("马英九"),
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
            return "科学";
        case 2:
            return "文学";
        case 3:
            return "艺术体育";
        case 4:
            return "人文思想";
        case 5:
            return "宗教";
        case 6:
            return "工商界";
        case 7:
            return "政治人物";
        case 8:
            return "中国先秦";
        case 9:
            return "中国秦汉晋南北朝";
        case 10:
            return "中国隋唐五代";
        case 11:
            return "中国宋辽夏金元";
        case 12:
            return "中国明清";
        case 13:
            return "中国晚晴民国";
        case 14:
            return "中国现代";
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
        for ($jj = get_small_person_begin($ii); $jj <= get_small_person_end($ii); $jj++)
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