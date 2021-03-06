<?php
// created by duangan, 2015-8-9 -->
// support vip tag class.    -->

require_once "tag_period.php";
require_once "tag_dynasty.php";
require_once "tag_country.php";
require_once "tag_topic.php";
// require_once "tag_city.php";
require_once "tag_person.php";
// require_once "tag_key_thing.php";
// require_once "tag_land.php";
require_once "tag_war.php";
require_once "tag_solution.php";

// 变量列表：
// 1. big name: 即分类名称。
// 2. vip tag struct: 即vip tag的数据结构。

/** vip tag struct的字段列表：
 * 1. tag name：tag显示名称。如果只有这一个字段，则各属性为：normal+sigle-key，且关键字即为tag显示名称（绝大多数如此）。
 * 2. show flag: tag显示属性。有3种：
 *      “super” 标签会加粗加大字体。
 *      “normal” 普通字体。默认值为normal。
 *      “hide” 标签不显示在tab页，但会显示在事件的标签字段中。
 *  允许这样定义： [tag name][super]，即各属性为super+sigle-key，且关键字即为tag显示名称。
 * 3. search flag: 检索属性。有如下：
 *      sigle-key: 单关键字。
 *      multe-key: 多关键字。需要指定。
 *      key-time : 关键字和时间区间的组合。支持多个关键字。支持2个时间字段。需要指定。
 *      key-time3: 关键字和时间区间的组合，支持多个关键字。支持3个时间字段。需要指定。
 *      tag-time : 指定tag和时间区间的组合。需要指定。（目前仅用于 中国朝代 tab页 之 正朔朝代。仅支持一个。
 * 4. 检索关键字。
 * 5. 时间范围字段 begin year/end year 总是放在最后两个，且只支持年份。
 *      对于key-time是这样的：[tag name][show flag][search flag][key1][key2][key3][begin year][end year].
 *      对于tag-time是这样的：[tag name][show flag][search flag][tag name][begin year][end year].
 * 6. 简写模式：只允许1、2这两种，其它则必须写完整形式。注意，除1、2两种外，其它形式中tag显示名称不算在关键字范围内。
**/
class vip_tag_class{
    private $vip_tag_big_name;
    private $vip_tag_struct;
    
    public function vip_tag_class($vip_tag_big_name, $vip_tag_struct)
    {
        $this->vip_tag_big_name = $vip_tag_big_name;
        $this->vip_tag_struct = $vip_tag_struct;
    }
    
    /**
     * get big name.
     */
    public function get_big_name($index)
    {
        return $this->vip_tag_big_name[$index - 1];
    }

    /**
     * 获取 big id begin.
     */
    public function get_big_begin()
    {
        return 1;   // 从1开始方便通过 GET 传递.
    }
    
    /**
     * 获取 big id end.
     */
    public function get_big_end()
    {
        return count($this->vip_tag_struct);
    }
    
    /**
     * 获取 small id begin.
     */
    public function get_small_begin($big_id)
    {
        return 1;
    }
    
    /**
     * 获取 small id end.
     */
    public function get_small_end($big_id)
    {
        return count($this->vip_tag_struct[$big_id - 1]);
    }
    
    /**
     * 获取 vig tag 对象。
     */
    public function get_vip_tag($big_id, $small_id)
    {
        return $this->vip_tag_struct[$big_id - 1][$small_id - 1];
    }
    
    /**
     * 获取 tag 名称.
     */
    public function get_tag_name($big_id, $small_id)
    {
        return $this->vip_tag_struct[$big_id - 1][$small_id - 1][0];
    }
    
    /**
     * 获取 vip tag 的显示属性.
     */
    public function get_tag_show_flag($big_id, $small_id)
    {
        // 如果只有这一个字段，则各属性为：normal+sigle-key，且关键字即为tag显示名称（绝大多数如此）。
        if (count($this->get_vip_tag($big_id, $small_id)) == 1)
        {
            return "normal";
        }
        else 
        {
            return $this->vip_tag_struct[$big_id - 1][$small_id - 1][1];
        }
    }
    
    /**
     * 获取 vip tag 的检索属性.
     */
    public function get_tag_search_flag($big_id, $small_id)
    {
        // 如果只有这一个字段，则各属性为：normal+sigle-key，且关键字即为tag显示名称（绝大多数如此）。
        // 如果有两个字段，则属性为sigle-key，且关键字即为tag显示名称。
        $tag_param_count = count($this->get_vip_tag($big_id, $small_id)); 
        if (($tag_param_count == 1) || ($tag_param_count == 2))
        {
            return "sigle-key";
        }
        else 
        {
            return $this->vip_tag_struct[$big_id - 1][$small_id - 1][2];
        }
    }
    
