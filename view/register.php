<?php

use lang\lang;
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
						<?php if (isset($_SESSION['register_error'])) { ?>
							<div class="alert alert-danger">
								<?= $_SESSION['register_error'] ?>
							</div>
						<?php } ?>
						<div class="mb-3">
							<label for="account" class="form-label">帳號</label>
							<input type="text" class="form-control<?= (isset($_SESSION['register_account'])) ? (' is-invalid') : ('') ?>" value="<?= (isset($_SESSION['register_account_last'])) ? ($_SESSION['register_account_last']) : ('') ?>" id="account" name="account" placeholder="請輸入帳號" aria-describedby="account-help" minlength="6" maxlength="20" required>
							<div id="account-help" class="<?= (isset($_SESSION['register_account'])) ? (' invalid-feedback') : ('form-text') ?>"><?= (isset($_SESSION['register_account'])) ? ($_SESSION['register_account']) : (lang::lang('six_to_twenty_word_only')) ?></div>
						</div>
						<div class="mb-3">
							<label for="name" class="form-label">姓名</label>
							<input type="text" class="form-control<?= (isset($_SESSION['register_name'])) ? (' is-invalid') : ('') ?>" value="<?= (isset($_SESSION['register_name_last'])) ? ($_SESSION['register_name_last']) : ('') ?>" id="name" name="name" placeholder="請輸入姓名" aria-describedby="name-help" required>
							<div id="name-help" class="<?= (isset($_SESSION['register_name'])) ? (' invalid-feedback') : ('form-text') ?>"><?= (isset($_SESSION['register_name'])) ? ($_SESSION['register_name']) : ('') ?></div>
						</div>
						<div class="mb-3">
							<label for="email" class="form-label">E-mail</label>
							<input type="email" class="form-control<?= (isset($_SESSION['register_email'])) ? (' is-invalid') : ('') ?>" value="<?= (isset($_SESSION['register_email_last'])) ? ($_SESSION['register_email_last']) : ('') ?>" id="email" name="email" placeholder="請輸入 E-mail" aria-describedby="email-help" required>
							<div id="email-help" class="<?= (isset($_SESSION['register_email'])) ? (' invalid-feedback') : ('form-text') ?>"><?= (isset($_SESSION['register_email'])) ? ($_SESSION['register_email']) : ('') ?></div>
						</div>
						<div class="mb-3">
							<label for="phone" class="form-label">電話 <small class="form-text">(建議輸入手機號碼)</small></label>
							<input type="tel" class="form-control<?= (isset($_SESSION['register_phone'])) ? (' is-invalid') : ('') ?>" value="<?= (isset($_SESSION['register_phone_last'])) ? ($_SESSION['register_phone_last']) : ('') ?>" id="phone" name="phone" placeholder="請輸入電話" aria-describedby="phone-help" pattern="09\d{2}\-?\d{3}\-?\d{3}" required>
							<div id="phone-help" class="<?= (isset($_SESSION['register_phone'])) ? (' invalid-feedback') : ('form-text') ?>"><?= (isset($_SESSION['register_phone'])) ? ($_SESSION['register_phone']) : ('') ?></div>
						</div>
						<div class="mb-3">
							<label for="password" class="form-label">密碼</label>
							<input type="password" class="form-control<?= (isset($_SESSION['register_password'])) ? (' is-invalid') : ('') ?>" id="password" name="password" placeholder="請輸入密碼" aria-describedby="password-help" minlength="6" required>
							<div id="password-help" class="<?= (isset($_SESSION['register_password'])) ? (' invalid-feedback') : ('form-text') ?>"><?= (isset($_SESSION['register_password'])) ? ($_SESSION['register_password']) : (lang::lang('at_least_six_word')) ?></div>
						</div>
						<div class="mb-3">
							<label for="password-again" class="form-label">再次確認密碼</label>
							<input type="password" class="form-control<?= (isset($_SESSION['register_password_again'])) ? (' is-invalid') : ('') ?>" id="password-again" name="password_again" placeholder="請再次輸入密碼" aria-describedby="password-again-help" minlength="6" required>
							<div id="password-again-help" class="<?= (isset($_SESSION['register_password_again'])) ? (' invalid-feedback') : ('form-text') ?>"><?= (isset($_SESSION['register_password_again'])) ? ($_SESSION['register_password_again']) : ('') ?></div>
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
<?php
view::view('footer');

unset($_SESSION['register_error']);
unset($_SESSION['register_account_last']);
unset($_SESSION['register_name_last']);
unset($_SESSION['register_email_last']);
unset($_SESSION['register_phone_last']);
unset($_SESSION['register_account']);
unset($_SESSION['register_name']);
unset($_SESSION['register_email']);
unset($_SESSION['register_phone']);
unset($_SESSION['register_password']);
unset($_SESSION['register_password_again']);