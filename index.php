<?php

//Path Definitions
define("BASEPATH", __DIR__);
define("APPPATH", __DIR__."/app/");
define("IMPORTPATH", __DIR__."/import_folder/");

//Config Options
$GLOBALS['acceptable_extensions'] = array('csv');
//if a file is in the import folder, and it doesn't meet criteria, should the system delete it?
$GLOBALS['delete_bad_files'] = false;
//Output log on main page
$GLOBALS['log_output'] = true;
//The acceptable mimetypes for csv
$GLOBALS['accepted_mimetypes'] = array('text/csv','text/plain','application/csv','text/comma-separated-values','application/excel','application/vnd.ms-excel','application/vnd.msexcel','text/anytext','application/octet-stream','application/txt');

//The helper functions
require(APPPATH."functions.php");


//Mini Router for the app

$request = $_SERVER['REQUEST_URI'];
$routeArray = parse_url($request);



switch ($routeArray["path"]) {
    case '/' :
        loadView('welcome');
        break;
    case '' :
        loadView('welcome');
        break;
    case '/process_file' :
        loadView('process_file');
        break;
    case '/process_file_backend':
        loadView('process_file_backend',false);
        break;
    case '/upload_file':
        loadView('upload_file', false);
        break;
    case '/get_directory':
        loadView('get_directory', false);
        break;
    default:
        http_response_code(404);
        loadView('404',false);
        die();
}
?>