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

	// 判断是新增，还是编辑
	$thing_uuid = "";
	if(!empty($_GET['thing_uuid']))
	{
		$thing_uuid = html_encode($_GET['thing_uuid']);   /// thing uuid.
        $_SESSION['update_input_thing_uuid'] = $thing_uuid;
		$_SESSION['update_input_is_edit'] = 1;                /// is edit.
	}
	else
	{
		$_SESSION['update_input_thing_uuid'] = "";
		$_SESSION['update_input_is_edit'] = 0;				 /// is create.
	}
	
	$_SESSION['update_input_data_changed'] = 0;				 /// data changed.
	
	// echo $_SESSION['update_once'];
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
    // 数据检查。
    if (tags_check() > 0)
    {
        alert("标签名称不能带有标点符号。");
        return;
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
            
            'start_tags'    :document.getElementById("start_tags").value,
            'end_tags'      :document.getElementById("end_tags").value,
            'country_tags'  :document.getElementById("country_tags").value,
            'geography_tags':document.getElementById("geography_tags").value,
            'person_tags'   :document.getElementById("person_tags").value,
            'free_tags'     :document.getElementById("free_tags").value,
            'dynasty_tags'  :document.getElementById("dynasty_tags").value,
            'topic_tags'    :document.getElementById("topic_tags").value,
            'office_tags'   :document.getElementById("office_tags").value,
            'key_tags'      :document.getElementById("key_tags").value,
            'source_tags'   :document.getElementById("source_tags").value,
            'note_tags'     :document.getElementById("note_tags").value,
            'land_tags'     :document.getElementById("land_tags").value
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
	
	$is_edit = 0;
    $time = 0;
	$time_type = 0;
    $time_limit = 0;
	$time_limit_type = 0;
	
	// 显示节点原始数据.
	if($_SESSION['update_input_is_edit'] == 1)
	{
		$is_edit = 1;
        
        // 更新 item_index.
        if (!empty($_GET['item_index']) && is_numeric($_GET['item_index']))
        {
            set_item_index(html_encode($_GET['item_index']));
        }
        
		$result = get_thing_db($thing_uuid);
		
		while($row = mysql_fetch_array($result))
		{
			$thing = html_encode($row['thing']);
			$time_type = html_encode($row['time_type']);
			$time = get_time_string_lite(html_encode($row['time']), $time_type);
			$time_limit = html_encode($row['time_limit']);
            if ($time_limit == 0)$time_limit = null;
			$time_limit_type = html_encode($row['time_limit_type']);
		}
	}

/*
	// 刷新界面之"时间类型"
	function flash_time_type($is_edit, $my_type, $time_type)
	{
		if((($is_edit == 0) || (($is_edit == 1) && ($time_type == null))) && ($my_type == 2))
		{
			echo " checked='checked' ";
		}
		if(($is_edit == 1) && ($time_type != null) && ($my_type == $time_type))
		{
			echo " checked='checked' style='color:blue' ";
		}
	}
*/

	// 刷新界面之"时间"
	function flash_time($is_edit, $time)
	{
		if($is_edit == 1)
		{
			echo " style='color:blue; font-weight:bold' value=$time ";
		}
	}
	
	// 刷新界面之"时间上下限"
	function flash_time_limit($is_edit, $time_limit)
	{
		if($is_edit == 1)
		{
			echo " style='color:blue; font-weight:bold' value=$time_limit ";
		}
	}
	
	// 刷新界面之"时间上下限类型"
	function flash_time_limit_type($is_edit, $my_time_limit_type, $time_limit_type)
	{
		if((($is_edit == 0) || (($is_edit == 1) && ($time_limit_type == null))) && ($my_time_limit_type == 1))
		{
			echo " checked='checked' ";
		}
		if(($is_edit == 1) && ($time_limit_type != null) && ($my_time_limit_type == $time_limit_type))
		{
			echo " checked='checked' style='color:blue' ";
		}
	}
	
	// 刷新界面之"标签"
	function flash_tags($is_edit, $tag_type, $thing_uuid)
	{
		if($is_edit == 1)
		{
			$property_name_array = get_tags_name($thing_uuid, $tag_type);
			// var_dump($property_name_array);
			
			if(!empty($property_name_array))
			{
				return get_string_from_array($property_name_array);
			}
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

<p class="thick" id="time_label">时间(必需)：
<input type="text" id="time" name="time" autofocus=autofocus <?php flash_time($is_edit, $time); ?> />
<nobr class="alert" id="time_alert">&nbsp;&nbsp;&nbsp;<-- 请输入时间！支持4种格式: 距今3.13亿年; 公元前212年; 1979-4-5; 1999-6-4 2:00:00.
</nobr>

<p class="thick">时间上下限(仅限数字)：<input type="text" id="time_limit" name="time_limit" <?php flash_time_limit($is_edit, $time_limit); ?> ></input>
&nbsp;&nbsp;&nbsp;&nbsp;单位：
<nobr class="normal"><input type="radio" name=time_limit_type value="1" <?php flash_time_limit_type($is_edit, 1, $time_limit_type); ?> >年
<input type="radio" name=time_limit_type value="2" <?php flash_time_limit_type($is_edit, 2, $time_limit_type); ?> >日
<input type="radio" name=time_limit_type value="3" <?php flash_time_limit_type($is_edit, 3, $time_limit_type); ?> >秒
</nobr></p>

<p class="thick" id="thing_label">事件(必需，最长400字)：</nobr>
<textarea name='thing' id='thing' 
<?php 
	if($is_edit == 1)
	{
		// echo "$thing <br/>";
		echo " class='has_text' >$thing";
	}
	else
	{
		echo " class='no_text' >";
	}
?>
</textarea>
<nobr class="alert" id="thing_alert">&nbsp;&nbsp;&nbsp;<-- 请输入事件!
</nobr>

<table class="normal">

<?php
    $my_index = 0;
    
    // 显示 tag 输入框.
    for ($ii = tag_list_min(); $ii <= tag_list_max(); $ii++)
    {
        if (is_show_input_tag($ii) == 1)
        {
            $tag_id = get_tag_id_from_index($ii);
            $tag_name = get_tag_list_name_from_index($ii);
            $tag_input_id = get_tag_input_id_from_index($ii);
            
            $my_print = "<p class='thick'> $tag_name:<input id='$tag_input_id' 
                    name='$tag_input_id' type='text' class='tags' value='" 
                    . flash_tags($is_edit, $tag_id, $thing_uuid) . "'></p></td>";
            
            // "出处标签"需要顶格显示.
            if (is_source(get_tag_id_from_index($ii)))
            {
                $my_index++;
            }
            
            if($my_index % 2 == 0)
            {
                echo "<tr class='tag_normal'><td width='400'>";
                echo $my_print;
                $my_index++;
            }
            else 
            {
                echo "<td width='400'>";
                echo $my_print;
                echo "</tr>";
                $my_index++;
            }
        }
    } 
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

<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input type="reset" style="font-size:25pt" value="恢复到最初状态">  <!-- 提交 -->
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input type="submit" style="font-size:22pt; color:red" id="update_data" onclick="ajax_do()" /> <!-- 提交 -->

<?php
    // exit
    mysql_close($conn);
    $conn = null;
?>

</body>
</html>