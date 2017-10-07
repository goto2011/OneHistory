<?php
// created by duangan, 2015-4-27 -->
// support country deal function.    -->

$country_big = array
(
    "史前史",
    "古代文明",
    "中东北非中亚",
    "亚洲",
    "欧洲",
    "北美",
    "其它地区",
    "大城市",
    "湖海河山",
    "其它"
);

// 数组
$country = array
(

    array
    (
        // 史前史
        array("考古", "super", "multe-key", "考古", "碳14", "碳十四", "智人", "遗址", "原始人", "金石学",
            "古代人类", "地层", "类型学", "史前", "能人", "直立人", "匠人", "海德堡人", "尼安德特人"),
        
        array("骨器", "super", "multe-key", "骨器", "兽骨", "象牙器", "木器"),
        array("石器", "super", "multe-key", "石器", "石核", "手斧", "砾石", "敲砸器", "砍砸器", "磨制石器", 
            "穿孔", "磨光"),
        array("玉器", "super", "multe-key", "玉器", "玉璧", "玉琮", "玉琀", "翡翠", "解玉砂琢碾加工", "碾法", 
            "古玉", "和田玉", "昆仑之玉", "岫玉", "蓝田玉", "独山玉", "绿松石", "黄蜡石", "玛瑙",
            "青金石", "孔雀石", "硬玉", "软玉", "玉戈", "玉瑗"),
        array("陶器", "super", "multe-key", "陶器", "黑陶", "白陶", "彩陶", "陶片", "陶雏器", "陶俑", 
            "陶轮", "陶瓷", "唐三彩", "釉", "窑", "瓷", "景德镇"),
        array("青铜器", "super", "multe-key", "青铜器", "青铜", "红铜", "铜器", "铜矿", 
            "铜石并用", "金石并用", "铜制"),
        array("铁器", "super", "multe-key", "铁器", "冶铁", "铁矿", "炼铁", "铁制"),
        
        array("农业工具", "super", "multe-key", "农业工具", "石磨", "犁", "斧", "铲", "镰", 
            "锄", "镞", "凿"),
        array("容器", "normal", "multe-key", "碗", "壶", "钵", "罐"),
        array("鼎"),
        array("车", "normal", "multe-key", "车轮", "纺轮", "陶轮", "马车", "人力车", "独轮车", "车辙"),
        array("船", "normal", "multe-key", "独木舟", "木船", "划艇", "筏子", "竹排", "竹筏", "木筏", 
            "木桨", "船桨", "木排", "舢板", "划子", "皮划艇", "皮筏", "羊皮筏子"),
        
        array("农作物", "normal", "multe-key", "农作物", "油籽", "蔓青", "大芥", "花生", "苜蓿", "豌豆",
            "胡麻", "大麻", "向日葵", "萝卜", "白菜", "芹菜", "韭菜", "蒜", "葱", "胡萝卜", "菜瓜", 
            "莲花菜", "菊芋", "刀豆", "芫荽", "莴笋", "黄花", "辣椒", "黄瓜", "西红柿", "香菜", 
            "梨", "青梅", "苹果", "桃", "杏", "核桃", "李子", "樱桃", "草莓", "沙果", "红枣", 
            "绿肥", "紫云英", "人参", "当归", "金银花", "薄荷", "艾蒿", "橄榄树", "无花果", "葡萄", 
            "青稞", "油菜", "土豆", "高粱", "甘蔗", "绿豆", "芝麻", "马铃薯", "烟草"),
        array("小麦", "super", "multe-key", "小麦", "大麦", "粟", "黍", "稷"),
        array("稻", "super"),
        array("玉米"),
        array("大豆"),
        array("甘薯"),
        array("棉花", "super"),
        array("丝绸", "super", "multe-key", "丝绸", "桑", "蚕", "绸缎"),
        array("茶", "super"),
        
        array("畜牧作物", "normal", "multe-key", "畜牧作物", "家畜", "家禽", "牧养动物", 
            "鸭", "鹅", "鸽子", "骆驼", "猫", "兔"),
        array("猪"),
        array("牛"),
        array("羊"),
        array("狗"),
        array("鸡"),
        array("渔猎", "normal", "multe-key", "渔猎", "捕鱼", "蚌", "养鱼", "独木舟", "狩猎", "水产"),
        
        array("房屋", "super", "multe-key", "房屋", "庇护所", "山洞", "洞穴", "木屋", "茅屋", "建筑", 
            "村庄", "庭院", "定居", "灶址", "灶台", "房基", "窖穴"),
        array("服装"),
        array("饮食"),
        array("武器"),
        array("堡垒"),
        array("城市", "super", "multe-key", "城市", "城址"),
        
        array("文字", "super", "multe-key", "文字", "篆文", "大篆", "小篆", "甲骨文", "金文", 
            "蝌蚪文", "石鼓文", "殷墟文字", "楔形文字", "线形文字", "象形文字", "字母文字", "仓颉"),
            
        array("宗教建筑", "super", "multe-key", "宗教建筑", "神庙", "巫师", "祭司", "巫术"),
        
        array("祭祀墓葬", "normal", "multe-key", "祭祀", "墓葬", "埋葬", "墓穴", "墓道", "随葬", 
            "瓮棺", "石棺", "悬棺", "封土", "火葬", "土葬", "水葬", "天葬", "陪葬", "殉葬",
            "祭器"),
            
        array("婚姻家庭", "normal", "multe-key", "婚姻", "家庭", "社会分工", "父系", "母系", 
            "父权", "母权", "舅权", "生殖崇拜"),
         
        array("世界遗产名单"),
    ),
    array
    (
        // 古代文明
        array("苏美尔文明", "super", "multe-key", "苏美尔", "楔形文字"),
        array("埃及文明", "super", "key-time", "埃及", "金字塔", "-4500", "642"),
        array("赫梯文明", "normal", "multe-key", "赫梯"),
        array("亚述文明", "super", "multe-key", "亚述", "阿卡德", "尼尼微"),
        array("巴比伦文明", "super", "multe-key", "巴比伦"),
        array("腓尼基人", "normal", "multe-key", "腓尼基"),
        array("爱琴文明", "normal", "multe-key", "爱琴文明", "克里特文明", "迈锡尼", "米诺斯"),
        array("希腊文明", "super", "key-time", "希腊", "荷马史诗", "雅典", "斯巴达", "马其顿", "-1200", "-146"),
        array("波斯文明", "normal", "key-time", "波斯", "大流士", "伊朗", "塞琉古王朝", "萨珊王朝", 
                "安息王朝", "德黑兰", "-3000", "651"),
        array("罗马文明", "super", "key-time", "伊特鲁里亚文明", "罗马", "罗马帝国", "-2000", "476"),
        array("日耳曼人", "normal", "multe-key", "日耳曼", "汪达尔人", "格庇德人", "哥特人", "勃艮第人", 
               "法兰克人", "盎格鲁人", "撒克逊人", "阿勒曼尼人"),
        array("古印度文明", "normal", "key-time", "印度", "印度河", "恒河", "哈拉帕文化", "摩揭陀", "孔雀王朝",
                "阿育王", "吠陀", "刹帝利", "婆罗门", "印度教", "笈多王朝", "吠陀", "梵", "摩诃婆罗多", 
                "罗摩衍那", "佛陀", "莫卧儿朝", "-2500", "1600"),
        array("班图人文明", "normal", "multe-key", "班图人文明", "班图尼格罗人", "班图语系", "割礼", "伊费王国", 
                "刚果王国", "大津巴布韦", "马拉维文化", "马蓬古布韦文化", "祖鲁王国", "斯瓦希里文明", 
                "加纳帝国", "贝宁文明", "诺克文化"),
        array("印第安文明", "normal", "multe-key", "玛雅", "印加", "阿兹特克", "美洲原住民", "易洛魁"),
        array("波利尼西亚文明", "normal", "multe-key", "波利尼西亚", "波利尼西亚语", "南岛人"),
        array("奥斯曼帝国"),
        array("神圣罗马帝国"),
        array("拜占庭", "normal", "key-time", "拜占庭", "君士坦丁堡", "东罗马", "-667", "1453"),
        array("奥匈帝国"),
    ),
    array
    (
        // 中东北非中亚
        array("以色列", "super", "multe-key", "以色列", "犹太人", "希伯来语", "犹太教", "希伯来人", 
             "犹太历", "犹太王国", "锡安主义", "犹太复国主义运动"),
        
        array("土耳其", "super"),
        array("埃及", "super", "key-time", "埃及", "尼罗河", "651", "2100"),
        array("伊朗", "super", "key-time", "伊朗", "波斯", "642", "2100"),
        array("叙利亚"),
        array("伊拉克", "normal", "key-time", "伊拉克", "635", "2100"),
        array("沙特阿拉伯", "normal", "multe-key", "沙特阿拉伯", "沙特"),
        array("利比亚"),
        array("卡塔尔", "hide", "multe-key", "卡塔尔", "半岛电视台"),
        array("阿联酋", "hide", "multe-key", "阿联酋", "阿拉伯联合酋长国"),
        array("约旦", "hide"),
        array("阿尔及利亚", "hide"),
        array("科威特", "hide"),
        array("黎巴嫩", "hide"),
        array("也门", "hide"),
        array("摩洛哥", "hide"),
        array("苏丹", "hide"),
        array("南苏丹", "hide"),
        array("突尼斯", "hide"),
        array("石油天然气", "super", "multe-key", "石油", "天然气", "油页岩"), 
        
        array("巴勒斯坦", "normal", "multe-key", "巴勒斯坦", "约旦河西岸"),
        array("阿富汗"),
        array("库尔德", "super"),
        array("塞浦路斯", "hide"),
        array("亚美尼亚", "hide"),
        array("阿塞拜疆", "hide"),
        array("格鲁吉亚", "hide"),
        array("哈萨克斯坦", "hide"),
        array("乌兹别克斯坦", "hide"),
        array("吉尔吉斯斯坦", "hide"),
        array("塔吉克斯坦", "hide"),
        array("土库曼斯坦", "hide"),
    ),
    array
    (
        // 亚洲
        array("日本", "super"),
        array("韩国", "super"),
        array("朝鲜"),
        array("蒙古", "hide", "key-time", "蒙古", "1904", "2100"),
        
        array("孟加拉国", "hide"),
        array("马尔代夫", "hide"),
        array("尼泊尔", "hide"),
        array("斯里兰卡", "hide"),

        array("印度", "super", "key-time", "印度", "印度教", "锡克教", "1600", "2100"),
        array("巴基斯坦", "super"),
        
        array("东南亚", "super", "multe-key", "东南亚", "东盟", "东南亚联盟"),
        array("印尼", "normal", "multe-key", "印尼", "印度尼西亚"),
        array("越南"),
        array("马来西亚"),
        array("泰国"),
        array("新加坡"),
        array("菲律宾"),
        array("柬埔寨", "hide"),
        array("老挝", "hide"),
        array("缅甸", "hide"),
    ),
    array
    (
        // 欧洲
        array("欧洲", "super", "multe-key", "欧洲", "欧盟", "欧洲联盟", "欧共体", "欧洲经济共同体", 
                "欧洲共同体", "欧元", "申根", "马约"),
        array("德国", "super", "multe-key", "德国", "德意志", "普鲁士", "条顿"),
        array("英国", "super", "multe-key", "英国", "英吉利", "大不列颠", "大英帝国"),
        array("法国", "super", "multe-key", "法国", "法兰西", "拿破仑"),
        array("俄罗斯", "super", "multe-key", "俄罗斯", "俄国", "苏联", "沙皇"),
        array("意大利"),
        array("奥地利"),
        array("西班牙"),
        array("葡萄牙"),
        array("波兰"),
        array("瑞士"),
        array("希腊"),
        array("荷兰"),
        array("爱尔兰"),
        array("乌克兰"),
        
        array("捷克", "hide"),
        array("匈牙利", "hide"),
        array("斯洛伐克", "hide"),
        array("保加利亚", "hide"),
        array("罗马尼亚", "hide"),
        array("阿尔巴尼亚", "hide"),
        array("比利时", "hide"),
        array("卢森堡", "hide"),
        array("挪威", "hide"),
        array("瑞典", "hide"),
        array("芬兰", "hide"),
        array("丹麦", "hide"),
        array("冰岛", "hide"),
        
        array("斯洛文尼亚", "hide"),
        array("黑山", "hide"),
        array("塞尔维亚", "hide"),
        array("克罗地亚", "hide"),
        array("科索沃", "hide"),
        array("波黑", "hide"),
        array("马其顿", "hide"),
        array("立陶宛", "hide"),
        array("拉脱维亚", "hide"),
        array("爱沙尼亚", "hide"),
    ),
    array
    (
        // 美洲
        array("美国", "super", "multe-key", "美国", "美利坚"),
        array("加拿大", "normal", "multe-key", "加拿大", "爱斯基摩"),
        array("墨西哥"),
        
        // 国际组织
        array("联合国", "super", "multe-key", "联合国", "联合国宪章", "安理会", "教科文组织", "安全理事会", 
            "常任理事国", "人权理事会", "国际联盟", "联合国家宣言", "世界人权宣言", "经济及社会理事会"),
        array("世界贸易", "super", "multe-key", "世界贸易", "世界贸易组织", "世贸", "关贸总协定"),
        array("世界金融", "super", "multe-key", "世界金融", "世界银行", "世行", "亚行", "亚洲开发银行", 
            "布雷顿森林体系","牙买加货币体系", "IMF", "国际货币基金组织", "特别提款权", "亚洲基础设施投资银行", 
            "亚投行"),
        array("北约", "super", "multe-key", "北约", "北大西洋公约", "华沙条约", "华约", 
            "北大西洋合作委员会", "和平伙伴关系"),
        array("上合组织", "normal", "multe-key", "上合组织", "上海合作组织", "上海五国", "上海公约"), 
        
        array("国际法", "super", "multe-key", "国际法", "国际法庭", "国际法院", "国际海洋法法庭", "海牙仲裁法院", 
            "国际公法", "条约", "万民法", "公海"),
        array("人权高于主权", "super", "multe-key", "人权高于主权", "人权"),
        array("TPP", "super", "multe-key", "TPP", "跨太平洋伙伴关系协定", "TTIP", "跨大西洋贸易和投资伙伴协定"),
    ),
    array
    (
        // 其它地区
        // 南美
        array("巴西", "super"),
        array("阿根廷"),
        array("古巴", "hide"),
        array("委内瑞拉", "hide"),
        array("玻利维亚", "hide"),
        array("智利", "hide"),
        array("哥伦比亚", "hide"),
        array("乌拉圭", "hide"),
        array("厄瓜多尔", "hide"),
        array("巴拉圭", "hide"),
        array("秘鲁", "hide"),
        array("危地马拉", "hide"),
        array("伯利兹", "hide"),
        array("萨尔瓦多", "hide"),
        array("洪都拉斯", "hide"),
        array("尼加拉瓜", "hide"),
        array("哥斯达黎加", "hide"),
        array("巴拿马", "hide"),

        // 大洋洲
        array("澳大利亚", "super"),
        array("新西兰"),
        array("基里巴斯", "hide"),
        array("图瓦卢", "hide"),
        array("马绍尔群岛", "hide"),
        array("斐济", "hide"),
        array("所罗门群岛", "hide"),
        array("帕劳", "hide"),
        array("汤加", "hide"),
        array("瑙鲁", "hide"),
        array("密克罗尼西亚联邦", "hide"),
        array("萨摩亚", "hide"),
        array("瓦努阿图", "hide"),
        array("巴布亚新几内亚", "hide"),
                
        // 非洲
        array("南非"),
        array("赞比亚", "hide"),
        array("几内亚", "hide"),
        array("尼日尔", "hide"),
        array("莫桑比克", "hide"),
        array("毛里塔尼亚", "hide"),
        array("毛里求斯", "hide"),
        array("乌干达", "hide"),
        array("纳米比亚", "hide"),
        array("厄立特里亚", "hide"),
        array("布隆迪", "hide"),
        array("卢旺达", "hide"),
        array("马达加斯加", "hide"),
        array("刚果", "hide"),
        array("安哥拉", "hide"),
        array("肯尼亚", "hide"),
        array("尼日利亚", "hide"),
        array("索马里", "hide"),
        array("津巴布韦", "hide"),
        array("坦桑尼亚", "hide"),
        array("埃塞俄比亚", "hide"),
    ),
    array
    (
        // 以色列
        array("耶路撒冷"),
        array("特拉维夫", "hide"), 
        array("海法", "hide"),
        
        // 阿联酋
        array("迪拜", "hide"),
        
        // 约旦
        array("安曼", "hide"),
        
        // 阿尔及利亚
        array("阿尔及尔", "hide"),
        
        // 黎巴嫩
        array("贝鲁特", "hide"),
        
        // 土耳其
        array("伊斯坦布尔", "normal", "multe-key", "伊斯坦布尔", "拜占庭", "康斯坦丁堡"),
        
        // 埃及
        array("开罗"),
        array("亚历山大", "hide"),
        array("苏伊士", "hide"),
        
        // 伊朗
        array("德黑兰", "hide"),
        array("马什哈德", "hide"),
        array("伊斯法罕", "hide"),
        
        // 叙利亚
        array("大马士革", "hide"),
        array("阿勒颇", "hide"),
        
        // 伊拉克
        array("巴格达", "hide"),
        array("巴士拉", "hide"),
        array("纳杰夫", "hide"),
        array("摩苏尔", "hide"),
        
        // 沙特阿拉伯
        array("利雅得", "hide"),
        array("麦加", "hide"),
        
        // 利比亚
        array("的黎波里", "hide"),
        
        // 卡塔尔
        array("多哈", "hide"),
        
        // 也门
        array("萨那", "hide"),
        array("亚丁", "hide"),
        
        // 摩洛哥
        array("拉巴特", "hide"),
        
        // 苏丹
        array("喀土穆", "hide"),
        
        // 南苏丹
        array("朱巴", "hide"),
        
        // 巴勒斯坦
        array("加沙", "hide"),
        array("杰里科", "hide"),
        
        // 塞浦路斯
        array("尼科西亚", "hide"),
        
        // 阿富汗
        array("喀布尔", "hide"),
        array("坎大哈", "hide"),
        
        // 亚美尼亚
        array("埃里温", "hide"),
        
        // 阿塞拜疆
        array("巴库", "hide"),
        
        // 格鲁吉亚
        array("第比利斯", "hide"),
        array("巴统", "hide"),
        
        // 哈萨克斯坦
        array("阿斯塔纳", "hide"),
        array("阿拉木图", "hide"),
        array("乌拉尔", "hide"),
        
        // 乌兹别克斯坦
        array("塔什干", "hide"),
        
        // 吉尔吉斯斯坦
        array("比什凯克", "hide"),
        
        // 塔吉克斯坦
        array("杜尚别", "hide"),
        
        // 土库曼斯坦
        array("阿什哈巴德", "hide"),
        
        // 库尔德
        array("基尔库克", "hide"),
        
        // 日本
        array("东京"),
        array("大阪"),
        array("京都", "hide"),
        array("北海道", "hide"),
        
        // 韩国
        array("首尔", "normal", "multe-key", "首尔", "汉城"),
        array("济州", "hide"),
        
        // 朝鲜
        array("平壤", "hide"),
        
        // 蒙古
        array("乌兰巴托", "hide"),
        
        // 孟加拉国
        array("达卡", "hide"),
        
        // 马尔代夫
        array("马累", "hide"),
        
        // 尼泊尔
        array("加德满都", "hide"),
        
        // 斯里兰卡
        array("科伦坡", "hide"),
        
        // 印度
        array("孟买"),
        array("新德里", "hide"),
        array("班加罗尔", "hide"),
        array("加尔各答", "hide"),
        
        // 巴基斯坦
        array("安卡拉", "hide"),
        
        // 柬埔寨
        array("金边", "hide"),
        
        // 老挝
        array("万象", "hide"),
        
        // 缅甸
        array("内比都", "hide"),
        array("仰光", "hide"),
        
        // 印尼
        array("雅加达", "hide"),
        
        // 越南
        array("河内", "hide"),
        array("胡志明市", "hide", "multe-key", "胡志明市", "西贡"),
        
        // 马来西亚
        array("吉隆坡", "hide"),
        
        // 泰国
        array("曼谷", "hide"),
        
        // 菲律宾
        array("马尼拉", "hide"),
        
        // 捷克
        array("布拉格", "hide"),
        
        // 匈牙利
        array("布达佩斯", "hide"),
        
        // 斯洛伐克
        array("克拉科夫", "hide"),
        
        // 保加利亚
        array("索非亚", "hide"),
        
        // 罗马尼亚
        array("布加勒斯特", "hide"),
        
        // 阿尔巴尼亚
        array("地拉那", "hide"),
        
        // 荷兰
        array("阿姆斯特丹"),
        
        // 比利时
        array("布鲁塞尔"),
        
        // 挪威
        array("斯德哥尔摩", "hide"),
        
        // 瑞典
        array("奥斯陆", "hide"),
        
        // 芬兰
        array("赫尔辛基", "hide"),
        
        // 丹麦
        array("哥本哈根", "hide"),
        
        // 冰岛
        array("雷克雅未克", "hide"),
        
        // 斯洛文尼亚
        array("卢布尔雅那", "hide"),
        
        // 黑山
        array("波德戈里察", "hide"),
        
        // 塞尔维亚
        array("贝尔格莱德", "hide"),
        
        // 克罗地亚
        array("萨格勒布", "hide"),
        
        // 波黑
        array("萨拉热窝", "hide"),
        
        // 马其顿
        array("斯科普里", "hide"),
        
        // 科索沃
        array("普里什蒂纳", "hide"),
        
        // 立陶宛
        array("维尔纽斯", "hide"),
        
        // 拉脱维亚
        array("里加", "hide"),
        
        // 爱沙尼亚
        array("塔林", "hide"),
        
        // 德国
        array("柏林"),
        
        // 英国
        array("伦敦"),
        array("利物浦", "hide"),
        
        // 法国
        array("巴黎"),
        array("马赛", "hide"),
        
        // 俄罗斯
        array("莫斯科"),
        array("圣彼得堡", "hide"),
        array("海参崴", "hide"),
        
        // 意大利
        array("罗马"),
        array("威尼斯", "hide"),
        array("佛罗伦萨", "hide"),
        array("热那亚", "hide"),
        array("米兰", "hide"),
        
        // 奥地利
        array("维也纳"),
        
        // 西班牙
        array("马德里", "hide"),
        
        // 葡萄牙
        array("里斯本", "hide"),
        
        // 波兰
        array("华沙", "hide"),
        
        // 瑞士
        array("日内瓦"),
        
        // 希腊
        array("雅典"),
        
        // 爱尔兰
        array("都柏林", "hide"),
        
        // 乌克兰
        array("基辅", "hide"),
        array("克里米亚", "hide"),
        
        // 美国
        array("纽约"),
        array("洛杉矶"),
        array("芝加哥"),
        array("西雅图", "hide"),
        array("华盛顿", "hide"),
        array("波士顿", "hide"),
        array("亚特兰大", "hide"),
        array("休斯顿", "hide"),
        
        // 加拿大
        array("多伦多", "hide"),
        array("温哥华", "hide"),
        array("魁北克", "hide"),
        array("渥太华", "hide"),
        
        // 巴西
        array("巴西利亚", "hide"),
        array("里约", "normal", "multe-key", "里约热内卢", "里约"),
        array("圣保罗", "hide"),
        
        // 阿根廷
        array("布宜诺斯艾利斯", "hide"),
        
        // 古巴
        array("哈瓦那", "hide"),
        
        // 委内瑞拉
        array("加拉加斯", "hide"),
        
        // 玻利维亚
        array("拉巴斯", "hide"),
        
        // 智利
        array("圣地亚哥", "hide"),
        
        // 哥伦比亚
        array("波哥大", "hide"),
        
        // 乌拉圭
        array("蒙得维的亚", "hide"),
        
        // 厄瓜多尔
        array("基多", "hide"),
        
        // 巴拉圭
        array("亚松森", "hide"),
        
        // 秘鲁
        array("利马", "hide"),
        
        // 澳大利亚
        array("堪培拉", "hide"),
        array("悉尼"),
        
        // 新西兰
        array("惠灵顿", "hide"),
        
        // 肯尼亚
        array("内罗毕", "hide"),
        
        // 索马里
        array("摩加迪沙", "hide"),
        
        // 埃塞俄比亚
        array("亚的斯亚贝巴", "hide"),
        
        // 南非
        array("比勒陀利亚", "hide"),

    ),
    array
    (
        // 湖海河山
        array("太平洋", "super"),
        array("大西洋", "super"),
        array("印度洋", "super"),
        array("北冰洋"),
        array("南极"),
        
        array("地中海", "super", "multe-key", "地中海", "爱琴海", "直布罗陀", "达达尼尔海峡", "苏伊士运河", 
                "博斯普鲁斯海峡", "马尔马拉海", "土耳其海峡"),
        array("黑海"),
        array("红海波斯湾", "super", "multe-key", "波斯湾", "红海"),
        array("加勒比海"),
        array("北海"),
        array("波罗的海"),
        array("日本海"),
        
        array("亚马逊河", "super", "multe-key", "亚马孙河", "亚马逊雨林", "热带雨林", "亚马逊丛林"),
        array("尼罗河", "super"),
        array("密西西比河", "super"),
        array("多瑙河"),
        array("莱茵河"),
        array("伏尔加河"),
        array("两河流域", "super", "multe-key", "两河流域", "幼发拉底河", "底格里斯河", "美索不达米亚"),
        array("里海"),
        array("印度河"),
        array("恒河"),
        array("湄公河"),
        
        array("五大湖区", "super", "multe-key", "五大湖", "苏必利尔湖", "密歇根湖", "休伦湖", 
                "伊利湖", "安大略湖"),
        array("贝加尔湖", "super"),
                
        array("撒哈拉沙漠"),
        array("东非大裂谷"),
        array("落基山脉", "normal", "multe-key", "落基山"),
        array("阿尔卑斯山脉", "normal", "multe-key", "阿尔卑斯山"),
        array("安第斯山脉", "normal", "multe-key", "安第斯山"),
    ),
    array
    (
        // other
    )
);

?>