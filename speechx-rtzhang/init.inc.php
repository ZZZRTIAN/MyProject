<?php
	$selpath = str_replace('\\','/',dirname(__FILE__)).'/';  //获取init.inp.php所在的目录
	define('ROOT',$selpath);
	include_once(ROOT.'smarty/Smarty.class.php');
	$smarty =new Smarty();
	$smarty->left_delimiter='<{';
	$smarty->right_delimiter='}>';
	$smarty->template_dir = ROOT.'templates/';
	$smarty->compile_dir = ROOT.'templates_c/';

	include_once __DIR__.'/config.php';
	include_once __DIR__.'/autoloader.php';
	include_once __DIR__.'/core/dbconn.class.php';

	\Speechx\Autoloader::register();

?>