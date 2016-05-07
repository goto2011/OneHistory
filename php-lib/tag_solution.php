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
        array("如何面对死亡", "super", "multe-key", "死亡"),
        array("为什么要有信仰", "super", "multe-key", "信仰"),
        array("如何立志", "super", "multe-key", "立志"),
        array("要不要努力", "super", "multe-key", "努力", "奋斗", "有为", "无为", "忘我"),
        array("运气是什么", "normal", "multe-key", "运气"),
        array("梦是什么", "normal", "multe-key", "梦"),
        array("如何读书", "super", "multe-key", "读书", "学习", "阅读"),
        array("如何独处", "super", "multe-key", "独处", "谨独", "静坐"),
        array("如何反省", "normal", "multe-key", "反省", "三省乎己"),
        array("如何做个美人", "normal", "multe-key", "美人", "美女", "佳人", "丽人"),
        array("为什么诚实", "normal", "multe-key", "诚实", "信"),
        array("如何克制欲望", "normal", "multe-key", "克制", "欲望"),
        array("如何战胜拖延", "normal", "multe-key", "拖延"),
        array("淡泊名利", "normal", "multe-key", "淡泊名利", "求去", "急流勇退"),
    ),
    array
    (
        // 人与自然界的关系
        array("世界的本源是什么", "super", "multe-key", "天道", "之道", "得道", "道也"),
        array("我们能不能认识世界", "super", "multe-key", "认知", "天人合一", "天人感应"),
        array("时空是什么", "normal", "multe-key", "时空", "时间", "空间"),
    ),
    array
    (
        // 人和他人的关系
        array("为什么要善良", "super", "multe-key", "圣人", "君子", "大人", "贤人", "贤者", "仁", "义", "小人"),
        array("为何同情", "super", "multe-key", "同情", "恻隐之心", "同理心"),
        array("如何守礼", "super", "multe-key", "礼", "礼仪"),
        array("如何中庸", "normal", "multe-key", "中庸", "中道"),
        
        array("如何和朋友相处", "normal", "multe-key", "朋友", "友谊"),
        array("如何向老师学习", "normal", "multe-key", "老师", "教师", "为师"),
        array("如何对付欺凌", "normal", "multe-key", "犯罪", "欺凌", "欺辱"),
        array("如何复仇", "normal", "multe-key", "复仇", "报复"),
    ),
    array
    (
        // 人与家庭的关系
        array("如何处理夫妻关系", "super", "multe-key", "夫妻", "结婚", "婚姻", "家庭", "爱情", "情人", "婆媳"),
        array("如何处理父母的关系",  "super", "multe-key", "孝", "父母", "父子", "母子", "父亲", "母亲", 
            "爸爸", "父亲", "妈妈", "母亲", "祖父母", "祖父", "祖母", "外祖父", "外祖母"),
        array("如何处理兄弟姐妹的关系", "normal", "multe-key", "兄弟", "姐妹", "兄妹", "姐弟"),
        array("家族关系", "normal", "multe-key", "家族", "祖宗", "祖先", "先祖", "祖上", "宗祠"),
    ),
    array
    (
        // 人和社会的关系
        array("如何获取信任", "super", "multe-key", "信任"),
        array("如何建立秩序", "super", "multe-key", "秩序"),
        array("公平"),
        
        // 人和工作的关系
        array("如何处理和上级的关系", "normal", "multe-key", "老板", "上级"),
        array("如何管理下属", "normal", "multe-key", "下属"),
        array("如何换工作", "normal", "multe-key", "找工作", "换工作"),
        array("如何提高工作效率", "normal", "multe-key", "高效"),
    ),
    array
    (
        // 人和国家的关系
        array("如何换太子", "super", "multe-key", "废立", "立太子", "废太子", "废储", 
            "册封", "继承大统", "皇储", "立储"),
        array("中央和地方关系", "super", "multe-key", "封建", "郡县", "集权", "分权", "共和", "分封", "行省", 
            "推恩令", "单一制", "联邦制", "自治"),
        array("官制", "super", "multe-key", "宰相"),
        array("奴隶问题", "super", "multe-key", "奴隶", "奴婢", "家生子", "隶臣", "隶妾"),
        array("宦官问题", "super", "multe-key", "宦官"),
        array("权臣问题", "super", "multe-key", "权臣"),
        array("外戚问题", "super", "multe-key", "外戚"),
        array("宗室问题", "super", "multe-key", "宗室"),
        
        array("如何争霸", "normal", "multe-key", "争霸", "霸道", "称霸", "霸王"),
        array("如何巩固统一", "normal", "multe-key", "统一", "一统"),
        array("如何分裂", "normal", "multe-key", "分裂"),
        array("如何分化百官", "normal", "multe-key", "党争"),
        array("如何巡视百官", "super", "multe-key", "巡视", "监督", "按察"),
        array("如何告密", "normal", "multe-key", "告密"),
        array("如何自污", "normal", "multe-key", "自污"),
        array("如何组织起义", "normal", "multe-key", "起义", "叛乱", "造反"),
        array("如何组织政变", "normal", "multe-key", "政变"),
        array("如何制订条约", "normal", "multe-key", "条约"),
        array("如何向外殖民", "normal", "multe-key", "殖民", "垦荒", "征服"),
    ),
    array
    (
        // 战争相关
        array("如何练兵", "super", "multe-key", "练兵"),
        array("如何攻城", "super", "multe-key", "攻城"),
        array("如何守城", "super", "multe-key", "守城"),
        array("如何斩首", "normal", "multe-key", "斩首"),
        array("如何以步制骑", "super", "multe-key", "以步制骑"),
        array("如何偷袭", "normal", "multe-key", "偷袭", "夜袭"),
        array("如何地道战", "normal", "multe-key", "地道战"),
        array("如何空袭", "normal", "multe-key", "空袭"),
        array("如何海战", "normal", "multe-key", "海战"),
        array("如何使用炮兵", "normal", "multe-key", "炮兵"),
        array("如何使用坦克与反坦克", "normal", "multe-key", "坦克", "反坦克"),
        array("如何以少胜多", "normal", "multe-key", "以少胜多"),
        array("哗变", "normal", "multe-key", "营啸", "炸营", "兵谏", "兵变"),
    ),
    array
    (
        // other
    )
);

?>