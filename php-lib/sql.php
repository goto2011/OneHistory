<?php
// created by duangan, 2014-12-28 -->
// support data deal function.    -->

require_once 'init.php';
require_once "data.php";

////////////////////////////////// 1.数据库管理 begin //////////////////////////
// 打开数据库
function open_db()
{
	$conn = @mysql_connect("localhost", "root", "1234") or die("数据库链接错误!");
	mysql_select_db("one-history", $conn);		// data为数据库名称
	mysql_query("set names 'UTF8'"); 			// 使用utf8中文编码
	
	return $conn;
}

// 将数据库查询到的多条记录集一次放入一个数组（通用接口，暂时没有使用）
function mysql_fetch_all($result)
{
	if(! is_resource($result))
	{
		$GLOBALS['log']->error('$result 不是一个有效的资源');
		return false;
	}
	while($row = mysql_fetch_assoc($result))
	{
		$arr[]=$row;
	}
	return $arr;
}

////////////////////////////////// 1.数据库管理 end //////////////////////////



////////////////////////////////// 2.thing_time begin //////////////////////////
// 根据thing uuid获取thing各项属性。
function get_thing_db($thing_uuid)
{
	$sql_string = "select * from thing_time where uuid='$thing_uuid'";
	$result = mysql_query($sql_string);
    if ($result == FALSE)
    {
        $GLOBALS['log']->error("error: get_thing_db() -- $sql_string 。");
    }
	
	return $result;
}

// 将事件-时间数据写入数据库
function insert_thing_to_db($time_array, $thing)
{
    if ($time_array['status'] != "ok")
    {
        $GLOBALS['log']->error("error: insert_thing_to_db() -- time array error.");
        return "";
    }
    
    $time = $time_array['time'];
    $time_type = $time_array['time_type'];
    $time_limit = $time_array['time_limit'];
    $time_limit_type = $time_array['time_limit_type'];
    $year_order = get_year_order($time, $time_type);

	$thing_uuid = create_guid();
	$sql_string = "INSERT INTO thing_time(uuid, time, time_type, time_limit, time_limit_type, 
	   thing, add_time, public_tag, user_UUID, year_order) VALUES('$thing_uuid', $time, $time_type, 
	   $time_limit, $time_limit_type, '$thing', now(), 1, '" . get_user_id() . "', $year_order)";
	
	if (mysql_query($sql_string) === TRUE)
	{
		return $thing_uuid;
	}
	else
	{
		$GLOBALS['log']->error("error: insert_thing_to_db() -- $sql_string 。" . mysql_error());
        return "";
	}
}

// 将事件的更新数据写入数据库
// 返回值: 成功返回1, 失败返回0.
function update_thing_to_db($thing_uuid, $time_array, $thing)
{
    if ($time_array['status'] != "ok")
    {
        $GLOBALS['log']->error("error: update_thing_to_db() -- time array error.");
        return 0;
    }
    
    $time = $time_array['time'];
    $time_type = $time_array['time_type'];
    $time_limit = $time_array['time_limit'];
    $time_limit_type = $time_array['time_limit_type'];
    $year_order = get_year_order($time, $time_type);
    
	// 保存数据
	$sql_string = "UPDATE thing_time set time = $time, time_type = $time_type, thing = '$thing', 
		time_limit = $time_limit, time_limit_type = $time_limit_type , year_order = $year_order 
		where uuid = '$thing_uuid' ";
	
	if (mysql_query($sql_string) === TRUE)
	{
		return 1;
	}
	else
	{
		$GLOBALS['log']->error("error: update_thing_to_db() -- $sql_string 。" . mysql_error());
		return 0;
	}
}

// 根据 user_uuid 获取 thing 的数量
function get_thing_count_by_user($user_uuid)
{
    $sql_string = "select count(*) from thing_time where user_UUID = '$user_uuid'";
    
    $result = mysql_query($sql_string);
    
    if($result == FALSE)
    {
       $GLOBALS['log']->error("error: get_thing_count_by_user() -- $sql_string 。");
       return -1;
    }
    
    $row = mysql_fetch_row($result);    // 返回一行.
    return $row[0];
}


