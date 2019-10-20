<?php 

class DirectoryScanner {

	public $log;
	public $acceptableFiles;

	public function __construct() {
		$this->log = array();
		$this->files = array();
		$this->cleanDirectory();
	}

	public function log()
	{
		return $this->log;
	}

	private function loggit($message) {
		$this->log[] = $message;
	}

	public function files()
	{
		if (count($this->files) > 0)
		{
			return $this->files;
		} 
		
		return false;
	}

	public function getReadableFiles()
	{
		$this->loggit("Scanning for files in the (" . IMPORTPATH . ")");
		$files = array_filter(scandir(IMPORTPATH), function($item) {
		    return (is_file(IMPORTPATH . $item) && (is_readable(IMPORTPATH . $item)));
		});
		$this->loggit(count($files) . ' file(s) found');
		
		return $files;
	}

	public function checkFile($fileName)
	{
		$fullFilePath = IMPORTPATH.$fileName;

		if (!is_file($fullFilePath))
		{
			$this->loggit("Unable to find file: $fileName");
			return false;
		} else {
			$this->loggit("$fileName is readable");
		}

		if (!is_readable($fullFilePath))
		{
			$this->loggit("$fileName is not readable");
			return false;
		} else {
			$this->loggit("$fileName is readable");
		}

		$info = pathinfo($fullFilePath);

	  	if (!in_array($info['extension'], $GLOBALS['acceptable_extensions']))
	  	{
	  		$this->loggit($fileName . " has unacceptable extension of " . $info["extension"]);
	  		return false;
	  	} else {
	  		$this->loggit($fileName . " has acceptable extension: " . $info["extension"]);
	  	}

	  	if (!in_array(mime_content_type($fullFilePath),$GLOBALS['accepted_mimetypes']))
	  	{
	  		$this->loggit($fileName . " has unacceptable mime type: " . mime_content_type($fullFilePath));
	  		return false;
	  	} else {
	  		$this->loggit($fileName . " has accepted mime type: " . mime_content_type($fullFilePath));
	  	}

	  	return true;
	}	

	private function cleanDirectory() {
		$this->checkFolderExists(IMPORTPATH);
		$files = $this->getReadableFiles();
		
		//Loop through the files and rename them to be URL safe
		if (count($files) > 0) {
			foreach($files as $file) {
				$this->loggit("processing file: " . $file);

				//File Processing Variables
				$fullFilePath = IMPORTPATH.$file;
				$info = pathinfo($fullFilePath);
				

				$acceptFile = $this->checkFile($file);
				$info = pathinfo($fullFilePath);
				$ext = $info["extension"];

			  	if ($acceptFile) {
			  		$this->loggit("file passed validation");

					$newFileName = $this->Slug($info["filename"]) . "." . $ext;

					if ($newFileName != $file) {
						$this->loggit("Renaming to URL safe file name: " . $newFileName);
						$newFilePath = IMPORTPATH . $newFileName;
						rename($fullFilePath, $newFilePath);    
					}
			  	} else {
			  		if ($GLOBALS['delete_bad_files']) {
			  			unlink($fullFilePath);
			  			$this->loggit("file failed validation - deleting file");
			  		} else {
			  			$this->checkFolderExists(IMPORTPATH."rejected");
			  			$newFileName = $this->Slug($info["filename"]) . "." . $info["extension"];
			  			$newFilePath = IMPORTPATH . "rejected/" . $newFileName;
			  			rename($fullFilePath, $newFilePath);
			  			$this->loggit("file failed validation - moving to rejected folder");
			  		}
			  	}
			}
		}
		$this->files = $this->getReadableFiles();
	}

	private function checkFolderExists($path)
	{
		if (!is_dir($path)) {
		    mkdir($path);
		    $this->loggit("No directory found at $path.  Making one now");
		}
	}

	private function Slug($string)
	{
	    return strtolower(trim(preg_replace('~[^0-9a-z]+~i', '-', html_entity_decode(preg_replace('~&([a-z]{1,2})(?:acute|cedil|circ|grave|lig|orn|ring|slash|th|tilde|uml);~i', '$1', htmlentities($string, ENT_QUOTES, 'UTF-8')), ENT_QUOTES, 'UTF-8')), '-'));
	}

}

?>