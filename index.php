<?php 
	//框架入口文件
	define('FZQ',realpath('')); //框架根目录
	define('CORE',FZQ.'/core');  //定义框架的核心文件
	define('APP',FZQ.'/app');   //项目目录文件
	define('MODULE','app');   //模块
	define('DEBUG',true); //是否开启错误调试模式
	define('__STATIC__',FZQ.'/static');//静态文件目录
	include CORE.'/common/function.php'; //加载函数库
	include CORE.'/fzq.php'; //加载框架核心文件
	include 'vendor/autoload.php';
	//判断 是否安装
	if(file_exists("./install/") && !file_exists("./Install/install.lock"))
	{
		header('Location:/Install/install.php');
		exit(); 
	}
	//开启session
	session_start();
	if(DEBUG)
	{
		$whoops = new \Whoops\Run;
		$whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
		$whoops->register();
		ini_set('dlsplay_error', 'On');
	}else{
		ini_set('display_error', 'Off');
	}
	spl_autoload_register('\core\fzq::load');
	\core\fzq::run();  //启动框架
 ?>
