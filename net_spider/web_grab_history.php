<?php

//include_once './config.php';
include_once './mysql_insert.php';


class web_grab_history {
	var $m_db_op;
	var $m_oldhistory;   // 从数据库读入的爬虫记录。
	var $m_newhistory;   // 当前访问的爬虫记录。
	var $m_subkey;
	
    /**
     * 初始化数据库操作类。
     */
	function __construct($db_op) {
		$this->m_db_op = $db_op;
		//$db_op->get_grab_history($this->m_oldhistory);
	}
	
    /**
     * 逐个保存爬虫历史记录，防止重复。
     */
	function save_history() 
	{
		foreach($this->m_newhistory as $md5 => $url) 
		{
			$this->m_db_op->add_history($url, $md5);
		}
	}

    /**
     * 记录 url md5值，并加载历史记录。
     */
	function load_subkey($subkey) 
	{
		$this->m_subkey[$subkey] = $subkey;
		$this->m_db_op->get_grab_history($this->m_oldhistory, $subkey);
	}
	
	function __destruct() {}
	
    /**
     * 判断超链接是否重复。
     */
	function have_key($url) {
		$ret = false;
		$md5 = md5($url);
		$subkey = $md5[0] . $md5[1] . $md5[2];

        // 什么意思？过滤掉压缩包吗？
		if (strstr($url, "rar") > 0) 
		{
			return true;
		}

        // 如果已经有了，不作处理。
		if (count($this->m_subkey) > 0 && array_key_exists($subkey, $this->m_subkey) == true) 
		{
		    // 
		}
		else
		{
		    // 如果没有则记录。
			$this->load_subkey($subkey);
		}

		if (count($this->m_oldhistory)) 
		{
			//$ret |= array_key_exists($url, $this->m_oldhistory);
			$ret |= array_key_exists($md5, $this->m_oldhistory);
		}
        // 如果历史数据表中有，则说明历史访问过，直接退出。
		if ($ret == true) 
		{
			return $ret;
		}
		
        // 返回当前爬虫记录中的状态。
		if (count($this->m_newhistory)) {
			$ret |= array_key_exists($md5, $this->m_newhistory);
		}
		return $ret;		
	}
	
    /**
     * 添加 url md5信息到数组。
     */
	function add_key($url) 
	{
		$md5 = md5($url);
		$this->m_newhistory[$md5] = $url;
        
        // 如果记录大于400，准备干吗？
	    if (count($this->m_newhistory) > 400)
	    {
			//
		}	
	}
}


?>


