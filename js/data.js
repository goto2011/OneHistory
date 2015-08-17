// <!--  // created by duangan, 2015-1-11	-->
// <!--  // support data deal function.	-->

/**
 * 过滤 html 代码。
 */
function remove_html_code(str)
{
	/*
	str = str.replace((@|#|$|^|&|*|html|body|pre|iframe|head|script|embed|meta|form|noscript)/g, ' ');
	alert(str);
	
	return str;
	*/
	
	s = "@|#|$|^|&|*|html|body|pre|iframe|head|script|embed|meta|form|noscript";
	var my_char =  s.split('|');
	for (var i = 0; i < my_char.length; i++)
	{
		var reg=new RegExp("\\" + my_char[i], "g"); 
		str = str.replace(reg, ' ');
	}
	return str;
	
	/*
	var pattern = new RegExp("[`~!@#$^&*()=|{}':;',\\[\\].<>/?~！@#￥……&*|]");
    var rs = "";
  	for (var i = 0; i < s.length; i++) {
    	rs = rs + str.substr(i, 1).replace(pattern, '');
  	}
  	return rs;
	*/
}

/**
 *  过滤空格、空行
 */
function remove_blank(str)
{
    str = str.replace(/[ | ]*\n/g,'\n'); 		//去除行尾空白
    //str = str.replace(/\n[\s| | ]*\r/g,'\n'); //去除多余空行
    str=str.replace(/&nbsp;/ig,'');				//去掉&nbsp;
    
    return str;
}

// 获取单选框的值，都没选中，则返回0。通用。
function get_checkbox_value(checkbox_name)
{
	for (var i = 0; i < document.getElementsByName(checkbox_name).length; i++)
	{
		if(document.getElementsByName(checkbox_name)[i].checked)
		{
			return document.getElementsByName(checkbox_name)[i].value;
		}
	}
	return 0;
}

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
	var checkboxs = document.getElementsByName("groupCheckbox[]");
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
	var checkboxs = document.getElementsByName("groupCheckbox[]");
	for (var ii = 0; ii < checkboxs.length; ii++)
	{
		if (checkboxs[ii].checked == true)
		{
			checkboxs[ii].checked = false;
		}
	}
}

// item list 界面 checkbox 检查是否都没有选中.
function checkbox_check()
{
	var checkboxs = document.getElementsByName("groupCheckbox[]");
	for (var ii = 0; ii < checkboxs.length; ii++)
	{
		if (checkboxs[ii].checked == true)
		{
			return true;
		}
	}
	
	alert("请至少选中一个表格行.");
	return false;
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

// 表单项输入不正确时报错.
function alert_input_fail(form_name, alert_text)
{
	document.getElementById(form_name).style.color = "red";
	document.getElementById(form_name).innerHTML = alert_text;
	document.getElementById(form_name).style.display = "inline";
}

// 表单项输入正确时提示用户.
function alert_input_ok(form_name, alert_text)
{
	document.getElementById(form_name).style.color = "black";
	document.getElementById(form_name).innerHTML = alert_text;
	document.getElementById(form_name).style.display = "none";
}

// 根据名称检查表单项是否为空检查
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

// 检查参数是不是数字。数字包括负号“-”，负号只能放在第一个字节。
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
