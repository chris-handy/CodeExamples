<?php
function getResource($url){
	$chandle=curl_init();
	curl_setopt($chandle, CURLOPT_URL,$url);
	curl_setopt($chandle, CURLOPT_RETURNTRANSFER, 1);
	$result=curl_exec($chandle);
	curl_close($chandle);
	
	return $result;
}

?>