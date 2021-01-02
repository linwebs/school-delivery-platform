<?php

//print_r($data);

use view\view;

view::view('header');
view::view('navbar');

$_SESSION['locale_area']
?>
	<h1>shop</h1>
<?php
view::view('footer');

unset($_SESSION['login_error']);