<?php
// created by duangan, 2015-03-30 -->
// user 相关的函数。主要是和sql相关的。    -->

require_once 'sql_public.php';

// 用户校验
function user_validate($user_name, $password)
{
    // use hash code.
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

/**
 * 获取当前用户的等级。2017-07-09
 */
function get_current_user_grade()
{
    return get_user_grade(get_user_id());
}

/**
 * 获取指定用户的等级。2017-07-09
 */
function get_user_grade($user_id)
{
    // 检查权限：访客没有，普通用户可以看自己的，特权用户可以看所有人的。
    if (is_guest()) 
    {
        return array(0, 0, 0);
    }
    if (is_normal() && ($user_id != get_user_id()))
    {
        return array(0, 0, 0);
    }
    // 获取用户添加的事件数量和tag数量。
    $thing_count = get_thing_count_by_adder(get_user_id());
    $tag_cout = get_tag_count_by_adder(get_user_id());
    
    // 1个事件算1分，1个tag算3分，计算用户等级。
    $total_scare = $thing_count + 3 * $tag_cout;
    // $total_scare = 72706
    $delt = 4 * ($total_scare / 25) - 1;
    // $current_grace = 54
    $current_grace = floor((1 + sqrt($delt)) / 2);
    $current_scare = $total_scare - $current_grace * ($current_grace - 1) * 25;
    $next_grace_scare = $current_grace * 50;
    
    return array($current_grace, $current_scare, $next_grace_scare);
}

// 根据 user_uuid 获取 thing 的数量
function get_thing_count_by_adder($uuid_id)
{
    $sql_string = "select count(*) from thing_time where user_UUID = '$uuid_id'";
    $result = mysql_query($sql_string);
    if ($result == FALSE)
    {
        $GLOBALS['log']->error("error: get_thing_count() -- $sql_string 。");
        return 0;
    }
    $row = mysql_fetch_row($result);
    return $row[0];
}

// 根据 user_uuid 获取 key 的数量
function get_tag_count_by_adder($uuid_id)
{
    $sql_string = $sql_string = "select count(*) from property where user_UUID = '$user_id'";;
    $result = mysql_query($sql_string);
    if ($result == FALSE)
    {
        $GLOBALS['log']->error("error: get_tag_count() -- $sql_string 。");
        return 0;
    }
    $row = mysql_fetch_row($result);
    return $row[0];
}
// 用户登陆。
function user_login_succ($user_name, $user_UUID, $user_right)
{
    // 登录成功
    $_SESSION['user_name'] = $user_name;
    $_SESSION['user_id'] = $user_UUID;
    $_SESSION['user_right'] = $user_right;
    $_SESSION[timeout] = time();
}

// 用户注销
function user_logout()
{
    // unset($_SESSION['user_id']);
    // unset($_SESSION['user_right']);
    // unset($_SESSION['user_name']);
    
    // 用户注销后，获取 guest 权限。
    $_SESSION['user_id'] = 0;
    $_SESSION['user_right'] = 0;
    $_SESSION['user_name'] = "guest";
}

// 检查用户是否登录. 返回: =1 表示已登陆；=0 表示没有登陆。
function user_is_login()
{
    // 清理状态。
    if((!isset($_SESSION['user_id'])) || (user_timeout()))
    {
        user_logout();
    }
    
    if (is_guest())
    {
        return 0;
    }
    else 
    {
        return 1;
    }
}

// 确认当前用户是否是管理员
function is_manager()
{
    return (($_SESSION['user_right'] == 1) || ($_SESSION['user_right'] == 2));
}

// 确认当前用户是否是添加者
function is_adder()
{
    return ($_SESSION['user_right'] == 5);
}

// 确认当前用户是否是删除者
function is_deleter()
{
    return ($_SESSION['user_right'] == 6);
}

// 是否为 vip 用户
function is_vip_user()
{
    return (is_adder() || is_deleter() || is_manager());
}

// 确认当前用户是否是普通登录用户
function is_normal()
{
    return ($_SESSION['user_right'] == 4);
}

// 确认当前用户是否是未登录用户
function is_guest()
{
    return ($_SESSION['user_right'] == 0);
}

/*
 * 用户登陆超时检查。
 */
function user_timeout(){
    if (!isset($_SESSION[timeout]) || ($_SESSION[timeout] == 0)){
        $_SESSION[timeout] = time();
    }
    $now_time = time();
    // 三十分钟退出
    if($now_time - $_SESSION[timeout] > 1800){
        return true;
    } else {
        $_SESSION[timeout] = time();
        return false;
    }
}

?>