// <!--  // created by duangan, 2015-8-16	-->
// <!--  // support key and time data deal in import/upate page. -->

// 检查数据是包含标点符号。=1，是；=0，不是。通用。
function is_dot(string)
{
	return (!(/^[,(\-)《》.a-zA-z0-9\u4E00-\u9FA5]*$/.test(string)));
}

// tag 数据检查。=1，不合格；=0，合格。
function tag_check(tag, tag_name)
{
    if(is_dot(tag_name))
    {
        document.getElementById(tag).focus();
        return 1;
    }
    else
    {
        return 0;
    }
}

// tag 输入数据检查.
function tags_check()
{
    var ret = 0;
    ret += tag_check("start_tags", document.getElementById("start_tags").value);
    ret += tag_check("end_tags", document.getElementById("end_tags").value);
    ret += tag_check("country_tags", document.getElementById("country_tags").value);
    ret += tag_check("geography_tags", document.getElementById("geography_tags").value);
    ret += tag_check("person_tags", document.getElementById("person_tags").value);
    ret += tag_check("source_tags", document.getElementById("source_tags").value);
    ret += tag_check("free_tags", document.getElementById("free_tags").value);
    ret += tag_check("dynasty_tags", document.getElementById("dynasty_tags").value);
    ret += tag_check("topic_tags", document.getElementById("topic_tags").value);
    ret += tag_check("office_tags", document.getElementById("office_tags").value);
    ret += tag_check("key_tags", document.getElementById("key_tags").value);
    ret += tag_check("key_tags", document.getElementById("land_tags").value);
    
    return ret;
}


// 添加标签时对标签文本做检查。
function onAddTag(tag)
{
	if (is_dot(tag))
	{
		alert("标签名称不能带有标点符号。");
	}
}

function onRemoveTag(tag)
{
	alert("Removed a tag: " + tag);
}
	
function onChangeTag(input,tag)
{
	alert("Changed a tag: " + tag);
}

/**
 * tag input settings.
 */
$(function() {
	$('#start_tags').tagsInput({
		width: '350px',
		height: '35px',
		removeWithBackspace : false,
		defaultText:'添加标签',
		onAddTag: function(elem, elem_tags)
		{
			$('.tag', elem_tags).each(function()
			{
				// $(this).css('background-color', 'red');
			});

			// autocomplete_url:'test/fake_plaintext_endpoint.html' //jquery.autocomplete (not jquery ui)
			// autocomplete_url:'test/fake_json_endpoint.html' // jquery ui autocomplete requires a json endpoint
		},
		onAddTag: onAddTag
	});

	$('#end_tags').tagsInput({
		width: '350px',
		height: '35px',
		removeWithBackspace : false,
		defaultText:'添加标签',
		onAddTag: onAddTag
	});

	$('#country_tags').tagsInput({
		width: '350px',
		height: '35px',
		removeWithBackspace : false,
		defaultText:'添加标签',
		onAddTag: onAddTag
	});

	$('#source_tags').tagsInput({
		width: '350px',
		height: '35px',
		removeWithBackspace : false,
		defaultText:'添加标签',
		onAddTag: onAddTag
	});

	$('#person_tags').tagsInput({
		width: '350px',
		height: '35px',
		removeWithBackspace : false,
		defaultText:'添加标签',
		onAddTag: onAddTag
	});

	$('#geography_tags').tagsInput({
		width: '350px',
		height: '35px',
		removeWithBackspace : false,
		defaultText:'添加标签',
		onAddTag: onAddTag
	});
	
	$('#free_tags').tagsInput({
		width: '350px',
		height: '35px',
		removeWithBackspace : false,
		defaultText:'添加标签',
		onAddTag: onAddTag
	});
	
	$('#dynasty_tags').tagsInput({
		width: '350px',
		height: '35px',
		removeWithBackspace : false,
		defaultText:'添加标签',
		onAddTag: onAddTag
	});
	
	$('#office_tags').tagsInput({
		width: '350px',
		height: '35px',
		removeWithBackspace : false,
		defaultText:'添加标签',
		onAddTag: onAddTag
	});
	
	$('#topic_tags').tagsInput({
		width: '350px',
		height: '35px',
		removeWithBackspace : false,
		defaultText:'添加标签',
		onAddTag: onAddTag
	});
	
	$('#key_tags').tagsInput({
		width: '350px',
		height: '35px',
		removeWithBackspace : false,
		defaultText:'添加标签',
		onAddTag: onAddTag
	});
	
	$('#note_tags').tagsInput({
		width: '350px',
		height: '35px',
		removeWithBackspace : false,
		defaultText:'添加标签',
		onAddTag: onAddTag
	});
	
	$('#land_tags').tagsInput({
		width: '350px',
		height: '35px',
		removeWithBackspace : false,
		defaultText:'添加标签',
		onAddTag: onAddTag
	});
// Uncomment this line to see the callback functions in action
//			$('input.tags').tagsInput({onAddTag:onAddTag,onRemoveTag:onRemoveTag,onChange: onChangeTag});		

// Uncomment this line to see an input with no interface for adding new tags.
//			$('input.tags').tagsInput({interactive:false});
});
	

// 确认输入是否ok. (import/update 页面 不再使用).
function validate_form(this_form)
{
	// 必须输入时间字段
	with(this_form)
	{
		if(validate_required(time) == false)
		{
			alert_input_fail("time_label", "<-- 请填写时间。");
			time.focus();
			return false;
		}
		else
		{
			alert_input_ok("time_label", "时间输入正确.");
		}
	}
	
	// 必须输入事件字段
	with(this_form)
	{
		if(validate_required(thing) == false)
		{
			alert_input_fail("thing_label", "<-- 请填写事件。");
			thing.focus();
			return false;
		}
		else
		{
			alert_input_ok("thing_label", "事件输入正确。");
		}
	}

	// 事件字段长度必须小于约定值。
	with(this_form)
	{
		if(thing.value.length > 400)
		{
			alert_input_fail("thing_label", "<-- 事件字段须小于400字，请重新输入。");
			thing.focus();
			return false;
		}
		else
		{
			alert_input_ok("thing_label", "事件输入正确。");
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
				alert_input_fail("time_label", "<-- 时间格式不正确。请重新输入。");
				return false;
			}
		}
		else if(time_type_index == 3)
		{
			if(check_date(time_value) == false)
			{
				alert_input_fail("time_label", "<-- 时间格式不正确。请重新输入。");
				return false;
			}
		}
		else if(time_type_index == 4)
		{
			if(check_time(time_value) == false)
			{
				alert_input_fail("time_label", "<-- 时间格式不正确。请重新输入。");
				return false;
			}
		}
	}
}