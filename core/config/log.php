<?php 
	return array(
	'DRIVE'=>'file',   //记录日志方式 file 文件模式   mysql 数据库模式
	'OPTION'=>array(
		//'DBNAME'=>'p_log',  //数据库模式 存储日志表
		//'CONTENT'=>'content' //数据库模式 存储日志内容字段
		'PATH'=> FZQ.'/log/',  //文件模式 设置存储日志目录
		'FILE'=>'log'           //文件模式 设置存储日志名称
	)
);