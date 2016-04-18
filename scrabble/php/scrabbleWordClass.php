<?php

class scrabbleWord {
var $letters;
var $uniqueLetters;
var $wordLength;
var $score;
var $letterMap;
var $letterScore = [
	"a" => 1,
	"b" => 3,
	"c" => 3,
	"d" => 2,
	"e" => 1,
	"f" => 4,
	"g" => 2,
	"h" => 4,
	"i" => 1,
	"j" => 8,
	"k" => 5,
	"l" => 1,
	"m" => 3,
	"n" => 1,
	"o" => 1,
	"p" => 3,
	"q" => 10,
	"r" => 1,
	"s" => 1,
	"t" => 1,
	"u" => 1,
	"v" => 4,
	"w" => 4,
	"x" => 8,
	"y" => 4,
	"z" => 10
];

public function __construct($letters){
	if($letters != ''){
		$this->letters = $letters;
		$this->wordLength = strlen($this->letters);
	} else {
		$this->letters = '';
		$this->score = 0;
		$this->letterMap = $this->getLetterMap();
	}
}

public function mapLetters(){
	$strLength = $this->wordLength;
	
	// Initialize letter at 0
	for( $i = 0; $i < $strLength; $i++ ) {
		$letterMap[$this->letters[$i]] = 0;
	}
	
	// Increment letter
	for( $i = 0; $i < $strLength; $i++ ) {
		$letterMap[$this->letters[$i]]++;
	}
	
	$arrayKeys = array_keys($letterMap);
	$this->uniqueLetters = implode("", $arrayKeys);
	return $letterMap;
}

public function resetLetterScore(){
	$this->letterScore = [
	"a" => 1,
	"b" => 3,
	"c" => 3,
	"d" => 2,
	"e" => 1,
	"f" => 4,
	"g" => 2,
	"h" => 4,
	"i" => 1,
	"j" => 8,
	"k" => 5,
	"l" => 1,
	"m" => 3,
	"n" => 1,
	"o" => 1,
	"p" => 3,
	"q" => 10,
	"r" => 1,
	"s" => 1,
	"t" => 1,
	"u" => 1,
	"v" => 4,
	"w" => 4,
	"x" => 8,
	"y" => 4,
	"z" => 10
];	
}

public function calculateScore(){
	$this->score = 0;
	$strLength = $this->wordLength;
	for( $i = 0; $i < $strLength; $i++ ) {
		$this->score += $this->letterScore[$this->letters[$i]];
	}
	unset($this->letterScore);
	return $this->score;
}

public function getLetterMap(){
		print_r($this->mapLetters());
}

public function wordMatch(scrabbleWord $inputLetters){
	$localMap = $this->mapLetters();
	$uniqueLetters = $this->uniqueLetters;
	$comparisonMap = $inputLetters->mapLetters();
	for ($i = 0; $i < strlen($uniqueLetters); $i++){
		$currentLetter = $uniqueLetters[$i];
		if(isset($comparisonMap[$currentLetter])){
			$localMap[$currentLetter] = $localMap[$currentLetter] - $comparisonMap[$currentLetter];	
			if($localMap[$currentLetter] < 0){$localMap[$currentLetter] = 0;}
		}
	}
	unset($this->uniqueLetters);
	unset($this->letterMap);
	if (array_sum($localMap) == 0){
		return true;
	} else {
		return false;
	}
}

}
?>