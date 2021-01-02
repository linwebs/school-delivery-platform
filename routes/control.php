<?php

require_once FOLDER_PATH . 'src/router.php';
require_once FOLDER_PATH . 'src/route.php';

use router\router;

if (isset(router::locale()[0])) {
	$local = router::locale()[0];
} else {
	$local = '';
}

switch ($local) {
	case 'api':
		require_once FOLDER_PATH . 'routes/api.php';
		break;
	case 'img':
		require_once FOLDER_PATH . 'routes/img.php';
		break;
	default:
		require_once FOLDER_PATH . 'routes/web.php';
}

