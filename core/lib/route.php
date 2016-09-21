<?php
	namespace core\lib;
	use core\lib\config;
	//路由类 
	class route
	{
		static public $module;
		static public $ctrl;
		static public $action;
		static public $mode;
		static public function init()
		{
			self::$module = config::get('module','route');
			self::$ctrl = config::get('ctrl','route');
			self::$action = config::get('action','route');
			self::$mode = config::get('mode','route');
		}
		public function makeurl()
		{
			switch(self::$mode)
			{
				case 0:
					return $this->getTradition();
					break;
				case 1:
					return $this->getPathInfo();
					break;
			}
		}
		public function getTradition()
		{
			if(isset($_SERVER['REQUEST_URI']) && $_SERVER['REQUEST_URI'] != '/')
			{
				$arr = explode('?',$_SERVER['REQUEST_URI']);
				$array = explode('&',$arr['1']);
				foreach($array as $k=>$v)
				{
					$value = explode('=',$v);
					if($value['0'] == 'c')
					{
						self::$ctrl = $value['1'];
						unset($array[$k]);
					}
					if($value['0'] == 'm')
					{
						self::$module = $value['1'];
						unset($array[$k]);
					}
					if($value['0'] == 'a')
					{
						self::$action = $value['1'];
						unset($array[$k]);
					}
				}
				if(!empty($array))
				{
					foreach($array as $k=>$v)
					{
						$arr = explode('=',$v);
						$_GET[$arr['0']] = $arr['1'];
					}
				}
			}
		}
		public function getPathInfo()
		{
			if(isset($_SERVER['REQUEST_URI']) && $_SERVER['REQUEST_URI'] != '/')
			{
				//  /index/index 解析出来
				$path = $_SERVER['REQUEST_URI'];
				$patharr = explode('/', trim($path, '/'));
				if (isset($patharr['0'])) {
					self::$module = $patharr['0'];
					unset($patharr['0']);
				}
				if (isset($patharr['1'])) {
					self::$ctrl = $patharr['1'];
					unset($patharr['1']);
				}
				if (isset($patharr['2'])) {
					self::$action = $patharr['2'];
					unset($patharr['2']);
				} else {
					self::$action = config::get('action', 'route');
				}
				//把url多余部分装换成get参数
				$count = count($patharr) + 3;
				$i = 3;
				while ($i < $count) {
					if (isset($patharr[$i + 1])) {
						$_GET[$patharr[$i]] = $patharr[$i + 1];
					}
					$i += 2;
				}
			}
		}
	}
?>