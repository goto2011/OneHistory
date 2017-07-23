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
