<?php 
namespace app\home\controller;
use core\lib\model;
use core\lib\log;
class indexController extends \core\fzq
{
	public function index()
	{
		$log = new log();
		$log->init();
		$log->log('nihao');
		
		$list = 'dddddd';
	    $this->assign('list',$list);
	    $this->display('index.html');
	}
}