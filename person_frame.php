
<link rel="stylesheet" type="text/css" href="./style/data.css" />

<?php 
    require_once 'init.php';
    is_user(3);
    require_once "data.php";
    require_once "sql.php";
    require_once "list_control.php";

    // 唯一可设置 list_type 的位置.
    if (!empty($_GET['list_type']) && is_numeric($_GET['list_type']))
    {
        set_current_list($_GET['list_type']);
    }
    
    // 判断当前list table id 是否为人物页面。
    if (get_tag_id_from_index(get_current_list_id()) != get_person_tag_id())
    {
        error_exit("请按照正常流程访问本网站。谢谢。");
    }
    
    // 统一在item_frame.php中处理list的各种过滤器。
    // 1.如果tag被设置,则tag第一优先.
    if(!empty($_GET['property_UUID']))
    {
        set_period_big_index(-1);
        set_period_small_index(-1);
        set_is_search(0);
        set_search_key("");
        
        // all 即显示全部.
        if ($_GET['property_UUID'] == "all")
        {
            set_property_UUID("");
        }
        else 
        {
            set_property_UUID(html_encode($_GET['property_UUID']));
        }
    }
    
    // 2.page 可以和其它各种过滤器配合使用。
    if(!empty($_GET['page']) && is_numeric($_GET['page']))
    {
        set_page($_GET['page']);
    }
    else 
    {
        set_page(1);
    }
    
    // 3. 处理检索
    if (!empty($_GET['search_key']))
    {
        set_is_search(1);
        set_search_key(html_encode($_GET['search_key']));
        
        // search_object 和 tag_type 两字段价值不大，去掉。2015-8-4
        // set_search_object(html_encode($_GET['search_object']));
        // set_search_tag_type(html_encode($_GET['tag_type']));
        
        set_property_UUID("");
    }
    
	// 分配令牌。
	alloc_update_token();
	// alloc_import_token();
	
	// 确认当前tab是否选中
	function get_selected_tab($my_sub_list_type)
	{
		$tab_string = "";
		
		if($my_sub_list_type == get_sub_list_id())
		{
			$tab_string = " selected='true' ";
		}
        
        // 传递 item_list.
        $tab_string .= " href='person_list.php?sub_list_type=" . $my_sub_list_type . "' ";
        
	    return $tab_string;
	}
    
    echo "<div class='easyui-tabs' style='' >";
    
    for ($ii = get_big_person_begin(); $ii <= get_big_person_end(); $ii++)
    {
        $tag_name = get_big_person_name($ii);
        echo "<div title='$tag_name' style='padding:10px;'" . get_selected_tab($ii) . "></div>";
    }
    
    echo "</div>";
?>