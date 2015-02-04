// <!--  // created by duangan, 2015-1-11	-->
// <!--  // support data deal function.	-->

// 表格显示效果, 一行浅色/一行深色.
function altRows(id)
{
	if(document.getElementsByTagName)
	{
		var table = document.getElementById(id);
		var rows = table.getElementsByTagName("tr");
		for(i = 0; i < rows.length; i++)
		{
			if(i % 2 == 0)
			{
				rows[i].className = "evenrowcolor";
			}
			else
			{
				rows[i].className = "oddrowcolor";
			}
		}
	}
}

// item list 界面 checkbox 全选
function select_all()
{
	var checkboxs = document.getElementsByName("groupCheckbox");
	for (var ii = 0; ii < checkboxs.length; ii++)
	{
		if (checkboxs[ii].checked == false)
		{
			checkboxs[ii].checked = true;
		}
	}
}

// item list 界面 checkbox 全不选
function select_none()
{
	var checkboxs = document.getElementsByName("groupCheckbox");
	for (var ii = 0; ii < checkboxs.length; ii++)
	{
		if (checkboxs[ii].checked == true)
		{
			checkboxs[ii].checked = false;
		}
	}
}

function onAddTag(tag)
{
	alert("Added a tag: " + tag);
}

function onRemoveTag(tag)
{
	alert("Removed a tag: " + tag);
}
	
function onChangeTag(input,tag)
{
	alert("Changed a tag: " + tag);
}

$(function() {
	$('#start_tags').tagsInput({
		width: '350px',
		height: '35px',
		removeWithBackspace : false,
		defaultText:'添加标签',
		onChange: function(elem, elem_tags)
		{
			$('.tag', elem_tags).each(function()
			{
				// $(this).css('background-color', 'red');
			});

			// autocomplete_url:'test/fake_plaintext_endpoint.html' //jquery.autocomplete (not jquery ui)
			// autocomplete_url:'test/fake_json_endpoint.html' // jquery ui autocomplete requires a json endpoint
		},
		onAddTag: function(elem, elem_tags)
		{
			$('.tag', elem_tags).each(function()
			{
				// $(this).css('background-color', 'red');
			});
		}
	});

	$('#end_tags').tagsInput({
		width: '350px',
		height: '35px',
		removeWithBackspace : false,
		defaultText:'添加标签',
		onChange: function(elem, elem_tags)
		{
			$('.tag', elem_tags).each(function()
			{
				// $(this).css('background-color', 'red');
			});

			// autocomplete_url:'test/fake_plaintext_endpoint.html' //jquery.autocomplete (not jquery ui)
			// autocomplete_url:'test/fake_json_endpoint.html' // jquery ui autocomplete requires a json endpoint
		}
	});

	$('#country_tags').tagsInput({
		width: '350px',
		height: '35px',
		removeWithBackspace : false,
		defaultText:'添加标签',
		onChange: function(elem, elem_tags)
		{
			$('.tag', elem_tags).each(function()
			{
				// $(this).css('background-color', 'blue');
			});

			// autocomplete_url:'test/fake_plaintext_endpoint.html' //jquery.autocomplete (not jquery ui)
			// autocomplete_url:'test/fake_json_endpoint.html' // jquery ui autocomplete requires a json endpoint
		}
	});

	$('#source_tags').tagsInput({
		width: '350px',
		height: '35px',
		removeWithBackspace : false,
		defaultText:'添加标签',
		onChange: function(elem, elem_tags)
		{
			$('.tag', elem_tags).each(function()
			{
				// $(this).css('background-color', 'blue');
			});

			// autocomplete_url:'test/fake_plaintext_endpoint.html' //jquery.autocomplete (not jquery ui)
			// autocomplete_url:'test/fake_json_endpoint.html' // jquery ui autocomplete requires a json endpoint
		}
	});

	$('#person_tags').tagsInput({
		width: '350px',
		height: '35px',
		removeWithBackspace : false,
		defaultText:'添加标签',
		onChange: function(elem, elem_tags)
		{
			$('.tag', elem_tags).each(function()
			{
				// $(this).css('background-color', 'yellow');
			});

			// autocomplete_url:'test/fake_plaintext_endpoint.html' //jquery.autocomplete (not jquery ui)
			// autocomplete_url:'test/fake_json_endpoint.html' // jquery ui autocomplete requires a json endpoint
		}
	});

	$('#geography_tags').tagsInput({
		width: '350px',
		height: '35px',
		removeWithBackspace : false,
		defaultText:'添加标签',
		onChange: function(elem, elem_tags)
		{
			$('.tag', elem_tags).each(function()
			{
				// $(this).css('background-color', 'purple');
			});

			// autocomplete_url:'test/fake_plaintext_endpoint.html' //jquery.autocomplete (not jquery ui)
			// autocomplete_url:'test/fake_json_endpoint.html' // jquery ui autocomplete requires a json endpoint
		}
	});
	
	$('#free_tags').tagsInput({
		width: '750px',
		height: '35px',
		removeWithBackspace : false,
		defaultText:'添加标签',
		onChange: function(elem, elem_tags)
		{
			// autocomplete_url:'test/fake_plaintext_endpoint.html' //jquery.autocomplete (not jquery ui)
			// autocomplete_url:'test/fake_json_endpoint.html' // jquery ui autocomplete requires a json endpoint
		}
	});
		
// Uncomment this line to see the callback functions in action
//			$('input.tags').tagsInput({onAddTag:onAddTag,onRemoveTag:onRemoveTag,onChange: onChangeTag});		

// Uncomment this line to see an input with no interface for adding new tags.
//			$('input.tags').tagsInput({interactive:false});
	});

