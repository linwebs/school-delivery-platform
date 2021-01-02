<?php

use view\view;

view::view('header');
view::view('navbar');
?>
	<div class="container-fluid">
		<div class="row">
			<div class="col-sm-12 col-md-3">

			</div>
			<div class="col-sm-12 col-md-6">
				<div class="index-area-top">
					<form action="/login" method="post">
						<p class="index-description text-secondary text-center">登入</p>
						<?php if (isset($_SESSION['login_error'])) { ?>
							<div class="alert alert-danger">
								<?= $_SESSION['login_error'] ?>
							</div>
						<?php } ?>
						<div class="mb-3">
							<label for="account" class="form-label">帳號</label>
							<input type="text" class="form-control" id="account" name="account" placeholder="請輸入帳號" required>
						</div>
						<div class="mb-3">
							<label for="password" class="form-label">密碼</label>
							<input type="password" class="form-control" id="password" name="password" placeholder="請輸入密碼" required>
						</div>
						<?php /*
						<div class="mb-3 form-check">
							<input type="checkbox" class="form-check-input" id="remember_login" name="remember_login">
							<label class="form-check-label" for="remember_login">記住我</label>
						</div>
						*/ ?>
						<div class="text-center">
							<button type="submit" class="btn btn-green login-btn">
								登入
							</button>
							<a href="/register" class="btn btn-secondary login-btn">
								註冊
							</a>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
<?php
view::view('footer');

unset($_SESSION['login_error']);