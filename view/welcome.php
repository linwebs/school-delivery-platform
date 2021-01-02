<?php

use view\view;

?>
<?php view::view('header'); ?>
<?php view::view('navbar'); ?>
	<div class="text-center index-area-top">
		<h1 class="index-title text-green-1">Hungry Cat</h1>
		<p class="index-description text-secondary">送餐互助服務 買到熱餐點 也找回人與人之間的溫度</p>
		<p class="index-danger text-danger">注意: 此為貓貓餓了 Ver. 2021 測試網站，請勿在此註冊點餐!</p>
		<a href="/shop" class="btn btn-green index-start-btn">
			<i class="fas fa-caret-right"></i>
			<i class="fas fa-caret-right"></i>
			馬上點餐
		</a>
	</div>
	<div class="bg-green-1">
		<div class="container">
			<div class="row text-center">
				<div class="col-sm-12 col-lg-4">
					<img src="/img/main/phone.png" class="index-phone img-fluid" />
				</div>
				<div class="col-sm-12 col-lg-8">
					<div class="index-area-center-text">
						<p class="index-description text-white">WHAT IS IT?</p>
						<br>
						<p class="index-description text-white">貓貓餓了是一個供你訂餐也可以送餐賺飲料錢的網路平台</p>
						<p class="index-description text-white">在這裡，你是一隻等待被救贖的飢餓小貓，也可以是一名負責任的主人</p>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="index-area-about">
		<div class="container">
			<p class="text-center h1">About</p>
			<p>身為大學生，應該都有過「不想上課地點與學餐兩邊跑」或「不想出去宿舍吃飯」的經驗，此平台乃是解決此問題的最佳之道，僅需支付些許的外送費，即可訂購校內餐點，由外送人員幫您外帶餐點，並送交至您指定的地點。</p>
			<p>因此，開發了這個「貓貓餓了」，希望想訂餐的同學能夠以單筆 15 元便宜的價格當外送員以及工程師的薪水，讓原本目的地就是你那棟樓的人順便幫你外帶。</p>
			<p>⊙⊙⊙ 未來也會努力與校外商家洽談外送相關服務 ⊙⊙⊙</p>
		</div>
	</div>
<?php view::view('footer'); ?>