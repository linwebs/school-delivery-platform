<?php

use view\view;

view::view('header');
view::view('navbar');
?>
	<div class="container">
		<form action="/car" method="post">
			<?php if (isset($data['shop']['name']) && (count($data['car']['meal']) > 0)) { ?>
				<div class="basic-area text-center">
					<h1>目前餐點</h1>
				</div>
				<div class="basic-area">
					<p class="h4">
						店家: <?= $data['shop']['name'] ?> <?= ($data['shop']['status'] == '1') ? ('') : ('<span class="badge bg-danger no-radius">目前未營業</span>') ?></p>
					<p><?= $data['shop']['intro'] ?></p>
				</div>
				<div class="alert alert-warning alert-dismissible fade show no-radius" role="alert" id="alert" style="display: <?= (isset($_SESSION['car_alert'])) ? ('') : ('none') ?>">
					<span id="alert-msg"><?= (isset($_SESSION['car_alert'])) ? ($_SESSION['car_alert']) : ('') ?></span>
					<button type="button" class="btn-close" id="alert-close"></button>
				</div>
				<div class="basic-area">
					<p class="h4">品項:</p>
					<?php foreach ($data['car']['meal'] as $item) { ?>
						<div class="row" id="meal-<?= $item['id'] ?>">
							<div class="col-xs-12 col-sm-8 col-md-10">
								<div class="mb-2">
									<span>品項: <?= $item['name'] ?></span>
									<br>
									<span>金額: <?= $item['price'] ?>元</span>
									<br>
									<span>小計: <span id="price-<?= $item['id'] ?>"><?= $item['price'] * $item['quantity'] ?></span>元</span>
									<br>
									<span>備註: <?= $item['note'] ?></span>
								</div>
							</div>
							<div class="col-xs-12 col-sm-4 col-md-2">
								<div class="btn-group mt-2 mb-5" role="group">
									<button type="button" class="btn btn-outline-dark-green" id="quantity-sub-<?= $item['id'] ?>">
										-
									</button>
									<button type="button" class="btn btn-outline-dark-green disabled" id="quantity-<?= $item['id'] ?>"><?= $item['quantity'] ?></button>
									<button type="button" class="btn btn-outline-dark-green" id="quantity-add-<?= $item['id'] ?>">
										+
									</button>
								</div>
							</div>
							<hr>
						</div>
					<?php } ?>
				</div>

				<div class="basic-area">
					<p class="h4">送餐地點:
						<small><?= $data['area'] ?> <?= $data['build'] ?> <?= $_SESSION['place']['room'] ?>
							<a href="/place" class="btn btn-dark-green no-radius btn-sm">選擇其他地點</a></small>
					</p>
					<div class="mb-3 row">
						<label for="place-name" class="col-sm-2 col-form-label">地點名稱: </label>
						<div class="col-sm-10">
							<input type="text" name="place_name" id="place-name" class="form-control" aria-describedby="place-name-hint" value="<?= $data['place']['name'] ?>" maxlength="30" required>
							<div id="place-name-hint" class="form-text">可在此處填寫地點名稱，方便下次訂餐使用 (最多30字)</div>
						</div>
					</div>
					<div class="mb-3 row">
						<label for="place-detail" class="col-sm-2 col-form-label">地點備註: </label>
						<div class="col-sm-10">
							<textarea name="place_detail" id="place-detail" cols="30" rows="1" class="form-control" aria-describedby="place-hint"><?= $data['place']['note'] ?></textarea>
							<div id="place-hint" class="form-text">在此處說明取餐地點(如: 前門門口)，若地點較難找到，也可在此處說明地點位置</div>
						</div>
					</div>
				</div>

				<div class="basic-area">
					<div class="mb-3 row">
						<label for="order-detail" class="col-sm-2 col-form-label">訂單備註: </label>
						<div class="col-sm-10">
							<textarea name="order_detail" id="place-detail" cols="30" rows="2" class="form-control" aria-describedby="order-hint"><?= $data['ticket_note'] ?></textarea>
							<div id="order-hint" class="form-text">在此處填寫給店家的訂單備註 (為響應環保，若不須附贈餐具，請在此處填寫)</div>
						</div>
					</div>
					<p class="mb-1 h5">總計: <span id="price-meals"><?= $data['price-meals'] ?></span>元</p>
					<p class="mb-1 h5">外送費: <span id="price-delivery"><?= $data['price-delivery'] ?></span>元</p>
					<p class="h5">總金額: <span id="price-total"><?= $data['price-total'] ?></span>元</p>
				</div>

				<?php if ($data['shop']['status'] == '1') { ?>
					<div class="text-center basic-area">
						<div class="row">
							<div class="col-sm-12 col-md-3">
							</div>
							<div class="col-sm-12 col-md-6">
								<button type="button" class="btn btn-dark-green no-radius login-btn" data-bs-toggle="modal" data-bs-target="#submit-order-modal">
									送出訂單
								</button>
							</div>
						</div>
					</div>
					<div class="modal fade" id="submit-order-modal" tabindex="-1" aria-labelledby="modal-title" aria-hidden="true">
						<div class="modal-dialog modal-dialog-centered">
							<div class="modal-content">
								<div class="modal-header">
									<h5 class="modal-title" id="modal-title">送出訂單</h5>
									<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
								</div>
								<div class="modal-body">
									是否確認送出訂單
								</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-secondary no-radius" data-bs-dismiss="modal">返回
									</button>
									<button type="submit" class="btn btn-dark-green no-radius">送出訂單</button>
								</div>
							</div>
						</div>
					</div>
				<?php } ?>
			<?php } else { ?>
				<div class="text-center mt-5 mb-5">
					<p class="h3 mb-4">目前購物車中尚無任何餐點</p>
					<a href="/shop" class="btn btn-green btn-lg no-radius">
						<i class="fas fa-caret-right"></i>
						<i class="fas fa-caret-right"></i>
						馬上點餐
					</a>
				</div>
			<?php } ?>
		</form>
	</div>
	<script>
		<?php foreach ($data['car']['meal'] as $item) { ?>
		$('#quantity-sub-<?= $item['id'] ?>').click(function () {
			var id = $(this).attr('id').substring(13);
			$.ajax({
				url: '/api/car/meal/sub/' + id, success: function (data, status) {
					if (status === 'success') {
						var json_obj = JSON.parse(data);
						console.log(json_obj);
						if (json_obj['status'] === true) {
							if (json_obj.quantity == 0) {
								if (json_obj.car_empty) {
									location.reload();
								} else {
									$('#meal-' + <?= $item['id'] ?>).remove();
								}
							} else {
								$('#quantity-' + id).html(json_obj.quantity);
								$('#price-' + id).html(json_obj.price);
							}
							$('#price-meals').html(json_obj.price_meals);
							$('#price-delivery').html(json_obj.price_delivery);
							$('#price-total').html(json_obj.price_total);
							$('#car-count').html(json_obj.total_meal);

						} else {
							$('#alert-msg').html(json_obj.msg);
							$('#alert').show();
							$("html, body").animate({scrollTop: 0}, "slow");
							$('#alert').delay(4000).slideUp(200, function () {
								$(this).alert('close');
							});
						}
					}
				}
			});
		});
		$('#quantity-add-<?= $item['id'] ?>').click(function () {
			var id = $(this).attr('id').substring(13);
			$.ajax({
				url: '/api/car/meal/add/' + id, success: function (data, status) {
					if (status === 'success') {
						var json_obj = JSON.parse(data);
						console.log(json_obj);
						if (json_obj['status'] === true) {
							$('#quantity-' + id).html(json_obj.quantity);
							$('#price-' + id).html(json_obj.price);
							$('#price-meals').html(json_obj.price_meals);
							$('#price-delivery').html(json_obj.price_delivery);
							$('#price-total').html(json_obj.price_total);
							$('#car-count').html(json_obj.total_meal);
						} else {
							$('#alert-msg').html(json_obj.msg);
							$('#alert').show();
							$("html, body").animate({scrollTop: 0}, "slow");
							$('#alert').delay(4000).slideUp(200, function () {
								$(this).alert('hide');
							});
						}
					}
				}
			});
		});
		<?php } ?>
		$('#alert-close').click(function () {
			$('#alert').hide();
		});
	</script>
<?php
view::view('footer');

unset($_SESSION['car_alert']);
unset($_SESSION['car_last']['place_name']);
unset($_SESSION['car_last']['place_detail']);
unset($_SESSION['car_last']['ticket_note']);