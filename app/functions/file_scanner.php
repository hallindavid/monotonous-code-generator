<?php

	class FileScanner {
		public $readable;
		public $fileName;
		public $filePath;
		public $cols;
		public $rows;
		public $sample;

		//Initialize file.  Returns true/false based on successful initialization
		public function __construct($fileName)
		{
			$this->fileName = $fileName;
			$this->filePath = IMPORTPATH.$fileName;
			if ($this->checkFile())
			{
				$this->readable = true;
				$this->getFileInfo();
			} else {
				$this->readable = false;
			}
			
		}

		public function info($var="") {

			if ($var == "filename") {
				return $this->fileName;
			} 
			
			if ($var == "filepath") {
				return $this->fileName;
			} 
			
			if ($var == "cols") {
				return $this->cols;
			}
			
			if ($var == "rows") {
				return $this->rows;
			}
			
			if ($var == "sample") {
				return $this->sample;
			}

			if ($var == "readable") {
				return $this->readable;
			}


			$arr["filename"] = $this->fileName;
			$arr["filepath"] = $this->filePath;
			$arr["cols"] = $this->cols;
			$arr["rows"] = $this->rows;
			$arr["sample"] = $this->sample;
			$arr["readable"] = $this->readable;

			return $arr;
			

			
		}

		private function checkFile()
		{
			if (!is_file($this->filePath))
			{
				return false;
			}

			if (!is_readable($this->filePath))
			{
				return false;
			}

			$info = pathinfo($this->filePath);

		  	if (!in_array($info['extension'], $GLOBALS['acceptable_extensions']))
		  	{
		  		return false;
		  	}
		  	
		  	if (!in_array(mime_content_type($this->filePath),$GLOBALS['accepted_mimetypes']))
		  	{
		  		return false;
		  	}

		  	return true;
		}

		private function getFileInfo() {
		    $row = 0;

		    $file = new SplFileObject($this->filePath);
			$file->setFlags(SplFileObject::READ_CSV | SplFileObject::READ_AHEAD | SplFileObject::SKIP_EMPTY | SplFileObject::DROP_NEW_LINE);
			$file->seek(PHP_INT_MAX);
			$this->rows = $file->key() +1;

			$sampleSize = min(array(10,$this->rows));

			for ($i = 0; $i< $sampleSize; $i++)
			{
				$file->seek($i);
				$row = $file->current();
				if ($i == 0) $this->cols = count($row);
				
				$colNum =1;
				foreach($row as $colData) {
					$this->sample["row".$i]['col'.$colNum] = $colData;
					$colNum++;
				}
			}
			$file = null;


		}

		public function formatFile($format)
		{

			if (!(($this->cols > 0) && ($this->rows > 0)))
			{
				return false;
			}

		    $file = new SplFileObject($this->filePath);
			$file->setFlags(SplFileObject::READ_CSV | SplFileObject::READ_AHEAD | SplFileObject::SKIP_EMPTY | SplFileObject::DROP_NEW_LINE);
			$rowNum = 1;
			foreach ($file as $row) {
				$table = array();
				$table["^0^"] = $rowNum;
				for ($i = 1; $i <= $this->cols; $i++)
				{
					$table["^".$i."^"] = $row[$i-1];
				}
		        	
				echo strtr($format, $table) . "\n";
				$rowNum++;
			}

			$file = null;
		}
	}
?>