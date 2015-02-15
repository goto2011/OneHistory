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
	if(strlen($_GET['thing_uuid']) > 0)
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

<!-- To test using the original jQuery.autocomplete, uncomment the following -->
<!--
<script type="text/javascript" src="http://xoxco.com/projects/code/tagsinput/jquery.tagsinput.js"></script>
<script type='text/javascript' src='http://xoxco.com/x/tagsinput/jquery-autocomplete/jquery.autocomplete.min.js'></script>
<link rel="stylesheet" type="text/css" href="http://xoxco.com/x/tagsinput/jquery-autocomplete/jquery.autocomplete.css" />
-->

<title>新增事件</title>
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
			
			// echo "$time - " . $row['time'] . "-" . $row['time_type'] . "<br />";
		}
	}
	
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
				echo get_string_from_array($property_name_array);
			}
		}
	}
?>

<form action="./ajax/update_do.php" method="get" onsubmit="return validate_form(this)">

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

<p class="thick" id="time_label">时间(必需)：
<input type="text" id="time" name="time" autofocus=autofocus <?php flash_time($is_edit, $time); ?> />
<nobr class="alert" id="time_alert">&nbsp;&nbsp;&nbsp;<-- 请输入时间！
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

<tr>
<td width='400'><p class="thick">事件开始标签：<input id='start_tags' 		name='start_tags' 	type='text' 	class='tags'  
	value="<?php flash_tags($is_edit, 1, $thing_uuid); ?>"></p></td>

<td width='400'><p class="thick">事件结束标签：<input id='end_tags' 		name='end_tags' 	type='text' 	class='tags' 
	value="<?php flash_tags($is_edit, 2, $thing_uuid); ?>"></p></td>
</tr>

<tr>
<td><p class="thick">文化/国家/民族/地区标签：<input id='country_tags' 		name='country_tags' 	type='text' 	class='tags' 
	value="<?php flash_tags($is_edit, 7, $thing_uuid); ?>"></p></td>

<td><p class="thick">地理标签：<input id='geography_tags' 	name='geography_tags' type='text' 	class='tags' 
	value="<?php flash_tags($is_edit, 5, $thing_uuid); ?>"></p></td>
</tr>

<tr>
<td><p class="thick">人物标签：<input id='person_tags' 		name='person_tags' 	type='text' 	class='tags' 
	value="<?php flash_tags($is_edit, 4, $thing_uuid); ?>"></p></td>
	
<td><p class="thick">出处标签：<input id='source_tags' 		name='source_tags' 	type='text' 	class='tags' 
	value="<?php flash_tags($is_edit, 3, $thing_uuid); ?>"></p></td>
</tr>

<tr>
<td colspan="2"><p class="thick">自由标签：<input id='free_tags' 		name='free_tags' 	type='text' 	class='tags' 
	value="<?php flash_tags($is_edit, 6, $thing_uuid); ?>"></p></td>
</tr>
</table>

<!--  公开范围（暂时删除）：
<input type="radio" name=public_type value="1" checked="checked" / >公开
<input type="radio" name=public_type value="2" / >小组公开
<input type="radio" name=public_type value="3" / >隐私
-->

<input type="hidden" name="originator" value="<?php echo html_encode($_GET['update_once']); ?>">
<input type="hidden" name="thing_length" value="<?php echo get_thing_length(); ?>">

<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input type="reset" style="font-size:25pt" value="恢复到最初状态">  <!-- 提交 -->
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input type="submit" style="font-size:25pt" /></p> <!-- 提交 -->

<?php
    // exit
    mysql_close($conn);
    $conn = null;
?>

</form>

</body>
</html>