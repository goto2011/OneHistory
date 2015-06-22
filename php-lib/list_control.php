<?php
// created by duangan, 2014-12-28 -->
// 处理list 页面的位置, 包括: list_type, property_UUID, page, item_index 四个维度.    -->

require_once 'sql.php';

// 获取 list type 的数量
function get_list_count()
{
    return tag_list_max();
}

// current list
function set_current_list($cur_list)
{
    $_SESSION['current_list'] = $cur_list;
}

function get_current_list_id()
{
    return $_SESSION['current_list'];
}

/**
 * 返回界面是否初始化的状态。
 * @return: 返回1表示已经初始化；返回0表示没有初始化。
 */
function get_list_control_init_status()
{
    if ($_SESSION['list_control_inited'] == 1)
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
    
    for ($ii = 1; $ii <= get_list_count(); $ii++)
    {
        list_param_init($ii);
    }
    
    $_SESSION['list_control_version'] = 3;
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

// 指定 list id 初始化, 系统登录时调用. 将来可做成恢复原状
function list_param_init($list_id)
{
    $session_name = "list_number_" . $list_id;
    unset($_SESSION[$session_name]);   // 这是一个array，需要内存回收。
    
    $_SESSION[$session_name] = array("property_UUID"=>"", "page"=>1, "item_index"=>1,
        "period_big_index"=>-1, "period_small_index"=>-1, "sub_list_id"=>1);
}

// 为了调试方便，打印 list控制变量
function print_list_param()
{
    $list_info = get_current_list();
    echo get_current_list_id() . " - " . get_list_count() . " - " . $list_info['page'] 
        . " - " . $list_info['item_index'] . "<br/>";
}

// 判断传入的参数是否 ok 
function check_list_param()
{
    if((get_current_list_id() > get_list_count()) || (get_current_list_id() <= 0))
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

// 是否显示指定 tag list.
function is_tag()
{
    // tag 为空表示显示所有节点.
    return (get_property_UUID() != "");
}

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
    if (($my_array = get_tag_type_from_UUID(get_property_UUID())) != NULL)
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

// 判断是不是 period tag.
function is_period_tag()
{
    return ((is_period() == 1) && (get_period_big_index() != -1) 
        && (get_period_small_index() != -1));
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

?>
