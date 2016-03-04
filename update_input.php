<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link rel="shortcut icon" type="image/x-icon" href="./favicon.ico" />

<?php 
    require_once 'init.php';
    is_user(1);
    require_once "data.php";
    require_once "sql.php";
    require_once "list_control.php";
    require_once "view_update.php";

	// 判断是新增，还是编辑
	$thing_uuid = "";
    $_SESSION['update_input_thing_uuid'] = "";
	if(!empty($_GET['thing_uuid']))
	{
		$thing_uuid = html_encode($_GET['thing_uuid']);   /// thing uuid.
        $_SESSION['update_input_thing_uuid'] = $thing_uuid;
	}
?>

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
function make_button_status(disabled)
{
    document.getElementById("update_data").disabled = disabled;
}

// 调用成功后的回调函数。
function succ_callback(data)
{
    make_button_status(false);
    
    if (data.substring(0, 2) == "ok")
    {
        alert("保存成功！");
        history.go(-1);
    }
    else if (data.substring(0, 4) == "fail")
    {
        alert(data);
    }
    
    // 如果是时间格式不对, 要自动选中时间字段.
    if (data == "fail: 时间格式不合法。")
    {
        time.focus();
    }
}

// 发起Ajax通讯。
function ajax_do()
{
    // 数据合法性检查。
    if (tags_check() > 0)
    {
        alert("标签名称不能带有标点符号。");
        return;
    }
    
    // 检查三个人数文本框的输入是否为数字。
    var death_person_count = document.getElementById("death_person_count").value;
    var hurt_person_count = document.getElementById("hurt_person_count").value;
    var missing_person_count = document.getElementById("missing_person_count").value;
    var word_count = document.getElementById("word_count").value;
    
    // 死亡人数。
    if (death_person_count != "")
    {
        if(!check_number(death_person_count))
        {
            alert("人数文本框请输入数字。");
            return;
        }
    }
    else
    {
        death_person_count = 0;
    }
    
    // 受伤人数。
    if (hurt_person_count != "")
    {
        if(!check_number(hurt_person_count))
        {
            alert("人数文本框请输入数字。");
            return;
        }
    }
    else
    {
        hurt_person_count = 0;
    }
    
    // 失踪人数。
    if (missing_person_count != "")
    {
        if(!check_number(missing_person_count))
        {
            alert("人数文本框请输入数字。");
            return;
        }
    }
    else
    {
        missing_person_count = 0;
    }
    
    // 字数。
    if (word_count != "")
    {
        if(!check_number(word_count))
        {
            alert("字数文本框请输入数字。");
            return;
        }
    }
    else
    {
        word_count = 0;
    }
    
    var update_ajax = xhr({
        url:'./ajax/update_do.php',
        data:{
            'originator'    :document.getElementById("originator").value,
            'thing'         :remove_blank(remove_html_code(document.getElementById("thing").value)),
            'time'          :document.getElementById("time").value,
            // 'time_type'     :get_checkbox_value("time_type"),
            'time_limit'    :document.getElementById("time_limit").value,
            'time_limit_type':get_checkbox_value("time_limit_type"),
            
            'die_tags'      :document.getElementById("die_tags").value,
            'solution_tags' :document.getElementById("solution_tags").value,
            'start_tags'    :document.getElementById("start_tags").value,
            'end_tags'      :document.getElementById("end_tags").value,
            'country_tags'  :document.getElementById("country_tags").value,
            'geography_tags':document.getElementById("geography_tags").value,
            'person_tags'   :document.getElementById("person_tags").value,
            'free_tags'     :document.getElementById("free_tags").value,
            'dynasty_tags'  :document.getElementById("dynasty_tags").value,
            'topic_tags'    :document.getElementById("topic_tags").value,
            // 'office_tags'   :document.getElementById("office_tags").value,
            // 'key_tags'      :document.getElementById("key_tags").value,
            'source_tags'   :document.getElementById("source_tags").value,
            'note_tags'     :document.getElementById("note_tags").value,
            'land_tags'     :document.getElementById("land_tags").value,
            
            'death_person_count'    :death_person_count,
            'hurt_person_count'     :hurt_person_count,
            'missing_person_count'  :missing_person_count,
            'word_count'            :word_count
            
        },
        async:false,
        method:'POST',
        complete: function () {
            // 将控件灰掉，防止用户多次点击。
            make_button_status(true);
        },
        success: function  (data) {
            // alert(data);
            succ_callback(data);
        },
        error: function () {
            // alert(data);
            succ_callback("fail");
        }
    });
    // system_manager_ajax.send();
}
</script>

<title>编辑事件</title>
</head>
<body>
    
<!-- 页眉 begin -->
<iframe src="./main_header.php" height="65px" width="100%" scrolling="no" frameborder="0"></iframe>
<!-- 页眉 end -->

