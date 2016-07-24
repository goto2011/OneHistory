<?php
// created by duangan, 2015-9-1 -->
// support list view.    -->

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

    // 通过数据库生成每个事件的标签信息。2016-07-20
    function print_item_tags_from_db($thing_uuid)
    {
        $result_string = "";
        $result = get_tags_from_thing_UUID($thing_uuid);
        
        if (mysql_num_rows($result) > 0)
        {
            $result_string = "<align='left' style='font-family:微软雅黑'>";
            
            while($row = mysql_fetch_array($result))
            {
                $result_string .= create_tag_link($row['property_type'], $row['property_UUID'], 
                    $row['property_name'], $row['hot_index']);
            }
            $result_string .= "</div>";
        }
        
        return $result_string;
    }

    /**
     * 生成每个事件的标签信息. 2015-9-1
     * $thing_UUID：要查找的事件 uuid。
     * $person_count_string: 打印死亡人数、受伤人数、失踪人数（为节省界面，作为标签的一部分，没有超链接）
     */
    function print_item_tags($thing_UUID, $tag_id_array, $tag_param_array, $person_count_string)
    {
        $result_string = "<div align='left' style='font-family:微软雅黑'>";
        // 死亡人数放在最前面。
        $result_string .= $person_count_string . "&nbsp;&nbsp;&nbsp;";
              
        // 数组中存在指定 thing uuid.
        if (array_key_exists($thing_UUID, $tag_id_array))
        {
            // 通过$thing_UUID
            // $GLOBALS['log']->error(date('H:i:s') . "-" . "print_item_tags(). Tag_hit!");
            for ($ii = 0; $ii < count($tag_id_array[$thing_UUID]); $ii++)
            {
                $my_tag_id = $tag_id_array[$thing_UUID][$ii];
                // 数组中存在指定的 tag_id
                if (array_key_exists($my_tag_id, $tag_param_array))
                {
                    $result_string .= create_tag_link($tag_param_array[$my_tag_id][0], $my_tag_id, 
                            $tag_param_array[$my_tag_id][1], $tag_param_array[$my_tag_id][2]);
                }
                else 
                {
                    // 只要有一个tag不存在，则所有tag重新从数据库中读取。
                    $GLOBALS['log']->error(date('H:i:s') . "-" . "print_item_tags(). Tag_not_hit!");
                    $GLOBALS['log']->error("thing_UUID: " . $thing_UUID);
                    $GLOBALS['log']->error("tag_UUID: " . $my_tag_id);
                    return print_item_tags_from_db($thing_UUID);
                }
            }
            $result_string .= "</div>";
        }
        // thing uuid 数组中不存在，则获取数据库的数据。
        else
        {
            $GLOBALS['log']->error(date('H:i:s') . "-" . "print_item_tags(). Tag_not_hit!");
            $GLOBALS['log']->error("thing_UUID: " . $thing_UUID);
            return print_item_tags_from_db($thing_UUID);
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


    /**
     * 打印表格遍历条(表格上下两条都有)。
     * 参数：$item_count：总数。
     *      $page_size：每页数量。
     *      $curr_page：当前页。
     */
    function print_list_control($item_count, $page_size, $curr_page)
    {
        // 计算共计多少页。
        $pages = intval($item_count / $page_size);
        if ($item_count % $page_size) $pages++;
            
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
    
    // 打印 分期 tag 链接
    function create_period_link($index, $period_count = NULL)
    {
        $result = "";
        $hot_index = 0;
        
        for ($ii = get_small_id_begin($index); $ii <= get_small_id_end($index); $ii++)
        {
            if ($period_count == NULL)
            {
                $sql_param = array("begin_year"=>get_begin_year($index, $ii), 
                    "end_year"=>get_end_year($index, $ii));
                $hot_index = get_thing_count(sql_object::CONST_PERIOD, $sql_param);
                // $GLOBALS['log']->error("create_period_link(): 1");
            }
            else 
            {
                $my_index = get_century_index($index, $ii);
                $hot_index = $period_count[$my_index];
                // $GLOBALS['log']->error("create_period_link(): 2");
            }
            
            $result .= "<a id='tag_normal' href='item_frame.php?big=$index&small=$ii'>" 
                . get_period_name($index, $ii) . "(" .  $hot_index. ")</a>";
        }
        return $result;
    }
    
    // 打印其它非 vip tag。
    function create_other_link(&$tags_db)
    {
        $result = "";
        $current_tag_uuid = get_property_UUID();
        
        // 这行代码真帅!
        while(list($key, $value) = each($tags_db[0]))
        {
            $hot_index = $tags_db[1][$key];
            
            if ((is_tag()) && ($current_tag_uuid == $key))
            {
                // return "<a id='tag_selected' href='item_frame.php?property_UUID=" . $key 
                //     . "'>". $value . "(" . $hot_index . ")</a>";
                $result .= create_normal_tag_link($key, $value, $hot_index, "tag_selected");
            }
            else
            {
                // return "<a id='tag_normal' href='item_frame.php?property_UUID=" . $key 
                //     . "'>". $value . "(" . $hot_index . ")</a>";
                $result .= create_normal_tag_link($key, $value, $hot_index, "tag_normal");
            }
        }
        
        return $result;
    }
    
    // 打印其它非 vip 的 person tag。
    function create_other_person_link(&$tags_db)
    {
        $result = "";
        
        $my_vip_tag = vip_tag_struct_init(tab_type::CONST_PERSON);
        
        for ($ii = $my_vip_tag->get_big_begin(); $ii <= $my_vip_tag->get_big_end(); $ii++)
        {
            for ($jj = $my_vip_tag->get_small_begin($ii); $jj <= $my_vip_tag->get_small_end($ii); $jj++)
            {
                $my_name = $my_vip_tag->get_tag_name($ii, $jj);
                search_tag_from_array($my_name, $tags_db[0], 1);
            }
        }
        
        while(list($key, $value) = each($tags_db[0]))
        {
            $my_hot_index = $tags_db[1][$key];
            $result .= "<a id='tag_normal' href='item_frame.php?property_UUID=" . $key 
                . "'>". $value . "($my_hot_index)</a>";
        }
        
        return $result;
    }
    /**
     * 打印 tag 链接。通用化。2015-8-9。
     */
    function create_vip_tag_link($vip_tag_class, $index, &$tags_db)
    {
        $my_tag_uuid = get_property_UUID();
        
        $result = "";
        for ($ii = $vip_tag_class->get_small_begin($index); $ii <= $vip_tag_class->get_small_end($index); $ii++)
        {
            $my_name = $vip_tag_class->get_tag_name($index, $ii);
            $is_super = $vip_tag_class->get_tag_show_flag($index, $ii);
            $my_uuid = search_tag_from_array($my_name, $tags_db[0], 1);
            $my_hot_index = $tags_db[1][$my_uuid];
            
            if ($my_uuid != "")
            {
                // 是否为当前选中的 tag。
                if ((is_tag()) && ($my_tag_uuid == $my_uuid))
                {
                    $result .= create_normal_tag_link($my_uuid, $my_name, $my_hot_index, "tag_selected");
                }
                else if ($is_super == "super")
                {
                    $result .= create_normal_tag_link($my_uuid, $my_name, $my_hot_index, "tag_super");
                }
                else 
                {
                    $result .= create_normal_tag_link($my_uuid, $my_name, $my_hot_index, "tag_normal");
                }
            }
            // vip tag在数据库中没有。
            else 
            {
                $result .= create_normal_tag_link("", $my_name, 0, "tag_nothing");
            }
        }
        
        return $result;
    }

    /**
     * 打印tag链接. $property_type, $property_UUID, $property_name
     */
    function create_tag_link($property_type, $property_UUID, $property_name, $hot_index)
    {
        // 开始事件
        if($property_type == 1)
        {
            return "<a href='item_frame.php?property_UUID=" . 
                $property_UUID . "'>{". $property_name . "</a>&nbsp;&nbsp;";
        }
        // 结束事件
        else if ($property_type == 2)
        {
            return "<a href='item_frame.php?property_UUID=" . 
                $property_UUID . "'>". $property_name . "}</a>&nbsp;&nbsp;";
        }
        // 出处
        else if ($property_type == 3)
        {
            return "<a href='item_frame.php?property_UUID=" . 
                $property_UUID . "'>[". $property_name . "]</a>&nbsp;&nbsp;";
        }
        else
        {
            return create_normal_tag_link($property_UUID, $property_name, $hot_index, "tag_table");
        }
    }
    
    /*
     * 按指定格式显示 tag 链接。
     * $show_type: 显示格式：tag_selected、tag_super、tag_normal、tag_nothing。
     */
    function create_normal_tag_link($tag_uuid, $tag_name, $tag_hot_index, $show_type)
    {
        if ($show_type != "tag_nothing")
        {
            return "<a id='" . $show_type . "' href='item_frame.php?property_UUID=" . 
                $tag_uuid . "'>$tag_name($tag_hot_index)</a>";
        }
        else 
        {
            return "<span id='" . $show_type . "'>$tag_name($tag_hot_index)</span>";
        }
    }
    
    // 打印 person 链接. 2015-5-8
    function create_person_link($index, &$tags_db)
    {
        $result = "";
        $my_tag_uuid = get_property_UUID();
        
        $my_vip_tag = vip_tag_struct_init(tab_type::CONST_PERSON);
        
        for ($ii = $my_vip_tag->get_small_begin($index); $ii <= $my_vip_tag->get_small_end($index); $ii++)
        {
            $my_name = $my_vip_tag->get_tag_name($index, $ii);
            
            // 标签数组不删除。
            $my_uuid = search_tag_from_array($my_name, $tags_db[0], 0);
            $my_hot_index = $tags_db[1][$my_uuid];
            
            if ((is_tag()) && ($my_tag_uuid == $my_uuid))
            {
                $result .= create_normal_tag_link($my_uuid, $my_name, $my_hot_index, "tag_selected");
            }
            else if ($my_uuid != "")
            {
                // $result .= "<a id='tag_normal' href='item_frame.php?property_UUID=" . 
                //     $my_uuid . "'>$my_name($my_hot_index)</a>";
                $result .= create_normal_tag_link($my_uuid, $my_name, $my_hot_index, "tag_normal");
            }
            else 
            {
                // $result .= "<span id='tag_nothing'>" . $my_name . "(0)</span>";
                create_normal_tag_link("", $my_name, 0, "tag_nothing");
            }
        }
        
        return $result;
    }

    /**
     * 打印查找到的标签.
     */
    function print_seach_tags_zone($sql_param)
    {
        echo "<div align='left'>";
        echo "<p><span id='tag_type'>符合条件的标签:</span>";
        $sql_string = "";
        $result = get_tags_from_search($sql_param, $sql_string);
        
        while($row = mysql_fetch_array($result))
        {
            echo create_normal_tag_link($row['property_UUID'], $row['property_name'], 
                $row['hot_index'], "tag_normal");
        }
    
        echo "</div>";
    }
    
    // 打印标签区
    function print_tags_zone()
    {
        echo "<div align='left'>";
        echo "<p><span id='tag_type'>标签:</span>";
        // 打印"全部"(super tag)
        echo "<a id='tag_super' href='item_frame.php?property_UUID=all'>全部</a>";
        
        $my_tag_uuid = get_property_UUID();
        
        // 非vip tag, 即 “全部”和“我的关注”。
        if(is_vip_tag_tab(get_current_list_id()) == 0)
        {
            // 获取property数据表的数据
            $result = get_tags_db(get_current_tag_id(), get_page_tags_size());
            
            while($row = mysql_fetch_array($result))
            {
                if ((is_tag()) && ($my_tag_uuid == $row['property_UUID']))
                {
                    echo create_normal_tag_link($row['property_UUID'], $row['property_name'], 
                        $row['hot_index'], "tag_selected");
                }
                else 
                {
                    echo create_normal_tag_link($row['property_UUID'], $row['property_name'], 
                        $row['hot_index'], "tag_normal");
                }
            }
        }
        // “时期”。
        else if(is_period(get_current_tag_id()))
        {
            echo "<br />";
            
            $period_count = get_thing_count_by_period();
            // print_r($period_count);
            
            // 第一组值需要重新从数据库中读取。
            echo "<span id='tag_type'>" . get_big_period_name(get_big_id_begin()) . ":</span>" 
                    . create_period_link(get_big_id_begin()) . "<br />";
                    
            // 后面每组值从 数组中获取。
            for ($ii = get_big_id_begin() + 1; $ii <= get_big_id_end(); $ii++)
            {
                echo "<span id='tag_type'>" . get_big_period_name($ii) . ":</span>" 
                    . create_period_link($ii, $period_count) . "<br />";
            }
        }
        // 是 vip tag。其它所有。
        else if(is_vip_tag_tab(get_current_list_id()))
        {
            echo "<br />";
            // array 下标是 thing_UUID, 值是 name。
            $tags_array = get_tags_array(get_current_tag_id());
            
            $my_vip_tag = vip_tag_struct_init(get_current_tag_id());
            
            if (is_person(get_current_tag_id()))
            {
                global $person_sub_list_id;
                // 处理 人物 之 其它 子页面.
                if ($person_sub_list_id != $my_vip_tag->get_big_end())
                {
                    echo "<span id='tag_type'>" . $my_vip_tag->get_big_name($person_sub_list_id) . ":</span>" 
                        . create_person_link($person_sub_list_id, $tags_array) . "<br />";
                }
                else
                {
                    echo "<span id='tag_type'>" . $my_vip_tag->get_big_name($person_sub_list_id) . ":</span>" 
                        . create_other_person_link($tags_array) . "<br />";
                }
            }
            else 
            {
                for ($ii = $my_vip_tag->get_big_begin(); $ii <= $my_vip_tag->get_big_end() - 1; $ii++)
                {
                    echo "<span id='tag_type'>" . $my_vip_tag->get_big_name($ii) . ":</span>" 
                        . create_vip_tag_link($my_vip_tag, $ii, $tags_array) . "<br />";
                }
                // 最后打印其它
                echo "<span id='tag_type'>" . $my_vip_tag->get_big_name($ii) . ":</span>" 
                        . create_other_link($tags_array) . "<br />";
            }
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
    
    
?>