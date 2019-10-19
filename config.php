<?php


//The directory where you drag the file into
$GLOBALS['importDirectory'] = "import_folder/";

//Acceptable file extensions
$GLOBALS['acceptable_extensions'] = array('csv');

//The acceptable mimetypes for csv
$GLOBALS['accepted_mimetypes'] = array(
    'text/csv',
    'text/plain',
    'application/csv',
    'text/comma-separated-values',
    'application/excel',
    'application/vnd.ms-excel',
    'application/vnd.msexcel',
    'text/anytext',
    'application/octet-stream',
    'application/txt',
);

//if a file is in the folder, and it won't work, should the system just delete it?
$GLOBALS['delete_bad_files'] = false;

$GLOBALS['log_output'] = true;


?>