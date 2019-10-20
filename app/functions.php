<?php

if (!ini_get("auto_detect_line_endings")) {
    	ini_set("auto_detect_line_endings", '1');
}

require_once(APPPATH."functions/view_loading.php");
require_once(APPPATH."functions/directory_scanner.php");
require_once(APPPATH."functions/file_scanner.php");


?>