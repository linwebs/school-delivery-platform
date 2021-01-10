<?php

use view\view;

view::view('header');
view::view('navbar');
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
			<h2><?= $data['shop']['name'] ?> <?= ($data['shop']['status'] == '1') ? ('') : ('<span class="badge bg-danger no-radius">目前未營業</span>') ?></h2>
			<p><?= $data['shop']['intro'] ?></p>
		</div>
		<?php if (isset($_SESSION['shop_alert'])) { ?>
			<div class="alert alert-warning alert-dismissible fade show no-radius" role="alert">
				<?= $_SESSION['shop_alert'] ?>
				<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
			</div>
			<?php
		}

		if (empty($data['meal'])) {
			?>
			<h3 class="text-center">目前尚無任何餐點</h3>
			<?php
		} else {
			foreach ($data['meal'] as $item) {
				?>
				<div class="row show-shop">
					<div class="col-sm-12 col-md-4 shop-img">
						<?= (isset($_SESSION['user']['id']) && $data['shop']['status'] == '1' && $item['status'] == '1') ? ('<a href="/meal/' . $item['id'] . '">') : ('') ?>
						<img src="/img/meal/<?= $item['id'] ?>" class="img-fluid rounded" alt="shop">
						<?php if ($item['status'] != '1') { ?>
							<div class="img-inner-text">
								<span class="bg-danger">目前未提供此餐點</span>
							</div>
						<?php } ?>
						<?= (isset($_SESSION['user']['id']) && $data['shop']['status'] == '1' && $item['status'] == '1') ? ('</a>') : ('') ?>
					</div>
					<div class="col-sm-12 col-md-8">
						<?= (isset($_SESSION['user']['id']) && $data['shop']['status'] == '1' && $item['status'] == '1') ? ('<a href="/meal/' . $item['id'] . '">') : ('') ?>
						<div class="d-flex w-100 justify-content-between">
							<h3 class="mb-2">
								<?= $item['name'] ?>
								<?php if ($item['status'] != '1') { ?>
									<small class="h4">目前未提供此餐點</small>
								<?php } ?>
							</h3>
							<h5><span class="badge bg-green-4 no-radius"><?= ($item['quantity'] == 0)?(''):($item['quantity']) ?></span></h5>
						</div>
						<p class="mb-0">價錢: <?= $item['price'] ?>元</p>
						<p class="d-none d-sm-none d-md-block">備註: <?= $item['note'] ?></p>
						<?= (isset($_SESSION['user']['id']) && $data['shop']['status'] == '1' && $item['status'] == '1') ? ('</a>') : ('') ?>
					</div>
				</div>
				<?php
			}
		}
		?>
		<div class="text-center basic-area">
			<div class="row">
				<div class="col-sm-12 col-md-6">
					<a onclick="history.go(-1)" class="btn btn-secondary no-radius login-btn"><i class="fas fa-caret-left"></i>
						返回</a>
				</div>
				<?php if (isset($_SESSION['user']['id']) && !empty($data['meal']) && $data['shop']['status'] == '1') { ?>
					<div class="col-sm-12 col-md-6">
						<a href="/car" class="btn btn-dark-green no-radius login-btn">
							結帳 <i class="fas fa-caret-right"></i>
						</a>
					</div>
				<?php } ?>
			</div>
		</div>
	</div>
<?php
view::view('footer');

unset($_SESSION['shop_alert']);