<?php
// Retrieve User input
if (isset($_GET['letterInput']) &! preg_match('/[\'`^£$%&*()}{@#~?><0123456789>,;!|=_+¬-]/', $_GET['letterInput'])){
	$letterInput = $_GET['letterInput'];
	// Import Word Class
	require 'scrabbleWordClass.php';
	wordEngine($letterInput);
} else if (preg_match('/[\'`^£$%&*()}{@#~?><0123456789>,;!|=_+¬-]/', $_GET['letterInput'])) {
	$message["error"] = 'Please remove any special characters.';
	echo json_encode($message);
} else {
	$message["error"] = 'Please provide letters to process.';
	echo json_encode($message);	
}

function wordEngine($letterInput){		
	// Sanitize user input
	$letterInput = strtolower(trim($letterInput));

	// Create object from user input
	$userLetters = new scrabbleWord($letterInput);
	$userLetters->mapLetters();
	$maxLimit = strlen($letterInput);
	$wordCollection = dictionaryGrab('new', $userLetters, $maxLimit);
	
	$bestScoringWord = new scrabbleWord('');
	
	foreach($wordCollection as $value){
		if($value->wordMatch($userLetters)){
			if($value->calculateScore() >= $bestScoringWord->score){
				$bestScoringWord = $value;
			}
		}
	}
	if($bestScoringWord->letters === ''){
		$message["error"] = 'No words fit the bill yet.';
		echo json_encode($message);
	} else {
		$bestScoringWord->resetLetterScore();
//		$response[0] = "The amount of objects created: " . count($wordCollection);
//		$execTime = microtime(true) - $_SERVER["REQUEST_TIME_FLOAT"];
//		$response[1] = "Execution Time: " . $execTime;
//		$response[2] = $bestScoringWord;
		echo json_encode($bestScoringWord);
	}
}

// Imports dictionary
function dictionaryGrab($dictionary, $wordObject, $maxLimit){
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
		$wordCollection = [];
		while(!feof($rawDictionary)) {
			$tempString = trim(fgets($rawDictionary));
						
			// Filter words before creating objects
			if(strlen($tempString) <= $maxLimit){
				
				// Build Regular Expression for comparison
				$pattern = "[$wordObject->uniqueLetters]";
				$pattern = str_repeat($pattern, strlen($tempString));
				$pattern = "/" . $pattern . "/";
//				print "resulting pattern: $pattern \n";

				if (preg_match($pattern, $tempString)){
//					print "Possible word: $tempString \n";
					$tempObject = new scrabbleWord($tempString);
					array_push($wordCollection, $tempObject);
				}
			}
		}
		
		// Close Data set
		fclose($rawDictionary);
		
		// Return dictionary collection
		return $wordCollection;
}
?>