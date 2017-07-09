<?php 
	require_once 'init.php';
    is_user(1);
    require_once "data.php";
    require_once "sql.php";
    require_once "view_update.php";
    
    // 为了能够连续导入事件，import的token自行分配。
    alloc_import_token();
    
    $thing_uuid = "";
    $_SESSION['import_input_thing_uuid'] = "";
    if(!empty($_GET['thing_uuid']) && (is_adder()))
    {
        $thing_uuid = html_encode($_GET['thing_uuid']);   /// thing uuid.
        $_SESSION['import_input_thing_uuid'] = $thing_uuid;
    }
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link rel="shortcut icon" type="image/x-icon" href="./favicon.ico" />

<link rel="stylesheet" type="text/css" href="./style/jquery-ui.css" />
<link rel="stylesheet" type="text/css" href="./style/jquery.tagsinput.css" />

<link rel="stylesheet" type="text/css" href="./style/data.css" />

<script type="text/javascript" src="./js/jquery.min.js"></script>
<script type='text/javascript' src='./js/jquery-ui.min.js'></script>
<script type="text/javascript" src="./js/jquery.tagsinput.js"></script>

<script type='text/javascript' src='./js/data.js'></script>
<script type='text/javascript' src='./js/ajax.js'></script>
<script type='text/javascript' src='./js/key_time.js'></script>

<script>
// 设置按钮的状态.
function make_button_status(operate_type, disabled)
{
    document.getElementById(operate_type).disabled = disabled;
}

// "check_data_label"
function show_check_data_status(is_ok, error_line)
{
    document.getElementById("update_data_label").style.display = "none";
    // document.getElementById("check_data_label").disabled = false;
    if (is_ok == 1)
    {
        document.getElementById("check_data_label").innerHTML = "数据检验ok，可以保存。";
    }
    else
    {
        if (error_line.length > 0)
        {
            document.getElementById("check_data_label").innerHTML = "数据有错！ 错误行：" + error_line + "。";
        }
        else
        {
            document.getElementById("check_data_label").innerHTML = "数据有错！";
        }
    }
    document.getElementById("check_data_label").style.display = "inline";
}

// "update_data_label"
function show_update_data_status(is_ok)
{
    document.getElementById("check_data_label").style.display = "none";
    // document.getElementById("update_data_label").disabled = false;
    if (is_ok == 1)
    {
        document.getElementById("update_data_label").innerHTML = "数据保存ok。";
    }
    else
    {
        document.getElementById("update_data_label").innerHTML = "数据保存失败 ！";
    }
    document.getElementById("update_data_label").style.display = "inline";
}

// 清空 textedit 的内容
function blank_context(token)
{
    /*
    document.getElementById("start_tags").value = "";
    document.getElementById("end_tags").value = "";
    document.getElementById("country_tags").value = "";
    document.getElementById("geography_tags").value = "";
    document.getElementById("person_tags").value = "";
    document.getElementById("source_tags").value = "";
    document.getElementById("free_tags").value = "";
    */
    document.getElementById("context").value = "";
    document.getElementById("context").focus();
    
    document.getElementById("originator").value = token;
}

// 调用成功后的回调函数。
function succ_callback(operate_type, data)
{
    make_button_status(operate_type, false);
    
    if (data.substring(0, 2) == "ok")
    {
        res_status = 1;
    }
    else if (data.substring(0, 4) == "fail")
    {
        res_status = 0;
    }
    // alert("Ajax_status: " + data);
    
    if (operate_type == "check_data")
    {
        var error_line = "";
        if (res_status == 0)
        {
            error_line = data.substring(8);
        }
        // 显示错误信息。
        show_check_data_status(res_status, error_line);
    }
    else if (operate_type == "update_data")
    {
        show_update_data_status(res_status);
        
        if (res_status == 1)
        {
            // 获取 token。echo "ok -- " . get_import_token();
            var token = data.substring(6);
            blank_context(token);
        }
    }
}

