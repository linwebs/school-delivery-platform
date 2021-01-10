<?php

//print_r($data);

use view\view;

view::view('header');
view::view('navbar');

// $_SESSION['place']['area']
// $_SESSION['place']['build']
// $_SESSION['place']['room']

?>
	<div class="container basic-area">
		<h4>送餐地點:
			<small><?= $data['area'] ?> <?= $data['build'] ?> <?= $_SESSION['place']['room'] ?>
				<a href="/place" class="btn btn-dark-green no-radius btn-sm">選擇其他地點</a></small>
		</h4>
		<?php /*
		<div class="row">
			<div class="col-md-12 col-lg-6">
				<h4>送餐地點: <small><?= $data['area'] ?> <?= $data['build'] ?> <?= $_SESSION['place']['room'] ?></small>
				</h4>
			</div>
			<form class="col-md-12 col-lg-6 food-search-form">
				<div class="row g-5">
					<div class="col-8">
						<input type="text" class="form-control" id="" placeholder="想吃點什麼?">
					</div>
					<div class="col">
						<button type="submit" class="btn btn-primary">尋找美食</button>
					</div>
				</div>
			</form>
		</div>
 		*/ ?>
		<div class="basic-area">
			<h2><?= $data['shop']['name'] ?></h2>
			<p><?= $data['shop']['intro'] ?></p>
		</div>
		<?php if (isset($_SESSION['meal_alert'])) { ?>
			<div class="alert alert-warning alert-dismissible fade show no-radius" role="alert">
				<?= $_SESSION['meal_alert'] ?>
				<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
			</div>
		<?php } ?>
		<form action="/meal/<?= $data['meal']['id'] ?>" method="post">
			<div class="row show-shop">
				<div class="col-md-12 col-lg-4 shop-img">
					<img src="/img/meal/<?= $data['meal']['id'] ?>" class="img-fluid rounded mt-lg-5 meal-img" alt="shop">
				</div>
				<div class="col-md-12 col-lg-8">
					<h3 class="mb-2 pt-2 pt-lg-0"><?= $data['meal']['name'] ?></h3>
					<p class="mb-2">價錢: <?= $data['meal']['price'] ?>元</p>
					<p class="mb-2">備註: <?= $data['meal']['note'] ?></p>
					<div class="mb-2">
						<label for="quantity" class="form-label">數量:</label>
						<select class="form-select" id="quantity" name="quantity" required>
							<option value="" <?= ($data['quantity'] == 0) ? ('selected') : ('') ?>>-- 請選擇數量 --</option>
							<?php for ($i = 1; $i <= ITEM_MAX_BUY; $i++) { ?>
								<option value="<?= $i ?>" <?= ($data['quantity'] == $i) ? ('selected') : ('') ?>><?= $i ?></option>
							<?php } ?>
						</select>
					</div>
					<div class="mb-3">
						<label for="note" class="form-label">餐點備註:</label>
						<textarea class="form-control" id="note" name="note" rows="3"><?= $data['note'] ?></textarea>
					</div>
					<input type="hidden" name="shop" value="<?= $data['shop']['id'] ?>">
					<input type="hidden" name="meal" value="<?= $data['meal']['id'] ?>">
				</div>
			</div>
			<div class="text-center basic-area">
				<div class="row">
					<div class="col-sm-12 col-md-6">
						<a onclick="history.go(-1)" class="btn btn-secondary no-radius login-btn"><i class="fas fa-caret-left"></i>
							返回</a>
					</div>
					<?php if (isset($_SESSION['user']['id']) && !empty($data['meal']) && $data['shop']['status'] == '1' && $data['meal']['status'] == '1') { ?>
						<div class="col-sm-12 col-md-6">
							<button type="submit" class="btn btn-dark-green no-radius login-btn">
								<?= ($data['quantity'] == 0) ? ('加入購物車') : ('更新購物車') ?> <i class="fas fa-caret-right"></i>
							</button>
						</div>
					<?php } ?>
				</div>
			</div>
		</form>
	</div>
<?php
view::view('footer');

unset($_SESSION['meal_alert']);