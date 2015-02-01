<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

<?php 
    require_once 'init.php';
    is_user(1);
?>

<link rel="stylesheet" type="text/css" href="./css/easyui.css">
<link rel="stylesheet" type="text/css" href="./css/demo.css">

<link rel="stylesheet" type="text/css" href="./css/data.css" />

<script type="text/javascript" src="./js/jquery.min.js"></script>
<script type="text/javascript" src="./js/jquery.easyui.min.js"></script>

<title>系统设置</title>
</head>
<body>
    
<!-- 页眉 begin -->
<iframe name="content" src="./header.php" height="65px" width="100%" scrolling="auto" frameborder="0"></iframe>
<!-- 页眉 end -->

<!-- tab页 begin -->
<div class="easyui-tabs" style="" >

<div title="用户中心"     style="padding:10px;" href='system_user.php' ></div>

<div title="用户配置"   style="padding:10px;" href='system_config.php' ></div>

<div title="用户积分"   style="padding:10px;" href='system_score.php' ></div>

<div title="全球排名"   style="padding:10px;" href='system_rank.php' ></div>

<div title="管理员界面"   style="padding:10px;" href='system_manager.php' ></div>

</div>
<!-- tab页 end -->

</body>
</html>
