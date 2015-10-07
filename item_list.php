<?php
    require_once 'init.php';
    is_user(3);
    require_once "sql.php";
    require_once "data.php";
    require_once "tag.php";
    require_once "list_control.php";
    
    // 唯一可设置 list_type 的位置.
    if (!empty($_GET['list_type']) && is_numeric($_GET['list_type']))
    {
        set_current_list($_GET['list_type']);
    }
    
    if (check_list_param() == false)
    {
        // debug.
        print_list_param();
        error_exit("请按照正常流程访问本网站。谢谢。");
    }
?>

<link rel="stylesheet" type="text/css" href="./style/data.css" />
<script type='text/javascript' src='./js/data.js'></script>

<script type="text/javascript">
window.onload = function()
{
    altRows('alternatecolor');
}
</script>

<?php 
    // main().
	flash_item_list();
    
    // 打印 分期 tag 链接
    function create_period_link($index)
    {
        $result = "";
        for ($ii = get_small_id_begin($index); $ii <= get_small_id_end($index); $ii++)
        {
            $result .= "<a id='tag_normal' href='item_frame.php?big=$index&small=$ii'>" 
                . get_period_name($index, $ii) . "</a>";
        }
        return $result;
    }
    
    // 打印其它非 vip tag。
    function create_other_link(&$tags_db)
    {
        $result = "";
        
        // 这行代码真帅!
        while(list($key, $value) = each($tags_db))
        {
            $result .= "<a id='tag_normal' href='item_frame.php?property_UUID=" . $key 
                . "'>". $value . "</a>";
        }
        
        return $result;
    }
    
    // 打印 tag 链接。通用化，2015-8-9.
    function create_vip_tag_link($vip_tag_class, $index, &$tags_db)
    {
        $result = "";
        for ($ii = $vip_tag_class->get_small_begin($index); $ii <= $vip_tag_class->get_small_end($index); $ii++)
        {
            $my_name = $vip_tag_class->get_tag_name($index, $ii);
            $is_super = $vip_tag_class->get_tag_show_flag($index, $ii);
            $my_uuid = search_tag_from_array($my_name, $tags_db, 1);
            
            if ($my_uuid != "")
            {
                if ($is_super == "super")
                {
                    $result .= "<a id='tag_super' href='item_frame.php?property_UUID=" . 
                        $my_uuid . "'>". $my_name . "</a>";
                }
                else 
                {
                    $result .= "<a id='tag_normal' href='item_frame.php?property_UUID=" . 
                        $my_uuid . "'>". $my_name . "</a>";
                }
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
		echo "<div align='left'>";
		echo "<p><span id='tag_type'>标签:</span>";
        
        // 打印"全部"(super tag)
        echo "<a id='tag_super' href='item_frame.php?property_UUID=all'>全部</a>";
        
        // 打印一般的标签区. 2015-4-19
        $my_tag_id = get_tag_id_from_index(get_current_list_id());
        
        // 非vip tag.
        if(is_vip_tag_tab(get_current_list_id()) == 0)
        {
            // 获取property数据表的数据
            $result = get_tags_db(get_current_list_id(), get_page_tags_size());
            
    		while($row = mysql_fetch_array($result))
    		{
    			echo create_tag_link($row['property_type'], $row['property_UUID'], $row['property_name']);
    		}
        }
        // 是时期
        else if(is_period(get_current_list_id()))
        {
            echo "<br />";
            
            for ($ii = get_big_id_begin(); $ii <= get_big_id_end(); $ii++)
            {
                echo "<span id='tag_type'>" . get_big_period_name($ii) . ":</span>" 
                    . create_period_link($ii) . "<br />";
            }
        }
        // 是 vip tag.
        else if(is_vip_tag_tab(get_current_list_id()))
        {
            echo "<br />";
            $tags_array = get_tags_array(get_current_list_id());
            
            $my_vip_tag = vip_tag_struct_init($my_tag_id);
            
            for ($ii = $my_vip_tag->get_big_begin(); $ii <= $my_vip_tag->get_big_end() - 1; $ii++)
            {
                echo "<span id='tag_type'>" . $my_vip_tag->get_big_name($ii) . ":</span>" 
                    . create_vip_tag_link($my_vip_tag, $ii, $tags_array) . "<br />";
            }
            
            // 最后打印其它
            echo "<span id='tag_type'>" . $my_vip_tag->get_big_name($ii) . ":</span>" 
                    . create_other_link($tags_array) . "<br />";
        }
    
		echo "</div>";
	}
	
    // 打印 period 控制条
    function print_period_info()
    {
        $big_id = get_period_big_index();
        $small_id = get_period_small_index();
        
        $name = get_period_name($big_id, $small_id);
        $begin = is_infinite(get_begin_year($big_id, $small_id)) ? "无穷远" 
            : get_time_string(get_begin_year($big_id, $small_id), 2);
        $end = is_infinite(get_end_year($big_id, $small_id)) ? "无穷远" 
            : get_time_string(get_end_year($big_id, $small_id), 2);
            
        echo " -- <nobr class='thick'>当前时间: $name ( $begin - $end ) </nobr></div>";
    }
    
	// 打印表格(main)
	function flash_item_list()
	{
        // 打开数据库
        $conn = open_db();
	    
        // 算下 period 开始/结束.
        if(is_period_tag(get_current_list_id()))
        {
            $begin_year = get_begin_year(get_period_big_index(), get_period_small_index());
            $end_year = get_end_year(get_period_big_index(), get_period_small_index());
        }

        $thing_substring = "";
        //计算记录偏移量
        $page_size = get_page_size();
        $offset = $page_size * (get_page() - 1);
        
        // 获取thing数据表的数据. +1
        // search 兼容 tag 和 period。所以检索优先级最高。
        if(is_search())
        {
            $thing_substring = get_search_where_sub();
        }
        else if (is_tag())
        {
            $thing_substring = get_tag_search_substring(get_property_UUID());
        }
        else if(is_period_tag(get_current_list_id()))
        {
            $thing_substring = get_period_where_sub($begin_year, $end_year);
        }
        else
        {
            $thing_substring = get_thing_substring(get_current_list_id());
        }
        
        // 获得条目数量.
        $item_count = get_thing_count($thing_substring);
        
        // debug
        // echo "$item_count - " . get_current_list_id() . " <br />";
		
		// 计算总页数。
		$pages = intval($item_count / $page_size);
		if ($item_count % $page_size) $pages++;

        // 打印搜索区
        if(is_show_search_box(get_current_list_id()))
        {
            print_search_zone();
        }
        
		// 打印标签区. +1
		print_tags_zone();
		
        // 打印表格控制条.
		print_list_control($item_count, $page_size, $pages, get_page());
		if (is_tag())
        {
            // +2
            print_tag_control();
        }
        else if(is_period_tag(get_current_list_id()))
        {
            print_period_info();
        }
        
        // 打印“添加标签”输入框。2015-4-21
        if (is_show_add_tag())
        {
            print_add_tag_form();
        }
        
        // 打印表头。
		print_item_list_head();
		
        if ($item_count > 0)
        {
            // 查询子句增加排序、分页。
            $thing_substring = add_order_page_substring($thing_substring, $offset, $page_size);
            
            // 完成 事件、标签、事件-标签对的三表联合查询。
            $tag_id_array = array();
            $tag_param_array = array();
            $result = get_thing_tag_prompt($thing_substring, $tag_id_array, $tag_param_array);
    
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
    			echo "<td>$index</td>";
    			echo "<td>" . get_time_string($row['time'], $row['time_type']) . "</td>";
    			echo "<td>" . get_time_limit_string($row['time_limit'], $row['time_limit_type']) . "</td>";
    			echo "<td><a href='update_input.php?thing_uuid=" . $row['uuid'] . "&update_once=" .
    				get_update_token() . "&item_index=" . $index . "'>" . $row['thing'] . "</a></td>";
                
                // 打印 死亡人数、受伤人数、失踪人数。
                $person_count_string = print_person_count($row['related_number1'], 
                        $row['related_number2'], $row['related_number3']);
                
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
