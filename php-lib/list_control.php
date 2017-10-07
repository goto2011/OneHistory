<?php
// created by duangan, 2014-12-28 -->
// 处理list 页面的位置, 核心控制结构。  -->
// V4: 增加 is_search， search_key 。 

require_once 'sql.php';

// 字段列表：
// property_UUID: tag uuid.
// page: page index.
// item_index: item index(暂时没有使用)
// period_big_index: period big index.
// period_small_index: period small index.
// sub_list_id: 子页id（只在 人物 页面用）.
// is_search: 是否是检索；
// search_key: 检索关键字；
// search_tag_type: 当前检索类型。

// tab type 枚举量控制。
// tab type id = list type id (list type / list id)， 即伟大的 $tag_control 的下标。
// 而 tag type id (tag type / tag id) 是 tab type id 的一部分。
class tab_type {
    const CONST_TOTAL       = -1;
    const CONST_MY_FOLLOW   = -2; 
    const CONST_NEWEST      = -3;  // deleted, 2016-01-10
    const CONST_PERIOD      = -4;
    const CONST_BEGIN       = 1;
    const CONST_END         = 2;
    const CONST_RESURCE     = 3;
    const CONST_PERSON      = 4;
    const CONST_CITY        = 5;
    const CONST_FREE        = 6;
    const CONST_COUNTRY     = 7;
    const CONST_DYNASTY     = 8;
    const CONST_OFFICE      = 9;   // deleted, 2016-01-10
    const CONST_TOPIC       = 10;
    const CONST_KEY_THING   = 11;  // deleted, 2016-01-10
    const CONST_MANAGER     = 12;
    const CONST_NOTE        = 13;
    const CONST_LAND        = 14;
    const CONST_DIE         = 15;  // add, 2016-01-10
    const CONST_SOLUTION    = 16;  // add，2016-01-10
}

// tag list 、tag index、tag id 对应关系。
// [0]表示数据库中的tag type；为负数表示不保存到数据库，只在逻辑上使用。
// [1]表示标签名称；
// [2]表示是标签显示特征：
//      0-tab，非tag；
//      1-tag tab；
//      2-tag，非tab；
//      3-管理用户才显示的
// [3]表示是否为 vip tag (0不是，1是)。
// [4]表示tag 输入框的id（字符串，用于import/input页面）。
$tag_control = array(
    array(tab_type::CONST_TOTAL,          "全部",             0,    0,      ""),
    // “我的关注”合并到首页。
    // array(tab_type::CONST_MY_FOLLOW,      "我的关注",         0,    0,      ""),
    // array(tab_type::CONST_NEWEST,         "最新标签",         0,    0,      ""),
    array(tab_type::CONST_PERIOD,         "时期",             0,    1,      ""),                // vip tag.
    array(tab_type::CONST_PERSON,         "人物",             1,    1,      "person_tags"),     // vip tag.
    array(tab_type::CONST_DIE,            "战争及死亡史",       1,   1,      "die_tags"),         // vip tag.
    array(tab_type::CONST_SOLUTION,       "人性和解决方案",     1,    1,      "solution_tags"),   // vip tag.
    array(tab_type::CONST_COUNTRY,        "世界历史",          1,    1,      "country_tags"),    // vip tag.
    array(tab_type::CONST_DYNASTY,        "中国历史",          1,    1,      "dynasty_tags"),    // vip tag.
    array(tab_type::CONST_TOPIC,          "领域",              1,   1,      "topic_tags"),      // vip tag.
    // array(tab_type::CONST_LAND,           "地理",           1,    1,      "land_tags"),       // vip tag.
    // array(tab_type::CONST_CITY,           "城市",           1,    1,      "geography_tags"),  // vip tag.
    // array(tab_type::CONST_KEY_THING,      "关键事件",        1,    1,      "key_tags"),        // vip tag.
    // array(tab_type::CONST_OFFICE,         "官制",           1,    0,      "office_tags"),
    // array(tab_type::CONST_BEGIN,          "事件开始",        2,    0,      "start_tags"),
    // array(tab_type::CONST_END,            "事件结束",        2,    0,      "end_tags"),
    array(tab_type::CONST_RESURCE,        "出处",              1,    0,      "source_tags"),
    array(tab_type::CONST_NOTE,           "笔记",              1,    0,      "note_tags"),
    array(tab_type::CONST_FREE,           "自由标签",           1,    0,      "free_tags"),
    array(tab_type::CONST_MANAGER,        "管理",              3,    0,      ""),
    array(tab_type::CONST_MANAGER,        "用户",              3,    0,      ""),
);