<?php 
	$conn = open_db();
	
    // 初始化变量。
    $time = 0;
	$time_type = 0;
    $time_limit = 0;
	$time_limit_type = 0;
    $death_person_count = "";
    $hurt_person_count = "";
    $missing_person_count = "";
	$word_count = "";
	
    // 更新 item_index, 暂时无用.
    if (!empty($_GET['item_index']) && is_numeric($_GET['item_index']))
    {
        set_item_index(html_encode($_GET['item_index']));
    }
    
	$result = get_thing_db($thing_uuid);
	
	while($row = mysql_fetch_array($result))
	{
		$thing = html_encode($row['thing']);
		$time_type = html_encode($row['time_type']);
        
        // 2016-01-31：修改bug：公元前日期显示不正常。
		$time = get_time_string(html_encode($row['time']), $time_type);
		
		$time_limit = html_encode($row['time_limit']);
        if ($time_limit == 0)$time_limit = null;
		$time_limit_type = html_encode($row['time_limit_type']);
        
        if ($row['related_number1'] > 0)
        {
            $death_person_count = html_encode($row['related_number1']);
        }
        if ($row['related_number2'] > 0)
        {
            $hurt_person_count = html_encode($row['related_number2']);
        }
        if ($row['related_number3'])
        {
            $missing_person_count = html_encode($row['related_number3']);
        }
	}

/*
 * 时间类型不再要求输入, 而是计算.
<p class="thick">时间类型：
<nobr class="normal"><input type="radio" id="time_type_1" name="time_type" value="1" <?php flash_time_type($is_edit, 1, $time_type); ?> />
距今年（138.2亿年前-15000年前，单位为年） </nobr>

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<nobr class="normal"><input type="radio" id="time_type_2" name="time_type" value="2" <?php flash_time_type($is_edit, 2, $time_type); ?> /> 
公元年（公元前13000年前至今。公元前为负数，公元后为正数。） </nobr>

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<nobr class="normal"><input type="radio" id="time_type_3" name="time_type" value="3" <?php flash_time_type($is_edit, 3, $time_type); ?> />
年-月-日

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input type="radio" id="time_type_4" name="time_type" value="4" <?php flash_time_type($is_edit, 4, $time_type); ?> />
年-月-日 时:分:秒 </nobr></p>
 */
?>

<font size="5" color="red" >编辑事件</font><br>

<p class="thick" id="time_label">时间(必需)：
<input type="text" id="time" name="time" <?php flash_time($time); ?> />
&nbsp;&nbsp;&nbsp; 支持4种格式: 
    距今3.13亿年;&nbsp;&nbsp;公元前212年;&nbsp;&nbsp;1979-4-5;&nbsp;&nbsp;1999-6-4 2:00:00.

<p class="thick">时间上下限(仅限数字)：<input type="text" id="time_limit" name="time_limit" <?php flash_time_limit($time_limit); ?> ></input>
&nbsp;&nbsp;&nbsp;&nbsp;单位：
<nobr class="normal"><input type="radio" name=time_limit_type value="1" <?php flash_time_limit_type(1, $time_limit_type); ?> >年
<input type="radio" name=time_limit_type value="2" <?php flash_time_limit_type(2, $time_limit_type); ?> >日
<input type="radio" name=time_limit_type value="3" <?php flash_time_limit_type(3, $time_limit_type); ?> >秒
</nobr></p>

<p class="thick" id="thing_label">事件(必需，最长400字)：</nobr>
<textarea name='thing' id='thing' class='has_text' >
<?php 
    echo $thing;
?>
</textarea>

<?php
    if(is_adder())
    {
        echo "<input type='button' style='font-size:22pt; color:red' value='重构数据' id='splite_data' 
            onclick=\"window.location='import_input.php?thing_uuid=" . $thing_uuid . "'\" />";
    }
?>
<table class="normal">

<?php
    $my_index = 0;
    
    // 打印 死亡人数、失踪人数、受伤人数 输入框。
    echo "<tr class='tag_normal'><td width='400'>";
    echo "<p class='thick'>死亡人数:<input type='number' autofocus=autofocus id='death_person_count' 
        value='$death_person_count' pattern='[0-9]' />";
    
    echo "<tr class='tag_normal'><td width='400'>";
    echo "<p class='thick'>受伤人数:<input type='number' id='hurt_person_count' 
        value='$hurt_person_count' pattern='[0-9]' />";
    echo "</p></td>";
    
    echo "<tr class='tag_normal'><td width='400'>";
    echo "<p class='thick'>失踪人数:<input type='number' id='missing_person_count' 
        value='$missing_person_count' pattern='[0-9]' />";
    echo "</p></tr>";
    
    echo "<tr class='tag_normal'><td width='400'>";
    echo "<p class='thick'>字   数:<input type='number' id='word_count' 
        value='$word_count' pattern='[0-9]' />";
    echo "</p></tr>";
    
    // 显示 tag 输入框.
    show_tag_input_view(1, $thing_uuid);
 
?>

</table>

<p style="text-align:center"><a href="../bbs/viewtopic.php?id=20" >如何添加和使用标签？</a>

<!--  公开范围（暂时删除）：
<input type="radio" name=public_type value="1" checked="checked" / >公开
<input type="radio" name=public_type value="2" / >小组公开
<input type="radio" name=public_type value="3" / >隐私
-->

<input type="hidden" id="originator" name="originator" value="<?php echo html_encode($_GET['update_once']); ?>">
<input type="hidden" id="thing_length" name="thing_length" value="<?php echo get_thing_length(); ?>">

<p>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<!--  公开范围（暂时删除）：
<input type="reset" style="font-size:25pt" value="恢复到最初状态">
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
-->
<input type="submit" style="font-size:22pt; color:red" id="update_data" value='保存' onclick="ajax_do()" /> <!-- 提交 -->

<?php
    // exit
    mysql_close($conn);
    $conn = null;
?>

</body>
</html>