<?php
// created by duangan, 2015-4-19 -->
// support dynasty deal function.    -->

$dynasty_big = array
(
    "正朔朝代",
    "春秋战国列国",
    "地方政权",
    "周边少数民族",
    "组织",
    "其它"
);

// 朝代数组
$dynasty = array
(
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
        array("中华人民共和国", "normal", "tag-time", "中国", "1949", "2100"),
        
        array("中华民国台湾", "super", "multe-key", "台湾", "台北", "高雄", "台南", "台中", 
                "蒋经国", "李登辉", "陈水扁", "马英九"),
        array("香港", "normal", "multe-key", "香港", "九龙", "新界", "特首"),
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
        array("北魏", "normal", "key-time", "北魏", "拓跋代", "代国", "258", "534"),
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
        array("鲜卑", "super", "multe-key", "鲜卑"),
        array("东胡"),
        array("乌桓"),
        array("吐谷浑"),
        array("柔然"),
        array("契丹", "super", "multe-key", "契丹"),
        array("室韦"),
        array("蒙古", "super", "multe-key", "蒙古"),
        array("准噶尔汗国"),
        array("女真", "super", "multe-key", "女真"),
        array("满族", "super", "multe-key", "满族"),
        
        array("濊貊"),
        array("扶余"),
        array("沃沮"),
        array("高句丽", "super", "multe-key", "高句丽"),
        array("古朝鲜", "normal", "multe-key", "弁韩", "马韩", "辰韩", "百济", "新罗", "高丽"),
        
        array("粛慎"),
        
        // 北方
        array("匈奴", "super", "multe-key", "匈奴"),
        array("羯"),
        array("氐"),
        array("鞑靼"),
        
        array("敕勒", "normal", "multe-key", "铁勒", "丁零", "高车"),
        array("回纥"),
        array("维吾尔人"),
        
        // 突厥民族
        array("突厥", "super", "multe-key", "突厥"),
        array("沙陀"),
        
        // 西方
        array("戎"),
        array("羌"),
        array("党项", "super", "multe-key", "党项"),
        array("吐蕃", "super", "multe-key", "吐蕃"),
        
        // 南方
        array("苗人", "super", "multe-key", "苗人"),
        array("壮人"),
        array("黎人"),
        
        // 西域
        array("月氏", "super", "multe-key", "月氏"),
        array("贵霜帝国"),
        array("乌孙"),
        array("鄯善", "normal", "multe-key", "鄯善", "楼兰"),
        array("车师"),
        array("高昌"),
        array("疏勒"),
        array("于阗"),
        array("龟玆"),
        array("焉耆"),
        
        // 周边地区
        array("西藏", "super", "multe-key", "西藏", "藏传佛教", "达赖", "班禅"),
        array("新疆", "super", "multe-key", "新疆"),
    ),
    array
    (
        // 组织
        array("中国共产党", "super", "multe-key", "中国共产党", "中共"),
        array("中国国民党", "super", "multe-key", "国民党", "孙中山", "蒋介石"),
        array("民主进步党", "normal", "multe-key", "民主进步党", "民进党"),
        array("人民解放军", "normal", "multe-key", "人民解放军", "解放军", "红军", "八路军", "新四军"),
    ),
    array
    (
        // other.
    )
);

?>