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
                    echo "ok1-" . $vip_tag_count;
                }
            }
            if ($_GET['step'] > 0) {
                $my_tag_name = vip_tag_search_to_db($vip_tag_object, $tag_index, $tag_step);
                if ($my_tag_name != "okok") {
                    echo "ok2-" . $my_tag_name;
                } else {
                    echo "ok3";
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
    
    // 修改标签属性
    else if($_GET['operate_type'] == "tag_property_modify")
    {
        $tag_type = get_tag_id_from_index(html_encode($_GET['vip_tag_checked']));
        $result = get_tags_db($tag_type, 1000);
        $tags_name = array();
        
        $ii = 0;
        while($row = mysql_fetch_array($result))
        {
            // $tags_name[$row['property_UUID']] = iconv("gb2312", "utf-8", $row['property_name']);
            // $tags_name[$row['property_UUID']] = urlencode($row['property_name']);
            $tags_name[$ii] = array($row['property_UUID'], urlencode($row['property_name']));
            $ii++;
        }
        
        echo urldecode(json_encode($tags_name));
    }
    
    // 修改标签属性
    else if($_GET['operate_type'] == "tag_selected")
    {
        $tag_id = html_encode($_GET['selected_tag_id']);
        
        $row = get_tag_from_UUID($tag_id);
        $tag_param = array();
        
        echo urldecode(json_encode($tag_param));
    }

    // exit.
    mysql_close($conn);
    $conn = null;
    
?>