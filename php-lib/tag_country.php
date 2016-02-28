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
    "大洋洲等",
    "其它"
);

// 朝代数组
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
        array("爱琴文明", "normal", "multe-key", "爱琴文明", "克里特文明", "迈锡尼", "米诺斯"),
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
    ),
    array
    (
        // 中东北非中亚
        array("犹太人", "super", "multe-key", "犹太人", "希伯来语", "犹太教", "希伯来人", "犹太历", 
                "犹太王国", "以色列王国", "锡安主义", "犹太复国主义运动"),
        array("以色列", "super", "multe-key", "以色列", "耶路撒冷", "特拉维夫", "海法"),
        
        array("伊斯兰", "super", "multe-key", "默罕默德", "伊斯兰教", "穆斯林", "逊尼派", "什叶派", 
                "斋月"),
        array("奥斯曼帝国"),
        array("土耳其", "super", "multe-key", "土耳其", "伊斯坦布尔", "安卡拉"),
        array("埃及", "super", "key-time", "埃及", "开罗", "亚历山大", "苏伊士", "651", "2100"),
        array("伊朗", "super", "key-time", "伊朗", "德黑兰", "马什哈德", "伊斯法罕", "642", "2100"),
        array("叙利亚", "super", "multe-key", "叙利亚", "大马士革", "阿勒颇"),
        array("伊拉克", "super", "key-time", "伊拉克", "巴格达", "巴士拉", "纳杰夫", "摩苏尔", "635", "2100"),
        array("ISIS", "super", "multe-key", "ISIS", "伊斯兰国", "达伊沙", "巴格达迪"),
        array("沙特阿拉伯", "normal", "multe-key", "沙特", "利雅得", "麦加"),
        array("利比亚"),
        array("约旦"),
        array("科威特"),
        array("黎巴嫩"),
        array("巴勒斯坦"),
        array("卡塔尔"),
        array("摩洛哥"),
        array("也门"),
        array("亚美尼亚"),
        array("阿塞拜疆"),
        array("塞浦路斯"),
        array("格鲁吉亚"),
        array("阿富汗"),
        array("中亚五斯坦", "normal", "multe-key", "吉尔吉斯斯坦", "塔吉克斯坦", "乌兹别克斯坦", 
                "土库曼斯坦", "哈萨克斯坦"),
    ),
    array
    (
        // 亚洲
        array("印度", "super", "key-time", "印度", "孟买", "1600", "2100"),
        array("日本", "super", "multe-key", "日本", "东京"),
        array("韩国", "super", "multe-key", "韩国", "汉城", "首尔"),
        array("朝鲜"),
        array("巴基斯坦"),
        array("孟加拉国"),
        array("马尔代夫"),
        array("尼泊尔"),
        array("斯里兰卡"),
        array("蒙古"),
        
        array("东盟", "super", "multe-key", "东盟", "东南亚联盟"),
        array("马来西亚"),
        array("泰国"),
        array("新加坡"),
        array("印尼"),
        array("越南"),
        array("柬埔寨"),
        array("老挝"),
        array("缅甸"),
        array("菲律宾"),
    ),
    array
    (
        // 欧洲
        array("欧盟",  "super", "multe-key", "欧盟", "欧洲联盟", "欧共体", "欧洲经济共同体", 
                "欧洲共同体", "欧元"),
        array("神圣罗马帝国"),
        array("奥匈帝国"),
        array("德国", "super", "multe-key", "德国", "德意志", "普鲁士", "条顿", "柏林"),
        array("英国", "super", "multe-key", "英国", "英吉利", "伦敦"),
        array("法国", "super", "multe-key", "法国", "法兰西", "巴黎", "拿破仑"),
        array("俄罗斯", "super", "multe-key", "俄罗斯", "俄国", "莫斯科", "沙皇"),
        array("意大利", "super", "key-time", "意大利", "罗马", "威尼斯", "佛罗伦萨", "比萨", 
                "热那亚", "476", "2100"),
        array("奥地利"),
        array("西班牙"),
        array("葡萄牙"),
        array("波兰"),
        array("瑞士"),
        array("希腊"),
        array("爱尔兰"),
        array("荷兰"),
        array("比利时"),
        array("挪威"),
        array("瑞典"),
        array("乌克兰", "super", "multe-key", "乌克兰", "基辅", "克里米亚"),
        array("捷克"),
        array("丹麦"),
        array("芬兰"),
        array("匈牙利"),
        array("保加利亚"),
        array("罗马尼亚"),
        array("阿尔巴尼亚"),
        array("冰岛"),
        array("南斯拉夫诸国", "normal", "multe-key", "南斯拉夫", "斯洛文尼亚", "黑山", "塞尔维亚", "克罗地亚", 
                "科索沃", "波黑", "马其顿"),
        array("波罗的海三国", "normal", "multe-key", "立陶宛", "拉脱维亚", "爱沙尼亚"),
    ),
    array
    (
        // 非洲
        array("非盟", "super", "multe-key", "非盟", "非洲联盟"),
        array("南非"),
        array("阿尔及利亚"),
        array("刚果"),
        array("布隆迪"),
        array("安哥拉"),
        array("埃塞俄比亚"),
        array("肯尼亚"),
        array("尼日利亚"),
        array("卢旺达"),
        array("索马里"),
        array("苏丹"),
        array("津巴布韦"),
        array("马达加斯加"),
        array("乍得"),
    ),
    array
    (
        // 美洲
        array("美国", "super", "multe-key", "美国", "美利坚", "纽约", "华盛顿"),
        array("加拿大"),
        array("墨西哥"),
        array("巴西", "super", "multe-key", "巴西"),
        array("阿根廷"),
        array("中美洲七国", "normal", "multe-key", "危地马拉", "伯利兹", "萨尔瓦多", "洪都拉斯", "尼加拉瓜", 
                "哥斯达黎加", "巴拿马"),
        array("委内瑞拉"),
        array("古巴"),
        array("玻利维亚"),
        array("智利"),
        array("哥伦比亚"),
        array("厄瓜多尔"),
        array("巴拉圭"),
        array("秘鲁"),
        array("乌拉圭"),
        array("爱斯基摩"),
    ),
    array
    (
        // 大洋洲等
        array("澳大利亚"),
        array("新西兰"),
        array("巴布亚新几内亚"),
        
        // 国际组织
        array("联合国", "super", "multe-key", "联合国", "安理会"),
        array("世界贸易组织", "super", "multe-key", "世界贸易组织", "世贸", "关贸总协定"),
        array("世界金融体系", "super", "multe-key", "世界银行", "世行", "亚洲开发银行", "布雷顿森林体系", 
                "牙买加货币体系", "IMF", "国际货币基金组织", "特别提款权", "亚洲基础设施投资银行", "亚投行"),
    ),
    array
    (
        // other
    )
);

?>