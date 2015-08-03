<?php
// created by duangan, 2015-2-1 -->
// support item_tag search function.    -->

// 字段说明：
// is_search: 是否是检索；
// search_key: 检索关键字；
// search_object: 待检索对象。（未使用）
// tag_type: 检索tag的类型。（未使用）
// tag_uuid: 待检索 tag uuid.
// begin_year: 按时间检索之开始年份.
// end_year: 按时间检索至结束年份.

// search 参数初始化.
function search_param_init()
{
    $_SESSION["search_param"] = array("is_search"=>0, "search_key"=>"",
         "search_object"=>"tag_item", "tag_type"=>1, "tag_uuid"=>"", "begin_year"=>-1, "end_year"=>-1);
}

// 判断传入的参数是否 ok 
function check_search_param()
{
    if(trim(search_key()) == "")
    {
        return false;
    }
    
    if ((search_object() != "tag_item") && (search_object() != "tag_only"))
    {
        return false;
    }
    
    if ((search_tag_type() < 0) || (search_tag_type() > 7))
    {
        return false;
    }
    
    return true;
}

// get_search_param
function get_search_param()
{
    if (is_search() != 1)
    {
        search_param_init();
    }
    return $_SESSION["search_param"];
}

// is_search. 0:no; 1:yes.
function set_is_search($is_search)
{
    $_SESSION["search_param"]["is_search"] = $is_search;
}
function is_search()
{
    return ($_SESSION["search_param"]["is_search"] 
        && $_SESSION["search_param"]["search_key"] != "");
}

// search_key
function set_search_key($search_key)
{
    $_SESSION["search_param"]["search_key"] = $search_key;
}
function search_key()
{
    if (is_search() == 1)
    {
        return $_SESSION["search_param"]["search_key"];
    }
    else 
    {
        return "";
    }
}

// search_object
function set_search_object($search_object)
{
    $_SESSION["search_param"]["search_object"] = $search_object;
}
function search_object()
{
    if (is_search() == 1)
    {
        return $_SESSION["search_param"]["search_object"];
    }
    else
    {
        return "tag_item";
    }
}

// tag_type
function set_search_tag_type($tag_type)
{
    $_SESSION["search_param"]["tag_type"] = $tag_type;
}
function search_tag_type()
{
    if (is_search() == 1)
    {
        return $_SESSION["search_param"]["tag_type"];
    }
    else
    {
        return 1;
    }
}

// tag_uuid: 待检索 tag uuid.
function set_search_tag_uuid($tag_type)
{
    $_SESSION["search_param"]["tag_uuid"] = $tag_type;
}
function search_tag_uuid()
{
    if (is_search() == 1)
    {
        return $_SESSION["search_param"]["tag_uuid"];
    }
    else
    {
        return "";
    }
}

// begin_year: 按时间检索之开始年份.
function set_search_begin_year($tag_type)
{
    $_SESSION["search_param"]["begin_year"] = $tag_type;
}
function search_begin_year()
{
    if (is_search() == 1)
    {
        return $_SESSION["search_param"]["begin_year"];
    }
    else
    {
        return -1;
    }
}

// end_year: 按时间检索至结束年份.
function set_search_end_year($tag_type)
{
    $_SESSION["search_param"]["end_year"] = $tag_type;
}
function search_end_year()
{
    if (is_search() == 1)
    {
        return $_SESSION["search_param"]["end_year"];
    }
    else
    {
        return -1;
    }
}
?>