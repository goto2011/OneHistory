<?php
// created by duangan, 2015-3-15 -->
// 管理系统配置项。需要放在数据库中。    -->

// 返回每一页的长度限制
function get_page_size()
{
    if (is_adder())
    {
        $_SESSION['page_size'] = 80;    /// 多一些比较好。
    }
    else 
    {
        $_SESSION['page_size'] = 30;   
    }
    return $_SESSION['page_size'];
}

// 返回每一页的 tag 的数量限制。暂时写死，后续再写活。
function get_page_tags_size()
{
    if (is_vip_user())
    {
        $_SESSION['page_tags_size'] = 200;
    }
    else
    {
        $_SESSION['page_tags_size'] = 40;
    }
    return $_SESSION['page_tags_size'];
}

// 返回被关注对标签的hot_index的影响系数
function get_follow_hot_rate()
{
    return 5;
}


?>