<?php
// created by duangan, 2016-02-09 -->
// support update view item.    -->

    // 刷新界面之"时间"
    function flash_time($time)
    {
        echo " style='color:blue; font-weight:bold' value='$time' ";
    }
    
    // 刷新界面之"时间上下限"
    function flash_time_limit($time_limit)
    {
        echo " style='color:blue; font-weight:bold' value=$time_limit ";
    }
    
    // 刷新界面之"时间上下限类型"
    function flash_time_limit_type($my_time_limit_type, $time_limit_type)
    {
        if(($time_limit_type != null) && ($my_time_limit_type == $time_limit_type))
        {
            echo " checked='checked' style='color:blue' ";
        }
    }
    
    // 刷新界面之"标签"
    function flash_tags($tag_type, $thing_uuid)
    {
        if ($thing_uuid == "")return "";
        
        $property_name_array = get_tags_name($thing_uuid, $tag_type);
        // var_dump($property_name_array);
        
        if(!empty($property_name_array))
        {
            return get_string_from_array($property_name_array);
        }
    }
    
    // 刷新界面之"时间类型"
    function flash_time_type($my_type, $time_type)
    {
        if(($time_type == null) && ($my_type == 2))
        {
            echo " checked='checked' ";
        }
        if(($time_type != null) && ($my_type == $time_type))
        {
            echo " checked='checked' style='color:blue' ";
        }
    }
    
    /**
     * 显示 tag 输入框.
     * 参数：$view_type: =1, update; =2, import.
     */
    function show_tag_input_view($view_type, $thing_uuid = "", $is_metadata = 0)
    {
        $my_index = 0;
        
        for ($ii = tag_list_min(); $ii <= tag_list_max(); $ii++)
        {
            if (is_show_input_tag($ii) == 1)
            {
                $tag_name = get_tag_list_name_from_index($ii);
                $tag_key = get_tag_key_from_index($ii);
                $tag_id = get_tag_id_from_index($ii);
                
                $my_print = "<p class='thick'> $tag_name:<input id='$tag_key' name='$tag_key' type='text' 
                    class='tags' value='" . flash_tags($tag_id, $thing_uuid) . "'></p></td>";
                
                // "出处标签"需要顶格显示.
                if (is_source(get_tag_id_from_index($ii)))
                {
                    if($my_index % 2 == 1)$my_index++;
                }
                
                if($my_index % 2 == 0)
                {
                    // 换行。
                    echo "<tr class='tag_normal'><td width='400'>";
                    echo $my_print;
                }
                else 
                {
                    echo "<td width='400'>";
                    echo $my_print;
                    echo "</tr>";
                }
                
                // 显示“出处细节”。
                if (is_source(get_tag_id_from_index($ii)))
                {
                    echo "<td width='400'>";
                    echo "<class='thick'>出处细节:";
                    echo "<textarea rows='2' cols='48' id='source_detail' >" 
                        . get_sourece_detail($my_tag_uuid) . "</textarea>";
                    echo "</tr>";
                    
                    $my_index++;
                }
                
                if (is_note(get_tag_id_from_index($ii)))
                {
                    echo "<td width='400'>";
                    
                    // 显示“标签内序号”，只用于笔记序号。仅显示在 import 界面。
                    if ($view_type == 2)
                    {
                        echo "<input type='checkbox' id='index_inside_tag' value='' />笔记标签内保持序号    ";
                    }
                    // 显示“是否为元数据”
                    if ($is_metadata == 1)
                    {
                        echo "<input type='checkbox' id='is_metadata' checked=true />是元数据";
                    }
                    else 
                    {
                        echo "<input type='checkbox' id='is_metadata' />是元数据";
                    }
                    
                    echo "</p></tr>";
                    
                    $my_index++;
                }
                
                $my_index++;
            }
        }
    }
?>