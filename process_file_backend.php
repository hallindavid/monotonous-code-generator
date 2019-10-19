<?php

	require_once('functions.php');

$filename = "";
$format = "";

$_POST = json_decode(file_get_contents("php://input"),true);

if (isset($_POST["filename"]))
{
	$filename = $_POST["filename"];
}

if (isset($_POST["format"]))
{
	$format = $_POST["format"];
}

readFullFile($filename, $format);

?>