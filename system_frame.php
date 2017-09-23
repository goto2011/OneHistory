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

<script type="text/javascript" src="./js/jquery.min.js"></script>
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

//////////////////////  设置 tag属性   begin  ///////////////////////////

// 检查时间字段的格式。
// 时间仅支持年份（公元前为负数）和年月日。
function check_input_time(view_id)
{
    var value = document.getElementById(view_id).value;
    if ((value == null) || (value == "")) {
        return true;
    }
    return (check_number(value) || check_date(value));
}

// 修改标签属性 step4: 保存标签属性
function tag_property_save()
{
    // alert("tag_property_save");
    var operate_type = "tag_property_save";
    // 1. 判断输入的时间是否合法
    if (!(check_input_time("begin_time") && check_input_time("big_day")
        && check_input_time("end_time")))
    {
        alert("时间格式不对");
        document.getElementById("begin_time").focus();
        return;
    }
    
    // 2. 传输
    var tag_obj = document.getElementById("tag_list_select");
    var tag_tree_obj = document.getElementById("tag_tree_type");
    var parent_obj = document.getElementById("parent_tag");
    var parent_tag = "";
    if (parent_obj.selectedIndex != -1) {
        parent_tag = parent_obj.options[parent_obj.selectedIndex].value;
        // 如果是直辖市
        if (parent_tag == "0")parent_tag = "";
    }
    var system_manager_ajax = xhr({
        url:'./ajax/general_ajax.php',
        data:{
            'operate_type'      :"tag_property_save",
            'selected_tag_id'   :tag_obj.options[tag_obj.selectedIndex].value,
            'begin_time'        :document.getElementById("begin_time").value,
            'big_day'           :document.getElementById("big_day").value,
            'end_time'          :document.getElementById("end_time").value,
            'tag_tree_type'     :tag_tree_obj.options[tag_tree_obj.selectedIndex].value,
            'parent_tag'        :parent_tag
        },
        async:false,
        method:'GET',
        complete: function () {
        },
        success: function (data) {
            // alert(data);
            succ_callback(operate_type, data);
        },
        error: function () {
            succ_callback(operate_type, "fail");
        }
    });
}

// 修改标签属性 step3: 选中标签树类型后的处理
function tag_tree_type_selected()
{
    // alert("tag_tree_type_selected");
    var operate_type = "tag_property_save";
    var system_manager_ajax = xhr({
        url:'./ajax/general_ajax.php',
        data:{
            'operate_type'      :"tag_tree_type_selected",
            'selected_tag_tree_type_id'   :document.getElementById("tag_tree_type").value
        },
        async:false,
        method:'GET',
        complete: function () {
        },
        success: function (data) {
            // alert(data);
            // 解析 json 数据。
            var tag_obj = JSON.parse(data);
            // 更新 parent_tag
            var obj = document.getElementById('parent_tag');
            obj.options.length = 0;
            // 当前是中国城市时，增加一个新的项目：“直辖市”
            if (document.getElementById("tag_tree_type").value == "10") {
                obj.options.add(new Option("-直辖市-", 0));
            }
            for (var ii = 0; ii < tag_obj.length; ii++)
            {
                // alert(tag_obj[ii][1] + "-" + tag_obj[ii][0]);
                // 将数据更新到界面。
                // tag_obj[ii][1] 为标题，tag_obj[ii][0] 为value。
                obj.options.add(new Option(tag_obj[ii][1], tag_obj[ii][0]));
            }
            document.getElementById("tag_property_save_label").style.display = "none";
        },
        error: function () {
            succ_callback(operate_type, "fail");
        }
    });
}

// 修改标签属性 step2: 选中标签后的处理
function tag_selected()
{
    var operate_type = "tag_property_save";
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
            // alert(data);
            // 解析 json 数据。
            var tag_obj = JSON.parse(data);
            document.getElementById("tag_name").value = tag_obj[1];
            document.getElementById("tag_count").value = tag_obj[2];
            document.getElementById("begin_time").value = tag_obj[3];
            document.getElementById("big_day").value = tag_obj[4];
            document.getElementById("end_time").value = tag_obj[5];
            var tag_tree_type = tag_obj[6];
            if (tag_tree_type >= 3 && tag_tree_type <= 15){
                $("#tag_tree_type").val(tag_tree_type);
            } else {
                $("#tag_tree_type").val(0);
            }
            document.getElementById("parent_tag").value = tag_obj[7];
            // 处理界面风格
            document.getElementById("tag_property_save").disabled = false;
            document.getElementById("tag_tree_type").focus();
            document.getElementById("tag_property_save_label").style.display = "none";
        },
        error: function () {
            succ_callback(operate_type, "fail");
        }
    });
}

