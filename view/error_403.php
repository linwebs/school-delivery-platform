<?php

use view\view;

http_response_code(403);

?>
<?php view::view('header'); ?>
<?php view::view('navbar'); ?>
	<div class="text-center index-area-top">
		<h1 class="index-title text-green-1">Hungry Cat</h1>
		<p class="index-description text-secondary">403 錯誤 - 沒有權限存取此頁面</p>
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