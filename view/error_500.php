<?php

use view\view;

?>
<?php view::view('header'); ?>
<?php view::view('navbar'); ?>
	<div class="text-center index-area-top">
		<h1 class="index-title text-green-1">Hungry Cat</h1>
		<p class="index-description text-secondary">500 錯誤 - 伺服器錯誤</p>
		<a href="/" class="btn btn-green index-start-btn">
			<i class="fas fa-caret-right"></i>
			<i class="fas fa-caret-right"></i>
			前往首頁
		</a>
		<a href="/shop" class="btn btn-green index-start-btn">
			<i class="fas fa-caret-right"></i>
			<i class="fas fa-caret-right"></i>
			馬上點餐
		</a>
	</div>
<?php view::view('footer'); ?>