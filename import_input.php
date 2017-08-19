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
<script type='text/javascript' src='./js/progress_view.js'></script>

<script>
// 设置按钮的状态.
function make_button_status(operate_type, disabled)
{
    document.getElementById(operate_type).disabled = disabled;
}

// 更新token
function update_token(token)
{
    document.getElementById("originator").value = token;
}

// 当前步骤计数。
var vip_tag_step = 0;
var progress = Progress_view.createNew();

// 调用成功后的回调函数。
// step1: 获取待处理的数量，并确认数据格式是否正确。返回：("step1", 行数, 出错行号)
// step2: 批量导入。返回：("step2", 行数, token)
// step3: 完成。返回：("step3", token)
// 其中一个环节出错就终止。
function succ_callback(operate_type, data)
{
    // alert(data);
    var parmas = new Array();
    parmas = data.split("-");
    
    if ((parmas.length != 2) && (parmas.length !=3))
    {
        progress.update("服务器返回错误: ".concat(data), vip_tag_step);
        make_button_status(operate_type, false);
    }
    
    // 返回数量
    if (parmas[0] == "step1")
    {
        progress.init(360, parmas[1], "update_data_label", "progress_border", 
            "progress", "percent");
        if (parmas[2] == 0) {
            progress.update("处理开始", vip_tag_step);
            ajax_do(++vip_tag_step);
        } else if (parmas[2] > 0) {
            progress.update("第 ".concat(parmas[2], " 行数据有错误"), vip_tag_step);
            make_button_status(operate_type, false);
        }
    }
    // 返回当前处理的数量. 每20条返回一次。
    else if (parmas[0] == "step2")
    {
        vip_tag_step = parmas[1];
        progress.update("已导入 ".concat(vip_tag_step, "; 累计: ", progress.getTotal()), 
            vip_tag_step);
            
        // 从后台获取 token. 
        update_token(parmas[2]);
        
        ajax_do(vip_tag_step);
    }
    // 返回最终结果: finish
    else if (parmas[0] == "step3")
    {
        vip_tag_step = progress.getTotal();
        progress.update("导入成功", vip_tag_step);
        
        // 从后台获取 token. 
        update_token(parmas[1]);
        document.getElementById("context").value = "";
        document.getElementById("context").focus();
        make_button_status(operate_type, false);
    }
    // 失败
    else if (parmas[0] == "fail")
    {
        // 显示错误信息。
        progress.update("第 ".concat(parmas[1], " 行数据有错误"), vip_tag_step);
        make_button_status(operate_type, false);
    }
}

// 发起Ajax通讯。
function ajax_do(step)
{
    // alert(step);
    operate_type = "update_data";
    
    // 数据检查。
    if (tags_check() > 0)
    {
        alert("标签名称不能带有标点符号。");
        return;
    }
    
    // 将控件灰掉，防止用户多次点击。
    if (step == 0){
        vip_tag_step = 0;
        document.getElementById("update_data_label").style.display = "none";
        make_button_status(operate_type, true);
    }
    
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
            'is_metadata'     :document.getElementById("is_metadata").checked,
            'step'            :step
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
<font size="5" color="red" >导入事件</font>

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
</textarea>
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
<tr>
<td>
    
<!-- 提交 begin -->
<table class="normal">
<tr>
<td>
    <div id="progress_border" style="width:360px">
    <div id="progress">
    <div id="percent">0%</div>
    </div>
    </div>
</td>
<td>
    <input type="hidden" id="originator" value="<?php echo html_encode(get_import_token()) ?>">
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <input type="submit" style="font-size:22pt; color:red" value="导入事件" 
        id="update_data" onclick="ajax_do(0)" /> 
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <class="label" style="display:none; color: red;" id="update_data_label">
</td>
</tr>
</table>
<!-- 提交 end -->
</td>
<td></td>
</tr>

</table>



    
<?php
    // exit
    mysql_close($conn);
    $conn = null;
?>

</body>
</html>