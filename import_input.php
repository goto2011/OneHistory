<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

<?php 
	require_once 'init.php';
    is_user(1);
?>

<style type="text/css">
	p.context {font-weight: normal}
	p.remark {color:blue;font-style:italic}
</style>

<title>批量数据导入</title>
</head>
<body>

<!-- 页眉 begin -->
<iframe src="./header.php" height="65px" width="100%" scrolling="no" frameborder="0"></iframe>
<!-- 页眉 end -->

<font size="5" color="red">批量数据录入</font><br>
<form action="./ajax/import_do.php" method="post">

<p>导入内容：<textarea class="context" rows="16" cols="88" name="context" 
	required=required autofocus="autofocus"></textarea></p>
<p>数据格式：“时间，事件”。<p class="remark">例如：2年，汉平帝元始二年，是岁，全国垦田八百二十七万零五百三十顷。</p>


<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

<input type="hidden" name="originator" value="<?php echo $_GET['import_once'] ?>">

<input type="submit" style="font-size:30pt" /></p>
</form>


</body>
</html>