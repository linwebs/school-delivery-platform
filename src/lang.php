<?php

namespace lang;

class lang {
	public static function lang($str) {
		return (require FOLDER_PATH . 'lang/' . LANG . '/lang.php')[$str];
	}
}