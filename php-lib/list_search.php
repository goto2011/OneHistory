<?php
// created by duangan, 2015-2-1 -->
// support item_tag search function.    -->

// search 参数初始化.
function search_param_init()
{
    $_SESSION["search_param"] = array("is_search"=>0, "search_key"=>"",
         "search_object"=>"tag_item", "tag_type"=>1);
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

// is_search. 0:no; 1:yes.
function set_is_search($is_search)
{
    $_SESSION["search_param"]["is_search"] = $is_search;
}
function is_search()
{
    return $_SESSION["search_param"]["is_search"];
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
?>