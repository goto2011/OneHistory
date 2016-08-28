<?php
require_once '../init.php';
is_user(2);
require_once "data.php";
require_once "sql.php";

if (empty($_POST['operate_type']) || (strlen($_POST['context']) == 0))
{
    ajax_error_exit(error_id::ERROR_CONTEXT_EMPTY);
}

$conn = open_db();

$ori_thing_uuid = "";
if (is_adder() && ($_SESSION['import_input_thing_uuid'] != ""))
{
    $ori_thing_uuid = $_SESSION['import_input_thing_uuid'];
}

// 检验数据。
if ($_POST['operate_type'] == "check_data")
{
    $error_line = handle_data_line(1);
    if ($error_line == 0)
    {
        ajax_error_exit(error_id::ERROR_OK);
    }
    else
    {
        // error line要传递给前台显示,所以不要轻易修改这一行.
        echo "fail -- " . $error_line;
    }
}

// 导入事件。
if ($_POST['operate_type'] == "update_data")
{
    // 避免重复提交。
    if ((!isset($_POST['originator'])) || (user_import_token($_POST['originator']) != 1))
    {
        ajax_error_exit(error_id::ERROR_PROGRASS_FAIL);
    }
    else
    {
        handle_data_line(2);

        // 更新成功. 重新分配 token. 所以不要轻易修改这两行.
        alloc_import_token();
        echo "ok -- " . get_import_token();
    }
}

/**
 * 按行读入数据并进行处理。返回0表示成功，其它值都表示有错误发生。
 * $operate_type==1, 数据校验。
 * $operate_type==2，数据输入。
 */
function handle_data_line($operate_type)
{
    global $ori_thing_uuid;

    // 按行读入输入界面传入的批量数据。
    $context = one_line_flag(html_encode($_POST['context']));
    $token = strtok($context, "\r");
    $line_index = 0;
    // 行号，含空行。
    $thing_index = 0;
    // 事件串号，一行一条，不含空行。
    $thing_index_inside_tag = 0;
    //  笔记编号。

    // 获取标签内编号的基数。
    if (($operate_type == 2) && (is_index_inside_tag() == 1))
    {
        // 根据 笔记标签 来读取标签内编号。
        $thing_index_inside_tag = get_index_base_inside_tag($_POST['note_tags']);
    }

    while (($token != false) && (strlen($token) > 0))
    {
        $line_index++;
        // 切割当前行。
        $my_array = splite_string($token);
        if ($my_array != FALSE)
        {
            // 校验数据
            if ($operate_type == 1)
            {
                @$time_array = get_time_from_native($my_array['time']);

                // 如果当前时间字段无法识别，则返回所在行数。
                if ($time_array['status'] != "ok")
                {
                    return $line_index;
                }
            }
            // 导入事件
            if ($operate_type == 2)
            {
                $thing_index++;
                
                $is_metadata = is_metadata();

                // 从 update_input.php “重构数据”来的事件，会持有非空的 $ori_thing_uuid。但只有第一条。
                if (($thing_index == 1) && ($ori_thing_uuid != ""))
                {
                    if (update_thing_to_db($ori_thing_uuid, 
                        get_time_from_native($my_array['time']), $my_array['thing'], $is_metadata) != 1)
                    {
                        ajax_error_exit(error_id::ERROR_UPDATE_FAIL);
                    }
                    insert_tag_from_input($_POST, $ori_thing_uuid);
                }
                else
                {
                    // 保存事件和时间
                    if (is_index_inside_tag() == 1)
                    {
                        $thing_index_inside_tag++;
                        // 保存序号
                        $thing_uuid = insert_thing_to_db(get_time_from_native($my_array['time']), 
                                $my_array['thing'], $is_metadata, $thing_index_inside_tag);
                    }
                    else
                    {
                        $thing_uuid = insert_thing_to_db(get_time_from_native($my_array['time']), 
                                $my_array['thing'], $is_metadata);
                    }

                    // 保存标签
                    if ($thing_uuid != "")
                    {
                        insert_tag_from_input($_POST, $thing_uuid, "");
                    }
                    else
                    {
                        ajax_error_exit(error_id::ERROR_INSERT_FAIL, $my_array['time'] . " -- " 
                                . $my_array['thing']);
                    }
                }
            }
        }
        else
        {
            // 校验数据时，发现错误即返回。
            if ($operate_type == 1)
            {
                return $line_index;
            }
            if ($operate_type == 2)
            {
                ajax_error_exit(error_id::ERROR_TIME_FAIL, $token);
            }
        }

        // 下一行
        $token = strtok("\r");
    }

    return 0;
}

// exit.
mysql_close($conn);
$conn = null;
?>