// 根据 list type 给出符合条件的条目总数
function get_thing_count($list_type)
{
	switch ($list_type)
	{
		// 全部条目
		case 1:
			$sql_string = "select count(*) from thing_time";
			break;

		// 我的关注
		case 2:
			$sql_string = "select count(*) from thing_time where UUID in(select thing_UUID from thing_property
                where property_UUID in(select property_UUID from follow
                where user_UUID = '" . get_user_id() . "'))";
			break;

		// 我的小组(暂无功能)
		case 3:
			$sql_string = "select count(*) from thing_time";
			break;

		// 最热门(此功能可删除)
		case 4:
			$sql_string = "select count(*) from thing_time";
			break;

		// 最新，指1天内的
		case 5:
			$sql_string = "select count(*) from thing_time where UUID in(select thing_UUID from thing_property
					where property_UUID in(select property_UUID from property
					where DATE_SUB(CURDATE(), INTERVAL 1 DAY) <= date(add_time)))";
			break;
				
		// 无标签
		case 6:
			$sql_string = "select count(*) from thing_time where UUID not in(select thing_UUID from thing_property)";
			break;

		// 时代
		case 7:
			$sql_string = "select count(*) from thing_time";
			break;

		// 事件始终
		case 8:
			$sql_string = "select count(*) from thing_time where UUID in(select thing_UUID from thing_property
				where property_UUID in(select property_UUID from property
				where property_type = 1 or property_type = 2))";
			break;

		// 人物
		case 9:
			$sql_string = "select count(*) from thing_time where UUID in(select thing_UUID from thing_property
				where property_UUID in(select property_UUID from property
				where property_type = 4))";
			break;

		// 地理
		case 10:
			$sql_string = "select count(*) from thing_time where UUID in(select thing_UUID from thing_property
				where property_UUID in(select property_UUID from property
				where property_type = 5))";
			break;

		// 出处
		case 11:
			$sql_string = "select count(*) from thing_time where UUID in(select thing_UUID from thing_property
				where property_UUID in(select property_UUID from property
				where property_type = 3))";
			break;
			
		// 国家民族
		case 12:
			$sql_string = "select count(*) from thing_time where UUID in(select thing_UUID from thing_property
				where property_UUID in(select property_UUID from property
				where property_type = 7))";
			break;
			
		// 自由标签
		case 13:
			$sql_string = "select count(*) from thing_time where UUID in(select thing_UUID from thing_property
				where property_UUID in(select property_UUID from property
				where property_type = 6))";
			break;
		default:
			$GLOBALS['log']->error("error: get_thing_count() -- list_type error 。");
			return -1;
	}

	$result = mysql_query($sql_string);
	if ($result == FALSE)
	{
        $GLOBALS['log']->error("error: get_thing_count() -- $sql_string 。");
        return -1;
    }

	$row = mysql_fetch_row($result);    // 返回一行.
	return $row[0];
}

// 获取 thing 表的字段
function get_thing_item_db($list_type, $offset, $page_size)
{
    $order_sub = " order by thing_time.year_order ASC limit $offset, $page_size ";
    
	switch ($list_type)
	{
		// 全部条目
		case 1:
			$sql_string = "select * from thing_time $order_sub";
			break;
	
		// 我的关注
		case 2:
			$sql_string = "select * from thing_time where UUID in(select thing_UUID from thing_property 
                where property_UUID in(select property_UUID from follow
                where user_UUID = '" . get_user_id() . "')) $order_sub ";
			break;
	
		// 我的小组(暂无功能)
		case 3:
			$sql_string = "select * from thing_time $order_sub ";
			break;
	
		// 最热门(此项目删除)
		case 4:
			$sql_string = "select * from thing_time $order_sub ";
			break;
	
		// 最新，指7天内的
		case 5:
			$sql_string = "select * from thing_time where UUID in(select thing_UUID from thing_property 
				where property_UUID in(select property_UUID from property 
				where DATE_SUB(CURDATE(), INTERVAL 1 DAY) <= date(add_time))) $order_sub ";
			break;
	
		// 无标签
		case 6:
			$sql_string = "select * from thing_time where UUID not in(select thing_UUID 
			     from thing_property) $order_sub ";
			break;
	
		// 时代
		case 7:
			$sql_string = "select * from thing_time $order_sub";
			break;
	
		// 事件
		case 8:
			$sql_string = "select * from thing_time where UUID in(select thing_UUID from thing_property 
				where property_UUID in(select property_UUID from property 
				where property_type = 1 or property_type = 2)) $order_sub ";
			break;
	
		// 人物
		case 9:
			$sql_string = "select * from thing_time
				where UUID in(select thing_UUID from thing_property 
				where property_UUID in(select property_UUID from property
				where property_type = 4)) $order_sub ";
			break;
	
		// 地理
		case 10:
			$sql_string = "select * from thing_time 
				where UUID in(select thing_UUID from thing_property
				where property_UUID in(select property_UUID from property
				where property_type = 5)) $order_sub ";
			break;
	
		// 出处
		case 11:
			$sql_string = "select * from thing_time 
				where UUID in(select thing_UUID from thing_property
				where property_UUID in(select property_UUID from property
				where property_type = 3)) $order_sub ";
			break;

		// 国家民族
		case 12:
			$sql_string = "select * from thing_time
				where UUID in(select thing_UUID from thing_property
				where property_UUID in(select property_UUID from property
				where property_type = 7)) $order_sub ";
			break;

		// 国家民族
		case 13:
			$sql_string = "select * from thing_time
				where UUID in(select thing_UUID from thing_property
				where property_UUID in(select property_UUID from property
				where property_type = 6)) $order_sub ";
			break;
			
		default:
			$GLOBALS['log']->error("error: get_thing_item_db() -- list_type error 。");
			return NULL;
	}
	
	$result = mysql_query($sql_string);
    if($result == FALSE)
    {
        $GLOBALS['log']->error("error: get_thing_item_db() -- $sql_string 。");
        return NULL;
    }
	
	return $result;
}

