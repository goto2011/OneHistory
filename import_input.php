<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link rel="shortcut icon" type="image/x-icon" href="./favicon.ico" />

<?php 
	require_once 'init.php';
    is_user(1);
    require_once "data.php";
    
    alloc_import_token();
?>

<link rel="stylesheet" type="text/css" href="./style/jquery-ui.css" />
<link rel="stylesheet" type="text/css" href="./style/jquery.tagsinput.css" />

<link rel="stylesheet" type="text/css" href="./style/data.css" />

<script type="text/javascript" src="./js/jquery.min.js"></script>
<script type='text/javascript' src='./js/jquery-ui.min.js'></script>
<script type="text/javascript" src="./js/jquery.tagsinput.js"></script>

<script type='text/javascript' src='./js/data.js'></script>
<script type='text/javascript' src='./js/ajax.js'></script>

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

// tag 数据检查。=1，不合格；=0，合格。
function tag_check(tag, tag_name)
{
    if(is_dot(tag_name))
    {
        document.getElementById(tag).focus();
        return 1;
    }
    else
    {
        return 0;
    }
}

function tags_check()
{
    var ret = 0;
    ret += tag_check("start_tags", document.getElementById("start_tags").value);
    ret += tag_check("end_tags", document.getElementById("end_tags").value);
    ret += tag_check("country_tags", document.getElementById("country_tags").value);
    ret += tag_check("geography_tags", document.getElementById("geography_tags").value);
    ret += tag_check("person_tags", document.getElementById("person_tags").value);
    ret += tag_check("source_tags", document.getElementById("source_tags").value);
    ret += tag_check("free_tags", document.getElementById("free_tags").value);
    
    return ret;
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
    
    var import_ajax = xhr({
        url:'./ajax/import_do.php',
        data:{
            'operate_type'  :operate_type,
            'originator'    :document.getElementById("originator").value,
            'context'       :document.getElementById("context").value,
            
            'start_tags'    :document.getElementById("start_tags").value,
            'end_tags'      :document.getElementById("end_tags").value,
            'country_tags'  :document.getElementById("country_tags").value,
            'geography_tags':document.getElementById("geography_tags").value,
            'person_tags'   :document.getElementById("person_tags").value,
            'source_tags'   :document.getElementById("source_tags").value,
            'free_tags'     :document.getElementById("free_tags").value
        },
        async:false,
        method:'POST',
        complete: function () {
            // 将控件灰掉，防止用户多次点击。
            make_button_status(operate_type, true);
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

<title>数据导入</title>
</head>
<body>

<!-- 页眉 begin -->
<iframe src="./main_header.php" height="65px" width="100%" scrolling="no" frameborder="0"></iframe>
<!-- 页眉 end -->

<font size="5" color="red" >批量数据录入</font><br>

<table width="100%" border="0">
<tr>
<td width="50%">

<!-- 事件内容输入 begin -->
<p class="thick">导入内容：<textarea class="context" rows="10" cols="100" id="context" 
    required=required autofocus="autofocus"></textarea></p>
<div>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    
    <input type="submit" style="font-size:22pt; color:red" value="确认数据合法性" 
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
        <li>每行数据的格式如下：“时间，事件”。"，"为分隔符，分隔符之前为时间字段，之后全部是事件字段。</li>
        <li>时间字段：时间格式多样，我们目前已支持了四五十种，基本上常见的都支持了。 
            细节参见：<a href="../bbs/viewtopic.php?id=18" >如何完成批量数据导入？</a>第四节。</li>
        <li>分隔符支持4种：
        中文逗号“，”、英文逗号“,”、中文冒号“：”、英文冒号“:”。</li>
    </ol>
</td></tr>
  
<tr><td>
<!-- 标签输入 begin -->
<table class="normal">
    
<tr class="tag_normal">
<td width='400'>
    <p class="thick">事件开始标签：<input id='start_tags'      name='start_tags'   type='text'     class='tags' ></p></td>
<td width='400'>
    <p class="thick">事件结束标签：<input id='end_tags'        name='end_tags'     type='text'     class='tags' ></p></td>
</tr>

<tr class="tag_normal">
<td><p class="thick">国家/民族/文明标签：<input id='country_tags'     name='country_tags'  type='text'     class='tags' ></p></td>
<!-- add, 2015-4-19 -->
<td><p class="thick">中国朝代标签：<input id='dynasty_tags'     name='dynasty_tags'  type='text'     class='tags' ></p></td>
</tr>

<tr class="tag_normal">
<td><p class="thick">地理标签：<input id='geography_tags'    name='geography_tags' type='text'   class='tags' ></p></td>
<td><p class="thick">出处标签：<input id='source_tags'       name='source_tags'  type='text'     class='tags' ></p></td>
</tr>

<tr class="tag_normal">
<td><p class="thick">人物标签：<input id='person_tags'       name='person_tags'  type='text'     class='tags' ></p></td>
<!-- add, 2015-4-19 -->
<td><p class="thick">官制标签：<input id='office_tags'       name='office_tags'  type='text'     class='tags' ></p></td>
</tr>
    
<tr class="tag_normal">
<!-- add, 2015-4-19 -->
<td><p class="thick">事件类型标签：<input id='type_tags'  name='type_tags'    type='text'     class='tags' ></p></td>
<td><p class="thick">自由标签：<input id='free_tags'  name='free_tags'    type='text'     class='tags' ></p></td>
</tr>

</table>
<!-- 标签输入 end -->
</td>

<td>
<p class="thick">标签使用说明：</p>
<p style="font-size:15px" style="text-align:left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <a href="../bbs/viewtopic.php?id=20" >如何添加和使用标签？</a></p>
</td>
</tr>
</table>

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

<input type="hidden" id="originator" value="<?php echo html_encode(get_import_token()) ?>">
<input type="submit" style="font-size:22pt; color:red" id="update_data" onclick="ajax_do('update_data')" /> <!-- 提交 -->
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<class="label" style="display:none; color: red;" id="update_data_label">

</body>
</html>