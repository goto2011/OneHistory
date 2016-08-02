<link rel="stylesheet" type="text/css" href="./style/data.css" />
<script type='text/javascript' src='./js/data.js'></script>

<?php 
    require_once 'init.php';
    is_user(3);
    require_once "sql.php";
    require_once "data.php";
    require_once "tag.php";
    require_once "list_control.php";
    require_once "view_list.php";
    
    // 判断当前list table id 是否为人物页面。
    if (!is_person(get_current_tag_id()))
    {
        $GLOBALS['log']->error(print_list_param());
        error_exit("请按照正常流程访问本网站。谢谢。");
    }
    
    if (check_list_param() == false)
    {
        // debug.
        $GLOBALS['log']->error(print_list_param());
        error_exit("请按照正常流程访问本网站。谢谢。");
    }
    
    // 唯一可设置 sub_list_id 的位置.
    if (!empty($_GET['sub_list_type']) && is_numeric($_GET['sub_list_type']))
    {
        set_sub_list_id($_GET['sub_list_type']);
        $person_sub_list_id = $_GET['sub_list_type'];
    }
    
    // main().
	flash_item_list();

	// 打印表格(main)
	function flash_item_list()
	{
        $thing_list_begin = strtotime("now");
        $begin_year = 0;
        $end_year = 0;
    $sql_object = sql_object::CONST_OBJECT_INIT;
        $sql_param = array();

        
        // 打开数据库
        $conn = open_db();
        
        // 获取thing数据表的数据
        if (is_tag())
        {
            $sql_param = array("tag_id"=>get_property_UUID());
            $sql_object = sql_object::CONST_TAG;
            // $my_array = get_tag_search_substring(get_property_UUID());   // tag检索
        }
        else
        {
            $sql_param = array("tag_type"=>get_current_tag_id());
            $sql_object = sql_object::CONST_TAG_TYPE;
            // $my_array = get_thing_substring(get_current_tag_id());     // 类型检索
        }
        
        // 获得条目数量.
        $item_count = get_thing_count($sql_object, $sql_param);
        
        // 人物列表暂不支持检索。
        
        // 打印标签区. +1
        print_tags_zone();
        
        // 计算总页数和当前页偏移量.
        $page_size = get_page_size();
        $offset = $page_size * (get_page() - 1);
    // 获得条目数量. ***
    $item_count = get_thing_count($sql_object, $sql_param);
		
    // 打印表格遍历条.
    print_list_control($item_count, $page_size, get_page());
		if (is_tag())
        {
            print_tag_control();
        }
        
        // 2015-4-21
        if (is_show_add_tag())
        {
            print_add_tag_form();
        }
        
        // 打印表头。
		print_item_list_head();   // table head.
        
        if ($item_count > 0)
        {
            // 查询子句增加排序、分页。
            $order_substring = add_order_page_substring($offset, $page_size);
            
            // 完成 事件、标签、事件-标签对的三表联合查询。
            $tag_id_array = array();
            $tag_param_array = array();
            $my_sql_thing = get_thing_tag_prompt($sql_object, $sql_param, $order_substring, 
                    $tag_id_array, $tag_param_array);
        // 获取 thing 数据。***
            $result = get_thing_item_db($sql_object, $sql_param, $order_substring);

            
    		$index = $offset;
    		
    		while($row = mysql_fetch_array($result))
    		{
    			$index++;

    			
    			echo "<tr>";
                if(is_show_add_tag())
                {
                    echo "<td><input name='groupCheckbox[]' type='checkbox' value='" . $row['uuid'] . "'></td>";
                }
                // 序号
    			echo "<td>$index</td>";
                // 时间字段
    			echo "<td>" . get_time_string($row['time'], $row['time_type']) . "</td>";
                // 时间范围字段
    			echo "<td>" . get_time_limit_string($row['time_limit'], $row['time_limit_type']) . "</td>";
    			
                // 死亡人数、受伤人数、失踪人数、字数。
            $person_count_string = print_person_count($row['related_number1'], $row['related_number2'], 
                $row['related_number3'], $row['related_number4']);
                        
                $thing_context = $row['thing'];
                // 事件字段
    			echo "<td><a href='update_input.php?thing_uuid=" . $row['uuid'] . "&update_once=" .
    				get_update_token() . "&item_index=" . $index . "'>" . $thing_context . "</a></td>";
                
            // 标签字段。 ***
    			echo "<td>" . print_item_tags($row['uuid'], $tag_id_array, $tag_param_array, $person_count_string) . "</td>";
    			echo "</tr>";
    		}
    		
    		echo "</table>";
        print_list_control($item_count, $page_size, get_page()); ;// list control.
            
            // log print.
            $time_diff = strtotime("now") - $thing_list_begin; 
            if ($time_diff >= 3)
            {
                $GLOBALS['log']->error(date('H:i:s') . " - " . $time_diff . " - Thing_list_too_long! ");
                $GLOBALS['log']->error("SQL string is: " . $my_sql_thing);
            }
		}

        if (is_tag())
        {
            print_tag_control();
        }
        if (is_show_add_tag())
        {
            echo "</form>";
        }
        
        // exit
        mysql_close($conn);
        $conn = null;
	}
?>

<input type="hidden" id="tag_id" name="tag_id" value="<?=get_property_UUID()?>">