////////////////////////////////// 2.thing_time end //////////////////////////


////////////////////////////////// 3.tag begin //////////////////////////
// 根据 tag 获取 thing 条目数量
function get_thing_count_by_tag($property_UUID)
{
	$sql_string = "select count(*) from thing_time where UUID in(select thing_UUID from thing_property 
			where property_UUID = '$property_UUID')";
	
	$result = mysql_query($sql_string);
	
	if($result == FALSE)
	{
	   $GLOBALS['log']->error("error: get_thing_count_by_tag() -- $sql_string 。");
	   return -1;
	}
	
	$row = mysql_fetch_row($result);    // 返回一行.
	return $row[0];
}

// 根据 tag 获取 thing 表的数据
function get_thing_item_by_tag($property_UUID, $offset, $page_size)
{
	$sql_string = "select * from thing_time where UUID in(select thing_UUID from thing_property 
			where property_UUID = '$property_UUID') order by thing_time.year_order ASC limit $offset, $page_size ";
	
	$result = mysql_query($sql_string);
	if($result ==FALSE)
    {
	   $GLOBALS['log']->error("error: get_thing_item_by_tag() -- $sql_string 。");
       return NULL;
    }
	
	return $result;
}
////////////////////////////////// 3.tag end //////////////////////////


////////////////////////////////// 4.search begin //////////////////////////
// 判断查询字符串是否为复杂查询串.
function is_complex_search($search_key)
{
    if ((stristr($search_key, "(")) || (stristr($search_key, ")")) || (stristr($search_key, "and"))
        || (stristr($search_key, "or")) || (stristr($search_key, "-")) || (stristr($search_key, "+")))
    {
        return true;
    }
    else 
    {
        return false;
    }
}

// 生成 search 查询之条件字句
function get_search_where_sub($search_key)
{
    $search_sub = " where ";
    
    $search_key = str_replace("+", " + ", $search_key);
    $search_key = str_replace("-", " - ", $search_key);
    $search_key = str_replace("(", " ( ", $search_key);
    $search_key = str_replace(")", " ) ", $search_key);
    
    $key_array = explode(" ", $search_key);
    // 这个正则表达式是对的, 但不合乎需求.
    // $key_array = preg_split("/\s+-\(\)/", $search_key);
    
    if (is_complex_search($search_key))
    {
        for ($ii = 0; $ii < count($key_array); $ii++)
        {
            if (strlen(trim($key_array[$ii])) == 0)
            {
                continue;
            }
            else if ($key_array[$ii] == "(")
            {
                $search_sub .= " ( ";
            }
            else if ($key_array[$ii] == ")")
            {
                $search_sub .= " ) ";
            }
            else if ($key_array[$ii] == "and")
            {
                $search_sub .= " and ";
            }
            else if (($key_array[$ii] == "or") || ($key_array[$ii] == "+"))
            {
                $search_sub .= " or ";
            }
            else if ($key_array[$ii] == "-")
            {
                $search_sub .= " and not ";
            }
            else
            {
                $search_sub .= " ( thing like '%" . $key_array[$ii] . "%' ) ";
            }
       } // for 
    } // if
    else
    {
        for ($ii = 0; $ii < count($key_array); $ii++)
        {
            if ($ii == 0)
            {
                $search_sub .= " ( thing like '%" . $key_array[$ii] . "%' ) ";
            }
            else 
            {
                $search_sub .= " or ( thing like '%" . $key_array[$ii] . "%' ) ";
            }
        } // for
    } // else
    
    return $search_sub;
}

