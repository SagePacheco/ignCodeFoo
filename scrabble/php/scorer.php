<?php
// Imports dictionary
ini_set('max_execution_time', 1800); //300 seconds = 5 minutes
require 'scrabbleWordClass.php';
$dictionary = 'new';
switch($dictionary){
	case 'ign':
	$filePath = '../txt/wordLibrary.txt';
	break;
	case 'foster':
	$filePath = '../txt/fosterDictionary.txt';
	break;
	case 'new':
	$filePath = '../txt/newDictionary.txt';
	break;
}

$rawDictionary = fopen($filePath, "r") or die("Unable to open file!");
while(!feof($rawDictionary)) {
	$tempString = trim(fgets($rawDictionary));
	$tempObject = new scrabbleWord($tempString);
	$tempObject->calculateScore();
	$resultString = $tempObject->letters . "," . $tempObject->score . "\n";
	file_put_contents('../txt/organized.txt', $resultString, FILE_APPEND | LOCK_EX);
}
print "Data Organized";
// Close Data set
fclose($rawDictionary);
?>