<?php 
    require_once 'init.php';
    is_user(1);
    require_once "sql.php";
    
    if(!is_vip_user())
    {
        echo "本页面只能管理员才能访问!";
        exit;
    }
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link rel="shortcut icon" type="image/x-icon" href="./favicon.ico" />

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
function manager_show_status(this_form, is_ok, is_display)
{
    if (is_display == 1)
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
    else
    {
        document.getElementById(this_form).style.display = "none";
    }
}

// 设置按钮的状态.
function make_button_status(operate_type, disabled)
{
    // = true 表示去激活；= false 表示激活。
    document.getElementById(operate_type).disabled = disabled;
}

/**
 * 设置状态条的状态。
 */
function change_status_lable(operate_type, res_status, is_display)
{
	manager_show_status(operate_type + "_label", res_status, is_display);
}

// 调用成功后的回调函数。
function succ_callback(operate_type, data)
{
    make_button_status(operate_type, false);
    
    if (data == "ok")
    {
        res_status = 1;
    }
    else
    {
        res_status = 0;
    }
    change_status_lable(operate_type, res_status, 1);
}

// 修改标签属性 step2: 选中标签后的处理
function tag_selected(evt)
{
    var evt = evt || window.event;
    var e = evt.srcElement || evt.target;
    var obj = document.getElementById("tag_list_select");
    
    var system_manager_ajax = xhr({
        url:'./ajax/general_ajax.php',
        data:{
            'operate_type'      :"tag_selected",
            'selected_tag_id'   :obj.options[obj.selectedIndex].value
        },
        async:false,
        method:'GET',
        complete: function () {
        },
        success: function (data) {
            alert(data);
        },
        error: function () {
            succ_callback(operate_type, "fail");
        }
    });
}

// 修改标签属性 step1: 选择标签类型
function tag_property_modify(evt)
{
    var evt=evt || window.event;
    var e =evt.srcElement || evt.target;
    
    var system_manager_ajax = xhr({
        url:'./ajax/general_ajax.php',
        data:{
            'operate_type'      :"tag_property_modify",
            'vip_tag_checked'   :get_checkbox_value("tag_modify_type")
        },
        async:false,
        method:'GET',
        complete: function () {
        },
        success: function (data) {
            // 解析 json数据。
            tag_obj = JSON.parse(data);
            // alert(tag_obj[0][1]);
            
            var obj = document.getElementById('tag_list_select');
            obj.options.length = 0;
            obj.style.visibility = 'visible';
            for (var ii = 0; ii < tag_obj.length; ii++)
            {
                // 将数据更新到界面。
                obj.options.add(new Option(tag_obj[ii][1], tag_obj[ii][0]));
            }
        },
        error: function () {
            succ_callback(operate_type, "fail");
        }
    });
}

// 发起Ajax通讯。
function ajax_do(operate_type)
{
    // 将控件灰掉，防止用户多次点击。
    make_button_status(operate_type, true);
    change_status_lable(operate_type, "", 0);
    var vip_tag_checked = "";
    
    // 批量更新 事件-VIP标签
    if (operate_type == "re_thing_add_vip_tag")
    {
        vip_tag_checked = get_checkbox_value("tag_type");
    }
    else
    {
        vip_tag_checked = get_checkbox_value("tag_modify_type");
    }

    var system_manager_ajax = xhr({
        url:'./ajax/general_ajax.php',
        data:{
            'operate_type'      :operate_type,
            'vip_tag_checked'   :vip_tag_checked
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
    <input type="submit" style="font-size:18pt" value="计算事件-时间轴指数" 
        id="re_calc_year_order" onclick="ajax_do('re_calc_year_order')" />  <!-- 提交 -->
    <div class="label" id="re_calc_year_order_label"></div>
    
    <input type="submit" style="font-size:18pt" value="计算标签-热门指数" 
        id="re_calc_tag_hot_index" onclick="ajax_do('re_calc_tag_hot_index')" /> <!-- 提交 -->
    <div class="label" id="re_calc_tag_hot_index_label"></div>
    
    <input type="submit" style="font-size:18pt" value="计算事件-标签类型映射" 
        id="re_add_thing_tag_map" onclick="ajax_do('re_add_thing_tag_map')" /> <!-- 提交 -->
    <div class="label" id="re_add_thing_tag_map_label"></div>
</div>

<div class="system_user">
    <input type="submit" style="font-size:18pt" value="批量更新事件-VIP标签" 
        id="re_thing_add_vip_tag" onclick="ajax_do('re_thing_add_vip_tag')" /></p> <!-- 提交 -->   
<?php
    for ($ii = tag_list_min(); $ii <= tag_list_max(); $ii++)
    {
        if ((is_vip_tag_tab($ii) == 1) && (is_show_input_tag($ii) == 1))
        {
            // 此处保存下标为好.
            // $tag_id = get_tag_id_from_index($ii);
            $tag_name = get_tag_list_name_from_index($ii);
            echo "&nbsp;&nbsp;<input type='radio' name=tag_type value='$ii' >$tag_name";
        }
    }
?>
    </br></br><div class="label" id="re_thing_add_vip_tag_label"></div>
</div>


<div class="system_user" style="width:700px">
    <input type="submit" style="font-size:18pt" value="修改VIP标签的属性" 
        id="tag_property_modify" /></p> <!-- 非提交 -->
<?php
    // 列出 key.
    for ($ii = tag_list_min(); $ii <= tag_list_max(); $ii++)
    {
        if ((is_vip_tag_tab($ii) == 1) && (is_show_input_tag($ii) == 1))
        {
            // 此处保存下标为好.
            // $tag_id = get_tag_id_from_index($ii);
            $tag_name = get_tag_list_name_from_index($ii);
            
            echo "&nbsp;&nbsp;<input type='radio' name=tag_modify_type value='$ii' 
                onclick='tag_property_modify()'>$tag_name";
        }
    }
?>
    <!-- tag列表 -->
    </br>&nbsp;&nbsp;<select id='tag_list_select' style="visibility:hidden" 
        onchange='tag_selected()'>
    </br>
    </br>
<?php
    $tag_name = "123";
    $tag_count = 0;
    $begin_time = "";
    $big_day = "";
    $end_time = "";
    
    // <!-- 标签名称 -->
    echo "<p class='thick'>标签名称:<input id='tag_name' value='$tag_name' />";
    // <!-- 数量（不可编辑） -->
    echo "<p class='thick'>事件数量:<input id='tag_count' value='$tag_count' />";
    // <!-- 开始时间 -->
    echo "<p class='thick'>开始时间:<input id='begin_time' value='$begin_time' />";
    // <!-- BigDay时间 -->
    echo "<p class='thick'>BigDay:<input id='big_day' value='$big_day' />";
    // <!-- 结束时间 -->
    echo "<p class='thick'>结束时间:<input id='end_time' value='$end_time' />";
        
    echo "</br></br><div class='label' id='tag_property_modify_label'></div>";
?>
</div>
 
</div>

 
<!-- tab页 end -->

</body>
</html>
