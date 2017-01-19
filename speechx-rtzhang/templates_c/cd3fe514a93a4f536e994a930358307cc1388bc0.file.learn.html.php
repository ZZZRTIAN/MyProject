<?php /* Smarty version Smarty-3.1.16, created on 2017-01-18 09:32:43
         compiled from "D:\xampp\htdocs\speechx-rtzhang\templates\learn.html" */ ?>
<?php /*%%SmartyHeaderCode:24914587f1bc4073f90-93517594%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'cd3fe514a93a4f536e994a930358307cc1388bc0' => 
    array (
      0 => 'D:\\xampp\\htdocs\\speechx-rtzhang\\templates\\learn.html',
      1 => 1484728263,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '24914587f1bc4073f90-93517594',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.16',
  'unifunc' => 'content_587f1bc41159c5_18509150',
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_587f1bc41159c5_18509150')) {function content_587f1bc41159c5_18509150($_smarty_tpl) {?><!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
		<meta content="yes" name="apple-mobile-web-app-capable">
		<meta content="black" name="apple-mobile-web-app-status-bar-style">
		<meta content="telephone=no" name="format-detection">
		<meta content="email=no" name="format-detection">
		<title>学习情况</title>
		<link rel="stylesheet" href="public/css/public.css" />
	</head>
	<body>
		
		<div class="weChat_box">
			<div class="today-header">
				<div class="header-content">
					<ul class="chooseDay">
						<li class="today select" data-type="today" data-name = "日" data-select="今日">今日</li>
						<li class="week" data-type="week" data-name = "周" data-select="本周">周</li>
						<li class="month" data-type="month" data-name = "月" data-select="本月">月</li>
					</ul>
					
					<span class="score">79</span>
					
					<div class="level">
						<span>优</span>
					</div>
				</div>
			</div>
			<div class="today-content">
				<ul class="fix">
					<li class="fix">
						<div class="content-icon">
							<img src="public/images/book.png" />
						</div>
						<div class="content-info">
							<h3>BOOK:</h3>
							<p>小学一年级上册（A）</p>
						</div>
					</li>
					<li class="fix">
						<div class="content-icon">
							<img src="public/images/section.png" />
						</div>
						<div class="content-info">
							<h3>SECTION:</h3>
							<p></p>
						</div>
					</li>
					<li class="fix">
						<div class="content-icon">
							<img src="public/images/avg.png" />
						</div>
						<div class="content-info">
							<h3>AVG:</h3>
							<p></p>
						</div>
					</li>
				</ul>
				
				<p class="tips">您的孩子学习情况很好哦，多为他加油，您的加油会让他更有力量哦</p>
			</div>
			
			<!-- 周 -->
			<div class="week-content">
				
			</div>
			
			<!-- 月 -->
			<div class="month-content">
				
			</div>
		
		</div>
		
		<script type="text/javascript" src="public/js/common/jquery-1.7.2.min.js" ></script>
		<script type="text/javascript" src="public/js/common/public.js" ></script>
		<script type="text/javascript" src="public/js/today.js" ></script>
	</body>
</html>
<?php }} ?>
