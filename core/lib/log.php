<?php 
	namespace core\lib;
	use core\lib\config;
	class log
	{
		/**
		 * 1. 确认日志的存储方式
		 * 2.写日志
		*/
		static public $class;
		static public function init()
		{
			//查看配置文件 获取日志储存方式
			$dirve = config::get('DRIVE','log');
			$class = '\core\lib\dirve\log\\'.$dirve;
			self::$class=new $class;
		}
		static function log($message)
		{
			self::$class->log($message);
		}
	}
