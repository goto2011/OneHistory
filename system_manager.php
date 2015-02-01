<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title></title>
</head>
<body>

<?php 
    require_once 'init.php';
    // is_user(1);
    require_once "sql.php";
    
    if(!is_manager())
    {
        echo "本页面只能管理员才能访问! 抱歉. ";
        exit;
    }
?>

<link rel="stylesheet" type="text/css" href="./css/data.css" />

<script>
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
function make_button_status(operate_type, is_ok)
{
    if (is_ok == 0)
    {
        document.getElementById(operate_type).disabled = true;
    }
    else
    {
        document.getElementById(operate_type).disabled = false;
    }
}

function ajax_do(operate_type)
{
    var xmlhttp;
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
    make_button_status(operate_type, 0);
    
    xmlhttp.onreadystatechange=function()
    {
        if (xmlhttp.readyState==4 && xmlhttp.status==200)
        {
            make_button_status(operate_type, 1);
            
            if (xmlhttp.response == "ok")
            {
                manager_show_status("re_calc_year_order_label", 1);
            }
            else
            {
                manager_show_status("re_calc_year_order_label", 0);
            }
        }
    }
    xmlhttp.open("GET", "./ajax/system_manager_do.php?operate_type=" + operate_type, true);
    xmlhttp.send(null);
}
    
</script>

<div class="system_user">
    <input type="submit" style="font-size:18pt" value="计算时间轴指数" 
    id="re_calc_year_order" onclick="ajax_do('re_calc_year_order')" /></p> <!-- 提交 -->
    <div class="label" id="re_calc_year_order_label"></div>
</div>

<div class="system_user">
    <input type="submit" style="font-size:18pt" value="计算tag热门指数" /></p> <!-- 提交 -->
</div>

<div class="system_user">
    <input type="submit" style="font-size:18pt" value="计算用户积分" /></p> <!-- 提交 -->
</div>

</body>
</html>