<?php
// created by duangan, 2016-01-10 -->
// support die deal function.    -->

$die_big = array
(
    "战争",
    "中国农民起义",
    "政治冲突",
    "屠杀",
    "饥荒",
    "非正常死亡",
    "其它",
);

// 关键事件数组
$die = array
(
    array
    (
        // 战争
        // "战争" 有几个关键字, 需要手动整理: 伐/击/大败/灭.
        array("战争", "super", "multe-key", "战役", "大战", "内战", "之战", "之役", "攻"),

        array("第一次世界大战", "super", "key-time", "战争", "一战", "1914", "1918"),
        array("第二次世界大战", "super", "key-time", "战争", "二战", "抗战", "抗日战争", 
                "1931", "1945"),
    ),
    array
    (
        // 中国农民起义
        array("中国农民起义"),
        array("陈胜吴广起义"),
        array("黄巾军起义"),
        array("黄巢起义"),
        array("太平天国"),
        array("义和团"),
    ),
    array
    (
        // 政治冲突
        // "国内冲突" 有几个关键字, 需要手动整理: 革命/杀.
        array("国内冲突", "normal", "multe-key", "冲突", "事变", "起事", "之变", "之乱", "危机", 
                "政变", "兵变", "民变", "篡弑", "阴谋", "造反", "叛乱", "骚动", "抗争", "纠纷"),
        array("大臣杀皇帝"),
        array("皇帝杀大臣"),
        
        array("党锢之祸"),
        array("永嘉之祸"),
        array("侯景之乱"),
        array("玄武门之变"),
        array("甘露之变"),
        array("白马之祸"),
        array("美丽岛事件"),
    ),
    array
    (
        // 屠杀
        array("屠杀", "super", "multe-key", "种族灭绝"),
        array("南京大屠杀"),
        array("二二八事件"),
        array("三反五反"),
        array("土地改革"),
        array("反右派"),
        array("文化大革命"),
        array("斯大林大清洗"),
        array("纳粹大屠杀"),
        array("红色高棉"),
        array("九一一事件"),
    ),
    array
    (
        // 饥荒
        array("饥荒", "super", "multe-key", "饥荒", "人相食"),
        array("新中国大饥荒"),
    ),
    array
    (
        // 非正常死亡
        array("非正常死亡"),
        array("地震"),
        array("水灾"),
        array("火灾"),
        array("空难"),
        array("矿难"),
        array("交通事故"),
        array("病疫"),
        array("欧洲黑死病"),
        array("自杀", "normal", "multe-key", "自尽", "自缢", "自裁"),
        array("谋杀"),
        array("死刑"),
    ),
    array
    (
        // other
    )
);

?>