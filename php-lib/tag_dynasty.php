<?php
// created by duangan, 2015-4-19 -->
// support dynasty deal function.    -->

$dynasty_big = array
(
    "中国文明遗址",
    "正朔朝代",
    "春秋战国列国",
    "地方政权",
    "周边少数民族",
    "官制",
    "组织",
    "重大事件",
    "政治问题",
    "大城市",
    "省份",
    "山河湖海",
    "其它"
);

// 朝代数组
$dynasty = array
(
    array
    (
        // 中国文明遗址
        array("磁山文化"),
        array("仰韶文化"),
        array("红山文化"),
        array("龙山文化"),
        array("大汶口文化"),
        array("二里头文化"),
        array("河姆渡文化"),
        array("三星堆文化"),
        array("良渚文化"),
        // array("盘龙城遗址"),
        array("玉文化", "super", "multe-key", "玉器"),
        array("陶瓷文化", "super", "multe-key", "陶", "瓷"),
        array("丝绸文化", "super", "multe-key", "丝绸", "丝绸之路"),
        array("茶文化", "super", "multe-key", "茶"),
    ),
    array
    (
        // 正朔朝代
        array("中国"),
        
        array("夏朝", "normal", "tag-time", "中国", "-2070", "-1600"),
        array("商朝", "normal", "tag-time", "中国", "-1600", "-1046"),
        array("周朝", "super", "tag-time", "中国", "-1046", "-770"),
        array("东周", "super", "tag-time", "中国", "-770", "-221"),
        array("秦朝", "normal", "tag-time", "中国", "-221", "-206"),
        array("汉朝", "super", "tag-time", "中国", "-206", "8"),
        array("新朝", "normal", "tag-time", "中国", "8", "24"),
        array("东汉", "normal", "tag-time", "中国", "24", "220"),
        array("三国", "normal", "tag-time", "中国", "220", "280"),
        array("西晋", "normal", "tag-time", "中国", "280", "316"),
        array("东晋", "normal", "tag-time", "中国", "316", "420"),
        array("南北朝", "normal", "tag-time", "中国", "420", "581"),
        array("隋朝", "normal", "tag-time", "中国", "581", "618"),
        array("唐朝", "super", "tag-time", "中国", "618", "907"),
        array("五代十国", "normal", "tag-time", "中国", "907", "960"),
        array("宋朝", "super", "tag-time", "中国", "960", "1127"),
        array("南宋", "normal", "tag-time", "中国", "1127", "1279"),
        array("元朝", "normal", "tag-time", "中国", "1279", "1368"),
        array("明朝", "normal", "tag-time", "中国", "1368", "1644"),
        array("清朝", "normal", "tag-time", "中国", "1644", "1912"),
        array("中华民国", "super", "tag-time", "中国", "1911", "1949"),
        array("中华人民共和国", "super", "tag-time", "中国", "1949", "2100"),
        array("台湾", "super", "multe-key", "台北", "高雄", "台南", "台中", "蒋经国", "李登辉", 
            "陈水扁", "马英九", "连战", "宋楚瑜", "蔡英文"),
        array("香港", "super", "multe-key", "香港岛", "九龙", "新界", "特首", "行政长官", "立法会"),
    ),
    array
    (
        // 春秋战国列国
        array("鲁国"),
        array("齐国"),
        array("田齐"),
        array("晋国"),
        array("曲沃"),
        array("秦国"),
        array("楚国"),
        array("燕国"),
        array("宋国"),
        array("卫国"),
        array("陈国"),
        array("蔡国"),
        array("曹国"),
        array("郑国"),
        array("吴国"),
        array("越国"),
        array("杞国"),
        array("赵国"),
        array("魏国"),
        array("韩国", "normal", "key-time", "韩国", "-700", "200"),
        array("其它候国", "normal", "key-time", "中山国", "蜀国", "巴国", "郕国", "邓国", "虢国", 
                "霍国", "滑国", "罗国", "莒国", "随国", "许国", "虞国", "-700", "200"),
    ),
    array
    (
        // 地方政权
        array("辽东郡"),
        array("乐浪郡"),
        array("前赵"),
        array("成汉"),
        array("前凉"),
        array("后赵"),
        array("前燕"),
        array("前秦"),
        array("后燕"),
        array("后秦"),
        array("西秦"),
        array("后凉"),
        array("南凉"),
        array("南燕"),
        array("西凉"),
        array("北凉"),
        array("胡夏"),
        array("北燕"),
        array("前仇池"),
        array("后仇池"),
        array("邓至"),
        array("冉魏"),
        array("谯蜀"),
        array("桓楚"),
        array("翟魏"),
        array("西燕"),
        array("宇文部"),
        array("段部"),
        array("北魏", "normal", "key-time", "拓跋代", "代国", "258", "534"),
        array("东魏"),
        array("西魏"),
        array("北齐"),
        array("北周"),
        array("南朝宋"),
        array("南朝齐"),
        array("南朝梁"),
        array("南朝陈"),
        array("辽"),
        array("西夏"),
        array("金国"),
        array("后梁"),
        array("后唐"),
        array("后晋"),
        array("后汉"),
        array("后周"),
        array("南唐"),
        array("吴越"),
        array("闽"),
        array("北汉"),
        array("前蜀"),
        array("后蜀"),
        array("荆南"),
        array("南楚"),
        array("南汉"),
        array("中华苏维埃共和国"),
        array("伪满洲国"),
    ),
    array
    (
        // 周边少数民族
        // 和中原有重大纠葛的
        
        // 东北
        array("鲜卑"),
        array("东胡"),
        array("乌桓"),
        array("吐谷浑"),
        array("柔然"),
        array("契丹"),
        array("室韦"),
        array("蒙古"),
        array("准噶尔汗国"),
        array("女真"),
        array("满族"),
        
        array("濊貊"),
        array("扶余"),
        array("沃沮"),
        array("高句丽"),
        array("古朝鲜", "normal", "multe-key", "弁韩", "马韩", "辰韩", "百济", "新罗", "高丽"),
        
        array("粛慎"),
        
        // 北方
        array("匈奴"),
        array("羯"),
        array("氐"),
        array("鞑靼"),
        
        array("敕勒", "normal", "multe-key", "铁勒", "丁零", "高车"),
        array("回纥"),
        array("维吾尔人"),
        
        // 突厥民族
        array("突厥"),
        array("沙陀"),
        
        // 西方
        array("戎"),
        array("羌"),
        array("党项"),
        array("吐蕃"),
        
        // 南方
        array("苗人"),
        array("壮人"),
        array("黎人"),
        
        // 西域
        array("月氏"),
        array("贵霜帝国"),
        array("乌孙"),
        array("鄯善", "normal", "multe-key", "楼兰"),
        array("车师"),
        array("高昌"),
        array("疏勒"),
        array("于阗"),
        array("龟玆"),
        array("焉耆"),
        
    ),
    array
    (
        // 官制
        // "共和"、"自治" 不宜做关键字。
        array("中央和地方关系", "super", "multe-key", "封建", "郡县", "集权", "分权", "分封", "行省", 
            "推恩令", "单一制", "联邦制"),
        array("宰相", "super", "key-time", "宰相", "丞相", "相国", "大学士", "三公", "九卿", "中书省", "尚书省", 
            "门下省", "尚书台", "司马", "司徒", "司空", "太傅", "太师", "太保", "令尹", "仆射", "平章事", 
            "参知政事", "首辅", "次辅", "内阁学士", "军机处", "-1500", "1911"),
        array("六部", "normal", "key-time", "尚书", "侍郎", "吏部", "户部", "礼部", "兵部", "刑部", "工部", "台阁", 
            "治粟内史", "太农令", "大司农", "司农寺", "运使司", "铁盐使司", "度支使司", "国子监", "-1500", "1911"),
        array("司法监察", "normal", "key-time", "御史大夫", "廷尉", "御史台", "大理寺", "都察院", "审刑院", 
            "监察", "司法", "-1500", "1911"),
        array("军制", "super", "key-time", "兵制", "征兵", "募兵", "世兵", "军屯", "团练", "蕃兵", 
            "边军", "府兵", "义从", "禁兵", "卫所", "八旗", "绿营", "虎符", 
            "太尉", "大都督府", "五军都督府", "都指挥使", "大将军", "骠骑将军", "车骑将军", "卫将军", 
            "前后左右将军", "上柱国", "枢密院", "都指挥司", "校尉", "执金吾", "虎贲中郎将", "羽林中郎将",
            "都尉", "观军容使", "折冲府", "节度使", "千户", "百户", "总兵", "参将", "游击", "都司", "守备", 
            "牛录", "甲喇", "固山", "都统", "-1500", "1911"),
        // "宗正" 不宜为关键字。
        array("大内", "normal", "key-time", "奉常", "郎中令", "少府", "卫尉",  "太仆", "太常", "太监", "宫女", 
            "中大夫令", "光禄勋", "太府", "太常寺", "光禄寺", "卫尉寺", "太仆寺", "宗人府", "内务府", "詹事府",
            "锦衣卫", "东厂", "西厂", "内厂", "宦官", "-1500", "1911"),
        array("地方官", "normal", "key-time", "诸候", "郡守", "县令", "县长", "刺史", "州牧", "通判", "行省", 
            "达鲁花赤", "里长", "布政司", "布政使", "按察司", "总督", "巡抚", "镇守", "-1500", "1911"),
        array("边臣", "normal", "key-time", "典客", "大行令", "大鸿胪", "鸿胪寺", "西域都护", "宣慰司", 
            "土司", "理藩院", "-1500", "1911"),
        array("世卿世禄制", "normal", "key-time", "世卿世禄", "世袭", "世职", "世官", "-1500", "1911"),
        array("军功爵制", "normal", "key-time", "军功", "斩一首爵一级", "-1500", "1911"),
        array("九品中正制", "normal", "key-time", "九品中正", "察举", "征辟", "孝廉", "-1500", "1911"),
        // "明经"、"金榜"不宜为关键字。
        array("科举制", "super", "key-time", "科举", "分科取士", "县试", "童生", "院试", "生员", 
            "秀才", "茂才", "乡试", "解试", "秋闱", "桂榜", "举人", "解元", "会试", "省试", "春闱", 
            "贡士", "会元", "殿试", "进士", "状元", "榜眼", "探花", "投牒自试", "常科", "制科", 
            "帖经", "墨义", "进士及第", "进士出身", "同进士出身", "琼林宴", "糊名", "誊录", 
            "贡院", "科场", "监生", "贡监", "荫监", "举监", "例监", "鹿鸣宴", "座师", "传胪", 
            "连中三元", "庶吉士", "翰林院", "八股文", "-1500", "1911"),
        
        array("宦官问题", "normal", "multe-key", "宦官", "太监", ""),
        array("权臣问题", "normal", "multe-key", "权臣", "篡", "自立", "弑"),
        array("外戚问题", "normal", "multe-key", "外戚"),
        array("宗室问题", "normal", "multe-key", "宗室"),
        // "部曲"不宜为关键字。
        array("奴隶问题", "normal", "multe-key", "奴隶", "奴婢", "家生子", "隶臣", "隶妾"),
    ),
    array
    (
        // 组织
        array("中国共产党", "normal", "multe-key", "中共"),
        array("中国国民党", "normal", "multe-key", "国民党", "孙中山", "蒋介石"),
        array("民主进步党", "normal", "multe-key", "民进党"),
        array("人民解放军", "normal", "multe-key", "解放军", "红军", "八路军", "新四军", 
            "中央军委", "政委"),
    ),
    array
    (
        // 重大改革
        array("商鞅变法"),
        array("王安石变法"),
        array("庆历新政"),
        array("张居正变法"),
        array("清末新政"),
        
        array("制宪国民大会"),
        array("改革开放"),
        array("台湾十大建设"),
        array("台湾民主转型"),
        
    ),
    array
    (
        // 政治问题
        array("延安整风运动"),
        array("村民自治", "super", "multe-key", "村民", "农民", "村民选举", "村民直选", "村长", "村支书"),
        array("中国官员", "normal", "multe-key", "中国官员"),
        array("拆迁", "normal", "multe-key", "强拆", "血拆", "土地征收"),

        array("司法独立", "super", "multe-key", "司法改革", "律师"),
        array("言论自由", "super", "sigle-key", "言论自由"),
        array("新闻自由", "super", "sigle-key", "新闻自由"),
        array("反腐", "normal", "multe-key", "贪污", "腐败", "腐化", "亏空"),
        array("户口"),
    ),
    array
    (
        // 大城市
        array("北京", "super", "multe-key", "北京", "蓟", "燕京", "涿郡", "幽州", "北平"), // "大都"歧义太多.
        array("上海", "super", "multe-key", "上海"),
        array("天津"),
        array("重庆", "super", "multe-key", "重庆", "渝"),
        
        array("广州", "super", "multe-key", "广州", "番禺", "任嚣城"),
        array("深圳", "super", "multe-key", "深圳"),
        array("武汉", "super", "multe-key", "武汉", "武昌", "汉口", "汉阳"),
        array("西安", "super", "multe-key", "西安", "长安", "镐京", "西京", "大兴城"),
        array("南京", "super", "multe-key", "南京", "金陵", "建康", "江宁", "石头城"),
        
        array("杭州", "normal", "multe-key", "杭州", "临安", "武林", "余杭", "杭城"),
        array("沈阳", "normal", "multe-key", "沈阳", "盛京", "奉天"),
        array("郑州", "normal", "multe-key", "郑州"),
        array("长沙", "normal", "multe-key", "长沙"),
        array("成都", "normal", "multe-key", "成都"),
        array("大连"),
        array("合肥"),
        array("青岛"),
        
        array("苏州", "normal", "multe-key", "苏州", "姑苏", "吴都", "吴中", "吴郡", "平江", "吴门"),
        array("扬州", "normal", "multe-key", "扬州", "邗江", "广陵", "江都", "维扬"),
        array("宁波"),
        array("徐州"),
        array("温州"),
        array("绍兴", "normal", "multe-key", "会稽"),
        array("哈尔滨"),
        array("长春"),
        array("开封", "normal", "multe-key", "开封", "汴梁", "汴州", "汴京", "大梁"), // "东京"歧义太多.
        array("洛阳"),
        array("澳门"),
        array("台北", "normal", "multe-key", "台北"),
        array("高雄", "normal", "multe-key", "高雄"),
        array("台南"),
        array("厦门", "normal", "multe-key", "厦门"),
        array("兰州"),
        array("乌鲁木齐"),
        array("福州"),
        array("拉萨"),
    ),
    array
    (
        // 省份
        // 东北
        array("辽宁", "normal", "multe-key", "辽宁", "沈阳", "大连", "盘锦", "鞍山", "抚顺", "本溪", "铁岭"),
        array("黑龙江", "normal", "multe-key", "黑龙江", "哈尔滨", "伊春", "牡丹江", "大庆"),
        array("吉林", "normal", "multe-key", "吉林", "长春", "四平"),
        
        // 华北
        array("河南", "normal", "multe-key", "河南", "郑州", "开封", "洛阳", "商丘", "信阳", "南阳", "许昌"),
        array("山东", "normal", "multe-key", "山东", "济南", "青岛", "潍坊", "淄博", "烟台", "临沂", ),
        array("河北", "normal", "multe-key", "河北", "石家庄", "唐山", "邯郸", "承德", "保定", "邢台", "廊坊"),
        array("内蒙古", "normal", "multe-key", "内蒙古", "呼和浩特", "呼伦贝尔", "包头", "鄂尔多斯"),
        array("山西", "normal", "multe-key", "山西", "太原", "大同", "临汾", "吕梁", "晋中"),
        
        // 华东
        array("江苏", "normal", "multe-key", "江苏", "南京", "苏州", "扬州", "徐州", "无锡", 
                "盐城", "淮安", "宿迁", "镇江", "南通"),
        array("浙江", "normal", "multe-key", "浙江", "杭州", "宁波", "温州", "绍兴", "湖州", 
                "嘉兴", "金华", "舟山"),
        array("江西", "normal", "multe-key", "江西", "赣", "南昌", "赣州", "景德镇", "九江", 
                "鹰潭", "宜春"),
        
        // 中部
        array("湖北", "normal", "multe-key", "湖北", "鄂", "武汉", "黄石", "宜昌", "鄂州", "十堰", 
                "襄樊", "荆州", "随州", "孝感", "黄冈"),
        array("湖南", "normal", "multe-key", "湖南", "长沙", "岳阳", "衡阳", "株洲", "湘潭", 
                "常德", "邵阳", "怀化"),
        array("安徽", "normal", "multe-key", "安徽", "皖", "合肥", "安庆", "徽州", "芜湖", "淮南", 
                "蚌埠", "滁州", "阜阳", "巢湖"),
        array("四川", "normal", "multe-key", "四川", "蜀", "成都", "绵阳", "乐山", "泸州"),
        
        // 华南
        array("广东", "normal", "multe-key", "广东", "粤", "广州", "深圳", "东莞", "佛山", 
                "汕头", "中山", "珠海", "肇庆", "潮州"),
        array("福建", "normal", "multe-key", "福建", "闽", "厦门", "福州", "泉州", "汕头", "莆田", "南平"),
        array("云南", "normal", "multe-key", "云南", "昆明", "玉溪", "大理", "丽江"),
        array("广西", "normal", "multe-key", "广西", "南宁", "柳州", "桂林"),
        array("贵州", "normal", "multe-key", "贵州", "黔", "贵阳", "遵义"),
        array("海南", "normal", "multe-key", "海南", "海口", "三亚", "三沙"),
        
        // 西北
        array("陕西", "normal", "multe-key", "陕西", "陕", "西安", "咸阳", "榆林", "渭南", "汉中", 
                "安康", "延安", "宝鸡"),
        array("甘肃", "normal", "multe-key", "甘肃", "兰州", "武威", "金昌", "张掖", "嘉峪关", 
                "酒泉", "陇南", "天水", "平凉"),
        array("青海", "normal", "multe-key", "青海", "西宁"),
        array("宁夏", "normal", "multe-key", "宁夏", "银川", "固原"),
        
        
        array("新疆", "super", "multe-key", "新疆", "乌鲁木齐", "且末", "库尔勒", "石河子", 
                "喀什", "克拉玛依", "西域"),
        array("西藏", "super", "multe-key", "西藏", "拉萨", "阿里", "吐蕃", "藏传佛教", "达赖", "班禅"),
    ),
    array
    (
        // 山河湖海
        array("南海"),
        array("东海"),
        array("黄海"),
        array("渤海"),
        
        array("长江", "super", "multe-key", "大江", "扬子江"),
        array("黄河"),
        array("京杭大运河", "super", "multe-key", "邗沟", "通济渠", "永济渠", "广通渠", "通惠河", 
                "江南河", "大运河"),
        array("辽河"),
        array("淮河"),
        array("珠江"),
        array("塔里木河"),
        array("雅鲁藏布江"),
        
        array("太湖", "super", "multe-key", "震泽", "具区"),
        array("鄱阳湖"),
        array("洞庭湖"),
        array("青海湖"),
        
        array("万里长城", "super", "sigle-key", "万里长城"),
        array("秦岭"),
        array("河西走廊"),
        array("长江三峡"),
        array("南岭", "normal", "multe-key", "五岭", "越城岭", "都庞岭", "萌渚岭", 
                "骑田岭", "大庾岭"),
        array("太行八径", "normal", "multe-key", "军都陉", "蒲阴陉", "飞狐陉", "井陉", "滏口陉", 
                "白陉", "太行陉", "轵关陉"),
        
        array("西域"),
        array("天山", "super", "sigle-key", "天山"),
        array("泰山", "super", "sigle-key", "泰山"),
        array("华山"),
        array("黄山"),
        array("庐山"),
    ),
    array
    (
        // other
    )
);

?>