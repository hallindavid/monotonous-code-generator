<?php

//View Loading
function loadView($phpFileName,$withIncludes=true) {
	if ($withIncludes)
	{
		require_once(APPPATH.'includes/header.php');
		require_once(APPPATH.$phpFileName.'.php');
		require_once(APPPATH.'includes/footer.php');
	} else {
		require_once(APPPATH.$phpFileName.'.php');
	}
}

?>