// 获取tag list 最小值
function tag_list_min()
{
    return 1;
}

// 获取tag list 的最大值
function tag_list_max()
{
    global $tag_control;
    return count($tag_control);
}


/**
 * 根据排列顺序给出tag 属性。2015-5-3.
 */
function get_tag_list_from_index($tag_index_id)
{
    global $tag_control;
    
    if($tag_index_id > count($tag_control))
    {
        return -1;
    }
    else
    {
        return $tag_control[$tag_index_id - 1];
    }
}

/**
 * 将 数组下标 转化为 tag id。 
 * 返回值：大于 0 表示为数据库中真实的tag type id；小于 0表示 tab id；-100 表示非法值。
 */
function get_tag_id_from_index($tag_index_id)
{
    $my_tag_list = get_tag_list_from_index($tag_index_id); 
    if ($my_tag_list != -1)
    {
        return $my_tag_list[0];
    }
    else 
    {
        return -100;
    }
}

/**
 * 根据数组下标 获取 tag 名称。 返回-2表示非法值。
 */
function get_tag_list_name_from_index($tag_index_id)
{
    $my_tag_list = get_tag_list_from_index($tag_index_id); 
    if ($my_tag_list != -1)
    {
        return $my_tag_list[1];
    }
    else 
    {
        return -2;
    }
}

/**
 * 根据数组下标 获取显示属性。 返回-2表示非法值。
 */
function get_tag_show_type_from_index($tag_index_id)
{
    $my_tag_list = get_tag_list_from_index($tag_index_id); 
    if ($my_tag_list != -1)
    {
        return $my_tag_list[2];
    }
    else 
    {
        return -2;
    }
}

/**
 * 根据数组下标 获取key tag属性。 返回-2表示非法值。
 */
function get_key_tag_type_from_index($tag_index_id)
{
    $my_tag_list = get_tag_list_from_index($tag_index_id); 
    if ($my_tag_list != -1)
    {
        return $my_tag_list[3];
    }
    else 
    {
        return -2;
    }
}

/**
 * 根据数组下标 获取 tag input id 属性。 返回""表示非法值。
 */
function get_tag_key_from_index($tag_index_id)
{
    $my_tag_list = get_tag_list_from_index($tag_index_id); 
    if ($my_tag_list != -1)
    {
        return $my_tag_list[4];
    }
    else 
    {
        return "";
    }
}

/**
 * 是否显示在tag input界面（即import/udpate页面）上，即为真正的tag。
 */
function is_show_input_tag($tag_index_id)
{
    $tag_show = get_tag_show_type_from_index($tag_index_id);
    
    if (($tag_show == 1) || ($tag_show == 2))
    {
        return 1;
    }
    else 
    {
        return 0;
    }
}

/**
 * 是否显示在主界面的标签栏上. tag id + tab id.
 */
function is_show_list_tab($tag_index_id)
{
    $tag_show = get_tag_show_type_from_index($tag_index_id);
    
    if (($tag_show == 0) || ($tag_show == 1))
    {
        return 1;
    }
    else 
    {
        return 0;
    }
}

/**
 * 是否显示检索、add tag等界面.
 */
function is_show_search_add($tag_index_id)
{
    $tag_show = get_tag_show_type_from_index($tag_index_id);
    
    if ($tag_show == 1)
    {
        return 1;
    }
    else 
    {
        return 0;
    }
}

/**
 * 是否为vip用户才显示的tab界面.
 */
function is_vip_user_show_tab($tag_index_id)
{
    $tag_show = get_tag_show_type_from_index($tag_index_id);
    
    // 3是管理界面
    if ($tag_show == 3)
    {
        return 1;
    }
    else 
    {
        return 0;
    }
}

/**
 * 是否是 vip tag.
 */
function is_vip_tag_tab($tag_index_id)
{
    $tag_show = get_key_tag_type_from_index($tag_index_id);
    
    if ($tag_show == 1)
    {
        return 1;
    }
    else 
    {
        return 0;
    }
}