// 根据检索条件获取满足条件的条目的数量.
function get_thing_count_by_search($search_key)
{
    $sql_string = "select count(*) from thing_time " . get_search_where_sub($search_key);
    $result = mysql_query($sql_string);
    
    if($result == FALSE)
    {
       $GLOBALS['log']->error("error: get_thing_count_by_search() -- $sql_string 。");
       return -1;
    }
    
    $row = mysql_fetch_row($result);    // 返回一行.
    return $row[0];
}

// 根据检索条件获取 thing 表的数据
function get_thing_item_by_search($search_key, $offset, $page_size)
{
    $sql_string = "select * from thing_time " . get_search_where_sub($search_key) .
         " order by thing_time.year_order ASC limit $offset, $page_size ";
    
    $result = mysql_query($sql_string);
    if($result ==FALSE)
    {
       $GLOBALS['log']->error("error: get_thing_item_by_search() -- $sql_string 。");
       return NULL;
    }
    
    return $result;
}
////////////////////////////////// 4.search end //////////////////////////


////////////////////////////////// 5.period begin //////////////////////////
// 生成 period 查询之条件字句
function get_period_where_sub($begin_year, $end_year)
{
    if(!is_infinite($begin_year) && !is_infinite($end_year))
    {
        return " where ((year_order >= $begin_year) and (year_order <= $end_year)) ";
    }
    else if(is_infinite($begin_year) && is_infinite($end_year))
    {
        return "  ";
    }
    else if(is_infinite($begin_year))
    {
        return " where (year_order <= $end_year) ";
    }
    else if(is_infinite($end_year))
    {
        return " where (year_order >= $begin_year) ";
    }
}

// 根据 period 获取 thing 条目的数量
function get_thing_count_by_period($begin_year, $end_year)
{
    $sql_string = "select count(*) from thing_time " 
        . get_period_where_sub($begin_year, $end_year);
        
    $result = mysql_query($sql_string);
    
    if($result == FALSE)
    {
       $GLOBALS['log']->error("error: get_thing_count_by_period() -- $sql_string 。");
       return -1;
    }
    
    $row = mysql_fetch_row($result);    // 返回一行.
    return $row[0];
}

// 根据 period 获取 thing 表的数据
function get_thing_item_by_period($begin_year, $end_year, $offset, $page_size)
{
    $sql_string = "select * from thing_time " . get_period_where_sub($begin_year, $end_year)
        . " order by thing_time.year_order ASC limit $offset, $page_size ";
    
    $result = mysql_query($sql_string);
    if($result ==FALSE)
    {
       $GLOBALS['log']->error("error: get_thing_item_by_period() -- $sql_string 。");
       return NULL;
    }
    
    return $result;
}
////////////////////////////////// 5.period end //////////////////////////


