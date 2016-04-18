<?php
ini_set('default_charset', 'utf-8');
// Retrieve User input
if (isset($_GET['letterInput'])){
	$letterInput = htmlspecialchars_decode($_GET['letterInput']);
	echo keyboardConverter($letterInput);
} else {
	$message["error"] = 'Please provide letters to process.';
	echo json_encode($message);	
}

function keyboardConverter($letterInput){
	require 'characterMap.php';
	$resultString = '';
	$inputArray = preg_split('//u', $letterInput, -1);
	foreach ($inputArray as $value){
		$resultString .= $characterMap[$value];		
	}
	$message['letters'] = $resultString;
	return json_encode($message);
}
?>