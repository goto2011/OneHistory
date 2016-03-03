<?php
// created by duangan, 2015-5-4 -->
// support topic deal function.    -->

// 朝代 big
$topic_big = array(
    "历史",
    "史前史",
    "科学技术",
    "艺术体育",
    "宗教",
    "思想",
    "人文社会",
    "经济",
    "政治外交",
    "其它"
);

// 朝代 tag vip struct.
$topic = array
(
    array
    (
        // 历史
        array("历史学", "super", "multe-key", "历史学", "历史研究", "史学"),
        array("考古", "super", "multe-key", "考古", "碳14", "年代学"),
        array("分子遗传学", "super", "multe-key", "基因"),
        array("语言学", "super", "multe-key", "语言学", "汉藏语系", "印欧语系", "阿尔泰语系", "闪含语系", 
                "达罗毗荼语系", "高加索语系", "乌拉尔语系"),
        array("地理"),
        array("地质年代"),
        array("中国年号"),
        array("全国重点文物保护单位"),
        array("世界遗产名单"),
    ),
    array
    (
        // 史前史
        array("古人类遗址", "super", "multe-key", "古人类遗址"),
        array("人类文明遗址", "super", "multe-key", "人类文明遗址"),
        array("石器时代", "super", "multe-key", "石器时代"),
        array("青铜时代", "super", "multe-key", "青铜时代"),
        array("铁器时代", "super", "multe-key", "铁器时代"),
        array("磁山文化"),
        array("仰韶文化"),
        array("红山文化", "super", "multe-key", "红山文化"),
        array("龙山文化"),
        array("大汶口文化", "super", "multe-key", "大汶口文化"),
        array("二里头文化", "super", "multe-key", "二里头文化"),
        array("河姆渡文化", "super", "multe-key", "河姆渡文化"),
        array("三星堆文化", "super", "multe-key", "三星堆文化"),
        array("良渚文化"),
        array("盘龙城遗址", "super", "multe-key", "盘龙城遗址"),
        array("陶文化"),
        array("玉文化"),
        array("陶瓷文化"),
        array("丝绸文化"),
        array("茶文化"),
    ),
    array
    (
        // 科学技术
        array("发明创造"),
        array("天文", "super", "multe-key", "天文", "航天", "太阳", "月球", "恒星", "行星", "卫星", "火星", 
                "月食", "日食", "黑洞", "星图", "历法", "水星", "土星", "水星", "天王星", "海王星", 
                "冥王星", "彗星", "星云", "银河", "星系", "宇宙", "陨石", "航天飞机", "宇宙飞船", 
                "空间站", "望远镜", "NASA"),
        array("航空"),
        array("物理"),
        array("基因", "super", "multe-key", "基因"),
        array("生物"),
        array("环境保护"),
        array("化学"),
        array("数学-逻辑学", "normal", "multe-key", "数学", "逻辑学"),
        array("医学"),
        array("中医"),
        array("诺贝尔奖", "super", "multe-key", "诺贝尔奖"),
    ),
    array
    (
        // 艺术文化体育
        array("文学", "super", "multe-key", "文学"),
        array("小说"),
        array("音乐", "super", "multe-key", "音乐"),
        array("美术", "super", "multe-key", "美术"),
        array("雕像"),
        array("电影", "super", "multe-key", "电影"),
        array("电视剧"),
        array("书法"),
        array("体育"),
        array("奥运会", "super", "multe-key", "奥运会"),
        array("奥斯卡奖", "super", "multe-key", "奥斯卡奖"),
    ),
    array
    (
        // 宗教
        array("基督教", "super", "multe-key", "耶稣会", "多明我会", "共济会", "圣公会", "方济各会", "循道公会",
                "循道会", "教宗", "教皇", "布道会", "浸信会", "圣经会", "公理会", "长老会", "归正会", "卫理公会", 
                "殉道", "巴色会", "联合路德会", "圣经", "新约", "旧约", "基督", "耶稣", "福音", "基督教", "新教",
                "东正教", "天主教", "修女", "修士", "传教士", "受洗", "浸礼会"),
        array("东正教"),
        array("犹太教"),
        array("伊斯兰教", "super", "multe-key", "伊斯兰教", "穆斯林", "古兰经", "逊尼派", "什叶派"),
        array("佛教"),
        array("道教"),
        array("印度教"),
        array("萨满教"),
        array("其它宗教", "normal", "multe-key", "耆那教", "拜火教", "祆教", "摩尼教", "景教"),
    ),
    array
    (    
        // 思想
        array("古希腊哲学", "super", "multe-key", "希腊哲学", "普罗泰戈拉", "德谟克利特", "芝诺", "苏格拉底", "柏拉图", 
                "亚里士多德", "伊壁鸠鲁", "泰勒斯", "米利都学派"),
        array("经院哲学"),
        array("康德哲学", "super", "multe-key", "康德", "康德哲学"),
        array("经验主义", "super", "multe-key", "经验主义"),
        array("存在主义", "super", "multe-key", "存在主义"),
        array("后现代哲学"),
        array("文艺复兴"),
        array("启蒙运动"),
        
        array("儒家", "super", "multe-key", "儒家", "孔子", "孟子", "四书五经", "论语", "尚书", "中庸", 
                "周易", "荀子", "董仲舒", "程颐", "朱熹", "陆九渊", "王阳明", "朱程理学", "心学"),
        array("道家", "super", "multe-key", "道家", "老子", "庄子", "列子", "道德经", "慎到", "杨朱"),
        array("法家", "super", "key-time", "法家", "管子", "韩非子", "商鞅", "商君书", "李斯", "吴起", 
                "-500", "200"),
        array("墨家", "super", "multe-key", "墨家", "墨子"),
        array("名家", "super", "multe-key", "名家", "邓析", "公孙龙", "惠子", "惠施", "杨子"),
        array("其它中国思想", "normal", "key-time", "阴阳家", "杂家", "纵横家", "邹衍", 
                "张仪", "苏秦", "吕不韦", "吕氏春秋", "淮南子", "许行", "孙武", "司马穣苴", "孙膑", 
                "吴起", "尉缭", "魏无忌", "白起", "司马法", "-500", "200"),
        array("马克思主义", "super", "multe-key", "马克思主义", "马列主义", "马克思", "恩格斯", 
                "列宁", "斯大林"),
        array("焚书坑儒"),
    ),
    array
    (
        // 人文社会
        array("社会", "super", "multe-key", "社会"),
        array("人口", "super", "multe-key", "人口"),
        array("教育", "super", "multe-key", "教育"),
        array("同性恋", "normal", "multe-key", "同性恋"),
        array("伦理学",  "normal", "multe-key", "道德"),
        array("心理学"),
        array("经济学"),
        array("户口"),
        array("晋商"),
        array("盐商"),
    ),
    array
    (
        // 经济
        array("农业"),
        array("水利"),
        
        array("私有制", "super", "multe-key", "私有制", "民企", "私企", "私营企业", "私有企业"),
        array("公有制", "super", "multe-key", "公有制", "国企", "国有企业", "国家所有制", "集体所有制"),
        array("经济危机", "super", "multe-key", "经济危机", "金融危机", "股灾"),
        array("工业"),
        array("金融业"),
        array("IT技术"),
        array("IT行业"),
        array("手机行业"),
        array("1933年经济危机"),
    ),
    array
    (
        // 政治外交
        array("国家制度", "super", "multe-key", "国家", "政治", "福利国家", "民主", "专制", "独裁"),
        array("民主", "super", "multe-key", "民主", "选举"),
        array("宪政", "normal", "multe-key", "宪政", "宪法", "制宪"),
        array("司法独立", "super", "multe-key", "司法独立"),
        array("言论自由", "super", "multe-key", "言论自由"),
        array("新闻自由", "normal", "multe-key", "新闻自由"),
        array("反腐", "normal", "multe-key", "反腐", "腐败"),
        array("财政税收", "super", "multe-key", "财政", "税收"),
        array("法律犯罪", "normal", "multe-key", "法律", "犯罪"),
        array("国际关系"),
        array("军事"),
        array("陆军"),
        array("海军"),
        array("空军"),
        array("核武器"),
    ),
    array
    (
        // other
    )
);

?>