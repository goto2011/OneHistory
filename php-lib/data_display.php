<?php
// created by duangan, 2015-9-1 -->
// support display item.    -->

    // 是否显示"添加标签". 2015-4-21
    function is_show_add_tag()
    {
        // 普通用户在查找界面；adder在所有界面可以用这个功能。
        // 普通用户在所有界面都有此功能。
        return 1;
    }
    
    // 是否显示 “检索框”(只有 我的关注 没有检索。)
    function is_show_search_box($tag_id)
    {
        return (!is_my_follow($tag_id) && !is_newest($tag_id));
    }
    
    // 打印检索区
    function print_search_zone()
    {
        echo "<div align='left' style='font-family:微软雅黑'>";
        echo "<form action='item_frame.php' method='get'>";
        echo "<p style='font-family:微软雅黑;color:red;font-size:15px'>查找：";
        
        echo "<input name='search_key' type='text' width='240px' value='" . search_key() 
                . "'  autofocus='autofocus' />";
        echo "&nbsp;&nbsp;&nbsp;<input name='' type='submit' />";
        
        // search_object 和 tag_type 两字段价值不大，去掉。2015-8-4
        /*
        echo "&nbsp;&nbsp;&nbsp;<select name='search_object'>";
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
        */
        
        echo "</nobr></form></div>";
    }

    /**
     * 打印tag链接. $property_type, $property_UUID, $property_name
     */
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
        else if ($property_type == 3)
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
    
    /**
     * 更新每个条目的标签. 2015-9-1
     * @$person_count_string: 打印死亡人数、受伤人数、失踪人数（为节省界面，作为标签的一部分，没有超链接）
     */
    function print_item_tags($thing_UUID, $tag_id_array, $tag_param_array, $person_count_string)
    {
        $result_string = "";
        $array_has_data = false;
        
        $result_string = "<div align='left' style='font-family:微软雅黑'>";
        $result_string .= $person_count_string . "&nbsp;&nbsp;&nbsp;";
            
        // 数组中存在.
        if (array_key_exists($thing_UUID, $tag_id_array))
        {
            for ($ii = 0; $ii < count($tag_id_array[$thing_UUID]); $ii++)
            {
                $my_tag_id = $tag_id_array[$thing_UUID][$ii];
                if (array_key_exists($my_tag_id, $tag_param_array))
                {
                    $result_string .= create_tag_link($tag_param_array[$my_tag_id][0], $my_tag_id, 
                            $tag_param_array[$my_tag_id][1]);
                    $array_has_data = true;
                }
            }
            $result_string .= "</div>";
        }
        
        // 数组中不存在，则获取数据库的数据。
        if ($array_has_data == false)
        {
            $result_string = "";
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
        }
        
        return $result_string;
    }
    
    /**
     * 判断当前页号是否显示. 如果全部显示就太长了。
     */
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
        
        if(!is_tag() && !is_period_tag(get_current_tag_id()) && !is_show_add_tag())
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
                if (get_tag_id_from_index($ii) == get_current_tag_id())
                {
                    echo "  <option selected='selected' value='$tag_id'>$tag_name</option>";
                }
                else 
                {
                    echo "  <option value='$tag_id'>$tag_name</option>";
                }
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
    
    /*
     * 根据数据库数据在页面上显示 死亡人数、受伤人数、失踪人数。
     */
    function print_person_count($death_person_count, $hurt_person_count, 
        $missing_person_count, $word_count)
    {
        $result = "";
        $result_index = 0;
        
        if ($death_person_count > 0)
        {
            $result .= "死-" . $death_person_count;
            $result_index++;
        }
        
        if ($hurt_person_count > 0)
        {
            if ($result_index > 0)
            {
                $result .= ";";
            }
            $result .= "伤-" . $hurt_person_count;
            $result_index++;
        }
        
        if($missing_person_count > 0)
        {
            if ($result_index > 0)
            {
                $result .= ";";
            }
            $result .= "失踪-" . $missing_person_count;
        }
        
        if($word_count > 0)
        {
            $result .= "字数-" . $word_count;
        }
        
        return $result;
    }
    
    
?>