<?php
// created by duangan, 2015-03-30 -->
// user 相关的函数。主要是和sql相关的。    -->

// 用户校验
function user_validate($user_name, $password)
{
    $password_hash = pun_hash($password);
    $sql_string = "select user_UUID, group_id from users where username='$user_name' 
           and password='$password_hash' limit 1";
    $check_query = mysql_query($sql_string);
    
    if($check_query == FALSE)
    {
        $GLOBALS['log']->error("error: user_validate() -- $sql_string 。");
        return array("user_UUID" => "", "user_right" => 0);
    }
    
    if($result = mysql_fetch_array($check_query))
    {
        return array("user_UUID" => $result['user_UUID'], 
              "user_right" => $result['group_id']);
    }
    else
    {
        return array("user_UUID" => "", "user_right" => 0);
    }
}

// 根据user id 获取用户名
function get_user_name_from_id($user_id)
{
    $user_name = "";

    $user_query = mysql_query("select username from users where user_UUID='$user_id' limit 1");
    if($user_query == FALSE)
    {
        $GLOBALS['log']->error("error: get_user_name_from_id() -- $sql_string 。");
        return "";
    }
    
    $row = mysql_fetch_array($user_query);

    return $row['username'];
}

// 根据user id 获取用户信息
function get_user_info($user_id)
{
    $user_query = mysql_query("select * from users where user_UUID='$user_id' limit 1");
    $row = mysql_fetch_array($user_query);
    
    if($row == FALSE)
    {
        $GLOBALS['log']->error("error: get_user_info() -- $sql_string 。");
        return "";
    }
    
    return $row;
}

// 检测用户名是否已经存在
function check_user_exist($user_name)
{
    $sql_string = "select user_UUID from users where username='$user_name' limit 1";
    $check_query = mysql_query($sql_string);
    
    if($check_query == FALSE)
    {
        $GLOBALS['log']->error("error: check_user_exist() -- $sql_string 。");
        return 0;
    }
    
    if(mysql_fetch_array($check_query))
    {
        return 1;
    }
    else
    {
        return 0;
    }
}

// 写入用户
function insert_user($user_name, $password, $email)
{
    $user_UUID = create_guid();
    $password_hash = pun_hash($password);
    $now = time();
    
    $sql_string = "INSERT INTO users(user_UUID, username, password, group_id, email, registered)
        VALUES('$user_UUID', '$user_name', '$password_hash', 4, '$email', $now)";
        
    if(mysql_query($sql_string))
    {
        return 1;
    }
    else
    {
        $GLOBALS['log']->error("error: insert_user() -- $sql_string 。");
        return 0;
    }
}

// 获取当前user_id
function get_user_id()
{
    return $_SESSION['user_id'];
}

// 获取当前用户名
function get_user_name()
{
    return $_SESSION['user_name'];
}

// 获取当前用户权限
function get_user_right()
{
    return $_SESSION['user_right'];
}

// 确认当前用户是否是管理员
function is_manager()
{
    return ((get_user_right() == 1) || (get_user_right() == 2));
}


?>