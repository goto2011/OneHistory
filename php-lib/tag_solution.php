<?php
// created by duangan, 2016-02-24 -->
// support solution deal function.    -->

// 返回大的名称
$solution_big = array(
    "人与自己的关系",
    "人与自然界的关系",
    "人和他人的关系",
    
    "人与家庭的关系",
    "人和社会的关系",
    "其它"
);

// 朝代数组
$solution = array
(
    array
    (
        // 人与自己的关系
        array("面对死亡", "super", "multe-key", "死亡", "向死而生"),
        array("信仰"),
        array("立志"),
        array("奋斗", "super", "multe-key", "奋斗", "努力", "有为", "无为", "忘我"),
        array("命运", "normal", "multe-key", "命运", "运气"),
        array("梦"),
        array("学习", "super", "multe-key", "学习", "读书", "阅读", "推敲", "听讲", "讲课", "研究"),
        array("独处", "super", "multe-key", "独处", "谨独", "静坐"),
        array("反省", "normal", "multe-key", "反省", "三省乎己"),
        array("诚实", "normal", "multe-key", "诚实", "信用", "信任"),
        array("欲望", "normal", "multe-key", "欲望", "克制", "谨慎", "欲壑难填", 
            "淡泊", "名利", "求去", "急流勇退"),
        array("积极", "normal", "multe-key", "积极", "拖延", "消极", "执行力"),
    ),
    array
    (
        // 人与自然界的关系
        array("第一问题", "super", "multe-key", "天道", "之道", "得道", "道也", "本源", "存在", "to be"),
        array("第二问题", "super", "multe-key", "认知", "天人合一", "天人感应"),
        array("时空"),
    ),
    array
    (
        // 人和他人的关系
        // "仁"、"义"不适为关键字。
        array("善良", "super", "multe-key", "善良", "圣人", "君子", "大人", "贤人", "贤者", "仁义", "小人"),
        array("同情", "super", "multe-key", "同情", "同情", "恻隐之心", "同理心"),
        array("守礼", "super", "multe-key", "礼", "礼仪"),
        array("中庸", "normal", "multe-key", "中庸", "中道"),
        
        array("朋友", "normal", "multe-key", "朋友", "友谊"),
        array("老师", "normal", "multe-key", "老师", "教师", "为师", "尊师"),
        array("欺凌", "normal", "multe-key", "欺凌", "犯罪", "欺辱"),
        array("复仇", "normal", "multe-key", "复仇", "报复"),
    ),
    array
    (
        // 人与家庭的关系
        array("夫妻", "super", "multe-key", "夫妻", "结婚", "婚姻", "家庭", "爱情", "情人", "婆媳"),
        array("父母",  "super", "multe-key", "父母",  "孝", "父母", "父子", "母子", "父亲", "母亲", 
            "爸爸", "父亲", "妈妈", "母亲", "祖父母", "祖父", "祖母", "外祖父", "外祖母", "爷爷", "奶奶",
            "儿子", "女儿"),
        array("兄弟姐妹", "normal", "multe-key", "兄弟", "姐妹", "兄妹", "姐弟"),
        array("家族", "normal", "multe-key", "家族", "祖宗", "祖先", "先祖", "祖上", "宗祠"),
    ),
    array
    (
        // 人和社会的关系
        array("信任"),
        array("秩序"),
        array("公平"),
        
        // 人和工作的关系
        array("组织", "normal", "multe-key", "组织", "老板", "上级", "上司", "下属", "工作"),
    ),
    array
    (
        // other
    )
);

?>