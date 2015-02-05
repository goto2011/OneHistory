<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

<?php
    require_once 'init.php';
    is_user(1);
    require_once "data.php";
    require_once "sql.php";
    require_once "list_control.php";
    require_once "list_search.php";
    
    if(!empty($_GET['property_UUID']))
    {
        // all 即显示全部.
        if ($_GET['property_UUID'] == "all")
        {
            set_property_UUID("");
            set_period_big_index(-1);
            set_period_small_index(-1);
            search_param_init();
        }
        else 
        {
            set_property_UUID($_GET['property_UUID']);
        }
    }
    
    if(!empty($_GET['page']))
    {
        set_page($_GET['page']);
    }
    else 
    {
        set_page(1);
    }
    
    if(!empty($_GET['item_index']))
    {
        set_item_index($_GET['item_index']);
    }
    else 
    {
        set_item_index(1);
    }
    
    if(!empty($_GET['big']))
    {
        set_period_big_index($_GET['big']);
    }
    
    if(!empty($_GET['small']))
    {
        set_period_small_index($_GET['small']);
    }
    
    // 处理检索
    if (is_total())
    {
        if(!empty($_GET['search_key']))
        {
            set_is_search(1);
            set_search_key($_GET['search_key']);
            set_search_object($_GET['object']);
            set_search_tag_type($_GET['tag_type']);
            
            if(check_search_param() == false)
            {
                search_param_init();
            }
        }
    }
    else 
    {
        search_param_init();
    }
?>

<link rel="stylesheet" type="text/css" href="./css/easyui.css">
<link rel="stylesheet" type="text/css" href="./css/demo.css">

<link rel="stylesheet" type="text/css" href="./css/data.css" />

<script type="text/javascript" src="./js/jquery.min.js"></script>
<script type="text/javascript" src="./js/jquery.easyui.min.js"></script>

<?php 

	// 分配令牌。
	alloc_update_token();
	alloc_import_token();
	
	// 确认当前tab是否选中
	function get_selected_tab($my_list_type)
	{
		$tab_string = "";
		
		if($my_list_type == get_current_list_id())
		{
			$tab_string = " selected='true' ";
		}
        
        // 传递 item_list.
        $tab_string .= " href='item_list.php?list_type=" . $my_list_type . "' ";
        
		echo $tab_string;
	}
?>

<title>时间</title>
</head>
<body>

<!-- 页眉 begin -->
<iframe name="content" src="./header.php" height="65px" width="100%" scrolling="auto" frameborder="0"></iframe>
<!-- 页眉 end -->

<!-- tab页 begin -->
<div class="easyui-tabs" style="" >

<div title="全部" 	style="padding:10px;" <?php get_selected_tab(1); ?> ></div>

<div title="我的关注" 	style="padding:10px;" <?php get_selected_tab(2); ?> ></div>

<div title="我的小组" 	style="padding:10px;" <?php get_selected_tab(3); ?> ></div>

<!--
// "全部条目"中标签也是按热门指数排序, 重复功能, 此项删除.
<div title="最热门" 		style="padding:10px;" <?php get_selected_tab(4); ?> ></div>
-->

<div title="最新" 		style="padding:10px;" <?php get_selected_tab(5); ?> ></div>

<!--
// 非必须功能.
<div title="无标签" 		style="padding:10px;" <?php get_selected_tab(6); ?> ></div>
-->

<div title="分期" 		style="padding:10px;" <?php get_selected_tab(7); ?> ></div>

<div title="国家民族"   style="padding:10px;" <?php get_selected_tab(12); ?> ></div>

<div title="自由标签"   style="padding:10px;" <?php get_selected_tab(13); ?> ></div>

<div title="事件起止" 	style="padding:10px;" <?php get_selected_tab(8); ?> ></div>

<div title="人物" 		style="padding:10px;" <?php get_selected_tab(9); ?> ></div>

<div title="地理" 		style="padding:10px;" <?php get_selected_tab(10); ?> ></div>

<div title="出处" 		style="padding:10px;" <?php get_selected_tab(11); ?> ></div>

</div>
<!-- tab页 end -->

</body>
</html>