// 发起Ajax通讯。
function ajax_do(operate_type)
{
    // 数据检查。
    if (tags_check() > 0)
    {
        alert("标签名称不能带有标点符号。");
        return;
    }
    
    // 将控件灰掉，防止用户多次点击。
    document.getElementById("check_data_label").style.display = "none";
    document.getElementById("update_data_label").style.display = "none";
    make_button_status(operate_type, true);
    
    var import_ajax = xhr({
        url:'./ajax/import_do.php',
        data:{
            'operate_type'  :operate_type,
            'originator'    :document.getElementById("originator").value,
            'context'       :remove_blank(remove_html_code(document.getElementById("context").value)),
            
            'die_tags'      :document.getElementById("die_tags").value,
            'solution_tags' :document.getElementById("solution_tags").value,
            // 'start_tags'    :document.getElementById("start_tags").value,
            // 'end_tags'      :document.getElementById("end_tags").value,
            'country_tags'  :document.getElementById("country_tags").value,
            // 'geography_tags':document.getElementById("geography_tags").value,
            'person_tags'   :document.getElementById("person_tags").value,
            'source_tags'   :document.getElementById("source_tags").value,
            'free_tags'     :document.getElementById("free_tags").value,
            'dynasty_tags'  :document.getElementById("dynasty_tags").value,
            'topic_tags'    :document.getElementById("topic_tags").value,
            // 'office_tags'   :document.getElementById("office_tags").value,
            // 'key_tags'      :document.getElementById("key_tags").value,
            'source_tags'   :document.getElementById("source_tags").value,
            'source_detail' :document.getElementById("source_detail").value,
            'note_tags'     :document.getElementById("note_tags").value,
            // 'land_tags'     :document.getElementById("land_tags").value,
            // 笔记标签内保持序号
            'index_inside_tag':document.getElementById("index_inside_tag").checked,
            // 是否是元数据
            'is_metadata'     :document.getElementById("is_metadata").checked
        },
        async:false,
        method:'POST',
        complete: function () {
        },
        success: function  (data) {
            succ_callback(operate_type, data);
        },
        error: function () {
            succ_callback(operate_type, "fail");
        }
    });
    // system_manager_ajax.send();
}
</script>

<title>导入事件</title>
</head>
<body>

<!-- 页眉 begin -->
<iframe src="./main_header.php" height="65px" width="100%" scrolling="no" frameborder="0"></iframe>
<!-- 页眉 end -->

<?php

    $conn = open_db();
        
    if ($thing_uuid != "")
    {
        // 初始化变量。
        $time_thing = "";
        $result = get_thing_db($thing_uuid);
        while($row = mysql_fetch_array($result))
        {
            $thing = html_encode($row['thing']);
            $time = get_time_string(html_encode($row['time']), html_encode($row['time_type']));
            $time_limit = get_time_limit_string(html_encode($row['time_limit']), html_encode($row['time_limit_type']));
            
            if ($time_limit != "")
            {
                $time_thing = $time . "，" . $time_limit . "，" . $thing;
            }
            else 
            {
                $time_thing = $time . "，" . $thing;
            }
        }
    }
?>

<font size="5" color="red" >导入事件</font><br>
<table width="100%" border="0">
<tr>
<td width="50%">

<!-- 事件内容输入 begin -->
<p class="thick">导入内容：<textarea class="context" rows="10" cols="80" id="context" 
    required=required autofocus="autofocus">

<?php
    if ($thing_uuid != "")
    {
        echo $time_thing;
    }
?>
</textarea></p>

<div>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    
    <input type="submit" style="font-size:22pt; color:red" value="检查数据" 
        id="check_data" onclick="ajax_do('check_data')" /> <!-- 提交 -->
    
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <div class="label" style="display:none; color: red;" id="check_data_label"></div>
</div>
<!-- 事件内容输入 end -->
</td>

<td width="40%">
    <p class="thick">数据格式说明：</p>
    <ol style="font-size:15px">
        <li>一行一个事件。不支持跨行。</li>
        <li>每行数据的格式如下：“时间，事件”。"，"是分隔符，分隔符之前为时间字段，之后都算事件字段。</li>
        <li>时间字段：时间格式多样，我们已经支持了五六十种，基本上常见的都支持了。 
            相关细节参见：<a href="../bbs/viewtopic.php?id=18" >如何完成批量数据导入？</a>第四节。</li>
        <li>分隔符支持2种：
        中文逗号“，”、英文逗号“,”。</li>
    </ol>
</td></tr>
  
<tr><td>
<!-- 标签输入 begin -->
<table class="normal">

<?php
    // 显示 tag 输入框.
    show_tag_input_view(2, $thing_uuid, 0);
?>

</table>
<!-- 标签输入 end -->
</td>

<td>
<p class="thick">标签使用说明：</p>
<p style="font-size:15px" style="text-align:left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <ol style="font-size:15px">
        <li>总体说明（内容较多，请移步）
            <p><a href="../bbs/viewtopic.php?id=20" >如何添加和使用标签？</a></li>
        <li>"事件开始"和"事件结束"标签会在时间轴显示中起标签作用，在主界面上不显示。</li>
        <li>"出处"往往需要很多细节，都放在标签中不太合适，所以请在标签区输入对应的书名等少数内容，细节放在后面的输入框中。</li>
            
</td>
</tr>
</table>

    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

<input type="hidden" id="originator" value="<?php echo html_encode(get_import_token()) ?>">
<input type="submit" style="font-size:22pt; color:red" value="导入事件" id="update_data" onclick="ajax_do('update_data')" /> <!-- 提交 -->
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<class="label" style="display:none; color: red;" id="update_data_label">

<?php
    // exit
    mysql_close($conn);
    $conn = null;
?>

</body>
</html>