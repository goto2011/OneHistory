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
<script type='text/javascript' src='./js/progress_view.js'></script>

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
// 设置按钮的状态.
function make_button_status(operate_type, disabled)
{
    // = true 表示去激活；= false 表示激活。
    document.getElementById(operate_type).disabled = disabled;
    
    if (operate_type == "re_thing_add_vip_tag") {
        var radios = document.getElementsByName("tag_type_radio");
        for (ii = 0; ii < radios.length; ii++) {
            radios[ii].disabled = disabled;
        }
    }
}

/**
 * 设置状态条的状态。
 */
function change_status_lable(this_form, is_ok, is_display)
{
	this_form = this_form + "_label";
    if (is_display == 1)
    {
        document.getElementById(this_form).style.color = "red";
        if (is_ok == 1)
        {
            document.getElementById(this_form).innerHTML = "处理成功";
        }
        else
        {
            document.getElementById(this_form).innerHTML = "处理失败";
        }
        document.getElementById(this_form).style.display = "inline";
    }
    else
    {
        document.getElementById(this_form).style.display = "none";
    }
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

//////////////  刷新vip tag   begin  ///////////////////////////
// 当前步骤计数。
var vip_tag_step = 0;
var progress = Progress_view.createNew();

// 刷新vip tag调用成功后的回调函数。
// step1: 获取vip tag的数量。
// step2: 一个个的刷新。
// step3: 完成。
// 其中一个环节出错就终止。
function thing_add_vip_tag_cb(operate_type, data)
{
    // alert(data);
    // 返回数量
    if (data.indexOf("step1") != -1)
    {
        progress.init(500, data.slice(6), "re_thing_add_vip_tag_label", 
            "progress_border", "progress", "percent");
        progress.update("处理开始", vip_tag_step);
        thing_add_vip_tag(++vip_tag_step);
    }
    // 返回当前处理的vip tag name
    else if (data.indexOf("step2") != -1)
    {
        var tag_name = data.slice(6);
        progress.update("\"".concat(tag_name, "\" 标签处理完毕"), vip_tag_step);
        thing_add_vip_tag(++vip_tag_step);
    }
    // 返回最终结果: ok
    else if (data.indexOf("step3") != -1)
    {
        vip_tag_step = progress.getTotal();
        progress.update("处理成功", vip_tag_step);
        make_button_status(operate_type, false);
    }
    else if (data == "fail")
    {
        progress.update("处理失败", vip_tag_step);
        make_button_status(operate_type, false);
    }
}

// 发起刷新vip tag的Ajax通讯。
function thing_add_vip_tag(step)
{
    // alert("step=" + step);
    var operate_type = "re_thing_add_vip_tag";
    // 将控件灰掉，防止用户多次点击。
    if (step == 0){
        vip_tag_step = 0;
        make_button_status(operate_type, true);
        change_status_lable(operate_type, "", 0);
    }
    
    // 批量更新 事件-VIP标签
    var vip_tag_checked = get_checkbox_value("tag_type_radio");

    var system_manager_ajax = xhr({
        url:'./ajax/general_ajax.php',
        data:{
            'operate_type'      :operate_type,
            'vip_tag_checked'   :vip_tag_checked,
            'step'              :step
        },
        async:false,
        method:'GET',
        complete: function () {
        },
        success: function (data) {
            thing_add_vip_tag_cb(operate_type, data);
        },
        error: function () {
            thing_add_vip_tag_cb(operate_type, "fail");
        }
    });
    // system_manager_ajax.send();
}
//////////////  刷新vip tag   end  ///////////////////////////


// 发起Ajax通讯-通用。
function ajax_do(operate_type)
{
    // 将控件灰掉，防止用户多次点击。
    make_button_status(operate_type, true);
    change_status_lable(operate_type, "", 0);
    var vip_tag_checked = "";
    vip_tag_checked = get_checkbox_value("tag_modify_type_radio");

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


<div class="system_user" style="height:150">
    <input type="submit" style="font-size:18pt" value="批量更新事件-VIP标签" 
        id="re_thing_add_vip_tag" onclick="thing_add_vip_tag(0)" /></p> <!-- 提交 -->   
<?php
    for ($ii = tag_list_min(); $ii <= tag_list_max(); $ii++)
    {
        if ((is_vip_tag_tab($ii) == 1) && (is_show_input_tag($ii) == 1))
        {
            // 此处保存下标为好.
            // $tag_id = get_tag_id_from_index($ii);
            $tag_name = get_tag_list_name_from_index($ii);
            echo "&nbsp;&nbsp;<input type='radio' name='tag_type_radio' value='$ii' >$tag_name";
        }
    }
?>
    </br></br>
    <div id="progress_border">
    <div id="progress">
    <div id="percent">0%</div>
    </div>
    </div>
    <div class="label" id="re_thing_add_vip_tag_label"></div>
    </div>
</div>


<div class="system_user" style="width:700px;height:400px">
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
            
            echo "&nbsp;&nbsp;<input type='radio' name='tag_modify_type_radio' value='$ii' 
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
