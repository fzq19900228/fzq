<?php 
//存储在数据库中
	// 日志存在文件中
	namespace core\lib\dirve\log;
	use core\lib\config;
	use core\lib\model;
	class mysql
	{
		static public $dbname;
		static public $content;
		public function __construct()
		{
			$db = config::get('OPTION','log');
			self::$dbname = $db['DBNAME'];
			self::$content = $db['CONTENT'];
		}
		public function log($message)
		{
			$dbname = self::$dbname; //表名
			$w[self::$content] = $message;
			$w['add_time'] = time();
			$model = new model();
			$model->insert(self::$dbname,$w);
		}
	}