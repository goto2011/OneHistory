<?php
// created by duangan, 2016-01-10 -->
// support die deal function.    -->

$die_big = array
(
    "武器",
    "军事制度",
    "战法",
    "骑兵",
    "骑马民族",
    "战争",
    "非正常死亡",
    "其它",
);

// 关键事件数组
$die = array
(
    array
    (
        // 武器
        array("刀剑", "super", "multe-key", "刀", "铁剑", "铜剑", "宝剑", "匕首", "长矛", 
            "长枪", "横刀", "环首刀", "戟", "狼牙棒", "马刀", "槊", "标枪", "战斧"),
        array("弓", "super", "multe-key", "弓", "弩"),
        array("盾牌铠甲", "super", "multe-key", "盾牌", "圆盾", "木盾", "方盾", "铠甲", "皮甲", 
            "铁铠", "札甲", "鱼鳞甲", "大铠", "胄", "黑光铠", "明光铠", "两当铠", "山文甲", 
            "锁予甲", "锁子甲", "步人甲", "铁甲", "棉袄甲"),
        array("枪"),
        array("炮"),
        array("坦克", "super", "multe-key", "坦克", "装甲车", "战车"),
        array("导弹", "super", "multe-key", "导弹", "反导"),
        array("飞机", "super", "multe-key", "飞机", "战斗机", "轰炸机", "歼击机", "预警机", "客机", 
            "直升机", "大飞机", "舰载机", "战机"),
        array("军舰", "super", "multe-key", "军舰", "铁甲舰", "炮艇", "巡洋舰", "炮舰", "潜艇", "军舰", 
            "护卫舰", "鱼雷艇", "战船", "战列舰", "登陆舰", "鱼雷", "深水炸弹"),
        array("驱逐舰", "super", "multe-key", "驱逐舰", "垂直发射"),
        array("航空母舰", "super", "multe-key", "航空母舰", "航母"),
        array("生化武器", "normal", "multe-key", "生化武器", "生物武器", "化学武器", "毒气", 
            "大规模杀伤性武器"),
        array("核武器", "super", "multe-key", "核武器", "核武", "原子弹", "氢弹", "中子弹", 
            "大规模杀伤性武器", "核子武器", "核能", "核动力"),
    ),
    array
    (
        // 军事制度
        array("军事", "normal", "multe-key", "国防", "军事合作", "武器禁运", "军事合作", "军费", "军事禁运",  
            "军事设施", "军事能力", "军事转型", "军事装备", "军事热线", "军事审判", "军事协议",
            "军事一体化", "军事现代化", "军事组织", "军事学说", "战争史", "部队", "情报", "军购", 
            "武器计划", "武器制造", "军事准则", "军事援助", "军援", "军事外交", "军民", "官兵", "士兵", 
            "军转民", "军事计划"),
            
        array("征兵", "normal", "multe-key", "兵制", "征兵", "募兵", "世兵", "军屯", "团练", "蕃兵", 
            "边军", "府兵", "义从", "禁兵", "卫所", "八旗", "绿营", "藩镇", "从军", "徵兵", 
            "志愿兵", "义务兵", "兵役", "动员令", "佣兵", "战时动员", "预备役", "现役"),
            
        array("军制", "super", "multe-key", "都督", "节度使", "镇守使", "经略使", "采访使", "防御使", 
            "太尉", "大都督府", "五军都督府", "都指挥使", "大将军", "骠骑将军", "车骑将军", "卫将军",  
            "前后左右将军", "上柱国", "枢密院", "都指挥司", "校尉", "执金吾", "虎贲中郎将", "羽林中郎将",
            "都尉", "观军容使", "折冲府", "千户", "百户", "总兵", "参将", "游击", "都司", "守备", "猛安谋克", 
            "牛录", "甲喇", "固山", "都统", "虎符", "观军容使", "监军", "总督", "指挥部", "指挥官", "司令官", 
            "军委", "军事委员会", "国防部", "参谋长", "军事家", "军事会谈", "军事会晤", "军事组织", "司令部", 
            "将军", "元帅", "大将", "上将", "中将", "少将", "准将", "大校", "上校", "中校", "少校", "大尉",
            "上尉", "中尉", "少尉", "上士", "中士", "下士", "列兵", "志愿兵", "士官", "军制", "兵制", 
            "军区", "战区", "总参", "总政", "总装", "军事顾问", "武官"),
            
        array("总体战"),
        
        array("训练", "super", "multe-key", "军事演习", "军训", "阅兵", "军演", "空军基地", 
            "海军基地", "兵棋推演", "实战演习"),
            
        array("后勤", "super", "multe-key", "后勤", "军事基地", "军基地", "军用物资", "军事供给", "军事货物"),
        
        array("陆军", "super", "multe-key", "陆军", "机械化部队"),
        array("海军"),
        array("空军"),
    ),
    array
    (
        // 战法
        array("机动性"),
        array("兵力组合"),
        array("战场部署"),
        array("攻城守城", "super", "multe-key", "攻城", "守城", "围城", "城堡", "防御工事", "城墙", 
            "壕沟", "护城河", "城门", "云梯", "攻城塔", "围攻", "要塞", "坑道", "投石机", "冲撞车", 
            "攻城锥", "攻城车", "投石车", "努车", "抛石机", "蚁附", "轒辒", "巢车", "望楼", "云楼", 
            "马面", "棱堡", "墨守", "瓮城", "墩台", "城壕", "羊马墙", "敌楼", "檑木", "狼牙拍", "飞钩",
            "箭塔", "城垛", "吊桥", "主城", "星形要塞"),
        array("战略", "super", "multe-key", "战略", "陆权", "海权", "制空权"),
    ),
    array
    (
        // 骑兵
        array("马匹", "super", "multe-key", "马匹", "马种", "马政", "养马", "普氏野马", "牧马", "官马", 
            "骥", "大宛马", "蒙古马", "哈萨克马", "河曲马", "西南马", "三河马", "伊犁马", "山丹马", 
            "荷兰温血马", "柏布马", "野马", "始祖马", "渐新马", "上新马", "真马", "马类", "三门马", 
            "三趾马", "骏马", "相马", "驹", "汗血马", "天马", "骒", "驹", "骟", "骠", "骝", "骃", "骅", 
            "骊", "騧", "骐", "骓", "骢", "龙马", "骥", "牧监"),
            
        array("马具", "super", "multe-key", "马具", "马镫", "马鞍", "笼头", "衔铁", "马衣",
            "低头革", "缰绳", "马靴", "马裤", "马鞭", "套马杆"),
            
        array("骑兵战法", "super", "multe-key", "骑兵战法", "轻骑兵", "重骑兵", "拐子马", "铁鹞子", 
            "步骑协同", "骑射", "回马箭", "重装骑兵", "重装甲骑兵", "铁浮屠", "锁子马", "扈从", 
            "枪骑兵", "龙骑兵", "斥候"),
            
        array("以步制骑", "super", "multe-key", "以步制骑", "平戎万全阵", "步兵方阵", "车营", 
            "拒马枪", "陷马坑", "鹿角木", "蒺藜"),
    ),
    array
    (
        // 骑马民族
        array("骑马民族", "super"),
        // 骑马民族早期：史前至汉武帝时期的匈奴
        array("骑马民族早期", "normal", "tag-time", "骑马民族", "-6000", "-87"),
        // 骑马民族中期：匈奴之后、蒙古之前
        array("骑马民族中期", "normal", "tag-time", "骑马民族", "-86", "1162"),
        // 骑马民族晚期：蒙古至满洲
        array("骑马民族晚期", "normal", "tag-time", "骑马民族", "1163", "2100"),
        
        array("内亚", "super", "multe-key", "内亚", "阿姆河", "锡尔河", "咸海", 
            "普什图人", "高加索", "呼罗珊", "单于", "丝绸之路", "丝路", "花刺子模"),
    ),
    array
    (
        // 战争
        // "战争" 有几个关键字, 需要手动整理: 伐/击/大败/灭.
        array("战争", "super", "multe-key", "战役", "大战", "内战", "之战", "之役", "攻", "军事行动",
            "侵略", "入侵", "先发制人", "军事占领", "军事化", "军事冲突", "维和", "战争", 
            "海盗", "军事打击", "枪战", "炮战", "军事手段", "军事危机", "军事干预", "禁飞区", 
            "军事手段", "撤军"),

        array("第一次世界大战", "super", "key-time", "第一次世界大战", "战争", "一战", "1914", "1918"),
        array("第二次世界大战", "super", "key-time", "第二次世界大战", "战争", "二战", "抗战", 
            "抗日战争", "纳粹", "法西斯", "希特勒", "墨索里尼", "慰安妇", "东条英机", "1931", "1945"),
        array("抗美援朝", "super", "multe-key", "抗美援朝", "志愿军", "朝鲜停战协定", "金日成", 
            "李承晚", "统一半岛", "联合国军", "仁川登陆", "跨过鸭绿江", "三八线"),
                
        // 政治冲突
        // "国内冲突" 有几个关键字, 需要手动整理: 革命/杀.
        array("国内冲突", "normal", "multe-key", "冲突", "事变", "起事", "之变", "之乱", "危机", 
                "政变", "兵变", "民变", "篡弑", "阴谋", "造反", "叛乱", "骚动", "抗争", "纠纷"),
        array("哗变", "normal", "multe-key", "哗变", "营啸", "炸营", "兵谏", "兵变", "乱兵", 
            "败兵"),
    ),
    array
    (
        array("非正常死亡", "super", "multe-key", "非正常死亡", "意外死亡"),
        
        // 屠杀
        array("屠杀", "super", "multe-key", "屠杀", "种族灭绝"),
        array("恐怖主义", "super", "multe-key", "恐怖主义", "恐怖分子", "拉登", "扎卡维", "基地组织", 
            "穆斯林兄弟会", "穆兄会", "ISIS", "伊斯兰国", "达伊沙", "巴格达迪", "东突", "圣战", "极端势力",
            "极端组织", "原教旨", "盖达组织"),
        array("大清洗", "super", "multe-key", "大清洗", "斯大林", "苏联肃反运动", "大整肃", "大恐怖时期", 
            "索契", "克格勃"),
        array("纳粹大屠杀", "super", "multe-key", "纳粹大屠杀", "集中营", "奥斯维辛", "毒气室", 
            "死亡火车", "灭绝营"),
        array("南京大屠杀"),
        array("红色高棉"),
        array("九一一事件"),
        array("卢旺达种族大屠杀"),
        
        // 非正常死亡
        array("地震"),
        array("水灾"),
        array("火灾"),
        array("空难"),
        array("矿难"),
        array("交通事故"),
        array("病疫", "normal", "multe-key", "病疫", "瘟疫", "疫疠", "时疫", "非典", "鼠疫", "天花", 
            "埃博拉病毒", "疟疾", "艾滋病", "癌", "肺结核", "心脑血管", "狂犬病", "流感", "登革热"),
        array("欧洲黑死病"),
        array("自杀", "normal", "multe-key", "自杀", "自尽", "自缢", "自裁"),
        array("谋杀"),
        array("死刑"),
        
        // 饥荒
        array("饥荒", "super", "multe-key", "饥荒", "人相食"),
        array("乌克兰大饥荒"),
        array("爱尔兰大饥荒"),
        
    ),
    array
    (
        // other
    )
);

?>