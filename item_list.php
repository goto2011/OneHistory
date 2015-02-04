<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title></title>
</head>
<body>

<?php
    require_once 'init.php';
    is_user(1);
    require_once "data.php";
    require_once "data_time.php";
    require_once "data_period.php";
    require_once "list_control.php";
    require_once "list_search.php";
    require_once "sql.php";
    
    // 唯一可设置 list_type 的位置.
    @$list_type = $_GET['list_type'];
    if (!empty($list_type))
    {
        set_current_list($list_type);
    }
    
    if (check_list_param() == false)
    {
        error_exit("请按照正常流程访问本网站。谢谢。");
    }
    
    // 处理检索
    if (!is_total())
    {
        search_param_init();
    }
?>

<link rel="stylesheet" type="text/css" href="./css/data.css" />
<script type='text/javascript' src='./js/data.js'></script>

<script type="text/javascript">
window.onload = function()
{
    altRows('alternatecolor');
}
</script>

<?php 
	flash_item_list();
    
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
        echo "&nbsp;&nbsp;<input type='radio' name=tag_type value='2' >国家民族";
        echo "&nbsp;&nbsp;<input type='radio' name=tag_type value='3' >自由标签";
        echo "&nbsp;&nbsp;<input type='radio' name=tag_type value='4' >事件起止";
        echo "&nbsp;&nbsp;<input type='radio' name=tag_type value='5' >人物";
        echo "&nbsp;&nbsp;<input type='radio' name=tag_type value='6' >地理";
        echo "&nbsp;&nbsp;<input type='radio' name=tag_type value='7' >出处";
        echo "</nobr>";
        
        echo "</form></div>";
    }
    
    // 打印时期 tag 链接
    function create_period_link($index)
    {
        $result = "";
        for ($ii = get_small_id_begin($index); $ii <= get_small_id_end($index); $ii++)
        {
            $result .= "<a href='item_frame.php?big=$index&small=$ii'>" 
                . get_period_name($index, $ii) . "</a>&nbsp;&nbsp;&nbsp;&nbsp;";
        }
        return $result;
    }
	
	// 打印tag联结
	function create_tag_link($property_type, $property_UUID, $property_name)
	{
		if(($property_type == 1) || ($property_type == 2))
		{
			return "<a href='item_frame.php?property_UUID=" . 
				$property_UUID . "'>[". $property_name . "]</a>&nbsp;&nbsp;";
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
		echo "<div align='left' style='font-family:微软雅黑'>";
		echo "<p style='font-family:微软雅黑;color:red;font-size:15px'>标签：";
        
        // 打印"全部"
        echo "<a href='item_frame.php?property_UUID=all'>全部</a> &nbsp;&nbsp;";
        
        if(get_current_list_id() != 7)
        {
            // 获取property数据表的数据
            $result = get_tags_db(get_current_list_id(), get_page_tags_size());
            
    		while($row = mysql_fetch_array($result))
    		{
    			echo create_tag_link($row['property_type'], $row['property_UUID'], $row['property_name']);
    		}
        }
        else
        {
            echo "<br />";
            
            for ($ii = get_big_id_begin(); $ii <= get_big_id_end(); $ii++)
            {
                echo get_big_period_name($ii) . " :&nbsp;&nbsp;&nbsp;" 
                    . create_period_link($ii) . "<br />";
            }
        }
		
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
    
    // 判断当前页号是否显示.
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
        if (is_search())
        {
            echo "<form method='post' action='./ajax/list_add_tag_do.php'  onSubmit='return checkbox_check()'>";
        }
		
		echo "<div align='left' style='font-family:微软雅黑; color:red; font-weight: bold'> ";
        if(is_search())
        {
            echo "<span class='link' onclick='select_all()'>全选</span> -- 
                  <span class='link' onclick='select_none()'>全不选</span> -- ";
        }
		echo "总计条目:$item_count -- 本页条目:$item_start-$item_end -- ";

		for ($index = 1; $index < $curr_page; $index++)
		{
		    if (page_is_show($index, $curr_page, $pages))
            {
			     echo "<a href='item_frame.php?page=$index'> [$index] </a> ";
            }
            else 
            {
                echo ".";    
            }
		}
		echo "[$curr_page]";
		
		for ($index = $curr_page + 1; $index <= $pages; $index++)
		{
		    if (page_is_show($index, $curr_page, $pages))
            {
			     echo "<a href='item_frame.php?page=$index'> [$index] </a> ";
            }
            else 
            {
                echo ".";    
            }
		}
        
        if(!is_tag() && !is_period_tag() && !is_search())
        {
            echo "</div>";
        }
	}
    
    // 打印 tag 控制条
    function print_tag_control()
    {
        echo " -- <nobr class='thick'>当前标签: " . get_property_name();
        
        $follower_count = get_follows_count(get_property_UUID());
        if($follower_count == 0)
        {
            echo " (当前无人关注)";
        }
        else 
        {
            echo " (当前有 $follower_count 人关注)";
        }
        
        if(is_followed(get_property_UUID()))
        {
            echo " -- 你已关注! --<a href='./ajax/follow_do.php?del_tag_id=" . get_property_UUID() 
                . "'>取消关注</a></nb>";
        }
        else 
        {
            echo "-- <a href='./ajax/follow_do.php?tag_id=" . get_property_UUID() . "'>关注它!</a></nobr>";
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
    
    // 打印添加 tag 界面.
    function print_add_tag_form()
    {
        echo "<span style='display:inline-block; right:3%; position:absolute;' >添加标签 : ";
        echo "<select name='tag_type'>";
        echo "  <option value='1'>国家民族</option>";
        echo "  <option value='2'>自由标签</option>";
        echo "  <option value='3'>事件开始</option>";
        echo "  <option value='4'>事件结束</option>";
        echo "  <option value='5'>人物</option>";
        echo "  <option value='6'>地理</option>";
        echo "  <option value='7'>出处</option>";
        echo "</select>";
        echo "<nobr><input name='add_tag' type='text' width='150px'></nobr>";
        echo "<input name='' type='submit' value='添加'>";
        echo "</span>";
        echo "</form>";
        echo "</div>";
    }
	
	// 打印条目列表的表头
	function print_item_list_head()
	{
		echo "<table class='altrowstable' id='alternatecolor' style='border-width: 1px;'>";
		echo "<tr>";
        if(is_search())
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
	    
        // 算下 period 开始/结束.
        if(is_period_tag())
        {
            $begin_year = get_begin_year(get_period_big_index(), get_period_small_index());
            $end_year = get_end_year(get_period_big_index(), get_period_small_index());
        }
        
        // 计算条目数量
		if (is_tag())
		{
		    $item_count = get_thing_count_by_tag(get_property_UUID());
		}
        else if(is_period_tag())
        {
            $item_count = get_thing_count_by_period($begin_year, $end_year);
        }
        else if(is_search() == 1)
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
        else if(is_period_tag())
        {
            print_period_info();
        }
        else if (is_search())
        {
            print_add_tag_form();
        }
            
		print_item_list_head();   // table head.
		
		// 获取thing数据表的数据
		if (is_tag())
		{
		    $result = get_thing_item_by_tag(get_property_UUID(), $offset, $page_size);
		}
        else if(is_period_tag())
        {
            $result = get_thing_item_by_period($begin_year, $end_year, $offset, $page_size);
        }
        else if(is_search() == 1)
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
            if(is_search())
            {
                echo "<td><input name='groupCheckbox[]' type='checkbox' value='" . $row['uuid'] . "'></td>";
            }
			echo "<td>$index</td>";
			echo "<td>" . get_time_string($row['time'], $row['time_type']) . "</td>";
			echo "<td></td>";
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
        if (is_search())
        {
            echo "</form>";
        }
        
        // exit
        mysql_close($conn);
        $conn = null;
	}
?>

</body>
</html>