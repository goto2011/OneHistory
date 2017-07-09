<?php 
    require_once 'init.php';
    is_user(3);
    require_once "waf.php";
    require_once "data.php";
    require_once "sql.php";
    
    define('PUN_ROOT', dirname(__FILE__).'/bbs/');
    require_once "common.php";

    $conn = open_db();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<script type="text/javascript">var cnzz_protocol = (("https:" == document.location.protocol) ? " https://" : " http://");document.write(unescape("%3Cspan id='cnzz_stat_icon_1255791580'%3E%3C/span%3E%3Cscript src='" + cnzz_protocol + "s95.cnzz.com/z_stat.php%3Fid%3D1255791580' type='text/javascript'%3E%3C/script%3E"));</script>
<link rel="stylesheet" type="text/css" href="./style/data.css" />
<title></title>
</head>
<body>

<!-- 页眉 begin -->
<div>
<div id="fixed_menu1" class="fixed">

<div id="goal" style="float:left;">
    为什么我们需要历史？
    &nbsp;&nbsp;&nbsp; 历史，让人们学会理性；
    &nbsp;&nbsp;&nbsp; 历史，让时光有了厚度；<br />
    &nbsp;&nbsp;&nbsp; <span id="dt" style="color:blue"><a href="./story3.php"  target="_top">
         历史，让社会远离蝴蝶的翅膀。</a></span>
</div>
    
<div id="welcome" style="float:center;">
<?php
    if (is_guest())
    {
        echo get_user_name() . "，欢迎您！ --- " . get_system_name();
    }
    else
    {
        $grace_array = get_current_user_grade();
        echo get_user_name() . "，" . $grace_array[0] . " / " . $grace_array[1]
        . " / " . $grace_array[2] .  " --- " . get_system_name();
    }
    echo "&nbsp;&nbsp;&nbsp";
    
    mysql_close($conn);
    $conn = null;
?>
</div>

<div>
    <!-- 1. 回到首页 -->
    <a href="./item_frame.php?property_UUID=main_all" class="red_black_underline" target="_top">回到首页</a> |
<!--
// 新增单个事件和批量导入事件合一。
    <a href="./update_input.php?update_once=<?php echo get_update_token(); ?>" class="red_black_underline"  target="_top">新增事件</a> |
-->
    <!-- 2. 导入事件 -->
    <a href="./import_input.php" class="red_black_underline"  target="_top">
       导入事件</a> |
<!--
// 小组功能的需求暂时不确定, 所以暂时不提供.
    <a href="./group.php" class="red_black_underline"  target="_top">小组管理</a> |
-->
    <!-- 3. 前往论坛 -->
    <a href="./bbs/index.php" class="red_black_underline"  target="_top">前往论坛</a> |
    
    <!-- 4. 系统设置 -->
<?php
    if(is_vip_user())
    {
?>
    <a href="./system_frame.php" class="red_black_underline"  target="_top">系统设置</a> |
<?php
    }
?>

    <!-- 5. 登陆/退出 -->
<?php
    if(user_is_login() == 1)
    {
?>
    <a href="./login.php?action=out&id=<?=$pun_user['id']?>&csrf_token=<?=pun_hash($pun_user['id'].pun_hash(get_remote_address()))?>"  class="red_black_underline"  target="_top">退出</a>
<?php
    } else {
?>
    <a href="./register.php"  class="red_black_underline"  target="_top">注册账号</a>
    <a href="./login.php"  class="red_black_underline"  target="_top">登陆</a>
<?php        
    }
?>    
</div>
</div>

<div style="height: 34px"></div>
</div>
<!-- 页眉 end -->

</body>
</html>