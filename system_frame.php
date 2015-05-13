<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link rel="shortcut icon" type="image/x-icon" href="./favicon.ico" />

<?php 
    require_once 'init.php';
    is_user(1);
    require_once "sql.php";
    
    if(!is_vip_user())
    {
        echo "本页面只能管理员才能访问! 抱歉. ";
        exit;
    }
?>

<link rel="stylesheet" type="text/css" href="./style/data.css" />
<script type='text/javascript' src='./js/data.js'></script>
<script type='text/javascript' src='./js/ajax.js'></script>

<title>系统设置</title>
</head>
<body>
    
<!-- 页眉 begin -->
<iframe name="content" src="./main_header.php" height="65px" width="100%" scrolling="auto" frameborder="0"></iframe>
<!-- 页眉 end -->

<!-- tab页 begin
<div class="easyui-tabs" style="" >
<div title="管理员界面"   style="padding:10px;"  selected='true' href='system_manager.php' ></div>
<div title="用户积分"   style="padding:10px;" href='system_score.php' ></div>
<div title="全球排名"   style="padding:10px;" href='system_rank.php' ></div>
</div>
 -->
 
 
<script>
// 显示调用结果。
function manager_show_status(this_form, is_ok)
{
    document.getElementById(this_form).style.color = "red";
    if (is_ok == 1)
    {
        document.getElementById(this_form).innerHTML = "更新成功!";
    }
    else
    {
        document.getElementById(this_form).innerHTML = "更新失败!";
    }
    document.getElementById(this_form).style.display = "inline";
}

// 设置按钮的状态.
function make_button_status(operate_type, disabled)
{
    document.getElementById(operate_type).disabled = disabled;
}

// 调用成功后的回调函数。
function succ_callback(operate_type, data)
{
    make_button_status(operate_type, true);
    
    if (data == "ok")
    {
        res_status = 1;
    }
    else
    {
        res_status = 0;
    }
    
    if (operate_type == "re_calc_year_order")
    {
        manager_show_status("re_calc_year_order_label", res_status);
    }
    else if (operate_type == "re_calc_tag_hot_index")
    {
        manager_show_status("re_calc_tag_hot_index_label", res_status);
    }
    else if (operate_type == "re_thing_add_vip_tag")
    {
        manager_show_status("re_thing_add_vip_tag_label", res_status);
    }
}

// 发起Ajax通讯。
function ajax_do(operate_type)
{
    // 将控件灰掉，防止用户多次点击。
    make_button_status(operate_type, true);
            
    var system_manager_ajax = xhr({
        url:'./ajax/general_ajax.php',
        data:{
            'operate_type':operate_type
        },
        async:false,
        method:'GET',
        complete: function () {
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

<div class="system_user">
    <input type="submit" style="font-size:18pt" value="计算时间轴指数" 
        id="re_calc_year_order" onclick="ajax_do('re_calc_year_order')" /></p>  <!-- 提交 -->
    <div class="label" id="re_calc_year_order_label"></div>
</div>

<div class="system_user">
    <input type="submit" style="font-size:18pt" value="计算tag热门指数" 
        id="re_calc_tag_hot_index" onclick="ajax_do('re_calc_tag_hot_index')" /></p> <!-- 提交 -->
    <div class="label" id="re_calc_tag_hot_index_label"></div>
</div>

<div class="system_user">
    <input type="submit" style="font-size:18pt" value="自动将事件添加vip标签" 
        id="re_thing_add_vip_tag" onclick="ajax_do('re_thing_add_vip_tag')" /></p> <!-- 提交 -->
    <div class="label" id="re_thing_add_vip_tag_label"></div>
</div>



 
<!-- tab页 end -->

</body>
</html>
