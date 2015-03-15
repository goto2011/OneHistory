<?php
// created by duangan, 2014-12-28 -->
// 处理list 页面的位置, 包括: list_type, property_UUID, page, item_index 四个维度.    -->

require_once 'sql.php';

// 获取 list type 的数量
function get_list_count()
{
    return 13;
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

// 获得当前 list 的结构信息
function &get_current_list()
{
    $session_name = "list_number_" . $_SESSION['current_list'];
    return $_SESSION[$session_name];
}

// list 界面初始状态, 系统登录时调用. 将来可做成恢复原状
function list_param_init($list_id)
{
    $session_name = "list_number_" . $list_id;
    $_SESSION[$session_name] = array("property_UUID"=>"", "page"=>1, "item_index"=>1,
        "period_big_index"=>-1, "period_small_index"=>-1);
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

// 是否是"全部"tab 页
function is_total()
{
    return (get_current_list_id() == 1);
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
    return get_tag_name_from_UUID(get_property_UUID());
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
    return ((get_current_list_id() == 7) && (get_period_big_index() != -1) 
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

?>
