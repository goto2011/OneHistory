<?php
// created by duangan, 2015-3-29 -->
// support time deal function.    -->

// 获取thing字段的最大长度。暂定为400。
function get_thing_length()
{
    return 400;
}

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

// html编码，防范html注入。
function html_encode($str)
{
    return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}

// 将文本的回车换行归一化。
function one_line_flag($ori_string)
{
    $order = array("\r\n","\n","\r");
    $replace = "\r";
    return str_replace($order, $replace, $ori_string);
}

?>