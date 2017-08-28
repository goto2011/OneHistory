<?php
    // created by duangan, 2015-1-27-->
    // support system_manager_do.    -->
    
    require_once '../init.php';
    is_user(2);
    require_once "sql.php";
    
    if(empty($_GET['operate_type']))
    {
        echo "parameter_error";
        exit;
    }
    
    $conn = open_db();
    
    // 计算时间轴指数
    if($_GET['operate_type'] == "re_calc_year_order")
    {
        if (re_calc_year_order() == 1)
        {
            echo "ok";
        }
        else
        {
            echo "fail";
        }
    }
    
    // 计算tag热门指数
    else if ($_GET['operate_type'] == "re_calc_tag_hot_index")
    {
        if (re_calc_tag_hot_index() == 1)
        {
            echo "ok";
        }
        else
        {
            echo "fail";
        }
    }
    
    // 批量更新事件-VIP标签
    // step1: 获取vip tag的数量。
    // step2: 一个个的刷新。
    // step3: 完成。
    // 然后一个环节出错就终止。
    else if($_GET['operate_type'] == "re_thing_add_vip_tag")
    {
        // 本函数执行时间长，去掉php执行时间限制。
        ini_set('max_execution_time', '0');
        
        $tag_index = html_encode($_GET['vip_tag_checked']);
        $tag_step = html_encode($_GET['step']);
        $vip_tag_object = get_vip_tag_object($tag_index);
        if (($vip_tag_object == NULL) || (!is_numeric($tag_step))) {
            echo "fail";
        } else {
            if ($_GET['step'] == 0) {
                $vip_tag_count = get_vip_tag_count($vip_tag_object);
                if ($vip_tag_object == 0) {
                    echo "fail";
                } else {
                    echo "step1-" . $vip_tag_count;
                }
            }
            if ($_GET['step'] > 0) {
                $my_tag_name = vip_tag_search_to_db($vip_tag_object, $tag_index, $tag_step);
                if ($my_tag_name != "okok") {
                    echo "step2-" . $my_tag_name;
                } else {
                    echo "step3";
                }
            }
        }
        // 恢复php执行时间限制。
        ini_set('max_execution_time', '1500');
    }
	
	// 计算事件-标签类型映射
	else if($_GET['operate_type'] == "re_add_thing_tag_map")
	{
	    set_time_limit(0);
        
        if (re_add_thing_tag_map() == 1)
        {
            echo "ok";
        }
        else
        {
            echo "fail";
        }
	}
    
    // 修改标签属性 step1 - 返回指定类型的tags。
    else if($_GET['operate_type'] == "select_vip_tag_type")
    {
        $tag_type = get_tag_id_from_index(html_encode($_GET['vip_tag_checked']));
        $result = get_tags_db($tag_type, 1000, 1);
        echo get_json_from_tags_db($result);
    }
    
    // 修改标签属性 step2 - 返回指定标签的属性
    else if($_GET['operate_type'] == "tag_selected")
    {
        $tag_id = html_encode($_GET['selected_tag_id']);
        $row = get_tag_from_UUID($tag_id);
        $tag_param = array($row['property_UUID'], $row['property_name'], $row['hot_index'], 
            $row['tag_begin'], $row['tag_bigday'], $row['tag_end'], $row['tag_tree_type'], 
            $row['parent_tag']);
        
        echo urldecode(json_encode($tag_param));
    }
    
    // 修改标签属性 step3 - 选择标签树类型
    else if($_GET['operate_type'] == "tag_tree_type_selected")
    {
        $tag_tree_type_id = html_encode($_GET['selected_tag_tree_type_id']);
        $result = get_tags_by_tree_type($tag_tree_type_id);
        echo get_json_from_tags_db($result);
    }

    // 修改标签属性 step4 - 保存指定标签的属性
    else if($_GET['operate_type'] == "tag_property_save")
    {
        $tag_id = html_encode($_GET['selected_tag_id']);
        
        $begin_time = html_encode($_GET['begin_time']);
        $big_day = html_encode($_GET['big_day']);
        $end_time = html_encode($_GET['end_time']);
        $tag_tree_type = html_encode($_GET['tag_tree_type']);
        $parent_node = html_encode($_GET['parent_node']);
        echo "mm";
        // 保存
        if(save_tag_params($tag_id, get_year_order_from_simple_time($begin_time), 
            get_year_order_from_simple_time($big_day), get_year_order_from_simple_time($end_time),
            $tag_tree_type, $parent_node) == true)
        {
            echo "ok";
        } else {
            echo "fail";
        }
    }
    
    // exit.
    mysql_close($conn);
    $conn = null;
    
?>