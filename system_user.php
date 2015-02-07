<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

<?php
    require_once 'init.php';
    is_user(1);
    require_once "data.php";
    require_once "sql.php";
?>

<link rel="stylesheet" type="text/css" href="./css/data.css" />

<title></title>
</head>
<body>

<?php
    // 打开数据库
    $conn = open_db();
    
    $user_id = get_user_id();
    $row = get_user_info($user_id);
    $add_thing_count = get_thing_count_by_user($user_id);
    $add_tag_count = get_tag_count_by_user($user_id);
    $add_thing_tag_count = get_thing_tag_count_by_user($user_id);
    
    // exit
    mysql_close($conn);
    $conn = null;
?>

<div class="system_user">
<p class="thick">用户信息</p>
<p class="thick">用 户 名：<nobr class="normal"><?=$row['username']?></nobr></p>
<p class="thick">注册日期：<nobr class="normal"><?=date("Y-m-d H:i:s",$row['registered'])?></nobr></p>
<p class="thick">添加事件：<nobr class="normal"><?=$add_thing_count?></nobr></p>
<p class="thick">添加标签：<nobr class="normal"><?=$add_tag_count?></nobr></p>
<p class="thick">添加事件-标签对：<nobr class="normal"><?=$add_thing_tag_count?></nobr></p>
</div>

<div class="system_user">
<form action="system_user.php" method="get" onsubmit="">
<p class="thick" id="self_introduction_label">自我介绍(不多于80个字)：</nobr>
<textarea name='self_introduction' id='self_introduction' class='self_introduction' autofocus=autofocus >
    <?=$row['signature']?>
</textarea>

<p class="thick" id="email_label">电子邮箱：
<input type="text" id="email" name="email" style='color:blue; font-weight:bold' value=<?=$row['email']?>>
</nobr>

<p class="thick" id="weixin_label">微    信：
<input type="text" id="weixin" name="weixin" style='color:blue; font-weight:bold' value=<?=$row['weixin'] ?>>
</nobr>

<p class="thick" id="weibo_label">新浪微博：
<input type="text" id="weibo" name="weibo" style='color:blue; font-weight:bold' value=<?=$row['weibo'] ?>>
</nobr>

<p class="thick" id="qq_label">QQ：
<input type="text" id="qq" name="qq" style='color:blue; font-weight:bold' value=<?=$row['qq'] ?>>
</nobr><br />

<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input type="submit" style="font-size:25pt" /></p> <!-- 提交 -->
</form>
</div>


</body>
</html>