////////////////////////////////// 6.property start //////////////////////////
// 将tag 插入数据库
function insert_tags($tags, $tags_type, $thing_uuid)
{
	$index = 0;

	if(strlen($tags) > 0)
	{
		$token = strtok($tags, ",");
			
		while(($token != false) && (strlen($token) > 0))
		{
			$tags_uuid = "";

			// 先检查是不是有重复。
			$sql_string = "select property_UUID from property 
				where property_name='$token' and property_type=$tags_type";

			$result = mysql_query($sql_string);
			if($result == FALSE)
            {
                $GLOBALS['log']->error("error: insert_tags() -- $sql_string 。");
                return -1;
            }

			if (mysql_num_rows($result) == 0)
			{
				$tags_uuid = create_guid();
					
				// 如果没有就插入标签表.
				$sql_string = "insert into property(property_UUID, property_name, property_type, add_time, user_UUID)
					VALUES('$tags_uuid', '$token', $tags_type, now(), '" . get_user_id() . "')";
					
				if (mysql_query($sql_string) === FALSE)
				{
					$GLOBALS['log']->error("error: insert_tags() -- $sql_string 。" . mysql_error());
                    return -1;
				}
			}
			else
			{
				$row = mysql_fetch_array($result);
				$tags_uuid = $row['property_UUID'];
			}

			// 插入事件-标签表
			$sql_string = "select property_UUID from thing_property
				where thing_UUID='$thing_uuid' and property_UUID='$tags_uuid'";

			$result = mysql_query($sql_string);
			if ($result == FALSE)
            {
                $GLOBALS['log']->error("error: insert_tags() -- $sql_string 。");
                return -1;
            }

			if (mysql_num_rows($result) == 0)
			{
				$index++;  // tag count.
				
				$sql_string = "insert into thing_property(thing_UUID, property_UUID, add_time, user_UUID)
					VALUES('$thing_uuid', '$tags_uuid', now(), '" . get_user_id() . "')";
					
				if (mysql_query($sql_string) === FALSE)
				{
					$GLOBALS['log']->error("Error: $sql_string , " . mysql_error());
					return -1;
				}
                // 更新 tag 的 hot 指数.
                update_tag_hot_index(1, $tags_uuid);
			}

			$token = strtok(",");
		}
	}
	
	return $index;
}

// 根据 user_uuid 获取 thing_tag 的数量
function get_thing_tag_count_by_user($user_uuid)
{
    $sql_string = "select count(*) from thing_property where user_UUID = '$user_uuid'";
    
    $result = mysql_query($sql_string);
    
    if($result == FALSE)
    {
       $GLOBALS['log']->error("error: get_thing_tag_count_by_user() -- $sql_string 。");
       return -1;
    }
    
    $row = mysql_fetch_row($result);    // 返回一行.
    return $row[0];
}

// 根据 user_uuid 获取 tag 的数量
function get_tag_count_by_user($user_uuid)
{
    $sql_string = "select count(*) from property where user_UUID = '$user_uuid'";
    
    $result = mysql_query($sql_string);
    
    if($result == FALSE)
    {
       $GLOBALS['log']->error("error: get_tag_count_by_user() -- $sql_string 。");
       return -1;
    }
    
    $row = mysql_fetch_row($result);    // 返回一行.
    return $row[0];
}

// 更新 tag 的 hot 指数
function update_tag_hot_index($add_hot_number, $tag_UUID)
{
    $sql_string = "update property set hot_index = ifNull(hot_index , 0) + " 
            . $add_hot_number . " where property_UUID = '" . $tag_UUID . "'";
    
    if (mysql_query($sql_string) === FALSE)
    {
        $GLOBALS['log']->error("Error: $sql_string , " . mysql_error());
        return false;
    }
    
    return true;
}


// 根据thing_uuid获取tags字符串
function get_tags_name($thing_uuid, $tag_type)
{
    $property_name_array[] = null;
    
	$sql_string = "select property_name from property where property_type=$tag_type and
		property_UUID in (select property_UUID from thing_property where thing_UUID='$thing_uuid')";

	$result = mysql_query($sql_string);
	if ($result == FALSE)
    {
        $GLOBALS['log']->error("error: get_tags_name() -- $sql_string 。");
        return NULL;
    }
		
	while($row = mysql_fetch_array($result))
	{
		$property_name_array[] = $row['property_name'];
	}
    
	return $property_name_array;
}

// 根据 uuid 获取name(此函数只允许 list_control.php.)
function get_tag_name_from_UUID($tag_UUID)
{
    $property_name = "";
    $sql_string = "select property_name from property where property_UUID='$tag_UUID' limit 0,1";
    
    $result = mysql_query($sql_string); 
    if($result == FALSE)
    {
        $GLOBALS['log']->error("error: get_tag_name() -- $tag_UUID -- $sql_string 。");
        return NULL;
    }
        
    while($row = mysql_fetch_array($result))
    {
        $property_name = $row['property_name'];
    }
    
    return $property_name;
}

