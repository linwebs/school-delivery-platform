<?php

use route\route;

route::get('/', 'welcome');

route::geth('/login', 'login_page');
route::post('/login', 'login');
route::geth('/register', 'register_page');
route::post('/register', 'register');
route::geth('/logout', 'logout');

route::geth('/place', 'place');
route::gethp('/place/my', 'place_my');
route::gethp('/place/add', 'place_add');
route::postp('/place/add', 'place_add_finish');

route::geth('/shop', 'shop_list');
route::getpn('/shop', 'shop_meal', array('checkout'));
route::getp('/meal', 'meal_detail');
route::postp('/meal', 'meal_add');

route::geth('/car', 'car');
route::post('/car', 'car_checkout');
route::geth('/car/error', 'car_error');

route::geth('/ticket', 'ticket');
route::getpn('/ticket', 'ticket_detail', array('old', 'no_found'));
route::postp('/ticket', 'ticket_change');
route::get('/ticket/no_found', 'ticket/no_found');


// delivery
route::getpn('/tickets', 'tickets_detail', array('my', 'new'));
route::postpn('/tickets', 'tickets_change', array('my', 'new'));
route::geth('/tickets/new', 'tickets_new');
route::geth('/tickets/my', 'tickets_my');

// shop
route::geth('/order', 'order');
route::getpn('/order', 'order_detail', array('my', 'no_found'));
route::postp('/order', 'order_change');

route::geth('/account', 'account_main');
route::geth('/account/change', 'account_change');

// invalid
route::get('/error_403', 'error_403');
route::get('/error_500', 'error_500');

// show 404 error
route::no_page();