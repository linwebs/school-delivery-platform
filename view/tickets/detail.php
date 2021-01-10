<?php

use view\view;

view::view('header');
view::view('navbar');
?>
	<div class="container">
		<div class="basic-area">
			<div class="basic-area text-center">
				<?php
				if (in_array($data['tickets']['order_status'], TICKET_STATUS_NEED_DELIVERY) && !isset($data['tickets']['delivery_name'])) {
					?>
					<h1>可接的訂單</h1>
					<?php
				} else {
					?>
					<h1>已接的訂單</h1>
					<?php
				}
				?>
			</div>
			<div class="basic-area">
				<div class="row ticket-list">
					<div class="col-sm-12 col-md-3 shop-img">
						<img src="/img/shop/<?= $data['tickets']['shop_id'] ?>" class="img-fluid rounded ticket-img" alt="shop">
					</div>
					<div class="col-sm-12 col-md-9">
						<div class="card">
							<div class="card-body">
								<?php if (isset($_SESSION['tickets_error'])) { ?>
									<div class="alert alert-warning">
										<?= $_SESSION['tickets_error'] ?>
									</div>
								<?php } ?>
								<h5 class="card-title">訂單編號:
									#<?= str_pad($data['tickets']['order_id'], 6, '0', STR_PAD_LEFT); ?></h5>
								<p class="mb-1">狀態: <?= TICKET_STATUS[$data['tickets']['order_status']] ?></p>
								<p class="mb-1">店家: <?= $data['tickets']['shop_name'] ?></p>
								<p class="mb-1">
									下單時間: <?= date('Y/m/d H:i:s', strtotime($data['tickets']['order_time'])) ?></p>
								<p class="mb-1">
									訂餐人: <?= $data['tickets']['user_name'] ?></p>
								<?php if (isset($data['tickets']['delivery_name'])) { ?>
									<p class="mb-1">
										訂餐人手機: <?= $data['tickets']['user_phone'] ?></p>
								<?php } ?>
								<p class="mb-1">
									送餐地點: <?= $data['tickets']['user_place_name'] ?>
									<br />
									<small>(<?= $data['tickets']['area_name'] ?>
										<?= $data['tickets']['build_name'] ?>
										<?= $data['tickets']['room_name'] ?>)</small>
								</p>
								<p class="mb-3">送餐地點備註: <?= $data['tickets']['user_place_detail'] ?></p>
								<div class="row mb-1">
									<div class="col-sm-12 col-md-2">
										<p>餐點:</p>
									</div>
									<div class="col-sm-12 col-md-10">
										<table class="table">
											<thead>
											<tr>
												<th>品項</th>
												<th>單價</th>
												<th>數量</th>
												<th>小計</th>
												<th>備註</th>
											</tr>
											</thead>
											<tbody>
											<?php foreach ($data['meal'] as $item) { ?>
												<tr>
													<th><?= $item['name'] ?></th>
													<td><?= $item['price'] ?>元</td>
													<td><?= $item['quantity'] ?></td>
													<td><?= $item['quantity'] * $item['price'] ?>元</td>
													<td><?= $item['note'] ?></td>
												</tr>
											<?php } ?>
											</tbody>
										</table>
									</div>
								</div>

								<p class="mb-1">總計: <?= $data['price_meals'] ?>元</p>
								<p class="mb-1">外送費: <?= $data['price_delivery'] ?>元</p>
								<p class="mb-1">總金額: <?= $data['price_total'] ?>元</p>
								<p class="mb-3">訂單備註: <?= $data['tickets']['order_note'] ?></p>
								<?php
								if (in_array($data['tickets']['order_status'], TICKET_STATUS_NEED_DELIVERY) && !isset($data['tickets']['delivery_name'])) {
									?>
									<form action="/tickets/<?= $data['tickets']['order_id'] ?>" method="post">
										<input type="hidden" name="status" value="get_ticket">
										<p class="mb-3">接下訂單:
											<button type="button" class="btn btn-dark-green no-radius login-btn" data-bs-toggle="modal" data-bs-target="#submit-order-modal">
												接此訂單
											</button>
										</p>
										<div class="modal fade" id="submit-order-modal" tabindex="-1" aria-labelledby="modal-title" aria-hidden="true">
											<div class="modal-dialog modal-dialog-centered">
												<div class="modal-content">
													<div class="modal-header">
														<h5 class="modal-title" id="modal-title">是否接下此訂單</h5>
														<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
													</div>
													<div class="modal-body">
														確認是否接下此訂單
													</div>
													<div class="modal-footer">
														<button type="button" class="btn btn-secondary no-radius" data-bs-dismiss="modal">
															返回
														</button>
														<button type="submit" class="btn btn-dark-green no-radius">
															接下訂單
														</button>
													</div>
												</div>
											</div>
										</div>
									</form>
									<?php
								} else {
									switch ($data['tickets']['order_status']) {
										case 3:
											?>
											<form action="/tickets/<?= $data['tickets']['order_id'] ?>" method="post">
												<input type="hidden" name="status" value="get_meal">
												<p class="mb-3">變更訂單狀態:
													<button type="button" class="btn btn-dark-green no-radius login-btn" data-bs-toggle="modal" data-bs-target="#submit-order-modal">
														已取餐
													</button>
												</p>
												<div class="modal fade" id="submit-order-modal" tabindex="-1" aria-labelledby="modal-title" aria-hidden="true">
													<div class="modal-dialog modal-dialog-centered">
														<div class="modal-content">
															<div class="modal-header">
																<h5 class="modal-title" id="modal-title">是否已取餐</h5>
																<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
															</div>
															<div class="modal-body">
																確認是否已取餐
															</div>
															<div class="modal-footer">
																<button type="button" class="btn btn-secondary no-radius" data-bs-dismiss="modal">
																	返回
																</button>
																<button type="submit" class="btn btn-dark-green no-radius">
																	已取餐
																</button>
															</div>
														</div>
													</div>
												</div>
											</form>
											<?php
											break;
										case 4:
											?>
											<form action="/tickets/<?= $data['tickets']['order_id'] ?>" method="post">
												<input type="hidden" name="status" value="delivery_finish">
												<p class="mb-3">變更訂單狀態:
													<button type="button" class="btn btn-dark-green no-radius login-btn" data-bs-toggle="modal" data-bs-target="#submit-order-modal">
														已送達
													</button>
												</p>
												<div class="modal fade" id="submit-order-modal" tabindex="-1" aria-labelledby="modal-title" aria-hidden="true">
													<div class="modal-dialog modal-dialog-centered">
														<div class="modal-content">
															<div class="modal-header">
																<h5 class="modal-title" id="modal-title">是否已送達</h5>
																<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
															</div>
															<div class="modal-body">
																確認餐點是否已送達
															</div>
															<div class="modal-footer">
																<button type="button" class="btn btn-secondary no-radius" data-bs-dismiss="modal">
																	返回
																</button>
																<button type="submit" class="btn btn-dark-green no-radius">
																	已送達
																</button>
															</div>
														</div>
													</div>
												</div>
											</form>
											<?php
											break;
									}
								}
								?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php
view::view('footer');

unset($_SESSION['tickets_error']);