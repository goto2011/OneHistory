<?php
// created by duangan, 2016-02-06 -->
// support data deal function.    -->

// sql 对象类型。
class sql_object {
    const CONST_SEARCH      =   1;
    const CONST_PERIOD      =   2;
    const CONST_TAG         =   3;
    const CONST_TAG_TYPE    =   4;
};

// sql 类型。
class sql_type {
    const CONST_GET_THING_COUNT     =   1;
    const CONST_GET_TAGS            =   2;
    const CONST_GET_THING_ITEMS     =   3;
};

// 生成SQL语句。
function get_sql_qurey($sql_object, $sql_type, $sql_param)
{
    switch ($sql_object) {
        case sql_object::CONST_SEARCH:
            
            // 基于检索字符串获取查询子句。
            $where_sub = get_search_where_sub_native($sql_param['search_key']) . " ";
            $search_tag_uuid = $sql_param['tag_uuid'];
            $search_tag_type = $sql_param['tag_type'];
            if ($sql_param['has_period'] == TRUE)
            {
                $begin_year = $sql_param['begin_year'];
                $end_year = $sql_param['end_year'];
            }
            
            switch ($sql_type) {
                case sql_type::CONST_GET_THING_COUNT:
                    // tag_uuid 优先。
                    if ($search_tag_uuid != "")
                    {
                        return "select count(distinct a.uuid) from thing_time a inner join thing_property c on $where_sub 
                            and a.uuid = c.thing_UUID and c.property_UUID = '$search_tag_uuid' ";
                    }
                    else if ($search_tag_type > 0)
                    {
                        return "select count(distinct a.uuid) from thing_time a 
                            inner join thing_property c on $where_sub and a.uuid = c.thing_UUID 
                            inner join property b on b.property_UUID = c.property_UUID and b.property_type = $search_tag_type ";
                    }
                    else if ($sql_param['has_period'] == TRUE)
                    {
                        return "select count(distinct a.uuid) from thing_time a where ( $where_sub ) 
                            and a.year_order >= $begin_year and a.year_order < $end_year ";
                    }
                    else
                    {
                        return "select count(distinct a.uuid) from thing_time a where $where_sub ";
                    }
                    break;
                case sql_type::CONST_GET_TAGS:
                    // tag_uuid 优先。
                    if ($search_tag_uuid != "")
                    {
                        return "select b.property_UUID, b.property_name, b.property_type, b.hot_index, c.thing_UUID from property b 
                            inner join thing_property c on b.property_UUID=c.property_UUID and c.property_UUID = '$search_tag_uuid' 
                            inner join thing_time a on $where_sub and c.thing_UUID = a.uuid ";
                    }
                    else if ($search_tag_type > 0)
                    {
                        return "select b.property_UUID, b.property_name, b.property_type, b.hot_index, c.thing_UUID from property b 
                            inner join thing_property c on b.property_UUID=c.property_UUID and b.property_type = $search_tag_type 
                            inner join thing_time a on $where_sub and c.thing_UUID = a.uuid ";
                    }
                    else if ($sql_param['has_period'] == TRUE)
                    {
                        return "select b.property_UUID, b.property_name, b.property_type, b.hot_index, c.thing_UUID from property b 
                            inner join thing_property c on b.property_UUID=c.property_UUID
                            inner join thing_time a on ( $where_sub ) and a.year_order >= $begin_year and a.year_order < $end_year and c.thing_UUID = a.uuid ";
                    }
                    else
                    {
                        return "select b.property_UUID, b.property_name, b.property_type, b.hot_index, c.thing_UUID from property b 
                            inner join thing_property c on b.property_UUID=c.property_UUID 
                            inner join thing_time a on $where_sub and c.thing_UUID = a.uuid ";;
                    }
                    break;
                case sql_type::CONST_GET_THING_ITEMS:
                    // tag_uuid 优先。
                    if ($search_tag_uuid != "")
                    {
                        return "select distinct a.* from thing_time a 
                            inner join thing_property c on $where_sub 
                            and a.uuid = c.thing_UUID and c.property_UUID = '$search_tag_uuid' ";
                    }
                    else if ($search_tag_type > 0)
                    {
                        return "select distinct a.* from thing_time a 
                            inner join thing_property c on $where_sub and a.uuid = c.thing_UUID 
                            inner join property b on b.property_UUID = c.property_UUID and b.property_type = $search_tag_type ";
                    }
                    else if ($sql_param['has_period'] == TRUE)
                    {
                        return "select distinct a.* from thing_time a where ( $where_sub ) 
                            and a.year_order >= $begin_year and a.year_order < $end_year ";
                    }
                    else
                    {
                        return "select distinct a.* from thing_time a where $where_sub ";
                    }
                    break;
                
                default:
                    
                    break;
            }
            break;
        case sql_object::CONST_PERIOD:
            $begin_year = $sql_param['begin_year'];
            $end_year = $sql_param['end_year'];
            
            switch ($sql_type) {
                case sql_type::CONST_GET_THING_COUNT:
                    if(!is_infinite($begin_year) && !is_infinite($end_year))
                    {
                        return "select count(distinct a.uuid) from thing_time a 
                            where ((year_order >= $begin_year) and (year_order <= $end_year)) ";
                    }
                    else if(is_infinite($begin_year) && is_infinite($end_year))
                    {
                        return "select count(distinct a.uuid) ";
                    }
                    else if(is_infinite($begin_year))
                    {
                        return "select count(distinct a.uuid) from thing_time a where (year_order <= $end_year) ";
                    }
                    else if(is_infinite($end_year))
                    {
                        return "select count(distinct a.uuid) from thing_time a where (year_order >= $begin_year) ";
                    }
                    break;
                case sql_type::CONST_GET_TAGS:
                    if(!is_infinite($begin_year) && !is_infinite($end_year))
                    {
                        return "select b.property_UUID, b.property_name, b.property_type, b.hot_index, c.thing_UUID from property b 
                            inner join thing_property c on b.property_UUID=c.property_UUID 
                            inner join thing_time a on c.thing_UUID = a.uuid and ((a.year_order >= $begin_year) and (a.year_order <= $end_year)) ";
                    }
                    else if(is_infinite($begin_year) && is_infinite($end_year))
                    {
                        return "select b.property_UUID, b.property_name, b.property_type, b.hot_index, c.thing_UUID from property b 
                                inner join thing_property c on b.property_UUID=c.property_UUID ";
                    }
                    else if(is_infinite($begin_year))
                    {
                        return "select b.property_UUID, b.property_name, b.property_type, b.hot_index, c.thing_UUID from property b 
                            inner join thing_property c on b.property_UUID=c.property_UUID
                            inner join thing_time a on c.thing_UUID = a.uuid and a.year_order <= $end_year";
                    }
                    else if(is_infinite($end_year))
                    {
                        return "select b.property_UUID, b.property_name, b.property_type, b.hot_index, c.thing_UUID from property b 
                            inner join thing_property c on b.property_UUID=c.property_UUID
                            inner join thing_time a on c.thing_UUID = a.uuid and a.year_order >= $begin_year ";
                    }
                    
                    break;
                case sql_type::CONST_GET_THING_ITEMS:
                    if(!is_infinite($begin_year) && !is_infinite($end_year))
                    {
                        return "select distinct a.* from thing_time a where ((year_order >= $begin_year) and (year_order <= $end_year)) ";
                    }
                    else if(is_infinite($begin_year) && is_infinite($end_year))
                    {
                        return "select distinct a.* ";
                    }
                    else if(is_infinite($begin_year))
                    {
                        return "select distinct a.* from thing_time a where (year_order <= $end_year) ";
                    }
                    else if(is_infinite($end_year))
                    {
                        return "select distinct a.* from thing_time a where (year_order >= $begin_year) ";
                    }
                    break;
                
                default:
                    
                    break;
            }
            
            break;
        case sql_object::CONST_TAG:
            $property_UUID = $sql_param['tag_id'];
            
            switch ($sql_type) {
                case sql_type::CONST_GET_THING_COUNT:
                    return "select count(distinct a.uuid) from thing_time a 
                            inner join thing_property b ON a.UUID=b.thing_UUID and b.property_UUID = '$property_UUID' ";
                    break;
                case sql_type::CONST_GET_TAGS:
                    return "select b.property_UUID, b.property_name, b.property_type, b.hot_index, c.thing_UUID from property b 
                            inner join thing_property c on b.property_UUID=c.property_UUID and c.property_UUID = '$property_UUID'
                            inner join thing_time a on c.thing_UUID = a.uuid ";
                    break;
                case sql_type::CONST_GET_THING_ITEMS:
                    return "select distinct a.* from thing_time a
                            inner join thing_property b on a.UUID=b.thing_UUID  and b.property_UUID = '$property_UUID' ";
                    break;
                
                default:
                    
                    break;
            }
            
            break;
        case sql_object::CONST_TAG_TYPE:
            $tag_type = $sql_param['tag_type'];
            
            switch ($sql_type) {
                case sql_type::CONST_GET_THING_COUNT:
                        switch ($tag_type)
                        {
                            // 全部条目
                            case tab_type::CONST_TOTAL:
                                return "select count(distinct a.uuid) from thing_time a ";
                                break;
                            // 我的关注
                            case tab_type::CONST_MY_FOLLOW:
                                return "select count(distinct a.uuid) from thing_time a 
                                    inner join thing_property c on a.UUID = c.thing_UUID 
                                    inner join follow e on e.property_UUID = c.property_UUID 
                                    and e.user_UUID = '" . get_user_id() . "' ";
                                break;
                            // 最新，指7天内新建的标签(暂时删除)
                            case tab_type::CONST_NEWEST:
                                return "select count(distinct a.uuid) from thing_time a 
                                    inner join thing_property c on a.UUID = c.thing_UUID  
                                    inner join property b on b.property_UUID = c.property_UUID 
                                    and DATE_SUB(CURDATE(), INTERVAL 1 WEEK) <= date(b.add_time) ";
                                break;
                            // 分期
                            case tab_type::CONST_PERIOD:
                                return "select count(distinct a.uuid) from thing_time a ";
                                break;
                            default:
                                if ($tag_type > 0)
                                {
                                    return "select count(distinct a.uuid) from thing_time a 
                                        inner join thing_property c on c.thing_UUID = a.UUID
                                        inner join property b on b.property_UUID = c.property_UUID and b.property_type = $tag_type ";
                                }
                                else
                                {
                                    $GLOBALS['log']->error("error: get_sql_qurey() -- tag_id error 。");
                                    return "";
                                }
                        }
                    break;
                    
                case sql_type::CONST_GET_TAGS:
                        switch ($tag_type)
                        {
                            // 全部条目
                            case tab_type::CONST_TOTAL:
                                return "select b.property_UUID, b.property_name, b.property_type, b.hot_index, c.thing_UUID from property b 
                                        inner join thing_property c on b.property_UUID=c.property_UUID 
                                        inner join thing_time a on c.thing_UUID = a.uuid ";
                                break;
                            // 我的关注
                            case tab_type::CONST_MY_FOLLOW:
                                return "select b.property_UUID, b.property_name, b.property_type, b.hot_index, c.thing_UUID from property b 
                                        inner join thing_property c on b.property_UUID=c.property_UUID 
                                        inner join thing_time a on c.thing_UUID = a.uuid 
                                        inner join follow e on e.property_UUID = b.property_UUID and e.user_UUID = '" . get_user_id() . "' ";
                                break;
                            // 最新，指7天内新建的标签(暂时删除)
                            case tab_type::CONST_NEWEST:
                                return "select b.property_UUID, b.property_name, b.property_type, b.hot_index, c.thing_UUID from property b 
                                        inner join thing_property c on b.property_UUID=c.property_UUID 
                                        and DATE_SUB(CURDATE(), INTERVAL 1 WEEK) <= date(b.add_time)
                                        inner join thing_time a on c.thing_UUID = a.uuid ";
                                break;
                            // 分期
                            case tab_type::CONST_PERIOD:
                                return "select b.property_UUID, b.property_name, b.property_type, b.hot_index, c.thing_UUID from property b 
                                        inner join thing_property c on b.property_UUID=c.property_UUID 
                                        inner join thing_time a on c.thing_UUID = a.uuid ";
                                break;
                            default:
                                if ($tag_type > 0)
                                {
                                    return "SELECT b.property_UUID, b.property_name, b.property_type, b.hot_index, c.thing_UUID
                                        FROM property b, thing_property c, thing_time a 
                                        where b.property_type=$tag_type and b.property_UUID = c.property_UUID AND c.thing_UUID = a.uuid ";
                                }
                                else
                                {
                                    $GLOBALS['log']->error("error: get_sql_qurey() -- tag_id error 。");
                                    return "";
                                }
                         }
                    break;
                case sql_type::CONST_GET_THING_ITEMS:
                        switch ($tag_type)
                        {
                            // 全部条目
                            case tab_type::CONST_TOTAL:
                                return "select distinct a.* from thing_time a ";
                                break;
                            // 我的关注
                            case tab_type::CONST_MY_FOLLOW:
                                return "select distinct a.* from thing_time a 
                                    inner join thing_property c on a.UUID = c.thing_UUID 
                                    inner join follow e on e.property_UUID = c.property_UUID 
                                    and e.user_UUID = '" . get_user_id() . "' ";
                                break;
                            // 最新，指7天内新建的标签(暂时删除)
                            case tab_type::CONST_NEWEST:
                                return "select distinct a.* from thing_time a 
                                    inner join thing_property c on a.UUID = c.thing_UUID  
                                    inner join property b on b.property_UUID = c.property_UUID 
                                    and DATE_SUB(CURDATE(), INTERVAL 1 WEEK) <= date(b.add_time) ";
                                break;
                            // 分期
                            case tab_type::CONST_PERIOD:
                                return "select distinct a.* from thing_time a ";
                                break;
                            default:
                                if ($tag_type > 0)
                                {
                                    return "select distinct a.* from thing_time a
                                            inner join thing_property c on c.thing_UUID = a.UUID
                                            inner join property b on b.property_UUID = c.property_UUID 
                                            and b.property_type = $tag_type ";
                                }
                                else
                                {
                                    $GLOBALS['log']->error("error: get_sql_qurey() -- $tag_type error 。");
                                    return "";
                                }
                        }
                    break;
                
                default:
                    
                    break;
            } // $sql_type
            
            break;
        default:
            
            break;
    } // $sql_object
}


?>