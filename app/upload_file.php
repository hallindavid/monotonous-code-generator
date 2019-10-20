<?php

function clean_file_name($tempFileName,$ext){
	$cleanName = strtolower(trim(preg_replace('~[^0-9a-z]+~i', '-', html_entity_decode(preg_replace('~&([a-z]{1,2})(?:acute|cedil|circ|grave|lig|orn|ring|slash|th|tilde|uml);~i', '$1', htmlentities($tempFileName, ENT_QUOTES, 'UTF-8')), ENT_QUOTES, 'UTF-8')), '-'));
	
	$target_path =IMPORTPATH.$cleanName. ".".$ext;
			
	while(file_exists($target_path)){
		$t=time();
		$target_path = (IMPORTPATH.$t.'-'.$cleanName.".".$ext);
	}
	return $target_path;			
}

function codeToMessage($code)
{
    switch ($code) {
        case UPLOAD_ERR_INI_SIZE:
            $message = "The uploaded file exceeds the upload_max_filesize directive in php.ini";
            break;
        case UPLOAD_ERR_FORM_SIZE:
            $message = "The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form";
            break;
        case UPLOAD_ERR_PARTIAL:
            $message = "The uploaded file was only partially uploaded";
            break;
        case UPLOAD_ERR_NO_FILE:
            $message = "No file was uploaded";
            break;
        case UPLOAD_ERR_NO_TMP_DIR:
            $message = "Missing a temporary folder";
            break;
        case UPLOAD_ERR_CANT_WRITE:
            $message = "Failed to write file to disk";
            break;
        case UPLOAD_ERR_EXTENSION:
            $message = "File upload stopped by extension";
            break;

        default:
            $message = "Unknown upload error";
            break;
    }
    return $message;
}

$response = array();
$filename = '';
if (!empty($_FILES)) {
    // Undefined | Multiple Files | $_FILES Corruption Attack
    // If this request falls under any of them, treat it invalid.
    if (
        !isset($_FILES['dzfile']['error']) ||
        is_array($_FILES['dzfile']['error'])
    ) {
        $response = array('status'=>'error','info'=>'Unable to upload file');
    } else {

    	$filename = $_FILES['dzfile']['name'];
    	// Check $_FILES['dzfile']['error'] value.
	    if ($_FILES['dzfile']['error'] !== UPLOAD_ERR_OK)
	    {
	    	$response = array('status'=>'error', 'info'=>codeToMessage($_FILES['dzfile']['error']));
	    } else {
	    	// You should also check filesize here.
		    if ($_FILES['dzfile']['size'] > 1000000) {
		    	$response = array('status'=>'error', 'info'=>'Exceeded filesize limit.');
		    } else {
		    	// DO NOT TRUST $_FILES['dzfile']['mime'] VALUE !!
			    // Check MIME Type by yourself.
			    $mime = mime_content_type($_FILES['dzfile']['tmp_name']);
			    if (!in_array($mime, $GLOBALS['accepted_mimetypes'])) {
			    	$response= array('status'=>'error', 'info'=>'Invalid file type');
			    } else {
			    	$tempFileInfo = pathinfo($_FILES['dzfile']['name']);
			    	
			    	$preferredFilename 	= $tempFileInfo['filename'];
			    	$extension 			= $tempFileInfo['extension'];

					$cleanName = clean_file_name($preferredFilename, $extension);

				    if (!move_uploaded_file(
				        $_FILES['dzfile']['tmp_name'],
				        $cleanName
				    )) {
				        $response = array('status'=>'error','info'=>'Check server configuration, make sure IMPORTPATH is writable');
				    } else {
				    	$response = array('status'=>'success');
				    }
			    }
		    }
	    }
    }
}

if ($response["status"] != "success")
{
	header("HTTP/1.0 400 Bad Request");
	if (strlen($filename) > 0) {
		echo 'Unable to Upload ' . $filename . ' - ';
	} else {
		echo 'Unable to Upload File - ';
	}
	echo $response["info"];
} else {
	echo 'Success!';
}


?>     