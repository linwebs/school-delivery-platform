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
				<tr>
					<td>教室</td>
					<td>蘭潭校區</td>
					<td>理工大樓</td>
					<td>402教室</td>
					<td></td>
					<td>
						<a href="/place/my/1" class="btn btn-dark-green btn-no-radius"><i class="fas fa-caret-right"></i>
							選擇</a>
					</td>
				</tr>
				<tr>
					<td>宿舍</td>
					<td>蘭潭校區</td>
					<td>學生宿舍</td>
					<td>5舍門口</td>
					<td></td>
					<td>
						<a href="/place/my/2" class="btn btn-dark-green btn-no-radius"><i class="fas fa-caret-right"></i>
							選擇</a>
					</td>
				</tr>
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

unset($_SESSION['login_error']);