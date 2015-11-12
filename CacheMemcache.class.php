<?php 

/**
 *  CacheMemcache 类
 *
 * @package lib
 * @subpackage plugins.cache
 * @author 祝清明
 */
class CacheMemcache
{
	/**
	 * @var Memcache $memcache Memcached 缓存连接对象
	 * @access public
	 */
	var $memcache = NULL;    
    
	/**
	 * 构造函数(兼容PHP4)
	 * @param string $host Memcached 服务器的主机名或IP地址
	 * @param int $port 端口号
	 * @param boolean $persistent 是否持久化连接
	 * @param int $timeout 超时时间
	 */
	function CacheMemcache($host = '127.0.0.1', $port = 11211, $persistent = FALSE, $timeout = 0) 
	{
    	$this->__construct($host, $port, $persistent, $timeout);
    }
	
	/**
	 * 构造函数
	 * @param string $host Memcached 服务器的主机名或IP地址或者为服务器组相关信息
	 * @param int $port 端口号
	 * @param int $timeout 超时时间
	 */
	function __construct($host = '127.0.0.1', $port = 11211, $persistent = FALSE, $timeout = 0) 
	{
    	$this->memcache = new Memcache();
    	$func = $persistent ? 'pconnect' : 'connect';
    	if ($timeout === 0) 
    	{
    		$result = $this->memcache->$func($host, $port);
    	}
    	else
    	{
    		$result = $this->memcache->$func($host, $port, $timeout);
    	}
    }
	
	/**
	 * 析构函数
	 */
	function __destruct() 
	{
    	return $this->memcache->close();
    }
	
	/**
	 * 在cache中设置键为$key的项的值，如果该项不存在，则新建一个项
	 * @param string $key 键值
	 * @param mix $var 值
	 * @param int $expire 到期秒数
	 * @return bool 如果成功则返回 TRUE，失败则返回 FALSE。
	 * @access public
	 */
    function set($key, $var, $expire = 0) 
    {
		return $this->memcache->set($key, $var, 0, $expire);
	}
	
	
	/**
	 * 在cache中获取键为$key的项的值
	 * @param string $key 键值
	 * @return string 如果该项不存在，则返回false
	 * @access public
	 */
    function get($key) 
    {
		return $this->memcache->get($key);
	}
	
	
	/**
	 * 在MC中获取为$key的自增ID
	 *
	 * @param string $key	 自增$key键值
	 * @param integer $count 自增量,默认为1
	 * @return 				 成功返回自增后的数值,失败返回false
	 */
	function increment($key, $count = 1) 
	{
		return $this->memcache->increment($key, $count);
	}
	
	
	/**
	 * 清空cache中所有项
	 * @return 如果成功则返回 TRUE，失败则返回 FALSE。
	 * @access public
	 */
    function flush() 
    {
		return $this->memcache->flush();
	}
	
	
	/**
	 * 删除在cache中键为$key的项的值
	 * @param string $key 键值
	 * @return 如果成功则返回 TRUE，失败则返回 FALSE。
	 * @access public
	 */
    function delete($key) 
    {		
		return $this->memcache->delete($key);
	}
}

$memcache = new CacheMemcache('192.168.1.226', '12000', FALSE, 0);


?>