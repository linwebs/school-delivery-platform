<?php

use database\area;
use view\view;

view::view('header');
view::view('navbar');
?>
	<form action="/place/add/<?= $data['area'] ?> " method="post">
		<div class="container basic-area">
			<h2>請選擇送餐地點</h2>
			<hr />
			<h3 class="mt-4 mb-4">新地點</h3>
			<div class="row">
				<div class="d-none d-md-block col-md-4">
					<div class="card">
						<img src="/img/area/<?= $data['area'] ?>" alt="" class="card-img-top">
						<div class="card-body">
							<h5 class="card-title"><?= area::get_name($data['area']) ?></h5>
						</div>
					</div>
				</div>
				<div class="d-sm-block d-md-none">
				</div>
				<div class="col-sm-12 col-md-8 mb-5">
					<div class="mt-3 mb-3 row">
						<label for="area" class="col-xs-12 col-sm-2 form-label">校區:</label>
						<div class="col-xs-12 col-sm-10" id="area">
							<?= area::get_name($data['area']) ?>
						</div>
					</div>
					<div class="mt-3 mb-3 row">
						<label for="build" class="col-xs-12 col-sm-2 form-label">建築物:</label>
						<div class="col-xs-12 col-sm-10">
							<select id="build" name="build" class="form-select">
								<?php foreach ($data['build'] as $item) { ?>
									<option value="<?= $item['id'] ?>"><?= $item['name'] ?></option>
								<?php } ?>
							</select>
							<div id="build-help" class="form-text">若建築物不在清單中，表示尚未提供外送服務</div>
						</div>
					</div>
					<div class="mt-3 mb-3 row">
						<label for="room" class="col-xs-12 col-sm-2 form-label">空間:</label>
						<div class="col-xs-12 col-sm-10">
							<select id="room" name="room" class="form-select bg-white" required>
							</select>
							<div id="room-help" class="form-text">若空間不在清單中，請自行輸入</div>
						</div>
					</div>
					<div class="row text-center">
						<div class="col-6">
							<a onclick="history.go(-1)" class="btn btn-secondary no-radius mt-4 mb-4">
								<i class="fas fa-angle-left"></i>
								返回上一頁
							</a>
						</div>
						<div class="col-6">
							<button type="submit" class="btn btn-dark-green no-radius mt-4 mb-4">
								開始訂餐
								<i class="fas fa-angle-right"></i>
							</button>
						</div>
					</div>
					<script>
						$('#room').editableSelect({effects: 'slide'});
						var room_list = <?= $data['room'] ?>;

						refresh_room_list(<?= $data['build'][0]['id'] ?>);
						$('#build').change(function () {
							refresh_room_list(this.value);
						});

						function refresh_room_list(index) {
							var list_index = room_list.findIndex(x => x.build == index);
							$('#room').editableSelect('clear');
							if(list_index !== -1) {
								for(var i=0; i<room_list[list_index]['room'].length; i++) {
									$('#room').editableSelect('add', room_list[list_index]['room'][i]['name']);
								}
							}
						}
					</script>
				</div>
			</div>
		</div>
	</form>
<?php
view::view('footer');