<?php

use view\view;

view::view('header');
view::view('navbar');
?>
	<div class="container basic-area">
		<h2>請選擇送餐地點</h2>
		<hr />
		<h3 class="mt-4 mb-4">我的地點</h3>
		<div class="table-responsive">
			<table class="table table-striped table-green">
				<thead>
				<tr>
					<th>名稱</th>
					<th>校區</th>
					<th>建築物</th>
					<th>空間</th>
					<th>備註</th>
					<th>選擇</th>
				</tr>
				</thead>
				<tbody>
				<?php
				if (isset($_SESSION['user']['id'])) {
					if (count($data['my']) == 0) { ?>
						<tr>
							<td colspan="6" rowspan="3" class="text-center">尚無我的地點</td>
						</tr>
					<?php
					} else {
						foreach ($data['my'] as $item) {
							?>
							<tr>
								<td><?= $item['user_place_name'] ?></td>
								<td><?= $item['area_name'] ?></td>
								<td><?= $item['build_name'] ?></td>
								<td><?= $item['room_name'] ?></td>
								<td><?= $item['user_place_detail'] ?></td>
								<td>
									<a href="/place/my/<?= $item['user_place_id'] ?>" class="btn btn-dark-green no-radius"><i class="fas fa-caret-right"></i>
										選擇</a>
								</td>
							</tr>
							<?php
						}
					}
				} else { ?>
					<tr>
						<td colspan="6" rowspan="3" class="text-center"><a href="/login">請先登入</a></td>
					</tr>
				<?php } ?>
				</tbody>
			</table>
		</div>
		<h3 class="mt-4">新地點</h3>
		<div class="row">
			<?php foreach ($data['area'] as $item) { ?>
				<div class="col-sm-12 col-md-6 col-lg-3">
					<a href="/place/add/<?= $item['id'] ?>" class="m-5 text-deco-none">
						<div class="card">
							<img src="/img/area/<?= $item['id'] ?>" class="card-img-top" alt="<?= $item['name'] ?>">
							<div class="card-body">
								<h5 class="card-title"><?= $item['name'] ?></h5>
							</div>
						</div>
					</a>
				</div>
			<?php } ?>
		</div>
	</div>
<?php
view::view('footer');