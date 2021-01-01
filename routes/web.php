<?php

use route\route;

route::get('/', 'welcome');

route::get('/login', 'login');
route::post('/login', 'login');
route::get('/register', 'register');

// show 404 error
route::no_page();