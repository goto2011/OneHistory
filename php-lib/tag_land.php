<?php
// created by duangan, 2015-8-8 -->
// support land deal function.    -->

// 返回大时期的名称
$land_big = array(
    "大海",
    "中国河湖",
    "外国河湖",
    "外国地理单元",
    "中国本部地理单元",
    "中国周边地理单元",
    "中国其它",
    "其它"
);

// 朝代数组
$land = array
(
    array
    (
        // 大海
        array("太平洋"),
        array("大西洋"),
        array("印度洋"),
        array("北冰洋"),
        array("南极洲"),
        
        array("地中海"),
        array("爱琴海"),
        array("北海"),
        array("波罗的海"),
        array("黑海"),
        
        array("南海"),
        array("东海"),
        array("黄海"),
        array("渤海"),
        array("红海"),
        array("波斯湾"),
        array("日本海"),
        
        array("加勒比海"),
        array("墨西哥湾"),
    ),
    array
    (
        // 中国河湖
        array("长江", "super", "multe-key", "长江", "大江", "扬子江"),
        array("黄河"),
        
        array("黑龙江", "normal", "multe-key", "黑龙江", "黑水"),
        array("辽河"),
        array("淮河"),
        array("桑干河"),
        array("渭河"),
        array("京杭大运河"),
        array("珠江"),
        array("塔里木河"),
        array("雅鲁藏布江"),
        array("澜沧江"),
        array("大凌河"),
        array("鄱阳湖"),
        array("洞庭湖"),
        array("太湖"),
        array("青海湖", "normal", "multe-key", "青海湖", "西海"),
        array("纳木错"),
    ),
    array
    (
        // 外国河湖
        array("尼罗河"),
        array("密西西比河"),
        array("亚马逊河"),
        array("多瑙河"),
        array("莱茵河"),
        array("伏尔加河"),
        array("贝加尔湖"),
        
        // 亚洲
        array("两河流域", "super", "multe-key", "两河流域", "幼发拉底河", "底格里斯河"),
        array("里海"),
        array("印度河"),
        array("恒河"),
        array("印度河"),
        array("湄公河"),
        array("红河"),
        array("鸭绿江"),
        array("洞里萨湖"),
        
        // 美洲
        array("五大湖区", "super", "multe-key", "苏必利尔湖", "密歇根湖", "休伦湖", "伊利湖", "安大略湖"),
        array("大熊湖"),
        array("的的喀喀湖"),
        
        // 非洲
        array("尼日尔河"),
        array("刚哥河"),
        array("乍得湖"),
        array("维多利亚湖"),
        array("马拉维湖"),
        array("坦噶尼喀湖"),
    ),
    array
    (
        // 外国地理单元
        array("撒哈拉大沙漠"),
        array("东非大裂谷"),
        array("落基山脉"),
        
    ),
    array
    (
        // 中国本部
        array("中原", "super", "multe-key", "山东", "关东"),
        array("河朔"),
        array("河东"),
        array("河套"),
        array("关中"),
        array("陇西"),
        array("江淮"),
        array("江东"),
        array("两湖"),
        array("巴蜀"),
        array("岭南"),
    ),
    array
    (
        // 中国周边
        array("东北"),
        array("漠北"),
        array("塞北"),
        array("青藏高原"),
        array("云贵高原"),
        
        // 中国西域
        array("西域"),
        array("昆仑山"),
        array("塔里木盆地"),
        array("天山"),
        array("准格尔盆地"),
        array("阿尔泰山"),
    ),
    array
    (
        // 中国其他地理单元
        array("万里长城"),
        array("秦岭"),
        array("河西走廊"),
        array("长江三峡"),
        array("大别山"),
        array("祁连山"),
        array("阴山"),
        array("南岭", "normal", "multe-key", "南岭", "五岭", "越城岭", "都庞岭", "萌渚岭", 
                "骑田岭", "大庾岭"),
        
        array("太行八径", "super", "multe-key", "军都陉", "蒲阴陉", "飞狐陉", "井陉", "滏口陉", 
                "白陉", "太行陉", "轵关陉"),
        array("山海关"),
        array("函谷关"),
        array("潼关"),
        array("嘉峪关"),
        array("玉门关"),
        array("居庸关"),
        array("娘子关"),
        array("平型关"),
        array("剑门关"),
        array("武胜关"),
        array("紫荆关"),
        array("友谊关"),
    ),
    array
    (
        // other
    )
);

?>