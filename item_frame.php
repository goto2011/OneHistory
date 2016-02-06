<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link rel="shortcut icon" type="image/x-icon" href="./favicon.ico" />

<?php
    require_once 'init.php';
    is_user(3);
    require_once "data.php";
    require_once "sql.php";
    require_once "list_control.php";
    
    // 检查 list control对象的状态和版本号。
    // list_control 的版本号修改，需要两处修改。这是其中一处。
    if ((get_list_control_init_status() == 0) || (list_control_version_check(5) == 0))
    {
        list_control_init();
        // $GLOBALS['log']->error("test1 - " . print_list_param());
    }
        
    /**
     * 清除检索条件相关字段。
     */
    function empty_search_params()
    {
        set_is_search(0);
        set_search_key("");
        set_search_tag_type(-100);
    }
    
    // 统一在 item_frame.php 中处理list的各种过滤器。规则如下：
    // 0.控制栏点击“回到首页”，则清空所有条件
    if ($_GET['property_UUID'] == "main_all")
    {
        set_period_big_index(-1);
        set_period_small_index(-1);
        
        empty_search_params();
        set_property_UUID("");
        // 返回“全部”tab 页。
        set_current_list(1);
    }
    
    // 1.search要和 tag、period 配合，所以第一优先。
    // 检索条件为空，或者用户点击 全部，或者某个tag，则清空检索。
    if (!empty($_GET['search_key']))
    {
        if ($_GET['search_key'] != "")
        {
            set_is_search(1);
            set_search_tag_type(get_current_tag_id());
        }
        set_search_key(html_encode($_GET['search_key']));
        
        // search_object 和 tag_type 两字段价值不大，去掉。2015-8-4
        // set_search_object(html_encode($_GET['search_object']));
        // set_search_tag_type(html_encode($_GET['tag_type']));
    }
    if ((empty($_GET['search_key'])) && (empty($_GET['page'])))
    {
        // 每个界面都有检索条，所以一旦检索框为空，就清空检索条件。
        empty_search_params();
    }
    
    // 2.如果tag被设置,则清空 search 和 period。
    if(!empty($_GET['property_UUID']))
    {
        set_period_big_index(-1);
        set_period_small_index(-1);
        
        empty_search_params();
        
        // all 即显示全部.
        if (($_GET['property_UUID'] == "all") || ($_GET['property_UUID'] == "main_all"))
        {
            set_property_UUID("");
        }
        else 
        {
            set_property_UUID(html_encode($_GET['property_UUID']));
        }
    }

    // 3.分期之big和small设置，则清空标签和检索。
    if(!empty($_GET['big']) && is_numeric($_GET['big']))
    {
        set_period_big_index($_GET['big']);
        set_property_UUID("");
        empty_search_params();
    }
    if(!empty($_GET['small']) && is_numeric($_GET['small']))
    {
        set_period_small_index($_GET['small']);
    }
    
    // 4.page 可以和其它各种过滤器配合使用。
    if(!empty($_GET['page']) && is_numeric($_GET['page']))
    {
        set_page($_GET['page']);
    }
    else 
    {
        set_page(1);
    }
    
    // 5.item_index 可以和其它各种过滤器配合使用（暂未使用）
    if(!empty($_GET['item_index']) && is_numeric($_GET['item_index']))
    {
        set_item_index($_GET['item_index']);
    }
    else 
    {
        set_item_index(1);
    }
?>

<link rel="stylesheet" type="text/css" href="./style/easyui.css">
<link rel="stylesheet" type="text/css" href="./style/demo.css">

<link rel="stylesheet" type="text/css" href="./style/data.css" />

<script type="text/javascript" src="./js/jquery.min.js"></script>
<script type="text/javascript" src="./js/jquery.easyui.min.js"></script>

<?php 

	// 分配令牌。
	alloc_update_token();
	// alloc_import_token();
	
	// 确认当前tab是否选中
	function get_selected_tab($my_list_type)
	{
		$tab_string = "";
		
		if($my_list_type == get_current_list_id())
		{
			$tab_string = " selected='true' ";
		}
        
        // 传递 item_list.
        if (is_person(get_tag_id_from_index($my_list_type)) == 1)
        {
            $tab_string .= " href='person_frame.php?list_type=" . $my_list_type . "&page=" . get_page() . "' ";
            // $tab_string .= " href='person_frame.php?list_type=" . $my_list_type . "' ";
        }
        else
        {
            $tab_string .= " href='item_list.php?list_type=" . $my_list_type . "' ";
        }
        
	    return $tab_string;
	}
?>

<title>时间</title>
</head>
<body>

<!-- 页眉 begin -->
<iframe name="content" src="./main_header.php" height="48px" width="100%" scrolling="auto" frameborder="0"></iframe>
<!-- 页眉 end -->

<!-- tab页 begin -->
<div class="easyui-tabs" style="" >
    
<?php
    for ($ii = tag_list_min(); $ii <= tag_list_max(); $ii++)
    {
        // 是否显示在tab list中。
        if ((is_show_list_tab($ii) == 1) || ((is_vip_user_show_tab($ii) == 1) && (is_vip_user())))
        {
            $tag_name = get_tag_list_name_from_index($ii);
            echo "<div title='$tag_name' style='padding:10px;'" . get_selected_tab($ii) . "></div>";
        }
    }
?>

</div>
<!-- tab页 end -->

</body>
</html>