<?php
// created by duangan, 2015-4-19 -->
// support dynasty deal function.    -->

$dynasty_big = array
(
    "正朔朝代",
    "东周列国",
    "少数民族和地方政权",
    "古代政治",
    "现代政治",
    "中国共产党",
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
        // 正朔朝代
        array("中国", "super"),
        array("中国年号", "normal"),
        array("全国重点文物保护单位"),
        
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
        array("台湾", "super", "multe-key", "台湾", "台北", "高雄", "台南", "台中", "蒋经国", "李登辉", 
            "陈水扁", "马英九", "连战", "宋楚瑜", "蔡英文"),
        array("香港", "super", "multe-key", "香港", "香港岛", "九龙", "新界", "特首", "行政长官", "立法会"),
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
        array("其它侯国", "normal", "key-time", "中山国", "蜀国", "巴国", "郕国", "邓国", "虢国", 
                "霍国", "滑国", "罗国", "莒国", "随国", "许国", "虞国", "-700", "200"),
    ),
    array
    (
        // 少数民族和地方政权
        array("戎"),
        array("匈奴", "super", "multe-key", "匈奴", "刘渊", "刘曜", "刘聪", "前赵", "汉赵", "赫连勃勃", "胡夏", 
                "北凉", "沮渠"),
        array("突厥"),
        array("氐", "super", "multe-key", "氐", "前秦", "苻洪", "苻健", "苻坚", "苻丕", "苻登",
                "王猛", "前仇池", "后仇池", "武都国", "武兴国", "阴平国", "后凉", "吕光"),
        array("前秦", "super", "multe-key", "前秦", "苻洪", "苻健", "苻坚", "苻丕", "苻登", "王猛"),
        array("成汉", "normal", "multe-key", "成汉", "李特", "李雄", "李寿"),
        array("羯", "normal", "multe-key", "羯", "后赵", "石勒", "石虎"),
        array("沙陀", "super", "multe-key", "沙陀", "后唐", "李国昌", "李克用", "李存勖", "李嗣源", "李从珂", 
                "后晋", "石敬瑭", "后汉", "刘知远", "北汉", "刘崇", "刘继元"),
        
        array("东胡"),
        array("乌桓"),
        array("鲜卑", "super", "multe-key", "鲜卑", "前燕", "后燕", "西燕", "南燕", "北燕", "段部", 
                "慕容部", "宇文部", "慕容皝", "慕容垂", "慕容恪", "慕容冲", "拓跋部", "北魏", "东魏", 
                "西魏", "拓跋圭", "拓跋珪", "乞伏部", "乞伏国仁", "西秦", "秃发氏", "秃发乌孤", "南凉", 
                "北周", "宇文泰", "宇文护", "宇文觉", "宇文邕"),
        array("吐谷浑"),
        array("柔然"),
        array("辽朝", "super", "multe-key", "契丹", "辽朝", "大辽", "耶律阿保机", "辽太祖", "耶律德光",
            "辽太宗", "天祚帝", "耶律大石", "西辽", "后西辽"),
        array("蒙古", "super", "key-time", "蒙古", "室韦", "蒙兀", "成吉思汗", "铁木真", "忽里勒台", 
            "忽必烈", "托雷", "阿里不哥", "术赤", "察合台", "窝阔台", "旭烈兀", "贵由", "海迷失", 
            "蒙哥", "兀鲁思", "钦察汗国", "伊儿汗国", "木华黎", "速不台", "916", "1644"),
        array("鞑靼", "normal", "multe-key", "瓦剌", "鞑靼", "达延汗", "准噶尔", "喀尔喀", "兀良哈", 
            "鄂尔多斯", "土默特", "察哈尔", "喀剌沁", "喀尔喀", "厄鲁特", "俺答汗"),
        
        array("敕勒", "normal", "multe-key", "敕勒", "丁零", "赤勒", "铁勒", "高车", "翟魏", "翟斌", "翟辽"),
        array("回鹘"),
        array("维吾尔"),
        
        array("东北少数民族", "super", "multe-key", "肃慎", "挹娄", "勿吉", "靺鞨", "濊貊", "扶余", 
                "沃沮", "辽东郡", "乐浪郡", "玄菟郡", "真番郡"),
        array("高句丽", "super", "multe-key", "高句丽", "高句骊", "句丽", "句骊"),
        array("渤海国", "normal", "multe-key", "渤海国", "粟末靺鞨", "大祚荣", "靺鞨国"),
        array("古朝鲜", "super", "multe-key", "箕子朝鲜", "卫满朝鲜", "弁韩", "马韩", "辰韩", 
                "百济", "新罗", "高丽"),
        array("金国", "super", "multe-key", "女真", "女直", "金太祖", "完颜阿骨打", "完颜旻", "会宁府", "海陵王", 
            "完颜亮", "大兴府", "完颜晟", "完颜亮", "完颜雍", "猛安谋克"),
        array("满族", "normal", "multe-key", "满洲", "后金"),
        array("满洲国", "normal", "multe-key", "满洲国", "溥仪"),
        
        array("羌", "normal", "multe-key", "羌", "姚弋仲", "后秦", "姚苌", "姚兴", "邓至"),
        array("西夏", "normal", "multe-key", "党项", "西夏", "李元昊", "李谅祚", "李睍"),
        array("吐蕃"),
        
        array("西南少数民族", "normal", "multe-key", "苗人", "壮人", "黎人"),
        array("西域少数民族", "super", "multe-key", "西域", "月氏", "贵霜帝国", "乌孙", "鄯善", "楼兰", 
                "车师", "高昌", "疏勒", "于阗", "龟玆", "焉耆"),
        
        array("北方汉人割据", "super", "multe-key", "前凉", "西凉", "归义军", "后梁", "朱温", 
                "后周", "郭威", "柴荣", "北齐", "高欢"),
        array("冉魏", "super", "multe-key", "冉魏", "冉闵", "杀胡令"),
        array("南方汉人割据", "normal", "multe-key", "谯蜀", "谯纵", "桓楚", "桓玄", "前蜀", 
                "后蜀", "荆南", "南楚", "南汉", "闽国", "吴越国", "钱镠", "钱弘俶", "南唐", "李昪", 
                "李璟", "李煜", "西梁", "萧琮", "萧绎", "萧纪", "萧铣"),
        array("中华苏维埃共和国"),
        
    ),
    array
    (
        // 官制
        // "共和"、"自治" 不宜做关键字。
        array("中央和地方关系", "super", "multe-key", "封建", "郡县", "集权", "分权", "分封", "行省", 
            "推恩令", "单一制", "联邦制"),
        array("宰相", "super", "key-time", "宰相", "丞相", "相权", "相国", "大学士", "三公", "九卿", 
            "中书省", "尚书省", "门下省", "尚书台", "司马", "司徒", "司空", "太傅", "太师", "太保", 
            "令尹", "仆射", "平章事", "参知政事", "首辅", "次辅", "内阁学士", "军机处", "-1500", "1911"),
        array("六部", "normal", "key-time", "六部", "尚书", "侍郎", "吏部", "户部", "礼部", "兵部", 
            "刑部", "工部", "台阁", "治粟内史", "太农令", "大司农", "司农寺", "运使司", "铁盐使司", 
            "度支使司", "国子监", "-1500", "1911"),
        array("司法监察", "normal", "key-time", "御史大夫", "廷尉", "御史台", "大理寺", "都察院", "审刑院", 
            "监察", "司法", "-1500", "1911"),
        // "宗正" 不宜为关键字。
        array("大内", "normal", "key-time", "大内", "奉常", "郎中令", "少府", "卫尉",  "太仆", 
            "太常", "太监", "宫女", "中大夫令", "光禄勋", "太府", "太常寺", "光禄寺", "卫尉寺", 
            "太仆寺", "宗人府", "内务府", "詹事府", "-1500", "1911"),
        array("地方官", "normal", "key-time", "诸候", "郡守", "县令", "县长", "刺史", "州牧", "通判", "行省", 
            "达鲁花赤", "里长", "布政司", "布政使", "按察司", "总督", "巡抚", "镇守", "-1500", "1911"),
        array("边臣", "normal", "key-time", "典客", "大行令", "大鸿胪", "鸿胪寺", "西域都护", "宣慰司", 
            "土司", "理藩院", "-1500", "1911"),
        array("世卿世禄制", "normal", "key-time", "世卿世禄", "世袭", "世职", "世官", "-1500", "1911"),
        array("九品中正制", "normal", "key-time", "九品中正", "察举", "征辟", "孝廉", "-1500", "1911"),
        // "明经"、"金榜"不宜为关键字。
        array("科举制", "super", "key-time", "科举", "分科取士", "县试", "童生", "院试", "生员", 
            "秀才", "茂才", "乡试", "解试", "秋闱", "桂榜", "举人", "解元", "会试", "省试", "春闱", 
            "贡士", "会元", "殿试", "进士", "状元", "榜眼", "探花", "投牒自试", "常科", "制科", 
            "帖经", "墨义", "进士及第", "进士出身", "同进士出身", "琼林宴", "糊名", "誊录", 
            "贡院", "科场", "监生", "贡监", "荫监", "举监", "例监", "鹿鸣宴", "座师", "传胪", 
            "连中三元", "庶吉士", "翰林院", "八股文", "-1500", "1911"),
        
        array("太子", "super", "multe-key", "太子", "废立", "立太子", "废太子", "废储", 
            "册封", "继承大统", "皇储", "立储"),
        array("权臣", "normal", "multe-key", "权臣", "篡", "权相", "自立", "弑", "九锡", "黄袍加身"),
        array("太监", "normal", "multe-key", "太监", "阉人", "寺人", "内监", "锦衣卫", "内书堂", "敬事房", 
            "东厂", "西厂", "内厂", "内务府"),
        array("外戚宗室", "normal", "multe-key", "外戚", "国舅", "戚畹", "外家", "后宫干政",
            "临朝", "宗室", "嫔妃", "贵妃", "皇后", "太后", "太皇太后", "老佛爷", "垂帘听政"),
        // "部曲"不宜为关键字。
        array("奴隶", "normal", "multe-key", "奴隶", "奴婢", "家生子", "隶臣", "隶妾"),
        
    ),
    array
    (
        // 政治问题
        array("改革", "super", "multe-key", "改革", "商鞅变法", "王安石变法", "庆历新政", "张居正变法", 
                "洋务运动", "百日维新", "戊戌变法", "清末新政", "制宪国民大会", "改革开放", 
                "台湾十大建设", "台湾民主转型"),
        
        array("太平天国"),
        array("义和团"),
        
        array("村民自治", "super", "multe-key", "村民", "农民", "村民选举", "村民直选", "村长", "村支书"),
        array("土地制度", "super", "multe-key", "土地制度", "平分土地",  "均分土地",  "分配土地", "土地面积", 
                "井田制", "初税亩", "摊丁入亩", "一条鞭法", "两税法", "租庸调", "均田", "土改", 
                "土地改革", "土地承包", "土地权", "圈地", "土地法", "土地问题", "土地征收", "地权"),
        array("水利"),
        array("拆迁", "normal", "multe-key", "拆迁", "强拆", "血拆", "土地征收"),

        array("民主", "super", "multe-key", "民主", "独裁", "选举", "专制"),
        array("宪政", "normal", "multe-key", "宪政", "宪政", "宪法", "制宪"),
        array("言论自由", "super", "multe-key", "言论自由", "新闻自由"),
        array("司法独立", "super", "multe-key", "司法独立", "司法改革", "律师"),
        array("食品安全", "super", "multe-key", "食品", "公共卫生", "毒奶粉", "地沟油", "毒大米", 
            "农药残留", "重金属", "致癌物", "有机农业", "转基因", "食材", "防腐剂", "速冻", "洗涤剂", 
            "消毒剂", "消毒卫生", "卫生标准", "添加剂"),
        array("权贵资本", "normal", "multe-key", "权贵资本", "红二代", "太子党", "反腐", "贪污", 
            "腐败", "腐化", "受贿", "行贿", "裙带", "双规"),
        array("财政税收", "super", "multe-key", "财政", "税收", "社会保障", "社保"),
        array("私人资本", "super", "multe-key", "私人资本", "民企", "私企", "私营企业", "私有企业"),
        array("公有制", "super", "multe-key", "公有制", "国企", "国有企业", "国家所有制", "集体所有制"),
        array("公民社会", "normal", "multe-key", "公民社会", "公益", "非营利", "NPO", "慈善", "群体事件", 
            "群体性事件"),
        array("户口"),
        array("法律犯罪", "normal", "multe-key", "法律", "犯罪"),
    ),
    array
    (
        // 中国共产党
        array("中国共产党", "super", "multe-key", "中国共产党", "中共", "总书记", "中央军委", "省委", "市委", 
            "县委", "乡镇党委", "政治局", "中央委员", "村书记", "纪委", "党委", "政法委", "组织部", 
            "中组部"),
        array("人民解放军", "super", "multe-key", "解放军", "红军", "八路军", "新四军", 
            "中央军委", "政委", "政治部"),
        array("延安整风运动", "super", "multe-key", "延安整风", "第一次整风运动"),
        array("土地改革", "super", "multe-key", "土地改革", "土地革命", "土改", "中国土地法"),
        array("镇反", "super", "multe-key", "镇反", "镇压反革命运动"),
        array("反右派", "super", "multe-key", "事情正在起变化", "反右", "右派分子", "引蛇出洞"),
        array("三年大饥荒", "super", "multe-key", "三年大饥荒", "三年自然灾害", "大跃进", "人民公社", 
            "农业学大寨", "社会主义建设总路线", "多快好省", "以钢为纲", "大炼钢铁", "共产风", "浮夸风", 
            "放卫星", "亩产万斤", "超英赶美", "三面红旗", "信阳事件", "吃饭不要钱", "大饥荒"),
        array("文化大革命", "super", "multe-key", "文化大革命", "文革", "姚文元", "五一六通知", "红卫兵", "造反派" ,
            "大字报", "江青", "陈伯达", "张春桥", "文攻武卫", "三支两军", "无产阶级专政下继续革命", "王洪文",
            "批林批孔", "四人帮", "反击右倾翻案风"),
        array("新时期", "super", "multe-key", "维稳", "邓小平理论", "三讲", "三个代表", "保先", 
            "科学发展观", "和谐社会", "社会主义荣辱观", "八荣八耻", "三个自信", "一带一路", 
            "习近平思想", "习近平理论", "之江新语", "四个全面", "中国梦", "新常态", "四个自信", "供给侧", 
            "统一战线", "群众路线", "统战"),
        
        array("奇言奇行", "super"),
        
        // 组织
        array("中国国民党", "normal", "multe-key", "国民党", "孙中山", "蒋介石", "蒋经国",  
            "李登辉", "连战", "马英九", "洪秀柱", "吴敦义", "宋楚瑜"),
        array("民主进步党", "normal", "multe-key", "民主进步党", "民进党", "林义雄", "施明德", "陈水扁", 
            "谢长廷", "苏贞昌", "蔡英文"),
        array("二二八事件", "normal", "multe-key", "二二八", "2·28"),
        array("美丽岛事件", "normal", "multe-key", "美丽岛", "高雄事件"),
    
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
        array("郑州"),
        array("长沙"),
        array("成都"),
        array("大连"),
        array("合肥"),
        array("青岛"),
        
        array("苏州", "normal", "multe-key", "苏州", "姑苏", "吴都", "吴中", "吴郡", "平江", "吴门"),
        array("扬州", "normal", "multe-key", "扬州", "邗江", "广陵", "江都", "维扬"),
        array("宁波"),
        array("徐州"),
        array("温州"),
        array("绍兴", "normal", "multe-key", "绍兴", "会稽"),
        array("哈尔滨"),
        array("长春"),
        array("开封", "normal", "multe-key", "开封", "汴梁", "汴州", "汴京", "大梁"), // "东京"歧义太多.
        array("洛阳"),
        array("澳门"),
        array("台北"),
        array("高雄"),
        array("台南"),
        array("厦门"),
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
        array("湖南", "normal", "multe-key", "湖南", "湘", "长沙", "岳阳", "衡阳", "株洲", "湘潭", 
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
        array("南海", "super", "multe-key", "南海", "南中国海", "九段线", "南沙群岛", 
                "中沙群岛", "西沙", "东沙群岛", "美济礁", "渚碧礁", "黄岩岛", "永兴岛", "三沙市"),
        array("东海", "super", "multe-key", "东海", "东中国海", "春晓油气田", "钓鱼岛"),
        array("黄海"),
        array("渤海"),
        
        array("长江", "super", "multe-key", "长江", "大江", "扬子江"),
        array("黄河"),
        array("京杭大运河", "super", "multe-key", "京杭大运河", "邗沟", "通济渠", "永济渠", 
            "广通渠", "通惠河", "江南河", "大运河"),
        array("辽河"),
        array("淮河"),
        array("珠江"),
        array("塔里木河"),
        array("雅鲁藏布江"),
        
        array("太湖", "super", "multe-key", "太湖", "震泽", "具区"),
        array("鄱阳湖"),
        array("洞庭湖"),
        array("青海湖"),
        
        array("万里长城", "super"),
        array("秦岭"),
        array("河西走廊"),
        array("长江三峡"),
        array("南岭", "normal", "multe-key", "南岭", "五岭", "越城岭", "都庞岭", "萌渚岭", 
                "骑田岭", "大庾岭"),
        array("太行八径", "normal", "multe-key", "太行八径", "军都陉", "蒲阴陉", "飞狐陉", "井陉", "滏口陉", 
                "白陉", "太行陉", "轵关陉"),
        
        array("天山"),
        array("泰山"),
        array("庐山"),
    ),
    array
    (
        // other
    )
);

?>