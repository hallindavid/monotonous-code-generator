<?php

require_once('config.php');
require_once('vendor/autoload.php');

function cleanDirectoryAndGetFiles()
{
	$log = cleanDirectory();
	$files = getFiles();
	return array('log'=>$log,'files'=>$files);
}

function Slug($string)
{
    return strtolower(trim(preg_replace('~[^0-9a-z]+~i', '-', html_entity_decode(preg_replace('~&([a-z]{1,2})(?:acute|cedil|circ|grave|lig|orn|ring|slash|th|tilde|uml);~i', '$1', htmlentities($string, ENT_QUOTES, 'UTF-8')), ENT_QUOTES, 'UTF-8')), '-'));
}

function cleanDirectory()
{
	$log = array();

	if (!is_dir($GLOBALS['importDirectory'])) {
	    mkdir($GLOBALS['importDirectory']);
	    $log[] = "Import directory (" . $GLOBALS['importDirectory'] . ") not found.  Creating it.";
	}

	//Get files currently in folder, less the current/parent directory values
	$log[] = "Scanning for files in the (" . $GLOBALS['importDirectory'] . ")";
	$files = array_filter(scandir($GLOBALS['importDirectory']), function($item) {
	    return (is_file($GLOBALS['importDirectory'] . $item) && (is_readable($GLOBALS['importDirectory'] . $item)));
	});
	//$files = array_diff($files, array('.', '..'));

	$log[] = count($files) . " file(s) found.";
	//Loop through the files and rename them to be URL safe
	if (count($files) > 0) {
		foreach($files as $file)
		{
			$log[] = "processing file: " . $file;

			//File Processing Variables
			$fullFilePath = $GLOBALS['importDirectory'].$file;
			$acceptFile = true;
			$info = pathinfo($fullFilePath);
			$ext = "";

		  	if (in_array($info['extension'], $GLOBALS['acceptable_extensions']))
		  	{
		  		$log[] = "file extension (" . $info['extension'] . ") is allowed";
				$ext = $info['extension'];
		  	} else {
		  		$log[] = "file extension (" . $info['extension'] . ") is not allowed";
				$acceptFile = false;
		  	}

		  	if (in_array(mime_content_type($fullFilePath),$GLOBALS['accepted_mimetypes']))
		  	{
		  		$log[] = "mime type (" . mime_content_type($fullFilePath) . ") is allowed";
		  	} else {
		  		$log[] = "mime type (" . mime_content_type($fullFilePath) . ") is not allowed";
		  		$acceptFile = false;
		  	}

		  	if ($acceptFile) {
		  		$log[] = "file passed validation - renaming to URL safe name";
				$newFileName = Slug($info["filename"]) . "." . $ext;
				$newFilePath = $GLOBALS['importDirectory'] . $newFileName;
				rename($fullFilePath, $newFilePath);    
				$log[] = 'renaming ' . $file . ' TO ' . $newFileName;
		  	} else {
		  		if ($GLOBALS['delete_bad_files'])
		  		{
		  			unlink($fullFilePath);
		  			$log[] = "file failed validation - deleting file";
		  		} else {
		  			if (!is_dir($GLOBALS['importDirectory'] . "/rejected")) {
					    mkdir($GLOBALS['importDirectory'] . "/rejected");
					    $log[] = "Creating rejected folder (" . $GLOBALS['importDirectory'] . "/rejected)";
					}

		  			$newFileName = Slug($info["filename"]) . "." . $info["extension"];
		  			$newFilePath = $GLOBALS["importDirectory"] . "rejected/" . $newFileName;
		  			rename($fullFilePath, $newFilePath);
		  			$log[] = "file failed validation - renaming to " . $newFileName . " and moving to the rejects folder to keep it out of the way";
		  		}
		  	}
		}
	}

	return $log;
}

function getFiles()
{
	$files = array_filter(scandir($GLOBALS['importDirectory']), function($item) {
	    return (is_file($GLOBALS['importDirectory'] . $item) && (is_readable($GLOBALS['importDirectory'] . $item)));
	});

	if (count($files) > 0)
	{
		return $files;
	}
	return false;
}

function checkFile($fileName)
{
	$fullFilePath = $GLOBALS['importDirectory'].$fileName;

	if (!is_file($fullFilePath))
	{
		return false;
	}

	if (!is_readable($fullFilePath))
	{
		return false;
	}

	$info = pathinfo($fullFilePath);

  	if (!in_array($info['extension'], $GLOBALS['acceptable_extensions']))
  	{
  		return false;
  	}

  	if (!in_array(mime_content_type($fullFilePath),$GLOBALS['accepted_mimetypes']))
  	{
  		return false;
  	}

  	return true;

}

function getNumHeadings($fileName)
{

	if (!ini_get("auto_detect_line_endings")) {
    	ini_set("auto_detect_line_endings", '1');
	}

	$filePath =  $GLOBALS['importDirectory'].$fileName;
	$reader = Reader::createFromPath($filePath, 'r');



}
?>