// 获取“我的关注”的 tab id.
function get_myfollow_id()
{
    return tab_type::CONST_MY_FOLLOW;
}

// current list
function set_current_list($cur_list)
{
    $_SESSION['current_list'] = $cur_list;
    $_SESSION['current_tag'] = get_tag_id_from_index($cur_list);
}

function get_current_list_id()
{
    return $_SESSION['current_list'];
}

function get_current_tag_id()
{
    return $_SESSION['current_tag'];
}

/**
 * 返回界面是否初始化的状态。
 * @return: 返回1表示已经初始化；返回0表示没有初始化。
 */
function get_list_control_init_status()
{
    if (isset($_SESSION['list_control_inited'])  && $_SESSION['list_control_inited'] == 1)
    {
        return 1;
    }
    else 
    {
        return 0;
    }
}

// list 控制对象 初始化
function list_control_init()
{
    set_current_list(1);
    
    for ($ii = 1; $ii <= tag_list_max(); $ii++)
    {
        list_param_init($ii);
    }
    
    // list_control 的版本号修改，需要两处修改。这是其中一处。
    $_SESSION['list_control_version'] = 5;
    $_SESSION['list_control_inited'] = 1;
}

/**
 * 检查 list 控制对象的版本号。
 * @return: 返回1表示当前版本正确；返回0表示不正确。
 */
function list_control_version_check($this_verson = 3)
{
    if ($_SESSION['list_control_version'] == $this_verson)
    {
        return 1;
    }
    else 
    {
        return 0;
    }
}

// list 界面重新初始化
function list_control_reinit()
{
    $_SESSION['list_control_inited'] = 0;
    list_control_init();
}

// 获得当前 list 的结构信息
function &get_current_list()
{
    $session_name = "list_number_" . $_SESSION['current_list'];
    return $_SESSION[$session_name];
}

// 指定 list id 初始化, 系统登录时调用. 将来可做成恢复原状.
function list_param_init($list_id)
{
    $session_name = "list_number_" . $list_id;
    unset($_SESSION[$session_name]);   // 这是一个array，需要内存回收。
    
    $_SESSION[$session_name] = array("property_UUID"=>"", "page"=>1, "item_index"=>1,
        "period_big_index"=>-1, "period_small_index"=>-1, "sub_list_id"=>1, 
        "is_search"=>0, "search_key"=>"", "search_tag_type"=>-100);
}

// 为了调试方便，打印 list控制变量
function print_list_param()
{
    $list_info = get_current_list();
    return get_current_list_id() . " - " . get_current_tag_id() . " - " . tag_list_max() . " - " 
        . $list_info['page'] . " - " . $list_info['item_index'] . "<br/>";
}

// 判断传入的参数是否 ok。
function check_list_param()
{
    if((get_current_list_id() > tag_list_max()) || (get_current_list_id() <= 0))
    {
        return false;
    }
    
    $list_info = get_current_list();
    if (($list_info['page'] == 0) || ($list_info['item_index'] == 0))
    {
        return false;
    }
    return true;
}

//////////////////// set / get /////////////////////////////////////////       

// property_UUID
function set_property_UUID($property_UUID)
{
    $list_info = &get_current_list();
    $list_info['property_UUID'] = $property_UUID;
}

function get_property_UUID()
{
    $list_info = get_current_list();
    return $list_info['property_UUID'];
}

// 获取当前 tag 的 name.
function get_property_name()
{
    if (($my_array = get_tag_from_UUID(get_property_UUID())) != NULL)
    {
        return $my_array['property_name'];
    }
    else 
    {
        return "";
    }
}

// page
function set_page($page)
{
    $list_info = &get_current_list();
    $list_info['page'] = $page;
}

function get_page()
{
    $list_info = get_current_list();
    return $list_info['page'];
}

// item_index
function set_item_index($item_index)
{
    $list_info = &get_current_list();
    $list_info['item_index'] = $item_index;
}

function get_item_index()
{
    $list_info = get_current_list();
    return $list_info['item_index'];
}

// period_big_index
function set_period_big_index($period_big_index)
{
    $list_info = &get_current_list();
    $list_info['period_big_index'] = $period_big_index;
}

function get_period_big_index()
{
    $list_info = get_current_list();
    return $list_info['period_big_index'];
}

// period_small_index
function set_period_small_index($period_small_index)
{
    $list_info = &get_current_list();
    $list_info['period_small_index'] = $period_small_index;
}

