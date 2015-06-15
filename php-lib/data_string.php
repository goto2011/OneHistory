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

/**
 * html编码，防范html注入。只能用于用户输入数据。
 */
function html_encode($str)
{
    return strip_tags(htmlspecialchars($str, ENT_QUOTES, 'UTF-8'));
}

/**
 * php字符串安全代码，防止各种注入。(暂时没用)
 */
function input_safe($str)
{
    $html_string = array("&amp;", "&nbsp;", "'", '"', "<", ">", "\t", "\r");
    $html_clear = array("&", " ", "&#39;", "&quot;", "&lt;", "&gt;", "&nbsp; &nbsp; ", "");
    $js_string = array("/<script(.*)<\/script>/isU");
    $js_clear = array("");

    $frame_string = array("/<frame(.*)>/isU", "/<\/fram(.*)>/isU", "/<iframe(.*)>/isU", "/<\/ifram(.*)>/isU",);
    $frame_clear = array("", "", "", "");

    $style_string = array("/<style(.*)<\/style>/isU", "/<link(.*)>/isU", "/<\/link>/isU");
    $style_clear = array("", "", "");
    $str = trim($str);
    
    //过滤字符串
    $str = str_replace($html_string, $html_clear, $str);

    //过滤JS
    $str = preg_replace($js_string, $js_clear, $str);

    //过滤ifram
    $str = preg_replace($frame_string, $frame_clear, $str);

    //过滤style
    $str = preg_replace($style_string, $style_clear, $str);

    return $str;
}

// 将文本的回车换行归一化。
function one_line_flag($ori_string)
{
    $order = array("\r\n","\n","\r");
    $replace = "\r";
    return str_replace($order, $replace, $ori_string);
}

/**
 * 截取utf8或GB2312或者GBK编码的字符串。1个长度代表一个汉字。（没有使用）
 */
function substr_for_utf8($sourcestr, $cutlength)
{
    $returnstr="";
    $i=0;
    $n=0;
    
    $str_length=strlen($sourcestr);    //字符串的字节数
    while (($n<$cutlength) and ($i<=$str_length))
    {
        $temp_str=substr($sourcestr,$i,1);
        $ascnum=Ord($temp_str); //得到字符串中第$i位字符的ascii码
        if ($ascnum>=224) //如果ASCII位高与224，
        {
            $returnstr=$returnstr.substr($sourcestr,$i,3); //根据UTF-8编码规范，将3个连续的字符计为单个字符
            $i=$i+3; //实际Byte计为3
            $n++; //字串长度计1
        }
        elseif ($ascnum>=192)//如果ASCII位高与192，
        {
            $returnstr=$returnstr.substr($sourcestr,$i,2); //根据UTF-8编码规范，将2个连续的字符计为单个字符
            $i=$i+2; //实际Byte计为2
            $n++; //字串长度计1
        }
        elseif ($ascnum>=65 && $ascnum<=90) //如果是大写字母，
        {
            $returnstr=$returnstr.substr($sourcestr,$i,1);
            $i=$i+1; //实际的Byte数仍计1个
            $n++; //但考虑整体美观，大写字母计成一个高位字符
        }
        else //其他情况下，包括小写字母和半角标点符号，
        {
            $returnstr=$returnstr.substr($sourcestr,$i,1);
            $i=$i+1;    //实际的Byte数计1个
            $n=$n+0.5;    //小写字母和半角标点等与半个高位字符宽…
        }
    }
    if ($str_length>$cutlength)
    {
        $returnstr = $returnstr . "…";    //超过长度时在尾处加上省略号
    }
    return $returnstr;
}

/**
 * 判断内容里有没有汉字.
 */
function check_is_chinese($s)
{        
    return preg_match('/[\x80-\xff]./', $s);
}

/**
 * 获取汉字字符串长度.
 */     
function gb_strlen($str)
{
     $count = 0;
     for($i=0; $i<strlen($str); $i++)
     {
         $s = substr($str, $i, 1);
         if (preg_match("/[\x80-\xff]/", $s)) ++$i;
         
         ++$count;
     }
     return $count;
}

?>