    /**
     * 获取 vip tag 的单关键字. 失败返回"".
     */
    public function get_tag_single_key($big_id, $small_id)
    {
        $my_vip_tag = $this->get_vip_tag($big_id, $small_id);
        
        // 如果只有这一个字段，则各属性为：normal+sigle-key，且关键字即为tag显示名称（绝大多数如此）。
        // 如果有两个字段，则属性为sigle-key，且关键字即为tag显示名称。
        if ((count($my_vip_tag) == 1) || (count($my_vip_tag) == 2))
        {
            return $my_vip_tag[0];
        }
        else if ($this->get_tag_search_flag($big_id, $small_id) == "sigle-key")
        {
            return $my_vip_tag[3];
        }
        else
        {
            return "";
        }
    }
    
    /**
     * 获取 vip tag 的多关键字，各关键字按空格分开. 失败返回"".
     */
    public function get_tag_multe_key($big_id, $small_id)
    {
        if ($this->get_tag_search_flag($big_id, $small_id) == "multe-key")
        {
            $my_vip_tag = $this->vip_tag_struct[$big_id - 1][$small_id - 1];
            
            // 多关键字的情况下，tag显示名称 默认为也参与检索。--这一点去掉。
            // $my_key_string = $my_vip_tag[0] . " ";
            
            for ($ii = 3; $ii < count($my_vip_tag); $ii++)
            {
                $my_key_string .= $my_vip_tag[$ii] . " ";
            }
            
            return $my_key_string;
        }
        else 
        {
            return "";
        }
    }
    
    /**
     * 根据 flag 返回时间字段的数量
     */
    private function get_time_count($vip_tag_flag){
        $my_time_count = 0;
        if ($vip_tag_flag == "key-time") {
            $my_time_count = 2;
        } else if ($vip_tag_flag == "key-time3") {
            $my_time_count = 3;
        }
        
        return $my_time_count;
    }
    
    /**
     * 获取 vip tag 的 key-time 之 key。失败返回""。
     */
    public function get_key_time_key($big_id, $small_id)
    {
        $my_flag = $this->get_tag_search_flag($big_id, $small_id);
        $my_time_count = $this->get_time_count($my_flag);
        
        if (($my_flag == "key-time") || ($my_flag == "key-time3"))
        {
            $my_vip_tag = $this->get_vip_tag($big_id, $small_id);
            
            // tag显示名称 默认为也参与检索。
            $my_key_string = $my_vip_tag[0] . " ";
            
            for ($ii = 3; $ii < count($my_vip_tag) - $my_time_count; $ii++)
            {
                $my_key_string .= $my_vip_tag[$ii] . " ";
            }
            return $my_key_string;
        }
        else 
        {
            return "";
        }
    }
    
    /**
     * 根据数字字段的位置id，获取指定的数字字段。
     * $time_index = 0, begin year
     * $time_index = 1, big year
     * $time_index = 2, end year
     */
    private function get_time_by_index($big_id, $small_id, $time_index)
    {
        $my_flag = $this->get_tag_search_flag($big_id, $small_id);
        $my_time_count = $this->get_time_count($my_flag);
        
        if (($my_flag != "key-time") && ($my_flag != "key-time3")) {
            return 0;
        }
        if (($my_flag != "key-time3") && ($time_index == 1)){
            return 0;
        }
        // key-time 的 $time_index 要做调整。
        if (($my_flag == "key-time") && ($time_index == 2)) {
            $time_index = 1;
        }
        
        if (($my_flag == "key-time") || ($my_flag == "key-time3")) {
            $my_vip_tag = $this->get_vip_tag($big_id, $small_id);
            return $my_vip_tag[count($my_vip_tag) - $my_time_count + $time_index];
        } else {
            return 0;
        }
    }
    
    /**
     * 获取 vip tag 的 key-time 之 begin year。失败返回0。
     */
    public function get_key_time_begin_year($big_id, $small_id)
    {
        // 第一个数字默认为 begin year.
        return $this->get_time_by_index($big_id, $small_id, 0);
    }
    
    /**
     * 获取 vip tag 的 key-time 之 big year。失败返回0。
     */
    public function get_key_time_big_day($big_id, $small_id)
    {
        return $this->get_time_by_index($big_id, $small_id, 1);
    }
    
    /**
     * 获取 vip tag 的 key-time 之 end year。失败返回0。
     */
    public function get_key_time_end_year($big_id, $small_id)
    {
        // 最后一个数字默认为 end year.
        return $this->get_time_by_index($big_id, $small_id, 2);
    }
    
