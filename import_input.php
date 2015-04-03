<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link rel="shortcut icon" type="image/x-icon" href="./favicon.ico" />

<?php 
	require_once 'init.php';
    is_user(1);
    require_once "data_string.php";
?>

<link rel="stylesheet" type="text/css" href="./style/jquery-ui.css" />
<link rel="stylesheet" type="text/css" href="./style/jquery.tagsinput.css" />

<link rel="stylesheet" type="text/css" href="./style/data.css" />

<script type="text/javascript" src="./js/jquery.min.js"></script>
<script type='text/javascript' src='./js/jquery-ui.min.js'></script>
<script type="text/javascript" src="./js/jquery.tagsinput.js"></script>

<script type='text/javascript' src='./js/data.js'></script>

<script>
// "check_data_label"
function show_check_data_status(is_ok, error_line)
{
    document.getElementById("check_data_label").disabled = false;
    document.getElementById("check_data_label").style.color = "red";
    if (is_ok == 1)
    {
        document.getElementById("check_data_label").innerHTML = "数据检验ok，可以保存。";
    }
    else
    {
        document.getElementById("check_data_label").innerHTML = "数据检验有错！ 错误行：" + error_line + "。";
    }
    document.getElementById("check_data_label").style.display = "inline";
}

// "update_data_label"
function show_update_data_status(is_ok)
{
    document.getElementById("update_data_label").disabled = false;
    document.getElementById("update_data_label").style.color = "red";
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
    document.getElementById("context").value = "";
    document.getElementById("context").focus();
    
    document.getElementById("originator").value = token;
    
    document.getElementById("start_tags").value = "";
    document.getElementById("end_tags").value = "";
    document.getElementById("country_tags").value = "";
    document.getElementById("geography_tags").value = "";
    document.getElementById("person_tags").value = "";
    document.getElementById("source_tags").value = "";
    document.getElementById("free_tags").value = "";
}

// ajax.
function ajax_do(operate_type)
{
    var xmlhttp;
    var res_status;
    if (window.XMLHttpRequest)
    {
        // code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp=new XMLHttpRequest();
    }
    else
    {
        // code for IE6, IE5
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
    // make_button_status(operate_type, 0);
    
    xmlhttp.onreadystatechange=function()
    {
        if (xmlhttp.readyState==4 && xmlhttp.status==200)
        {
            var response = xmlhttp.response;
            if (response.substring(0, 2) == "ok")
            {
                res_status = 1;
            }
            else if (response.substring(0, 4) == "fail")
            {
                res_status = 0;
            }
            // alert("Ajax_status: " + xmlhttp.response);
            
            if (operate_type == "check_data")
            {
                var error_line = "";
                if (res_status == 0)
                {
                    error_line = response.substring(8);
                }
                show_check_data_status(res_status, error_line);
            }
            else if (operate_type == "update_data")
            {
                show_update_data_status(res_status);
                
                if (res_status == 1)
                {
                    // 获取 token。echo "ok -- " . get_import_token();
                    var token = response.substring(6);
                    blank_context(token);
                }
            }
        }
    }
    // 获取数据
    var originator      = document.getElementById("originator").value;
    var context         = document.getElementById("context").value;
    var start_tags      = document.getElementById("start_tags").value;
    var end_tags        = document.getElementById("end_tags").value;
    var country_tags    = document.getElementById("country_tags").value;
    var geography_tags  = document.getElementById("geography_tags").value;
    var person_tags     = document.getElementById("person_tags").value;
    var source_tags     = document.getElementById("source_tags").value;
    var free_tags       = document.getElementById("free_tags").value;
    
    xmlhttp.open("POST", "./ajax/import_do.php", true);
    xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
    xmlhttp.send("operate_type=" + operate_type 
                    + "&originator=" + originator 
                    + "&context=" + context
                    + "&start_tags=" + start_tags
                    + "&end_tags=" + end_tags
                    + "&country_tags=" + country_tags
                    + "&geography_tags=" + geography_tags
                    + "&person_tags=" + person_tags
                    + "&source_tags=" + source_tags
                    + "&free_tags=" + free_tags
                    );
}
</script>

<title>批量数据导入</title>
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
<p>导入内容：<textarea class="context" rows="18" cols="100" id="context" 
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
    <div class="label" style="display:none;" id="check_data_label"></div>
</div>
<!-- 事件内容输入 end -->
</td>

<td width="40%">
    <p>数据格式说明：</p>
      <ol>
        <li>一行一个事件。不支持跨行。</li>
        <li>每行数据的格式如下：“时间，事件”。即开始为时间字段，然后是分隔符，接着是事件字段。</li>
        <li>时间字段：时间格式较多样，我们尽量支持。目前已经支持了四五十种。基本上除了年代没有支持外，其它都支持了。 
            细节参见：<a href="../bbs/viewtopic.php?id=18" >如何完成批量数据导入？</a> 第四节。</li>
        <li>分隔符支持4种：<br />
        中文逗号“，”、英文逗号“,”、中文冒号“：”、英文冒号“:”。</li>
        <li>分隔符后到行尾，全部是事件字段。</li>
    </ol>
</td></tr>
  
<tr><td>
<!-- 标签输入 begin -->
<table class="normal">
<tr>
<td width='400'>
    <p class="thick">事件开始标签：<input id='start_tags'      name='start_tags'   type='text'     class='tags' ></p></td>
<td width='400'>
    <p class="thick">事件结束标签：<input id='end_tags'        name='end_tags'     type='text'     class='tags' ></p></td>
</tr>
<tr>
<td><p class="thick">国家/朝代/民族/文明标签：<input id='country_tags'     name='country_tags'  type='text'     class='tags' ></p></td>
<td><p class="thick">地理标签：<input id='geography_tags'    name='geography_tags' type='text'   class='tags' ></p></td>
</tr>
<tr>
<td><p class="thick">人物标签：<input id='person_tags'       name='person_tags'  type='text'     class='tags' ></p></td>
<td><p class="thick">出处标签：<input id='source_tags'       name='source_tags'  type='text'     class='tags' ></p></td>
</tr>
<tr>
<td colspan="2"><p class="thick">自由标签：<input id='free_tags'  name='free_tags'    type='text'     class='tags' ></p></td>
</tr>
</table>
<!-- 标签输入 end -->
</td>

<td>
<p>标签使用说明：</p>
<p style="text-align:left"><a href="../bbs/viewtopic.php?id=20" >如何添加和使用标签？</a></p>
</td>
</tr>
</table>

<p>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

<input type="hidden" id="originator" value="<?php echo html_encode($_GET['import_once']) ?>">
<input type="submit" style="font-size:22pt; color:red" id="update_data" onclick="ajax_do('update_data')" /> <!-- 提交 -->
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<class="label" style="display:none;" id="update_data_label">

</body>
</html>