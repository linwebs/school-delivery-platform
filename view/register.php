<?php

use view\view;

?>
<?php view::view('header'); ?>
<?php view::view('navbar'); ?>
	<div class="container-fluid">
		<div class="row">
			<div class="col-sm-12 col-md-3">

			</div>
			<div class="col-sm-12 col-md-6">
				<div class="index-area-top">
					<form action="/register" method="post">
						<p class="index-description text-secondary text-center">註冊</p>
						<div class="mb-3">
							<label for="account" class="form-label">帳號</label>
							<input type="text" class="form-control" id="account" name="account" placeholder="請輸入帳號" minlength="6" maxlength="20" required>
						</div>
						<div class="mb-3">
							<label for="account" class="form-label">姓名</label>
							<input type="text" class="form-control" id="account" name="account" placeholder="請輸入姓名" required>
						</div>
						<div class="mb-3">
							<label for="email" class="form-label">E-mail</label>
							<input type="email" class="form-control" id="email" name="email" placeholder="請輸入 E-mail" required>
						</div>
						<div class="mb-3">
							<label for="phone" class="form-label">電話</label>
							<input type="tel" class="form-control" id="phone" name="phone" placeholder="請輸入電話" pattern="09\d{2}\-?\d{3}\-?\d{3}" required>
						</div>
						<div class="mb-3">
							<label for="password" class="form-label">密碼</label>
							<input type="password" class="form-control" id="password" name="password" placeholder="請輸入密碼" required>
						</div>
						<div class="mb-3">
							<label for="password-again" class="form-label">再次確認密碼</label>
							<input type="password" class="form-control" id="password-again" name="password_again" placeholder="請再次輸入密碼" required>
						</div>
						<div class="text-center">
							<button type="submit" class="btn btn-green login-btn">
								註冊
							</button>
						</div>
						<div>
							已有帳號？前往
							<a href="/login" class="btn btn-secondary login-btn">
								<i class="fas fa-caret-right"></i>
								登入
							</a>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
<?php view::view('footer'); ?>