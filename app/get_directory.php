<?php 
$dir = new DirectoryScanner();

$log = $dir->log();
$files = $dir->files();

$displayFiles = array();
if ($files != false)
{
	foreach($files as $file)
	{
		$displayFiles[] = array("file_name"=>$file);
	}
}

$displayLog = $GLOBALS['log_output'];

echo json_encode(array(
	'hasFiles'=>($files != false ? '1' : '0'),
	'files'=>$displayFiles,
	'log'=>($displayLog ? implode("\n",$log) : ''),
	'log_count'=>($displayLog ? count($log) : 0)
));

?>
