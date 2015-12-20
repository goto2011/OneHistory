<link rel="stylesheet" type="text/css" href="./style/data.css" />
<script type='text/javascript' src='./js/data.js'></script>

<?php 
    require_once 'init.php';
    is_user(3);
    require_once "sql.php";
    require_once "data.php";
    require_once 'tag.php';;
    require_once "list_control.php";
    
    // 判断当前list table id 是否为人物页面。
    if (get_tag_id_from_index(get_current_list_id()) != get_person_tag_id())
    {
        error_exit("请按照正常流程访问本网站。谢谢。");
    }
    
    if (check_list_param() == false)
    {
        // debug.
        print_list_param();
        error_exit("请按照正常流程访问本网站。谢谢。");
    }
    
    // 唯一可设置 list_type 的位置.
    if (!empty($_GET['sub_list_type']) && is_numeric($_GET['sub_list_type']))
    {
        set_sub_list_id($_GET['sub_list_type']);
        $person_sub_list_id = $_GET['sub_list_type'];
    }
    
    // main().
	flash_item_list();
    
    // 打印其它非 vip tag。
    function create_other_link(&$tags_db)
    {
        $result = "";
        
        $my_vip_tag = vip_tag_struct_init(tab_type::CONST_PERSON);
        
        for ($ii = $my_vip_tag->get_big_begin(); $ii <= $my_vip_tag->get_big_end(); $ii++)
        {
            for ($jj = $my_vip_tag->get_small_begin($ii); $jj <= $my_vip_tag->get_small_end($ii); $jj++)
            {
                $my_name = $my_vip_tag->get_tag_name($ii, $jj);
                search_tag_from_array($my_name, $tags_db, 1);
            }
        }
        
        while(list($key, $value) = each($tags_db))
        {
            $result .= "<a id='tag_normal' href='item_frame.php?property_UUID=" . $key 
                . "'>". $value . "</a>";
        }
        
        return $result;
    }
    
    // 打印 person 链接. 2015-5-8
    function create_person_link($index, &$tags_db)
    {
        $result = "";
        
        $my_vip_tag = vip_tag_struct_init(tab_type::CONST_PERSON);
        
        for ($ii = $my_vip_tag->get_small_begin($index); $ii <= $my_vip_tag->get_small_end($index); 
                $ii++)
        {
            $my_name = $my_vip_tag->get_tag_name($index, $ii);
            
            // 标签数组不删除。
            $my_uuid = search_tag_from_array($my_name, $tags_db, 0);
            
            if ($my_uuid != "")
            {
                $result .= "<a id='tag_normal' href='item_frame.php?property_UUID=" . 
                    $my_uuid . "'>". $my_name . "</a>";
            }
            else 
            {
                $result .= "<span id='tag_nothing'>" . $my_name . "</span>";
            }
        }
        
        return $result;
    }
    
	// 打印标签区
	function print_tags_zone()
	{
        global $person_sub_list_id;
        
		echo "<div align='left'>";
		echo "<p><span id='tag_type'>标签:</span>";
        
        // 打印"全部"
        echo "<a id='tag_super' href='item_frame.php?property_UUID=all'>全部</a>";
        
        // 打印标签
        echo "<br />";
        $tags_array = get_tags_array(get_current_list_id());
        
        $my_vip_tag = vip_tag_struct_init(tab_type::CONST_PERSON);
        
        // 处理 人物 之 其它 子页面.
        if ($person_sub_list_id != $my_vip_tag->get_big_end())
        {
            echo "<span id='tag_type'>" . $my_vip_tag->get_big_name($person_sub_list_id) . ":</span>" 
                . create_person_link($person_sub_list_id, $tags_array) . "<br />";
        }
        else
        {
            echo "<span id='tag_type'>" . $my_vip_tag->get_big_name($person_sub_list_id) . ":</span>" 
                . create_other_link($tags_array) . "<br />";
        }
		echo "</div>";
	}

	// 打印表格(main)
	function flash_item_list()
	{
        $thing_substring = "";
        $join_substring = "";
        
        // 打开数据库
        $conn = open_db();
        
        // 获取thing数据表的数据
        if (is_tag())
        {
            $my_array = get_tag_search_substring(get_property_UUID());
        }
        else
        {
            $my_array = get_thing_substring(get_current_list_id());
        }
        $thing_substring = $my_array[0];
        $join_substring = $my_array[1];
        
        // 获得条目数量.
        $item_count = get_thing_count($thing_substring);
        
        // 人物列表暂不支持检索。
        
        // 打印标签区. +1
        print_tags_zone();
        
        // 计算总页数和当前页偏移量.
        $page_size = get_page_size();
        $offset = $page_size * (get_page() - 1);
		$pages = intval($item_count / $page_size);
		if ($item_count % $page_size) $pages++;
		
        // 打印表格控制条.
		print_list_control($item_count, $page_size, $pages, get_page());
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
            $thing_substring .= $order_substring;
            
            // 完成 事件、标签、事件-标签对的三表联合查询。
            $tag_id_array = array();
            $tag_param_array = array();
            get_thing_tag_prompt($join_substring, $order_substring, $tag_id_array, $tag_param_array);
            $result = get_thing_item_db($thing_substring);
            
    		$index = $offset;
    		
    		while($row = mysql_fetch_array($result))
    		{
    			$index++;
    			// echo "$index. " . $row['time'] . "年，" . $row['thing'] . "<br />";
    			
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
                // 事件字段
    			echo "<td><a href='update_input.php?thing_uuid=" . $row['uuid'] . "&update_once=" .
    				get_update_token() . "&item_index=" . $index . "'>" . $row['thing'] . "</a></td>";
                
                // 死亡人数、受伤人数、失踪人数、字数。
                $person_count_string = print_person_count($row['related_number1'], 
                        $row['related_number2'], 
                        $row['related_number3'],
                        $row['related_number4']);
                        
                // +n。数据库性能优化的重点。
    			echo "<td>" . print_item_tags($row['uuid'], $tag_id_array, $tag_param_array, $person_count_string) . "</td>";
    			echo "</tr>";
    		}
    		
    		echo "</table>";
    		print_list_control($item_count, $page_size, $pages, get_page());   // list control.
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
