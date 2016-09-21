<?php
namespace core;
class fzq
{
	public static $classMap = array();
	public $assign;
	//启动框架方法
	static public function run()
	{
		//控制器
		$route = new \core\lib\route(); //路由类
		$route->init();
		$route->makeurl();
		$module= $route::$module;
		$ctrlClass = $route::$ctrl;
		$action = $route::$action;
		$ctrlfile = APP.'/'.$module.'/Controller/'.$ctrlClass.'Controller.php';
		$ctrlClass = '\\'.MODULE.'\\'.$module.'\\Controller\\'.$ctrlClass.'Controller';
		if(is_file($ctrlfile))
		{
			include $ctrlfile;
			$ctrl = new $ctrlClass();
			$ctrl->$action();
		}
		else
		{
			throw new \Exception('控制器不存在'.$ctrlfile);
		}
	}
	//自动加载
	static public function load($class)
	{
		if(isset($classMap[$class]))
		{
			return true;
		}
		else
		{
			$class = str_replace('\\','/', $class);
			$file = FZQ.'/'.$class .'.php';
			if(is_file($file))
			{
				include $file;
				self::$classMap[$class] = $class;
			}
			else
			{
				return false;
			}
		}	
	}
	//视图 assign 方法
	public function assign($name,$value)
	{
		$this->assign[$name]=$value;
	}
	public function display($file)
	{

		$route = new \core\lib\route(); //路由类
		$module= $route::$module; //模块
		$class= $route::$ctrl; //类名
		$files = APP.'/'.$module.'/view/'.$class.'/'.$file;
		if(is_file($files))
		{
			$dir = APP.'/'.$module.'/view/'.$class;
			$array =array();
			$data = $this->assign?$this->assign:$array;
			$this->set_swig($dir,$file,$data);
		}
	}
	/**
	* $type 消息类型 1.失败 0 是成功  非必填
	* $url 跳转地址 必填
	* $message 消息提示信息
	* $time  消息 等待跳转时间 
	*/
	//操作成功跳转提示方法
	public function T($url,$message='',$time=1,$type=0)
	{
		//判断模板 类型
		if($type>0)
		{
			$file = 'error.html';
		}else{
			$file = 'success.html';
		}
		//判断提示消息
		if(!$message && $type>0)
		{
			$message = '操作失败';
		}
		if(!$message && $type<1) 
		{
			$message = '操作成功';
		}
		$dir = APP.'/public';
		$data = array(
			'url'=>$url,
			'message'=>$message,
			'tmie'=>$time
			); 
		$this->set_swig($dir,$file,$data);
	}

	//模板引擎调用
	private function set_swig($dir,$file,$data)
	{
		\Twig_Autoloader::register();
		$loader = new \Twig_Loader_Filesystem($dir);
		$twig = new \Twig_Environment($loader, array(
		    'cache' => FZQ.'/log/twig',
		    'debug'=>DEBUG
		));
		$twig->addExtension(new \Twig_Extension_Debug());
		$template = $twig->loadTemplate($file); 
		$template->display($data);
	}
}
