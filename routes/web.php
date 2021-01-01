<?php

use route\route;

route::get('/', 'welcome');

// show 404 error
route::no_page();