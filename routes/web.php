<?php

use route\route;

route::get('/', 'welcome');

route::get('/login', 'login');
route::post('/login', 'login');
route::get('/register', 'register');
route::post('/register', 'register');
route::geth('/logout', 'logout');

route::geth('/place', 'place');
route::gethp('/place/my', 'place_my');
route::gethp('/place/add', 'place_add');
route::postp('/place/add', 'place_add_finish');
route::geth('/shop', 'shop_list');

// invalid
route::get('/error_403', 'error_403');
route::get('/error_500', 'error_500');

// show 404 error
route::no_page();