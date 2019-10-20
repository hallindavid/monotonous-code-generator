<?php
$_POST = json_decode(file_get_contents("php://input"),true);
if (isset($_POST["filename"]))
{
	$filename = $_POST["filename"];
}

if (isset($_POST["format"]))
{
	$format = $_POST["format"];
}

$file = new FileScanner($filename);
if (!$file->info("readable"))
{
	echo 'Unable to read file';
} else {
	$file->formatFile($format);
}

?>