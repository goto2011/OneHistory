<link rel="stylesheet" type="text/css" href="./style/data.css" />
<script type='text/javascript' src='./js/data.js'></script>

<?php 
    require_once 'init.php';
    is_user(3);
    require_once "sql.php";
    require_once "data.php";
    require_once "list_control.php";
    require_once "list_search.php";
    
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
    
    // add, 2015-4-21
    // 是否显示"添加标签"
    function is_show_add_tag()
    {
        // 普通用户在查找界面；adder在所有界面可以用这个功能。
        return ((is_search_ex()) || (is_adder()));
    }
    
    // 是否显示查找界面.
    function is_search_ex()
    {
        // 如果是adder，则在任何界面都可以添加标签。
        return (is_search() && is_total());
    }
    
    // 打印检索区
    function print_search_zone()
    {
        echo "<div align='left' style='font-family:微软雅黑'>";
        echo "<form action='item_frame.php' method='get'>";
        echo "<p style='font-family:微软雅黑;color:red;font-size:15px'>查找：";
        
        echo "<input name='search_key' type='text' width='240px' value='" . search_key() . "' />";
        echo "&nbsp;&nbsp;&nbsp;<input name='' type='submit' />";
        echo "&nbsp;&nbsp;&nbsp;<select name='object'>";
        echo "   <option value='tag_item'>标签和条目</option>";
        echo "   <option value='tag_only'>只搜标签</option>";
        echo "</select>";
        
        echo "&nbsp;&nbsp;&nbsp;<nobr class='normal'>标签类型: ";
        echo "&nbsp;&nbsp;<input type='radio' name=tag_type value='1' checked='checked'>全部";
        
        for ($ii = tag_list_min(); $ii <= tag_list_max(); $ii++)
        {
            if ((is_show_search_add($ii) == 1) || ((is_vip_user_show_tab($ii) == 1) && (is_vip_user())))
            {
                $tag_id = get_tag_id_from_index($ii);
                $tag_name = get_tag_list_name_from_index($ii);
                
                echo "&nbsp;&nbsp;<input type='radio' name=tag_type value='$tag_id' >$tag_name";
            }
        }
        
        echo "</nobr></form></div>";
    }
    
    // add, 2015-5-8
    // 打印 person 链接
    function create_person_link($index, &$tags_db)
    {
        $result = "";
        for ($ii = get_small_person_begin($index); $ii <= get_small_person_end($index); $ii++)
        {
            $my_name = get_person_name($index, $ii);
            
            // 标签数组不删除。
            $my_uuid = search_tag_from_array($my_name, $tags_db, 0);
            
            if ($my_uuid != "")
            {
                $result .= "<a href='item_frame.php?property_UUID=" . 
                    $my_uuid . "'>". $my_name . "</a>&nbsp;&nbsp;";
            }
            else 
            {
                $result .= $my_name . "&nbsp;&nbsp;";
            }
        }
        
        return $result;
    }
    
	// 打印tag链接
	function create_tag_link($property_type, $property_UUID, $property_name)
	{
		if($property_type == 1)
		{
			return "<a href='item_frame.php?property_UUID=" . 
				$property_UUID . "'>{". $property_name . "</a>&nbsp;&nbsp;";
		}
        else if ($property_type == 2)
        {
            return "<a href='item_frame.php?property_UUID=" . 
                $property_UUID . "'>". $property_name . "}</a>&nbsp;&nbsp;";
        }
		else
		{
			return "<a href='item_frame.php?property_UUID=" . 
				$property_UUID . "'>". $property_name . "</a>&nbsp;&nbsp;";
		}
	}
    
	// 打印标签区
	function print_tags_zone()
	{
        global $person_sub_list_id;
        
		echo "<div align='left' style='font-family:微软雅黑'>";
		echo "<p style='font-family:微软雅黑;color:red;font-size:15px'>标签：";
        
        // 打印"全部"
        echo "<a href='item_frame.php?property_UUID=all'>全部</a> &nbsp;&nbsp;";
        
        // 打印标签
        echo "<br />";
        $tags_array = get_tags_array(get_current_list_id());
        
        echo get_big_person_name($person_sub_list_id) . " :&nbsp;&nbsp;&nbsp;" 
            . create_person_link($person_sub_list_id, $tags_array) . "<br />";
        /*
        $my_tag_id = get_tag_id_from_index(get_current_list_id());
        if(is_person($my_tag_id))
        {
        }
         */
    
		echo "</div>";
	}
	
	// 更新每个条目的标签
	function print_item_tags($thing_UUID)
	{
		$result_string = "";
		
		// 获取property数据表的数据
		$result = get_tags_from_thing_UUID($thing_UUID);
		
		if (mysql_num_rows($result) > 0)
		{
			$result_string = "<div align='left' style='font-family:微软雅黑'>";
			
			while($row = mysql_fetch_array($result))
			{
				$result_string .= create_tag_link($row['property_type'], $row['property_UUID'], $row['property_name']);
			}
			$result_string .= "</div>";
		}
		return $result_string;
	}
    
    // 判断当前页号是否显示. 如果全部显示就太长了。
    function page_is_show($curr_page, $showing_page, $total_pages)
    {
        if ($total_pages <= 15)
        {
            return true;
        }
        if (($curr_page == 1) || ($curr_page == $total_pages) || ($curr_page == $showing_page))
        {
            return true;
        }
        if (($curr_page >= $showing_page - 3) && ($curr_page <= $showing_page + 3))
        {
            return true;
        }
        $index = floor(($total_pages - 7) / 8);
        
        if (($curr_page % $index) == 0)
        {
            return true;
        }
        
        return false;
    }
	
	// 打印表格控制区(表格上下两条都有)
	function print_list_control($item_count, $page_size, $pages, $curr_page)
	{
		$item_start = ($curr_page - 1) * $page_size + 1;
		if ($item_start + $page_size - 1 < $item_count)
		{
			$item_end = $item_start + $page_size - 1;
		}
		else
		{
			$item_end = $item_count;
		}
        
        // $item_end 为0的特殊处理.
        if($item_end < $item_start)
        {
            $item_start = $item_end;
        }
        
        // form 要包大部分.
        if (is_show_add_tag())
        {
            echo "<form method='post' action='./ajax/list_add_tag_do.php'  onSubmit='return checkbox_check()'>";
        }
		
		echo "<div align='left' style='font-family:微软雅黑; color:red; font-weight: bold'> ";
        if(is_show_add_tag())
        {
            echo "<span class='link' onclick='select_all()'>全选</span> -- 
                  <span class='link' onclick='select_none()'>全不选</span> -- ";
        }
		echo "总计条目:$item_count -- 本页条目:$item_start-$item_end -- ";

        $point_count = 0;
		for ($index = 1; $index < $curr_page; $index++)
		{
		    if (page_is_show($index, $curr_page, $pages))
            {
			     echo "<a href='item_frame.php?page=$index'> [$index] </a> ";
                 $point_count = 0;
            }
            else 
            {
                if ($point_count < 4)
                {
                    echo ".";
                }
                $point_count++;
            }
		}
		echo "[$curr_page]";
		
		for ($index = $curr_page + 1; $index <= $pages; $index++)
		{
		    if (page_is_show($index, $curr_page, $pages))
            {
			     echo "<a href='item_frame.php?page=$index'> [$index] </a> ";
			     $point_count = 0;
            }
            else 
            {
                if ($point_count < 4)
                {
                    echo ".";
                }
                $point_count++;
            }
		}
        
        if(!is_tag() && !is_period_tag() && !is_show_add_tag())
        {
            echo "</div>";
        }
	}
    
    // 打印 tag 控制条
    function print_tag_control()
    {
        $my_tag_uuid = get_property_UUID();
        
        echo " -- <nobr class='thick'>当前标签: " . get_property_name();
        
        $follower_count = get_follows_count($my_tag_uuid);
        if($follower_count == 0)
        {
            echo " (当前无人关注)";
        }
        else 
        {
            echo " (有 $follower_count 人关注)";
        }
        
        if(is_followed($my_tag_uuid))
        {
            echo " -- 你已关注! --<a href='./ajax/follow_do.php?un_follow_tag=" . $my_tag_uuid 
                . "'>取消关注</a></nobr>";
        }
        else 
        {
            echo " -- <a href='./ajax/follow_do.php?follow_tag=" . $my_tag_uuid . "'>关注它!</a></nobr>";
        }
        
        // 打开删除标签的功能
        if (is_deleter())
        {
            echo " -- <a href='./ajax/follow_do.php?delete_tag=" . $my_tag_uuid . "'>删除这个标签</a></nobr>";
        }

        // 2015-5-24
        // 显示出处细节。
        if (is_source(get_tag_type($my_tag_uuid)))
        {
            $my_detail = get_sourece_detail($my_tag_uuid);
            if (strlen($my_detail) > 0)
            {
                echo "</br> -- 出处细节: $my_detail ";
            }
        }
         
        echo "</div>";
    }
    
    // 打印添加 tag 界面.
    function print_add_tag_form()
    {
        echo "<span style='display:inline-block; right:3%; position:absolute;' >添加标签 : ";
        echo "<select name='tag_type'>";
        
        // add, 2015-5-3
        for ($ii = tag_list_min(); $ii <= tag_list_max(); $ii++)
        {
            if ((is_show_search_add($ii) == 1) || ((is_vip_user_show_tab($ii) == 1) && (is_vip_user())))
            {
                $tag_id = get_tag_id_from_index($ii);
                $tag_name = get_tag_list_name_from_index($ii);
                echo "  <option value='$tag_id'>$tag_name</option>";
            }
        }
        
        echo "</select>";
        echo "<nobr><input name='tag_name' type='text' width='150px'></nobr>";
        echo "<input name='' type='submit' value='添加'>";
        echo "</span>";
        echo "</div>";
    }
	
	// 打印条目列表的表头
	function print_item_list_head()
	{
		echo "<table class='altrowstable' id='alternatecolor' style='border-width: 1px;'>";
		echo "<tr>";
        if(is_show_add_tag())
        {
            echo "<td></td>";
        }
		echo "<td style='font-family:微软雅黑; text-align:center; width:3%' >编号</td>";
		echo "<td style='font-family:微软雅黑; text-align:center; width:8%' >时间</td>";
		echo "<td style='font-family:微软雅黑; text-align:center; width:5%' >时间上下限</td>";
		echo "<td style='font-family:微软雅黑; text-align:center; width:54%' >事件</td>";
		echo "<td style='font-family:微软雅黑; text-align:center; width:30%' >标签</td>";
		echo "</tr>";
	}

	// 打印表格(main)
	function flash_item_list()
	{
        // 打开数据库
        $conn = open_db();
	    
        // 计算条目数量
		if (is_tag())
		{
		    $item_count = get_thing_count_by_tag(get_property_UUID());
		}
        else if(is_search_ex())
        {
            $item_count = get_thing_count_by_search(search_key());
        }
		else
		{
			$item_count = get_thing_count(get_current_list_id());
		}
        
        // echo "$item_count - " . get_current_list_id() . " <br />";
		
        $page_size = get_page_size();
		$pages = intval($item_count / $page_size);   // 计算总页数。
		if ($item_count % $page_size) $pages++;

		//计算记录偏移量
		$offset = $page_size * (get_page() - 1);
		
        // 打印搜索区
        if(is_total())
        {
            print_search_zone();
        }
        
		// 打印标签区
		print_tags_zone();
		
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
            
		print_item_list_head();   // table head.
		
		// 获取thing数据表的数据
		if (is_tag())
		{
		    $result = get_thing_item_by_tag(get_property_UUID(), $offset, $page_size);
		}
        else if(is_search_ex())
        {
            $result = get_thing_item_by_search(search_key(), $offset, $page_size);
        }
		else
		{
            $result = get_thing_item_db(get_current_list_id(), $offset, $page_size);
		}
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
			echo "<td>" . print_item_tags($row['uuid']) . "</td>";
			echo "</tr>";
		}
		
		echo "</table>";
        
		print_list_control($item_count, $page_size, $pages, get_page());   // list control.
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