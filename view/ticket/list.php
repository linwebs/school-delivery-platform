<?php

use view\view;

view::view('header');
view::view('navbar');
?>
	<div class="container">
		<div class="basic-area">
			<?php if (isset($data['order'][0])) { ?>
				<div class="basic-area text-center">
					<h1>目前訂單</h1>
				</div>
				<div class="basic-area">
					<?php
					foreach ($data['order'] as $item) {
						?>
						<div class="row ticket-list">
							<div class="col-sm-12 col-md-4 shop-img">
								<img src="/img/shop/<?= $item['shop_id'] ?>" class="img-fluid rounded ticket-img" alt="shop">
							</div>
							<div class="col-sm-12 col-md-8">
								<div class="card">
									<div class="card-body">
										<h5 class="card-title">訂單編號:
											#<?= str_pad($item['order_id'], 6, '0', STR_PAD_LEFT); ?></h5>
										<p class="mb-1">狀態: <?= TICKET_STATUS[$item['order_status']] ?></p>
										<p class="mb-1">店家: <?= $item['shop_name'] ?></p>
										<p class="mb-1">
											下單時間: <?= date('Y/m/d H:i:s', strtotime($item['order_time'])) ?></p>
										<p class="mb-1">
											外送員: <?= (isset($item['delivery_name'])) ? ($item['delivery_name']) : ('無') ?></p>
										<p class="mb-1">
											送餐地點: <?= $item['user_place_name'] ?>
										</p>
										<p class="mb-1">查看訂單:
											<a href="/ticket/<?= $item['order_id'] ?>" class="btn btn-dark-green no-radius">查看訂單詳細資料</a>
										</p>
									</div>
								</div>
							</div>
						</div>
						<?php
					}
					?>
				</div>
			<?php } else { ?>
				<div class="text-center mt-5 mb-5">
					<p class="h3 mb-4">目前無任何進行中的訂單</p>
					<a href="/shop" class="btn btn-green btn-lg no-radius">
						<i class="fas fa-caret-right"></i>
						<i class="fas fa-caret-right"></i>
						馬上點餐
					</a>
				</div>
			<?php } ?>
		</div>
	</div>
<?php
view::view('footer');