// 获取符合条件的tags。
function get_tags_db($list_type, $tags_show_limit)
{
	switch ($list_type)
	{
		// 全部条目
		case 1:
		    // 全部条目容许显示的 tag 数量翻倍.
			$sql_string = "select property_UUID, property_name, property_type from property order by hot_index desc
			         limit 0, " . ($tags_show_limit * 2);
			break;

		// 我的关注
		case 2:
			$sql_string = "select property_UUID, property_name, property_type from property 
                    where property_UUID in(select property_UUID from follow
                    where user_UUID = '" . get_user_id() . "') order by hot_index desc
                    limit 0, " . $tags_show_limit;
			break;

		// 我的小组(暂无功能)
		case 3:
			$sql_string = "select property_UUID, property_name, property_type from property order by hot_index desc 
			         limit 0, " . $tags_show_limit;
			break;

		// 最热门(此项删除)
		case 4:
			$sql_string = "select property_UUID, property_name, property_type from property order by hot_index desc
                     limit 0, " . $tags_show_limit;
			break;

		// 最新，指1天内的
		case 5:
			$sql_string = "select property_UUID, property_name, property_type from property 
					where DATE_SUB(CURDATE(), INTERVAL 1 DAY) <= date(add_time) order by add_time DESC 
                    limit 0, " . $tags_show_limit;
			break;

		// 无标签, 不需要这条.
		case 6:
			return NULL;
			break;

		// 时代
		case 7:
			$sql_string = "select property_UUID, property_name, property_type from property
                     limit 0, " . $tags_show_limit;
			break;

		// 事件
		case 8:
			$sql_string = "select property_UUID, property_name, property_type from property 
					where property_type = 1 or property_type = 2  order by hot_index desc
                    limit 0, " . $tags_show_limit;
			break;

		// 人物
		case 9:
			$sql_string = "select property_UUID, property_name, property_type from property where property_type = 4 
			         order by hot_index desc limit 0, " . $tags_show_limit;
			break;

		// 地理
		case 10:
			$sql_string = "select property_UUID, property_name, property_type from property where property_type = 5 
			         order by hot_index desc limit 0, " . $tags_show_limit;
			break;

		// 出处
		case 11:
			$sql_string = "select property_UUID, property_name, property_type from property where property_type = 3 
			         order by hot_index desc limit 0, " . $tags_show_limit;
			break;
			
		// 国家民族
		case 12:
			$sql_string = "select property_UUID, property_name, property_type from property where property_type = 7 
			         order by hot_index desc limit 0, " . $tags_show_limit;
			break;

		// 事件特征
		case 13:
			$sql_string = "select property_UUID, property_name, property_type from property where property_type = 6 
			         order by hot_index desc limit 0, " . $tags_show_limit;
			break;
		default:
			$GLOBALS['log']->error("error: get_tags_db() -- list_type error 。");
			return NULL;
	}
	
    $result = mysql_query($sql_string);
    if ($result == FALSE)
    {
        $GLOBALS['log']->error("error: get_tags_db() -- $sql_string 。");
        $result = NULL;
    }

	return $result;
}

// 获取property数据表的数据
function get_tags_from_thing_UUID($thing_UUID)
{
	$sql_string = "select property_UUID, property_name, property_type from property where property_UUID in(
			select property_UUID from thing_property where thing_UUID = '$thing_UUID')";
	$result = mysql_query($sql_string);
    if($result == FALSE)
    {
        $GLOBALS['log']->error("error: get_tags_from_thing_UUID() -- $sql_string 。");
        return NULL;
    }
	
	return $result;
}

// 重新计算 thing 的时间轴指数
function re_calc_year_order()
{
    $sql_string = "update thing_time set year_order=time where time_type=2";
    if (!mysql_query($sql_string))
    {
        $GLOBALS['log']->error("error: re_calc_year_order() -- $sql_string 。");
        return 0;
    }
    
    $sql_string = "update thing_time set year_order=time+2015 where time_type=1";
    if (!mysql_query($sql_string))
    {
        $GLOBALS['log']->error("error: re_calc_year_order() -- $sql_string 。");
        return 0;
    }
    
    $sql_string = "select UUID, time, time_type from thing_time where time_type = 3 or time_type = 4";
    $result = mysql_query($sql_string);
    if ($result)
    {
        while($row = mysql_fetch_array($result))
        {
            $sql_string = "update thing_time set year_order=" . get_year_order($row['time'], 
                $row['time_type']) . " where UUID = '" . $row['UUID'] . "' ";
            if (!mysql_query($sql_string))
            {
                $GLOBALS['log']->error("error: re_calc_year_order() -- $sql_string 。");
                return 0;
            }
        }
    }
    else 
    {
        $GLOBALS['log']->error("error: re_calc_year_order() -- $sql_string 。");
        return 0;
    }
    
    return 1;
}

