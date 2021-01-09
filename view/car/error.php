<?php

use view\view;

view::view('header');
view::view('navbar');
?>
<div class="container">
	<div class="basic-area text-center">
		<h1>訂單送出錯誤</h1>
		<h2 class="h4 mt-5"><?= $_SESSION['car_error'] ?></h2>
		<a href="/car" class="btn btn-dark-green btn-lg no-radius mt-4">返回購物車</a>
	</div>
</div>

<?php
view::view('footer');

//unset($_SESSION['car_error']);
