<?php

use view\view;

view::view('header');
view::view('navbar');
?>
	<div class="container">
		<div class="basic-area">
			<div class="basic-area text-center">
				<h1>此訂單不存在</h1>
			</div>
			<div class="text-center basic-area">
				<a href="/ticket" class="btn btn-secondary no-radius login-btn"><i class="fas fa-caret-left"></i>
					返回訂單列表</a>
			</div>
		</div>
	</div>
<?php
view::view('footer');