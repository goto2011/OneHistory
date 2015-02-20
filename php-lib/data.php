<?php
// created by duangan, 2014-12-28 -->
// support data deal function.    -->

require_once 'data_time.php';
// require_once 'data_chinese.php';

/////////////////////////////// 1.SYSTEM start //////////////////////////////////////
// 系统名称
function get_system_name()
{
	return "时间";
}

// 系统版本号
function get_system_version()
{
	return "V1.5";
}

// 系统说明
function get_system_desc()
{
    return 
'<div>这儿是一个记录历史事件的网站，它具有几个特点： 
<ol>
<li>1. 它的条目会很多，我希望有一天会有100万亿条。这样，平均每个地球人都可以摊到1000条，足以覆盖一个人的生老病死，以及家庭、教育、工作等方方面面。</li>
<li>2. "统一时间轴"，指所有这些条目，从182.2亿年前宇宙大爆炸起、到现在和未来的每一件事，都放在同一个时间轴上。在这个时间轴上，你可放大，可缩小，可按时间横断，可依地理细分，可顺人物勾勒，可尊文本梳理。笼天地于形内，挫万物于指端，何其痛快。</li>
<li>3. "无限标签"，指每个条目都可以打上无穷个标签。每一个标签，都是一把斩向"时间之河"的刀，从刀锋之上你能攫取一些东西，对比之，权衡之，追索之，品味之，深思之，然后再把它们放回去。每个标签，都意味着一种看世间的角度，每一组标签都代表着一套价值观和历史观。</li>
</ol>
</div>';
}

// 异常退出页面
function error_exit($exit_string)
{
	echo "<html>";
	echo "<head><meta http-equiv='Content-Type' content='text/html; charset=UTF-8'>";
	echo "<body>访问失败了！请返回上一页. </a><br /><br />";
	exit($exit_string);
	echo "</body></html>";
    echo "<script>history.go(-1);</script>";
    // header("refresh:1; Location:" . $_SESSION['HTTP_REFERER']);
}

// 分配更新界面令牌, 避免重复提交.
function alloc_update_token()
{
	$_SESSION['update_once'] = mt_rand(0,1000000);     // 随机数
}

// 获得更新界面令牌.
function get_update_token()
{
	return $_SESSION['update_once'];
}

// 使用更新界面令牌，使用后清空。
function user_update_token($update_token)
{
	if(($update_token != $_SESSION['update_once']) || ($update_token == ""))
	{
		return 0;
	}
	else
	{
		$_SESSION['update_once'] = "";
		return 1;
	}
}

// 获得导入界面令牌, 避免重复提交.
function alloc_import_token()
{
	$_SESSION['import_once'] = mt_rand(0,1000000);  // 随机数
}

// 获得导入界面令牌.
function get_import_token()
{
	return $_SESSION['import_once'];
}

// 使用导入界面令牌，使用后清空。
function user_import_token($import_token)
{
	if(($import_token != $_SESSION['import_once']) || ($import_token == ""))
	{
		return 0;
	}
	else
	{
		$_SESSION['import_once'] = "";
		return 1;
	}
}

/////////////////////////////// 1.SYSTEM end //////////////////////////////////////



/////////////////////////////// 2.GUID begin //////////////////////////////////////
function create_guid(){
	$microTime = microtime();
	list($a_dec, $a_sec) = explode(" ", $microTime);
	$dec_hex = dechex($a_dec* 1000000);
	$sec_hex = dechex($a_sec);
	ensure_length($dec_hex, 5);
	ensure_length($sec_hex, 6);
	$guid = "";
	$guid .= $dec_hex;
	$guid .= create_guid_section(3);
	$guid .= '-';
	$guid .= create_guid_section(4);
	$guid .= '-';
	$guid .= create_guid_section(4);
	$guid .= '-';
	$guid .= create_guid_section(4);
	$guid .= '-';
	$guid .= $sec_hex;
	$guid .= create_guid_section(6);
	return $guid;
}

function ensure_length(&$string, $length){
	$strlen = strlen($string);
	if($strlen < $length)
	{
		$string = str_pad($string,$length,"0");
	}
	else if($strlen > $length)
	{
		$string = substr($string, 0, $length);
	}
}

function create_guid_section($characters){
	$return = "";
	for($i=0; $i<$characters; $i++)
	{
	$return .= dechex(mt_rand(0,15));
	}
	return $return;
}
/////////////////////////////// 2.GUID begin //////////////////////////////////////


/////////////////////////////// 3.STRING start //////////////////////////////////////
// 将字符串数组变成以“,”分割的字符串，方便tags输出。
function get_string_from_array($array)
{
	$result_string = "";
	
	$count = count($array);
		
	if($count == 1)
	{
		$result_string = $array[0];
	}
	else if($count > 1)
	{
		for($index = 0; $index < $count; $index++) 
		{
			$result_string .= $array[$index] . ",";
		}
	}
	
	return $result_string;
}

// 获取thing字段的最大长度。暂定为400。
function get_thing_length()
{
	return 400;
}

// 将字符串按特定分隔符切分成两半.
function splite_string($token)
{
    // 支持多种分隔符
    $my_tokens = array(
        array("length"=>strpos($token, "，"), "token"=>"，"),
        array("length"=>strpos($token, ","), "token"=>","),
        array("length"=>strpos($token, "："), "token"=>"："),
        array("length"=>strpos($token, ":"), "token"=>":"),
       );
    
    $time_index = 0;
    $char_len = 0;
    foreach ($my_tokens as $my_token)
    {
        if ($my_token['length'] > 0)
        {
            if ($time_index == 0)
            {
                $time_index = $my_token['length'];
                $char_len = strlen($my_token['token']);
            }
            else if($my_token['length'] < $time_index)
            {
                $time_index = $my_token['length'];
                $char_len = strlen($my_token['token']);
            }
        }
    }
    
    $time_sub = substr($token, 0, $time_index);
    $thing_sub = substr($token, $time_index + $char_len, strlen($token));
    $thing_sub = addslashes($thing_sub);   // 对引号等特殊字符进行转义，方便sql语句中使用。
    
    return array("time"=>$time_sub, "thing"=>$thing_sub);
}

// html 编码, 防范html注入.
function html_encode($str)
{
    return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}


/////////////////////////////// 3.STRING end //////////////////////////////////////


?>