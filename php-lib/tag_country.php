<?php
// created by duangan, 2015-4-27 -->
// support country deal function.    -->

$country_big = array
(
    "古代文明",
    "中东北非中亚",
    "亚洲",
    "欧洲",
    "非洲",
    "美洲",
    "澳洲及国际组织",
    "大城市",
    "洋海山河",
    "其它"
);

// 数组
$country = array
(
    array
    (
        // 古代文明
        array("苏美尔文明", "super", "sigle-key", "苏美尔"),
        array("埃及文明", "super", "key-time", "埃及", "-4500", "642"),
        array("赫梯文明", "normal", "sigle-key", "赫梯"),
        array("巴比伦文明", "super", "sigle-key", "巴比伦"),
        array("腓尼基人", "normal", "sigle-key", "腓尼基"),
        array("爱琴文明", "normal", "multe-key", "克里特文明", "迈锡尼", "米诺斯"),
        array("希腊文明", "super", "key-time", "希腊", "荷马史诗", "雅典", "斯巴达", "马其顿", "-1200", "-146"),
        array("波斯文明", "normal", "key-time", "波斯", "大流士", "伊朗", "塞琉古王朝", "萨珊王朝", 
                "安息王朝", "德黑兰", "-3000", "651"),
        array("罗马文明", "super", "key-time", "伊特鲁里亚文明", "罗马", "-2000", "476"),
        array("日耳曼人", "normal", "multe-key", "日耳曼", "汪达尔人", "格庇德人", "哥特人", "勃艮第人", 
               "法兰克人", "盎格鲁人", "撒克逊人", "阿勒曼尼人"),
        array("拜占庭", "normal", "key-time", "君士坦丁堡", "东罗马", "-667", "1453"),
        array("古印度文明", "normal", "key-time", "印度", "印度河", "恒河", "哈拉帕文化", "摩揭陀", "孔雀王朝",
                "阿育王", "吠陀", "刹帝利", "婆罗门", "印度教", "笈多王朝", "吠陀", "梵", "摩诃婆罗多", 
                "罗摩衍那", "佛陀", "莫卧儿朝", "-2500", "1600"),
        array("班图人文明",  "normal", "multe-key", "班图尼格罗人", "班图语系", "割礼", "伊费王国", "刚果王国", 
                "大津巴布韦", "马拉维文化", "马蓬古布韦文化", "祖鲁王国", "斯瓦希里文明", "加纳帝国", "贝宁文明", "诺克文化"),
        array("玛雅文明", "normal", "sigle-key", "玛雅"),
        array("波利尼西亚文明", "normal", "multe-key", "波利尼西亚", "波利尼西亚语", "南岛人"),
        array("奥斯曼帝国"),
        array("神圣罗马帝国"),
        array("奥匈帝国"),
    ),
    array
    (
        // 中东北非中亚
        array("犹太人", "super", "multe-key", "希伯来语", "犹太教", "希伯来人", "犹太历", 
                "犹太王国", "以色列王国", "锡安主义", "犹太复国主义运动"),
        array("以色列", "super", "multe-key", "耶路撒冷", "特拉维夫", "海法"),
        
        array("土耳其", "super", "multe-key", "伊斯坦布尔", "安卡拉"),
        array("埃及", "super", "key-time", "开罗", "亚历山大", "苏伊士", "651", "2100"),
        array("伊朗", "super", "key-time", "德黑兰", "马什哈德", "伊斯法罕", "642", "2100"),
        array("叙利亚", "normal", "multe-key", "大马士革", "阿勒颇"),
        array("伊拉克", "normal", "key-time", "巴格达", "巴士拉", "纳杰夫", "摩苏尔", "635", "2100"),
        array("ISIS", "super", "multe-key", "伊斯兰国", "达伊沙", "巴格达迪"),
        array("沙特阿拉伯", "normal", "multe-key", "沙特", "利雅得", "麦加"),
        array("阿联酋", "normal", "multe-key", "阿拉伯联合酋长国", "迪拜"),
        array("利比亚", "normal", "multe-key", "的黎波里"),
        array("约旦", "normal", "multe-key", "安曼"),
        array("科威特"),
        array("黎巴嫩", "normal", "multe-key", "贝鲁特"),
        array("巴勒斯坦", "normal", "multe-key", "加沙"),
        array("卡塔尔", "normal", "multe-key", "多哈"),
        array("摩洛哥", "normal", "multe-key", "拉巴特"),
        array("也门", "normal", "multe-key", "萨那", "亚丁"),
        array("塞浦路斯", "normal", "multe-key", "尼科西亚"),
        array("阿富汗", "normal", "multe-key", "坎布尔"),
        array("高加索三国", "super", "multe-key", "亚美尼亚", "阿塞拜疆", "格鲁吉亚", 
                "埃里温", "巴库", "第比利斯"),
        array("中亚五斯坦", "super", "multe-key", "哈萨克斯坦", "乌兹别克斯坦", "吉尔吉斯斯坦",
                 "塔吉克斯坦", "土库曼斯坦", "阿斯塔纳", "塔什干", "比什凯克", "杜尚别", "阿什哈巴德"),
        array("库尔德", "normal", "multe-key", "基尔库克"),       
    ),
    array
    (
        // 亚洲
        array("日本", "super", "multe-key", "东京", "大阪", "京都", "北海道"),
        array("韩国", "super", "multe-key", "汉城", "首尔", "济州"),
        array("印度", "super", "key-time", "孟买", "加德满都", "新德里", "1600", "2100"),
        array("朝鲜", "normal", "multe-key", "平壤"),
        array("巴基斯坦", "normal", "multe-key", "安卡拉"),
        array("孟加拉国", "normal", "multe-key", "达卡"),
        array("马尔代夫", "normal", "multe-key", "马累"),
        array("尼泊尔", "normal", "multe-key", "加德满都"),
        array("斯里兰卡", "normal", "multe-key", "科伦坡"),
        array("蒙古", "normal", "multe-key", "乌兰巴托"),
        
        array("东南亚", "super", "multe-key", "东盟", "东南亚联盟"),
        array("马来西亚", "normal", "multe-key", "吉隆坡"),
        array("泰国", "normal", "multe-key", "曼谷"),
        array("新加坡"),
        array("印尼", "normal", "multe-key", "雅加达", "印度尼西亚"),
        array("菲律宾", "normal", "multe-key", "马尼拉"),
        array("越南", "normal", "multe-key", "河内"),
        array("柬埔寨", "normal", "multe-key", "金边"),
        array("老挝", "normal", "multe-key", "万象"),
        array("缅甸", "normal", "multe-key", "内比都", "仰光"),
    ),
    array
    (
        // 欧洲
        array("欧洲",  "super", "multe-key", "欧盟", "欧洲联盟", "欧共体", "欧洲经济共同体", 
                "欧洲共同体", "欧元", "申根"),
        array("德国", "super", "multe-key", "德意志", "普鲁士", "条顿", "柏林"),
        array("英国", "super", "multe-key", "英吉利", "伦敦", "利物浦", "大不列颠", "大英帝国"),
        array("法国", "super", "multe-key", "法兰西", "巴黎", "拿破仑", "马赛"),
        array("俄罗斯", "super", "multe-key", "俄国", "莫斯科", "沙皇", "圣彼得堡", "海参崴"),
        array("意大利", "normal", "key-time", "罗马", "威尼斯", "佛罗伦萨", "热那亚", "米兰", 
                "476", "2100"),
        array("奥地利", "normal", "multe-key", "维也纳"),
        array("西班牙", "normal", "multe-key", "马德里"),
        array("葡萄牙", "normal", "multe-key", "里斯本"),
        array("波兰", "normal", "multe-key", "华沙"),
        array("瑞士", "normal", "multe-key", "日内瓦"),
        array("希腊", "normal", "multe-key", "雅典"),
        array("爱尔兰", "normal", "multe-key", "都柏林"),
        array("乌克兰", "super", "multe-key", "基辅", "克里米亚"),
        array("捷克", "normal", "multe-key", "布拉格"),
        array("匈牙利", "normal", "multe-key", "布达佩斯"),
        array("保加利亚", "normal", "multe-key", "索非亚"),
        array("罗马尼亚", "normal", "multe-key", "布加勒斯特"),
        array("阿尔巴尼亚", "normal", "multe-key", "地拉那"),
        array("底地三国", "super", "multe-key", "荷兰", "比利时", "卢森堡", "阿姆斯特丹", "布鲁塞尔"),
        array("北欧五国", "super", "multe-key", "挪威", "瑞典", "芬兰", "丹麦", "冰岛", 
                "斯德哥尔摩", "奥斯陆", "赫尔辛基", "哥本哈根", "雷克雅未克"),
        array("南斯拉夫诸国", "super", "multe-key", "南斯拉夫", "斯洛文尼亚", "黑山", "塞尔维亚", 
                "克罗地亚", "科索沃", "波黑", "马其顿", "卢布尔雅那", "波德戈里察", "贝尔格莱德", 
                "萨格勒布", "萨拉热窝", "斯科普里"),
        array("波罗的海三国", "super", "multe-key", "立陶宛", "拉脱维亚", "爱沙尼亚", 
                "维尔纽斯", "里加", "塔林"),
    ),
    array
    (
        // 非洲
        array("非洲", "super", "multe-key", "非盟", "非洲联盟", "赞比亚", "卢萨卡", "布隆迪", "布琼布拉", 
                "班吉", "几内亚", "科纳克里", "尼日尔", "尼亚美", "比绍", "博茨瓦纳", "哈博罗内", 
                "加纳", "阿克拉", "布基纳法索", "瓦加杜古", "加蓬", "利伯维尔", "莱索托", "马塞卢", 
                "圣多美", "莫桑比克", "马普托", "吉布提", "马拉维", "利隆圭", 
                "毛里塔尼亚", "努瓦克肖特", "毛里求斯", "路易港", "贝宁", "波多诺伏", "毛里塔尼亚", 
                "努瓦克肖特", "乌干达", "坎帕拉", "纳米比亚", "温得和克", "塞舌尔", "厄立特里亚"),
        array("南非", "normal", "multe-key", "比勒陀利亚"),
        array("阿尔及利亚", "normal", "multe-key", "阿尔及尔"),
        array("刚果", "normal", "multe-key", "布拉柴维尔", "金沙萨"),
        array("布隆迪", "normal", "multe-key", "布琼布拉"),
        array("安哥拉", "normal", "multe-key", "罗安达"),
        array("埃塞俄比亚", "normal", "multe-key", "亚的斯亚贝巴"),
        array("肯尼亚", "normal", "multe-key", "内罗毕"),
        array("尼日利亚", "normal", "multe-key", "阿布贾"),
        array("卢旺达", "normal", "multe-key", "基加利"),
        array("索马里", "normal", "multe-key", "摩加迪沙"),
        array("苏丹", "normal", "multe-key", "喀土穆", "朱巴"),
        array("津巴布韦", "normal", "multe-key", "哈拉雷"),
        array("马达加斯加", "normal", "multe-key", "塔那那利佛"),
        array("乍得", "normal", "multe-key", "恩贾梅纳"),
        array("坦桑尼亚", "normal", "multe-key", "达累斯萨拉姆"),
        array("马里", "normal", "multe-key", "巴马科"),
    ),
    array
    (
        // 美洲
        array("美国", "super", "multe-key", "美利坚", "纽约", "华盛顿", "洛杉矶", "芝加哥", "波士顿", 
                "亚特兰大", "休斯顿"),
        array("加拿大", "normal", "multe-key", "多伦多", "温哥华", "魁北克", "渥太华"),
        array("墨西哥"),
        array("巴西", "normal", "multe-key", "里约"),
        array("阿根廷", "normal", "multe-key", "布宜诺斯艾利斯"),
        array("中美洲七国", "super", "multe-key", "危地马拉", "伯利兹", "萨尔瓦多", "洪都拉斯", "尼加拉瓜", 
                "哥斯达黎加", "巴拿马"),
        array("委内瑞拉", "normal", "multe-key", "加拉加斯"),
        array("古巴", "normal", "multe-key", "哈瓦那"),
        array("玻利维亚", "normal", "multe-key", "拉巴斯"),
        array("智利", "normal", "multe-key", "圣地亚哥"),
        array("哥伦比亚", "normal", "multe-key", "圣菲波哥大"),
        array("厄瓜多尔", "normal", "multe-key", "基多"),
        array("巴拉圭", "normal", "multe-key", "亚松森"),
        array("秘鲁", "normal", "multe-key", "利马"),
        array("乌拉圭", "normal", "multe-key", "蒙得维的亚"),
        array("爱斯基摩"),
    ),
    array
    (
        // 大洋洲等
        array("澳大利亚", "normal", "multe-key", "堪培拉", "悉尼"),
        array("新西兰", "normal", "multe-key", "惠灵顿"),
        array("巴布亚新几内亚", "normal", "multe-key", "莫尔兹比"),
        array("太平洋岛国", "normal", "multe-key", "基里巴斯", "塔拉瓦", "图瓦卢", "富纳富提", 
                "马绍尔群岛", "马朱罗", "斐济", "所罗门群岛", "霍尼亚拉", "帕劳", "梅莱凯奥克", 
                "汤加", "努库阿洛法", "瑙鲁", "密克罗尼西亚联邦", "帕利基尔", "萨摩亚", "阿皮亚", 
                "瓦努阿图", "维拉港"),
        
        // 国际组织
        array("联合国", "super", "multe-key", "安理会", "联合国大会"),
        array("世界贸易组织", "super", "multe-key", "世贸", "关贸总协定"),
        array("世界金融体系", "super", "multe-key", "世界银行", "世行", "亚洲开发银行", "布雷顿森林体系", 
                "牙买加货币体系", "IMF", "国际货币基金组织", "特别提款权", "亚洲基础设施投资银行", "亚投行"),
    ),
    array
    (
        // 大城市
        array("纽约"),
        array("伦敦"),
        array("巴黎"),
        array("东京"),
        array("芝加哥"),
        array("洛杉矶"),
        array("布鲁塞尔"),
        array("悉尼"),
        array("首尔", "normal", "multe-key", "汉城"),
        array("多伦多"),
        
        array("柏林"),
        array("罗马"),
        array("维也纳"),
        array("莫斯科"),
        array("阿姆斯特丹"),
        array("马德里"),
        array("西雅图"),
        array("波士顿"),
        array("大阪"),
        array("孟买"),
        array("吉隆坡"),
        array("雅加达"),
        array("迪拜"),
        array("伊斯坦布尔"),
        array("耶路撒冷"),
        array("开罗"),
        array("巴格达"),
    ),
    array
    (
        // 洋海山河
        array("太平洋", "super", "sigle-key", "太平洋"),
        array("大西洋", "super", "sigle-key", "大西洋"),
        array("印度洋", "super", "sigle-key", "印度洋"),
        array("北冰洋"),
        array("南极"),
        
        array("地中海", "super", "multe-key", "爱琴海", "直布罗陀", "达达尼尔海峡", "苏伊士运河", 
                "博斯普鲁斯海峡", "马尔马拉海", "土耳其海峡"),
        array("北海"),
        array("波罗的海"),
        array("黑海"),
        array("红海-波斯湾", "super", "multe-key", "红海", "波斯湾"),
        array("日本海"),
        array("加勒比海"),
        array("墨西哥湾"),
        
        array("亚马逊河", "super", "sigle-key", "亚马逊河"),
        array("尼罗河", "super", "sigle-key", "尼罗河"),
        array("密西西比河", "super", "sigle-key", "密西西比河"),
        array("多瑙河"),
        array("莱茵河"),
        array("伏尔加河"),
        array("两河流域", "super", "multe-key", "幼发拉底河", "底格里斯河", "美索不达米亚"),
        array("里海"),
        array("印度河"),
        array("恒河"),
        array("湄公河"),
        
        array("五大湖区", "super", "multe-key", "五大湖", "苏必利尔湖", "密歇根湖", "休伦湖", 
                "伊利湖", "安大略湖"),
        array("贝加尔湖"),
                
        array("撒哈拉大沙漠"),
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