// 显示“时间格式不正确”
function show_time_alert(alert_text)
{
	document.getElementById("time_label").style.color = "red";
	document.getElementById("time_alert").innerHTML = alert_text;
	document.getElementById("time_alert").style.display = "inline";
}

// 显示时间格式正确
function show_time_ok()
{
	document.getElementById("time_label").style.color = "black";
	document.getElementById("time_alert").style.display = "none";
}

// 显示“事件格式不正确”
function show_thing_alert(alert_text)
{
	document.getElementById("thing_label").style.color = "red";
	document.getElementById("thing_alert").innerHTML = alert_text;
	document.getElementById("thing_alert").style.display = "inline";
}

// 显示事件格式正确
function show_thing_ok()
{
	document.getElementById("thing_label").style.color = "black";
	document.getElementById("thing_alert").style.display = "none";
}

// 根据name获取单选框的选择状态
function get_radio_checked_from_name(radio_name)
{
	var chkObjs = document.getElementsByName(radio_name);
    for(var ii = 0;ii < chkObjs.length; ii++)
    {
        if(chkObjs[ii].checked)
        {
        	return ii + 1;
        }
    }
}

// 确认输入是否ok
function validate_form(this_form)
{
	// 必须输入时间字段
	with(this_form)
	{
		if(validate_required(time) == false)
		{
			show_time_alert("<-- 请填写时间。");
			time.focus();
			return false;
		}
		else
		{
			show_time_ok();
		}
	}
	
	// 必须输入事件字段
	with(this_form)
	{
		if(validate_required(thing) == false)
		{
			show_thing_alert("<-- 请填写事件。");
			thing.focus();
			return false;
		}
		else
		{
			show_thing_ok();
		}
	}

	// 事件字段长度必须小于约定值。
	with(this_form)
	{
		if(thing.value.length > 400)
		{
			show_thing_alert("<-- 事件字段须小于400字，请重新输入。");
			thing.focus();
			return false;
		}
		else
		{
			show_thing_ok();
		}
	}
	
	// 确定时间字段的格式是否正常
	with(this_form)
	{
		var time_type_index = get_radio_checked_from_name("time_type");
		var time_value = document.getElementById("time").value;

		if((time_type_index == 1) || (time_type_index == 2))
		{
			if(check_number(time_value) == false)
			{
				show_time_alert("<-- 时间格式不正确。请重新输入。");
				return false;
			}
		}
		else if(time_type_index == 3)
		{
			if(check_date(time_value) == false)
			{
				show_time_alert("<-- 时间格式不正确。请重新输入。");
				return false;
			}
		}
		else if(time_type_index == 4)
		{
			if(check_time(time_value) == false)
			{
				show_time_alert("<-- 时间格式不正确。请重新输入。");
				return false;
			}
		}
	}
}

// 表单项是否为空检查
function validate_required(field)
{
	with(field)
	{
		if(value == null || value == "")
		{
			return false;
		}
		else
		{
			return true;
		}
	} 
}

// 检查是不是数字。数字包括负号“-”，负号只能放在第一个字节。
function check_number(value)
{
	var reg = "1234567890"; 	// 可输入值
	var i;
	var c;
	c = value.charAt( 0 );
	if((c != '-') && (reg.indexOf( c ) < 0))return false;
	
	for( i = 1; i < value.length; i ++ )
	{
		c = value.charAt( i );
		if (reg.indexOf( c ) < 0)return false;
	}
	return true;
}

// 检查是不是“年月日”字符串
function check_date(time_value)
{
	var r = time_value.match(/^(\d{1,4})(-|\/)(\d{1,2})\2(\d{1,2})$/);
	if(r == null)return false;
	
	var d = new Date(r[1], r[3]-1, r[4]);
	return ((d.getFullYear()==r[1]) && ((d.getMonth()+1)==r[3]) && (d.getDate()==r[4]));
}

//检查是不是“年月日 时分秒”字符串
function check_time(time_value)
{
	var r = time_value.match(/^(\d{1,4})(-|\/)(\d{1,2})\2(\d{1,2}) (\d{1,2}):(\d{1,2}):(\d{1,2})$/);
	if(r == null)return false;
	
	var d= new Date(r[1], r[3]-1,r[4],r[5],r[6],r[7]);
	return ((d.getFullYear()==r[1]) && ((d.getMonth()+1)==r[3]) && (d.getDate()==r[4])
		&& (d.getHours()==r[5]) && (d.getMinutes()==r[6]) && (d.getSeconds()==r[7]));
}

// 判断是否为数字字母下滑线。用于判断用户名。
function not_chinese(str)
{ 
	var reg="/[^A-Za-z0-9_]/g"; 
	if (reg.test(str))
	{
		return false; 
	}
	else
	{
		return true;
	} 
}
