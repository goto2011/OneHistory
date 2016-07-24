<?php
require_once 'init.php';
is_user(3);
require_once "sql.php";
require_once "data.php";
require_once "tag.php";
require_once "list_control.php";
require_once "view_list.php";

// 唯一可设置 list_type 的位置.
if (!empty($_GET['list_type']) && is_numeric($_GET['list_type']))
{
    set_current_list($_GET['list_type']);
}

if (check_list_param() == false)
{
    // debug.
    $GLOBALS['log'] -> error(print_list_param());
    error_exit("请按照正常流程访问本网站。谢谢。");
}
?>

<link rel="stylesheet" type="text/css" href="./style/data.css" />
<script type='text/javascript' src='./js/data.js'></script>

<script type="text/javascript">
    window.onload = function() {
        altRows('alternatecolor');
    }
</script>

<?php
// main().
flash_item_list();

// 打印表格(main)
function flash_item_list()
{
    $GLOBALS['log'] -> error(date('H:i:s') . "-" . "Thing_List_Begin.");
    $thing_list_begin = strtotime("now");

    $begin_year = 0;
    $end_year = 0;
    $sql_object = sql_object::CONST_OBJECT_INIT;
    $sql_param = array();

    // 打开数据库
    $conn = open_db();

    // 算下 period 开始/结束.
    if (is_period_tag(get_current_tag_id()))
    {
        $begin_year = get_begin_year(get_period_big_index(), get_period_small_index());
        $end_year = get_end_year(get_period_big_index(), get_period_small_index());
    }
    $GLOBALS['log']->error(date('H:i:s') . "-" . "flash_item_list(). Step3");

    // 生成sql语句的查询子句。**
    // search 要兼顾 tag 和 period。所以检索优先级最高。
    if (is_search())
    {
        // 获取查询子句。
        $search_key = search_key();
        // 1.可以在指定的tag下检索。
        $search_tag_uuid = get_property_UUID();
        // 2.可以在当前tag type下检索。
        $search_tag_type = search_tag_type();
        // 3.也可以在当前时期下检索。
        if (is_period_tag(get_current_tag_id()))
        {
            $sql_param = array(
                "search_key" => $search_key,
                "tag_uuid" => $search_tag_uuid,
                "tag_type" => $search_tag_type,
                "has_period" => TRUE,
                "begin_year" => $begin_year,
                "end_year" => $end_year
            );
        }
        else
        {
            $sql_param = array(
                "search_key" => $search_key,
                "tag_uuid" => $search_tag_uuid,
                "tag_type" => $search_tag_type,
                "has_period" => FALSE
            );
        }
        $sql_object = sql_object::CONST_SEARCH;
        // $my_array = get_search_where_sub();   // 关键词检索
    }
    else if (is_tag())
    {
        $sql_param = array("tag_id" => get_property_UUID());
        $sql_object = sql_object::CONST_TAG;
        // $my_array = get_tag_search_substring(get_property_UUID());   // tag检索
    }
    else if (is_period_tag(get_current_tag_id()))
    {
        $sql_param = array(
            "begin_year" => $begin_year,
            "end_year" => $end_year
        );
        $sql_object = sql_object::CONST_PERIOD;
        // $my_array = get_period_where_sub($begin_year, $end_year);   // 时期检索
    }
    else
    {
        $sql_param = array("tag_type" => get_current_tag_id());
        $sql_object = sql_object::CONST_TAG_TYPE;
        // $my_array = get_thing_substring(get_current_tag_id());     // 类型检索
    }

    $GLOBALS['log']->error(date('H:i:s') . "-flash_item_list(). Step7-" . get_current_tag_id());
    // 打印搜索区
    if (is_show_search_box(get_current_tag_id()))
    {
        print_search_zone();
    }

    $GLOBALS['log']->error(date('H:i:s') . "-" . "flash_item_list(). Step8");
    // 打印标签区。
    print_tags_zone();

    // $GLOBALS['log']->error(date('H:i:s') . "-" . "flash_item_list(). Step8-2");
    // 打印查找到的标签。
    if (is_search())
    {
        print_seach_tags_zone($sql_param);
    }
    
    $GLOBALS['log']->error(date('H:i:s') . "-" . "flash_item_list(). Step9");
    // 计算总页数和当前页偏移量.
    $page_size = get_page_size();
    $offset = $page_size * (get_page() - 1);
    // 获得条目数量. ***
    $item_count = get_thing_count($sql_object, $sql_param);
    $GLOBALS['log']->error(date('H:i:s') . "-" . "flash_item_list(). Step9-2");
    
    // 打印表格遍历条.
    print_list_control($item_count, $page_size, get_page());

    if (is_tag())
    {
        print_tag_control();
    }
    else if (is_period_tag(get_current_tag_id()))
    {
        print_period_info();
    }

    $GLOBALS['log']->error(date('H:i:s') . "-" . "flash_item_list(). Step10");
    // 打印“添加标签”输入框。2015-4-21
    if (is_show_add_tag())
    {
        print_add_tag_form();
    }

    $GLOBALS['log']->error(date('H:i:s') . "-" . "flash_item_list(). Step11");
    // 打印表头。
    print_item_list_head();

    $GLOBALS['log'] -> error(date('H:i:s') . "-flash_item_list(). Step12-" . get_current_tag_id());

    if ($item_count > 0)
    {
        // 查询子句增加排序、分页。
        $order_substring = add_order_page_substring($offset, $page_size);

        // 完成 事件、标签、事件-标签对的三表联合查询。****
        $tag_id_array = array();
        $tag_param_array = array();
        $my_sql_thing = get_thing_tag_prompt($sql_object, $sql_param, $order_substring, 
            $tag_id_array, $tag_param_array);

        // var_dump($tag_id_array) . "</br>";
        // var_dump($tag_param_array) . "</br>";

        // $GLOBALS['log']->error(date('H:i:s') . "-" . "flash_item_list(). Step13");
        // 获取 thing 数据。***
        $result = get_thing_item_db($sql_object, $sql_param, $order_substring);

        $index = $offset;
        while ($row = mysql_fetch_array($result))
        {
            $index++;

            echo "<tr>";
            if (is_show_add_tag())
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
            // 高亮 检索关键字。 2016-01-27
            if (is_search())
            {
                $search_key = search_key();
                $key_array = get_highline_key_string($search_key);
                for ($ii = 0; $ii < count($key_array); $ii++)
                {
                    $thing_context = preg_replace("/($key_array[$ii])/i", "<b style=\"color:red\">\\1</b>", $thing_context);
                }
            }

            // 事件字段
            echo "<td><a href='update_input.php?thing_uuid=" . $row['uuid'] . "&update_once=" . 
                get_update_token() . "&item_index=" . $index . "'>" . $thing_context . "</a></td>";

            // $GLOBALS['log']->error(date('H:i:s') . "-" . "flash_item_list(). Step15");
            // 标签字段。 ***
            echo "<td>" . print_item_tags($row['uuid'], $tag_id_array, $tag_param_array, $person_count_string) . "</td>";
            echo "</tr>";
            // $GLOBALS['log']->error(date('H:i:s') . "-" . "flash_item_list(). Step16");
        }// while

        // $GLOBALS['log']->error(date('H:i:s') . "-" . "flash_item_list(). Step17");

        echo "</table>";
        print_list_control($item_count, $page_size, get_page()); ;// list control.

        // log print.
        $time_diff = strtotime("now") - $thing_list_begin;
        if ($time_diff >= 3)
        {
            $GLOBALS['log'] -> error(date('H:i:s') . " - " . $time_diff . " - List_show_too_late! ");
            $GLOBALS['log'] -> error("SQL string is: " . $my_sql_thing);
        }
    }// if

    if (is_tag())
    {
        print_tag_control();
    }
    if (is_show_add_tag())
    {
        echo "</form>";
    }

    $GLOBALS['log'] -> error(date('H:i:s') . "-" . "Thing_List_End.");

    // exit
    mysql_close($conn);
    $conn = null;
}
?>

<input type="hidden" id="tag_id" name="tag_id" value="<?=get_property_UUID() ?>">
