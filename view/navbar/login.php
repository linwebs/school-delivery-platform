<nav class="navbar navbar-header sticky-top navbar-expand-lg navbar-light bg-white">
	<div class="container">
		<a class="navbar-brand" href="#">
			<img src="/img/hungrycat_logo.png" alt="<?= APP_NAME ?>" class="d-inline-block align-top navbar-logo">
		</a>
		<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>
		<div class="collapse navbar-collapse" id="navbarSupportedContent">
			<ul class="navbar-nav me-auto mb-lg-0">
			</ul>
			<ul class="navbar-nav ml-auto">
				<li class="nav-item">
					<a class="nav-link" aria-current="page" href="/">首頁</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="/car">購物車</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="/ticket">訂單</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="/shop">店家</a>
				</li>
				<li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
						<?= $_SESSION['name'] ?>
					</a>
					<ul class="dropdown-menu" aria-labelledby="navbarDropdown">
						<li><a class="dropdown-item" href="/account">帳號資訊</a></li>
						<li><hr class="dropdown-divider"></li>
						<li><a class="dropdown-item" href="/logout">登出</a></li>
					</ul>
				</li>
			</ul>
		</div>
	</div>
</nav>