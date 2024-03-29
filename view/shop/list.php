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
		<?php
		if (isset($data['shop'][0])) {
			foreach ($data['shop'] as $item) {
				?>
				<div class="row show-shop">
					<?php if ($item['status'] == '1') { ?>
						<div class="col-sm-12 col-md-4 shop-img">
							<a href="/shop/<?= $item['id'] ?>"><img src="/img/shop/<?= $item['id'] ?>" class="img-fluid rounded" alt="shop"></a>
						</div>
						<div class="col-sm-12 col-md-8">
							<a href="/shop/<?= $item['id'] ?>">
								<div class="d-flex w-100 justify-content-between">
									<h3 class="mb-2"><?= $item['name'] ?></h3>
									<?php
									if (isset($_SESSION['car']['shop'])) {
										if ($item['id'] == $_SESSION['car']['shop']) {
											?>
											<h5><span class="badge bg-green-4 no-radius">目前點餐店家</span></h5>
											<?php
										}
									}
									?>
								</div>
								<p class="d-none d-sm-none d-md-block"><?= $item['intro'] ?></p>
							</a>
						</div>
					<?php } else { ?>
						<div class="col-sm-12 col-md-4 shop-img">
							<a href="/shop/<?= $item['id'] ?>">
								<img src="/img/shop/<?= $item['id'] ?>" class="img-fluid rounded" alt="shop">
								<div class="img-inner-text">
									<span class="bg-danger">目前未營業</span>
								</div>
							</a>
						</div>
						<div class="col-sm-12 col-md-8">
							<a href="/shop/<?= $item['id'] ?>">
								<div class="d-flex w-100 justify-content-between">
									<h3 class="mb-2"><?= $item['name'] ?> <small class="h4">目前未營業</small></h3>
									<?php
									if (isset($_SESSION['car']['shop'])) {
										if ($item['id'] == $_SESSION['car']['shop']) {
											?>
											<h5><span class="badge bg-green-4 no-radius">目前點餐店家</span></h5>
											<?php
										}
									}
									?>
								</div>
								<p class="d-none d-sm-none d-md-block"><?= $item['intro'] ?></p>
							</a>
						</div>
					<?php } ?>
				</div>
				<?php
			}
		} else {
			?>
			<h3 class="text-center">目前尚無任何餐廳</h3>
			<?php
		}
		?>
	</div>
<?php
view::view('footer');