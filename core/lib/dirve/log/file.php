<?php 
	// 日志存在文件中
	namespace core\lib\dirve\log;
	use core\lib\config;
	class file
	{
		public $path;
		public $file;
		public function __construct()
		{
			$conf= config::get('OPTION','log'); 
			$this->path  = $conf['PATH'];
			$this->file = $conf['FILE'];
		}
		public function log($message)
		{
			/**
			 * 
			 * 1.确认文件储存位置问价是否存在
			 *   新建目录
			 * 2.写入日志
			 * 
			 */
			if(!is_file($this->path.$this->file.'.php'))
			{
				mkdir($this->path,'0777',true);
			}
			return file_put_contents($this->path.$this->file.'.php', date('Y-m-d H:i:s').json_encode($message).PHP_EOL,FILE_APPEND);
		}
	}