////////////////////////////////// 6.property end //////////////////////////



////////////////////////////////// 7.user start //////////////////////////
// 用户校验
function user_validate($user_name, $password)
{
	$password_md5 = MD5($password);
	$sql_string = "select user_UUID, user_right from user where user_name='$user_name' and password='$password_md5' limit 1";
	$check_query = mysql_query($sql_string);
    
    if($check_query == FALSE)
    {
        $GLOBALS['log']->error("error: user_validate() -- $sql_string 。");
        return array("user_UUID" => "", "user_right" => 0);
    }
    
	if($result = mysql_fetch_array($check_query))
	{
		return array("user_UUID" => $result['user_UUID'], 
		      "user_right" => $result['user_right']);
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

	$user_query = mysql_query("select user_name from user where user_UUID='$user_id' limit 1");
	if($user_query == FALSE)
    {
        $GLOBALS['log']->error("error: get_user_name_from_id() -- $sql_string 。");
        return "";
    }
	
	$row = mysql_fetch_array($user_query);

	return $row['user_name'];
}

// 根据user id 获取用户信息
function get_user_info($user_id)
{
	$user_query = mysql_query("select * from user where user_UUID='$user_id' limit 1");
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
	$sql_string = "select user_UUID from user where user_name='$user_name' limit 1";
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
	$password_md5 = MD5($password);
	
	$sql_string = "INSERT INTO user(user_UUID, user_name, password, user_right, email, add_time)
		VALUES('$user_UUID', '$user_name', '$password_md5', 11, '$email', now())";
        
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

////////////////////////////////// 7.user end //////////////////////////


////////////////////////////////// 8.follow start //////////////////////////
// 判断当前 tag 是否已关注
function is_followed($tag_uuid)
{
    $user_id = get_user_id();
    
    $sql_string = "select * from follow where property_UUID = '$tag_uuid' 
        and user_UUID = '$user_id'";
    if(($result = mysql_query($sql_string)) == FALSE)
    {
        $GLOBALS['log']->error("error: is_followed() -- $sql_string 。");
        return FALSE;
    }
    
    if (mysql_num_rows($result) > 0)
    {
        return TRUE;
    }
    else
    {
        return FALSE;
    }
}

// 获取多少人已关注.
function get_follows_count($tag_uuid)
{
    $sql_string = "select count(user_UUID) from follow where property_UUID = '$tag_uuid'";
    if(($result = mysql_query($sql_string)) == FALSE)
    {
        $GLOBALS['log']->error("error: get_follows_count() -- $sql_string 。");
        return -1;
    }
    $row = mysql_fetch_row($result);    // 返回一行.
    return $row[0];
}

// 将 follow 信息保存到数据库中去.
function insert_follow_to_db($tag_uuid)
{
    $user_id = get_user_id();
    // 是否已关注.
    if(is_followed($tag_uuid) == FALSE)
    {
        $sql_string = "INSERT INTO follow(property_UUID, user_UUID, add_time)
            VALUES('$tag_uuid', '$user_id', now())";
        
        if(mysql_query($sql_string))
        {
            // 完成加分.
            update_tag_hot_index(5, $tag_uuid);
            return 1;
        }
        else
        {
            $GLOBALS['log']->error("error: insert_follow_to_db() -- $sql_string 。");
            return 0;
        }
    }
}

// 删除 follow 信息
function delete_follow_to_db($tag_uuid)
{
    $user_id = get_user_id();
    if(is_followed($tag_uuid) == TRUE)
    {
        $sql_string = "delete from follow where property_UUID = '$tag_uuid' and user_UUID = '$user_id'";
        if(mysql_query($sql_string))
        {
            // 完成减分.
            update_tag_hot_index(-5, $tag_uuid);
            return 1;
        }
        else
        {
            $GLOBALS['log']->error("error: delete_follow_to_db() -- $sql_string 。");
            return 0;
        }
    }
    
}

////////////////////////////////// 8.follow end //////////////////////////


?>