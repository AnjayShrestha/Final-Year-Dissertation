<?php 
//creating function to run template.
function runTemplate($files, $templatesVar){
	extract($templatesVar);
	ob_start();
	require($files);
	$contents = ob_get_clean();
	return $contents;
}
 ?>