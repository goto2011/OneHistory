<?php
// created by duangan, 2016-02-24 -->
// support solution deal function.    -->

// 返回大的名称
$solution_big = array(
    "人与自己的关系",
    "人与自然界的关系",
    "人和他人的关系",
    
    "人与家庭的关系",
    "人和工作的关系",
    "人和社会的关系",
    
    "人和国家的关系",
    "战争相关",
    "其它"
);

// 朝代数组
$solution = array
(
    array
    (
        // 人与自己的关系
        array("死亡"),
        array("信仰"),
        array("努力"),
        array("运气"),
        array("心理治疗"),
        array("梦"),
        array("立志"),
        array("欲望"),
        array("拖延"),
        array("勇敢"),
        array("怯懦"),
        array("自尊"),
        array("忘我"),
    ),
    array
    (
        // 人与自然界的关系
        array("认知"),
        array("时空", "normal", "multe-key", "时空", "时间", "空间"),
        array("天人合一"),
        array("好奇心"),
        array("科学研究"),
    ),
    array
    (
        // 人和他人的关系
        array("仁"),
        array("义"),
        array("礼"),
        array("智"),
        array("信"),
        
        array("朋友"),
        array("老师"),
        array("同志"),
        array("陌生人"),
        array("同情", "normal", "multe-key", "同情", "恻隐之心", "同理心"),
        array("犯罪"),
        array("复仇"),
        array("欺凌"),
    ),
    array
    (
        // 人与家庭的关系
        array("夫妻关系", "super", "multe-key", "夫妻", "结婚", "婚姻", "家庭", "爱情"),
        array("情人",  "normal", "multe-key", "情人", "爱情"),
        array("父与子", "normal", "multe-key", "父子", "爸爸"),
        array("母与子", "normal", "multe-key", "母子", "妈妈"),
        array("兄弟与姐妹", "normal", "multe-key", "兄弟", "姐妹"),
        array("兄妹与姐弟", "normal", "multe-key", "兄妹", "姐弟"),
        array("祖父母"),
        array("婆媳关系"),
        array("私生子"),
        array("继子"),
        array("赘婿", "normal", "multe-key", "赘婿", "入赘"),
        array("同性恋"),
        array("其它亲人"),
    ),
    array
    (
        // 人和工作的关系
        array("老板"),
        array("上级"),
        array("下属"),
        array("同僚"),
        array("不满意的工作"),
        array("工作太慢"),
        array("工作效率低"),
    ),
    array
    (
        // 人和社会的关系
        array("如何建立信任"),
        array("秩序"),
        array("公平"),
    ),
    array
    (
        // 人和国家的关系
        array("忠诚"),
        array("建国"),
        array("统一"),
        array("分裂"),
        array("分化"),
        array("巡视"),
        array("告密"),
        array("自污"),
        array("起义", "normal", "multe-key", "起义", "叛乱", "造反"),
        array("政变"),
        array("哗变"),
        array("条约"),
        array("殖民"),
        array("奴隶"),
    ),
    array
    (
        // 战争相关
        array("快速进击"),
        array("野战"),
        array("阵地战"),
        array("攻城与守城"),
        array("斩首"),
        array("夜袭"),
        array("地道"),
        array("空袭"),
        array("海战"),
        array("以步制骑"),
        array("炮兵"),
        array("坦克与反坦克", "normal", "multe-key", "坦克", "反坦克"),
        array("以少胜多"),
    ),
    array
    (
        // other
    )
);

?>