<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

<?php 
    require_once 'init.php';
    is_user(1);
    require_once "data.php";
    require_once "sql.php";
    
    define('PUN_ROOT', dirname(__FILE__).'/bbs/');
    require_once "common.php";
?>

<link rel="stylesheet" type="text/css" href="./style/data.css" />
<title></title>
</head>
<body>

<!-- 页眉 begin -->
<div>
<div id="fixed_menu1" class="fixed">

<div id="goal" style="float:left;">
    为什么需要历史？
    &nbsp;&nbsp;&nbsp; 历史，让人们学会理性；<br />
    &nbsp;&nbsp;&nbsp; 历史，让时光有了厚度；<br />
    &nbsp;&nbsp;&nbsp; <span id="dt" style="color:blue"><a href="./story3.php"  target="_top">
         历史，让社会远离蝴蝶的翅膀。</a></span>
</div>
    
<div id="welcome" style="float:center;">
<?php
    echo get_user_name() . "，欢迎您！ --- " . get_system_name() . ". " . get_system_version();
    echo "&nbsp;&nbsp;&nbsp";
?>
</div>

<div>
    <a href="./item_frame.php" class="red_black_underline" target="_top">回到首页</a> |
    <a href="./update_input.php?update_once=<?php echo get_update_token(); ?>" class="red_black_underline"  target="_top">新增事件</a> |
    <a href="./import_input.php?import_once=<?php echo get_import_token(); ?>" class="red_black_underline"  target="_top">
        批量导入事件</a> |
<!--
// 小组功能的需求暂时不确定, 所以暂时不提供.
    <a href="./group.php" class="red_black_underline"  target="_top">小组管理</a> |
-->
<?php
    if(is_manager())
    {
?>
    <a href="./system_frame.php" class="red_black_underline"  target="_top">系统设置</a> |
<?php
    }
?>
    <a href="./bbs/index.php" class="red_black_underline"  target="_top">进入论坛</a> |
    <a href="./login.php?action=out&id=<?=$pun_user['id']?>&csrf_token=<?=pun_hash($pun_user['id'].pun_hash(get_remote_address()))?>"  class="red_black_underline"  target="_top">退出</a>
</div>
</div>

<div style="height: 34px"></div>
</div>
<!-- 页眉 end -->

</body>
</html>