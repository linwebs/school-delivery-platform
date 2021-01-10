<?php

use view\view;

view::view('header');
view::view('navbar');
?>
	<div class="container">
		<div class="basic-area">
			<div class="basic-area">
				<div class="row m-5">
					<div class="col-md-12 col-lg-4">
						<div class="text-center">
							<img src="/img/main/user.png" alt="<?= $_SESSION['user']['name'] ?>" class="img-fluid account-img">
						</div>
						<div class="m-5 mb-md-0">
							<span class="mt-2">帳號: <?= $data['user']['account'] ?></span><br>
							<span class="mt-2">姓名: <?= $data['user']['name'] ?></span><br>
							<span class="mt-2">Email: <?= $data['user']['email'] ?></span><br>
							<span class="mt-2">手機號碼: <?= $data['user']['phone'] ?></span><br>
							<span class="mt-2">帳號類型: <?= USER_TYPE[$data['user']['type']] ?></span>
						</div>
					</div>
					<div class="col-md-12 col-lg-8">
						<h1 class="h2 mt-5">歡迎 <?= $_SESSION['user']['name'] ?></h1>
						<a href="/tickets/all" class="btn btn-dark-green btn-lg no-radius m-3">
							<i class="fas fa-ticket-alt"></i>
							全部訂單
						</a>
						<a href="/tickets/my" class="btn btn-dark-green btn-lg no-radius m-3">
							<i class="fas fa-clipboard-check"></i>
							我的訂單
						</a>
						<a href="/account/change" class="btn btn-dark-green btn-lg no-radius m-3">
							<i class="fas fa-user"></i>
							暫時切換為顧客身份
						</a>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php
view::view('footer');