    /**
     * 获取 vip tag 的 tag-time 之 tag。失败返回""。
     */
    public function get_tag_time_tag($big_id, $small_id)
    {
        if ($this->get_tag_search_flag($big_id, $small_id) == "tag-time")
        {
            return $this->vip_tag_struct[$big_id - 1][$small_id - 1][3];
        }
        else 
        {
            return "";
        }
    }
    
    /**
     * 获取 vip tag 的 tag-time 之 begin year。失败返回0。
     */
    public function get_tag_time_begin_year($big_id, $small_id)
    {
        if ($this->get_tag_search_flag($big_id, $small_id) == "tag-time")
        {
            return $this->vip_tag_struct[$big_id - 1][$small_id - 1][4];
        }
        else 
        {
            return 0;
        }
    }
    
    /**
     * 获取 vip tag 的 tag-time 之 end year。失败返回0。
     */
    public function get_tag_time_end_year($big_id, $small_id)
    {
        if ($this->get_tag_search_flag($big_id, $small_id) == "tag-time")
        {
            return $this->vip_tag_struct[$big_id - 1][$small_id - 1][5];
        }
        else 
        {
            return 0;
        }
    }
    
    // 获取指定tag是否存在. =1 表示存在； =0表示不存在。
    public function tag_is_exist($tag_name)
    {
        for ($ii = $this->get_big_begin(); $ii <= $this->get_big_end(); $ii++)
        {
            for ($jj = $this->get_small_begin($ii); $jj <= $this->get_small_end($ii); $jj++)
            {
                if($this->get_tag_name($ii, $jj) == $tag_name)
                {
                    return 1;
                }
            }
        }
        
        return 0;
    }
}

/** 
 * vip_tag_init: 根据制定 tag type id 初始化 vip_tag_struct。
 * 
 *  array(tab_type::CONST_TOPIC,          "领域",            1,    1,      "topic_tags"),      // vip tag.
    array(tab_type::CONST_COUNTRY,        "国家民族",         1,    1,      "country_tags"),    // vip tag.
    array(tab_type::CONST_DYNASTY,        "中国朝代",         1,    1,      "dynasty_tags"),    // vip tag.
    array(tab_type::CONST_LAND,           "地理",            1,    1,      "land_tags"),       // vip tag.
    array(tab_type::CONST_CITY,           "城市",            1,    1,      "geography_tags"),  // vip tag.
    array(tab_type::CONST_PERSON,         "人物",            1,    1,      "person_tags"),     // vip tag.
    array(tab_type::CONST_KEY_THING,      "关键事件",         1,    1,      "key_tags"),        // vip tag.
 */
function vip_tag_struct_init($vip_tag_id)
{
    $vip_tag_struct;
    
    switch ($vip_tag_id) {
        // add, 2016-01-10
        case tab_type::CONST_DIE:
            global $die_big;
            global $die;
            $vip_tag_struct = new vip_tag_class($die_big, $die);
            break;
        
        // add, 2016-02-25
        case tab_type::CONST_SOLUTION:
            global $solution_big;
            global $solution;
            $vip_tag_struct = new vip_tag_class($solution_big, $solution);
            break;
        
        case tab_type::CONST_TOPIC:
            global $topic_big;
            global $topic;
            $vip_tag_struct = new vip_tag_class($topic_big, $topic);
            break;
            
        case tab_type::CONST_COUNTRY:
            global $country_big;
            global $country;
            $vip_tag_struct = new vip_tag_class($country_big, $country);
            break;
            
        case tab_type::CONST_DYNASTY:
            global $dynasty_big;
            global $dynasty;
            $vip_tag_struct = new vip_tag_class($dynasty_big, $dynasty);
            break;
            
        case tab_type::CONST_LAND:
            global $land_big;
            global $land;
            $vip_tag_struct = new vip_tag_class($land_big, $land);
            break;
            
        case tab_type::CONST_CITY:
            global $city_big;
            global $city;
            $vip_tag_struct = new vip_tag_class($city_big, $city);
            break;
            
        case tab_type::CONST_PERSON:
            global $person;
            global $person_big;
            $vip_tag_struct = new vip_tag_class($person_big, $person);
            break;
            
        case tab_type::CONST_KEY_THING:
            global $key_thing_big;
            global $key_thing;
            $vip_tag_struct = new vip_tag_class($key_thing_big, $key_thing);
            break;
            
        default:
            $GLOBALS['log']->error("error: vip_tag_struct_init() -- $vip_tag_id 。");
            $vip_tag_struct = NULL;
            break;
    }
    
    return $vip_tag_struct;
} 

?>