function get_period_small_index()
{
    $list_info = get_current_list();
    return $list_info['period_small_index'];
}

// sub_list_id
function set_sub_list_id($sub_list_id)
{
    $list_info = &get_current_list();
    $list_info['sub_list_id'] = $sub_list_id;
}

function get_sub_list_id()
{
    $list_info = get_current_list();
    return $list_info['sub_list_id'];
}

// is_search. 0:no; 1:yes.
function set_is_search($is_search)
{
    $list_info = &get_current_list();
    $list_info['is_search'] = $is_search;
}

// search_key
function set_search_key($search_key)
{
    $list_info = &get_current_list();
    $list_info['search_key'] = $search_key;
}
function search_key()
{
    if (is_search() == 1)
    {
        $list_info = get_current_list();
        return $list_info['search_key'];
    }
    else 
    {
        return "";
    }
}

// search_tag_type
function set_search_tag_type($search_tag_type)
{
    $list_info = &get_current_list();
    $list_info['search_tag_type'] = $search_tag_type;
}
function search_tag_type()
{
    if (is_search() == 1)
    {
        $list_info = get_current_list();
        return $list_info['search_tag_type'];
    }
    else
    {
        return -100;
    }
}
///////////////////////////////////////////////////////////////////////////  
/////////////////////////  tab页 管理方法 /////////////////////////////////

// 是否是检索。
function is_search()
{
    $list_info = get_current_list();
    return ($list_info['is_search'] && ($list_info['search_key'] != ""));
}

// 判断是不是 period tag。
function is_period_tag($tag_id)
{
    return ((is_period($tag_id) == 1) && (get_period_big_index() != -1) 
        && (get_period_small_index() != -1));
}

// 是否显示指定 tag list.
function is_tag()
{
    // tag 为空表示显示所有节点.
    return ((get_property_UUID() != "") and (!is_search()));
}

/**
 * 是否是 "全部"。
 */
function is_total($tag_id)
{
    return ($tag_id == tab_type::CONST_TOTAL);
}
 
/**
 * 是否是 我的关注 tab页。
 */
function is_my_follow($tag_id)
{
    return ($tag_id == tab_type::CONST_MY_FOLLOW);
}

/**
 * 是否是 最新 tab页.
 */
function is_newest($tag_id)
{
    return ($tag_id == tab_type::CONST_NEWEST);
}

/**
 * 是否是 period tab页.
 */
function is_period($tag_id)
{
    return ($tag_id == tab_type::CONST_PERIOD);
}

/**
 * 判断当前是否是 中国朝代 页面.
 */
function is_dynasty($tag_id)
{
    return ($tag_id == tab_type::CONST_DYNASTY);
}

/**
 * 判断当前是否是 国家民族 页面.
 */
function is_country($tag_id)
{
    return ($tag_id == tab_type::CONST_COUNTRY);
}

/**
 * 判断当前是否是 专题 页面.
 */
function is_topic($tag_id)
{
    return ($tag_id == tab_type::CONST_TOPIC);
}

// 判断当前是否是 city 页面.
function is_city($tag_id)
{
    return ($tag_id == tab_type::CONST_CITY);
}

// 判断当前是否是 land 页面.
function is_land($tag_id)
{
    return ($tag_id == tab_type::CONST_LAND);
}

/**
 * 判断当前是否是 person 页面.
 */
function is_person($tag_id)
{
    return ($tag_id == tab_type::CONST_PERSON);
}

/**
 * 判断当前是否是 key_thing 页面.
 */
function is_key_thing($tag_id)
{
    return ($tag_id == tab_type::CONST_KEY_THING);
}

/**
 * 判断指定 tag type 是否是出处。
 */
function is_source($tag_id)
{
    return ($tag_id == tab_type::CONST_RESURCE);
}

/**
 * 判断当前是否是 笔记 页面.
 */
function is_note($tag_id)
{
    return ($tag_id == tab_type::CONST_NOTE);
}

/**
 * 判断当前是否是 管理 页面.
 */
function is_manager_tab($tag_id)
{
    return ($tag_id == tab_type::CONST_MANAGER);
}

/**
 * 获取 笔记 tag type 的id。
 */
function get_note_tag_id()
{
    return tab_type::CONST_NOTE;
}



?>