// 修改标签属性 step1: 选择标签类型，获取标签列表
function select_vip_tag_type()
{
    var operate_type = "tag_property_save";
    var system_manager_ajax = xhr({
        url:'./ajax/general_ajax.php',
        data:{
            'operate_type'      :"select_vip_tag_type",
            'vip_tag_checked'   :get_checkbox_value("tag_modify_type_radio")
        },
        async:false,
        method:'GET',
        complete: function () {
        },
        success: function (data) {
            // alert(data);
            // 解析 json数据。
            var tag_obj = JSON.parse(data);
            document.getElementById("tag_property_save_label").style.display = "none";
            // 更新 tag_list_select
            var obj = document.getElementById('tag_list_select');
            obj.options.length = 0;
            obj.style.visibility = 'visible';
            for (var ii = 0; ii < tag_obj.length; ii++)
            {
                // alert(tag_obj[ii][1] + "-" + tag_obj[ii][0]);
                // 将数据更新到界面。
                // tag_obj[ii][1] 为标题，tag_obj[ii][0] 为value。
                obj.options.add(new Option(tag_obj[ii][1], tag_obj[ii][0]));
            }
        },
        error: function () {
            succ_callback(operate_type, "fail");
        }
    });
}
//////////////  设置 tag属性   end  ///////////////////////////



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

<fieldset style="width:600px;">
<legend>计算数据</legend>
    <input type="submit" style="font-size:18pt" value="计算事件-时间轴指数" 
        id="re_calc_year_order" onclick="ajax_do('re_calc_year_order')" />  <!-- 提交 -->
    <div class="label" id="re_calc_year_order_label"></div>
    
    <input type="submit" style="font-size:18pt" value="计算标签-热门指数" 
        id="re_calc_tag_hot_index" onclick="ajax_do('re_calc_tag_hot_index')" /> <!-- 提交 -->
    <div class="label" id="re_calc_tag_hot_index_label"></div>
    
    <input type="submit" style="font-size:18pt" value="计算事件-标签类型映射" 
        id="re_add_thing_tag_map" onclick="ajax_do('re_add_thing_tag_map')" /> <!-- 提交 -->
    <div class="label" id="re_add_thing_tag_map_label"></div>
</fieldset>


<fieldset style="width:600px;">
<legend>批量更新事件-VIP标签</legend>
<div style="positon:relative;">
<div id='div_top'>选择类型: </div>
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
    </br>
    <!-- 提交 -->
    <input type="submit" style="font-size:18pt; position:absolute;top:28%;left:35%;margin-left:50px;margin-top:40px"
        value="开始" id="re_thing_add_vip_tag" onclick="thing_add_vip_tag(0)" />
    
</br></br>
    <div id="progress_border">
    <div id="progress">
    <div id="percent">0%</div>
    </div>
    </div>
    <div class="label" id="re_thing_add_vip_tag_label"></div>
    </div>
</div>
</div>
</fieldset>


<fieldset style="width:600px;">
<legend>修改VIP标签属性</legend>
<div style="positon:relative;">
<div id='div_top'>选择类型: </div>
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
                onclick='select_vip_tag_type()'>$tag_name";
        }
    }
?>
</br></br>
<fieldset>
<table border="0" align="center">
<tr>
<td width=50%>
    <div id='div_top'>选择标签: </div>
    <select id='tag_list_select' size=23 onchange='tag_selected()'></select>
</td>
<td width=50%>
    <fieldset>
    <p class='thick'>标签名称: <input id='tag_name' readOnly="true" />
    <p class='thick'>事件数量: <input id='tag_count' readOnly="true" />
    <p class='thick'>标签树类型: 
        <select id='tag_tree_type' onChange="tag_tree_type_selected();">
            <option value='0'>--请选择--</option>
            <option value='3'>中国王朝</option>
            <option value='4'>中国皇帝</option>
            <option value='5'>中国年号</option>
            <option value='6'>外国国家</option>
            <option value='7'>外国王朝</option>
            <option value='8'>外国皇帝</option>
            <option value='9'>中国省份</option>
            <option value='10'>中国城市</option>
            <option value='11'>外国城市</option>
            <option value='12'>中国人</option>
            <option value='13'>外国人</option>
            <option value='14'>中国组织</option>
            <option value='15'>外国组织</option>
        </select>
    <p class='thick'>上级节点: 
        <select id='parent_tag'"></select>
    <p class='thick'>开始时间: <input id='begin_time' />
    <p class='thick'>BigDay&nbsp;&nbsp;: <input id='big_day' />
    <p class='thick'>结束时间: <input id='end_time' />

    </br></br>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <input type="submit" style="font-size:18pt" value="保存" disabled="true" 
        id="tag_property_save" onclick='tag_property_save()' />
    <div class="label" id="tag_property_save_label"></div>
    </fieldset>
</td>
</tr>
</table>
</fieldset>
</div>
</fieldset>
 
<!-- tab页 end -->

</body>
</html>
