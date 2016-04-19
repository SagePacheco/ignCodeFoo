<?php
if(isset($_GET['dt'])){
	$userInput = $_GET['dt'];
	$time = new ignTime($userInput);
	echo $time->getISO();
}

class ignTime{
	var $result;
	var $year;
	var $month;
	var $day;
	var $hour;
	var $minute;
	var $second;
	var $gmtOffset;
	var $nameDay;
	var $iso;
	
	public function __construct($userInput){
		$this->extractData($userInput);
		$this->setISO();
	}
	
	private function extractData($userInput){
		
		$months = [
					'january' => '01',
					'february' => '02',
					'march' => '03',
					'april' => '04',
					'may' => '05',
					'june' => '06',
					'july' => '07',
					'august' => '08',
					'september' => '09',
					'october' => '10',
					'november' => '11',
					'december' => '12',
					'jan' => '01',
					'feb' => '02',
					'mar' => '03',
					'apr' => '04',
					'may' => '05',
					'jun' => '06',
					'jul' => '07',
					'aug' => '08',
					'sep' => '09',
					'oct' => '10',
					'nov' => '11',
					'dec' => '12'
		];
		
		// Initialize Regular Expressions
		$exNameDay='(monday|tuesday|wednesday|thursday|friday|saturday|sunday|tues|thur|thurs|sun|mon|tue|wed|thu|fri|sat)';
		$exMonth='(jan(?:uary)?|feb(?:ruary)?|mar(?:ch)?|apr(?:il)?|may|jun(?:e)?|jul(?:y)?|aug(?:ust)?|sep(?:tember)?|sept|oct(?:ober)?|nov(?:ember)?|dec(?:ember)?)';
		$exDay='(?:((?:[0-2]?\\d{1})|(?:[3][01]{1}))(?![\\d]))';
		$exYear='((?:(?:[1]{1}\d{1}\d{1}\d{1})|(?:[2]{1}\d{3})))(?![\d])';
		$exHMS12 = '(?:((?:[0-1][0-9])|(?:[2][0-3])|(?:[0-9])):([0-5][0-9]):?([0-5][0-9])?(?:\s?(am|AM|pm|PM)))';
		$exHMS24 = '(?:((?:[0-1][0-9])|(?:[2][0-3])):([0-5][0-9]):?([0-5][0-9])(?! pm|am))';
		$exGMT = '((?:[a-z]{3})|(?:-[0-2]\d\d\d))';
		$exMDY = '(?:(\b[1-9]|[1][012])[-:\/.]((?:[12]?\d{1})|(?:[3][01]{1}))[-:\/.]((?:[1]{1}\d{1}\d{1}\d{1})|(?:[2]{1}\d{3})))(?![\d])';
		$exDMY = '(?:((?:[0-2]?\d{1})|(?:[3][01]{1}))[-:\/.]([0]?[1-9]|[1][012])[-:\/.]((?:[1]{1}\d{1}\d{1}\d{1})|(?:[2]{1}\d{3})))(?![\d])';
		$exYMDInt = '(?:((?:[1]{1}\d{1}\d{1}\d{1})|(?:[2]{1}\d{3}))([0]?[1-9]|[1][012])((?:[0-2]?\d{1})|(?:[3][01]{1}))(?![\d]))';
		$exYMDDot = '(?:((?:[1]{1}\d{1}\d{1}\d{1})|(?:[2]{1}\d{3}))[-:\/.]([0]?[1-9]|[1][012])[-:\/.]((?:[0-2]?\d{1})|(?:[3][01]{1})))(?![\d])';
		
		// Remove Whitespace
		$userInput = trim($userInput);
		
		// Switch to Lowercase
		$userInput = strtolower($userInput);
		

		// Extract day of week string
		if (preg_match('/' . $exNameDay . '/', $userInput, $matches)){
			$this->nameDay = $matches[1];
			$userInput = str_replace($this->nameDay, '', $userInput);
		}
		
		// Extract Month string
		if (preg_match('/' . $exMonth . '/', $userInput, $matches)){
			$this->month = $months[$matches[1]];
			$userInput = str_replace($matches[1], '', $userInput);		
		}
		
		// Time Extraction Switch
		switch($userInput){
			
		// Extract Time 12 HR
		case (preg_match_all('/' . $exHMS12 . '/', $userInput, $matches) ? true : false):
			$this->hour = $matches[1][0];
			$this->minute = $matches[2][0];
			if($matches[3][0] !== ''){
				$this->second = $matches[3][0];
			} else {
				$this->second = '00';	
			}
			if($matches[4][0] === 'pm'){
				$this->hour += 12;						
			};
			$userInput = str_replace($matches[0][0], '', $userInput);
			break;

		// Extract Time 24 HR
		case (preg_match_all('/' . $exHMS24 . '/', $userInput, $matches) ? true : false):
			$this->hour = $matches[1][0];
			$this->minute = $matches[2][0];
			if($matches[3][0] !== ''){
				$this->second = $matches[3][0];
			} else {
				$this->second = '00';	
			}
			$userInput = str_replace($matches[0][0], '', $userInput);
			break;
		}
		// If string still contains data...
		if (preg_match_all('/(?:[a-z]|[0-9])/', $userInput)){
	
			// Date Extraction Switch
			switch($userInput){
	
				// Extract full American date. M/D/YYYY
				case (preg_match_all('/' . $exMDY . '/', $userInput, $matches) ? true : false):	
					$this->month = $matches[1][0];
					$this->day = $matches[2][0];
					$this->year = $matches[3][0];
					$userInput = str_replace($matches[0][0], '', $userInput);
					break;	
	
				// Extract full Euro date. DD/MM/YYYY
				case (preg_match_all('/' . $exDMY . '/', $userInput, $matches) ? true : false):	
					$this->day = $matches[1][0];
					$this->month = $matches[2][0];
					$this->year = $matches[3][0];
					$userInput = str_replace($matches[0][0], '', $userInput);
					break;
		
				// Extract long date int. YYYYMMDD
				case (preg_match_all('/' . $exYMDInt . '/', $userInput, $matches) ? true : false):	
					$this->year = $matches[1][0];
					$this->month = $matches[2][0];
					$this->day = $matches[3][0];
					$userInput = str_replace($matches[0][0], '', $userInput);
					break;
	
				// Extract long date int. YYYY.MM.DD
				case (preg_match_all('/' . $exYMDDot . '/', $userInput, $matches) ? true : false):
					$this->year = $matches[1][0];
					$this->month = $matches[2][0];
					$this->day = $matches[3][0];
					$userInput = str_replace($matches[0][0], '', $userInput);
					break;
				
				default:
					// Extract Year int
					if(preg_match('/' . $exYear . '/', $userInput, $matches)){
						$this->year = $matches[1];
						$userInput = str_replace($this->year, '', $userInput);
					}
			
					// Extract Day int
					if(preg_match('/' . $exDay . '/', $userInput, $matches)){
						$this->day = $matches[1];
						$userInput = str_replace($this->day, '', $userInput);
					}
					break;
		}
					
			// Standard offset
			if(preg_match_all('/' . $exGMT . '/', $userInput, $matches)){
				$this->gmtOffset = $matches[1][0];
				$userInput = str_replace($matches[0][0], '', $userInput);				
			}
			
			// Final Cleanup. Month int and offset
			if(preg_match_all('/' . '-([01][0-9])t(-\d\d):(\d\d)' . '/', $userInput, $matches)){
				$this->month = $matches[1][0];
				$this->gmtOffset = $matches[2][0] . $matches[3][0];
				$userInput = str_replace($matches[0][0], '', $userInput);				
			}
		}
	}

	private function setISO(){
	$localISO = '';
	if($this->year !== null){
		$localISO .= $this->year;
	} else {unset($this->year);}

	if($this->month !== null){
		$localISO .= '-' . $this->month;
	} else {unset($this->month);}

	if($this->day !== null){
		$localISO .= '-' . $this->day;
	} else {unset($this->day);}

	if($this->hour !== null){
		$localISO .= ' ' . $this->hour;
	} else {unset($this->hour);}

	if($this->minute !== null){
		$localISO .= '-' . $this->minute;
	} else {unset($this->minute);}

	if($this->second !== null){
		$localISO .= '-' . $this->second;
	} else {unset($this->second);}
	
	if($this->gmtOffset !== null){
		if($this->gmtOffset === 'gmt'){
			$this->gmtOffset = '-0000';
			$localISO .= $this->gmtOffset;
		} else {
			$localISO .= $this->gmtOffset;
		}
	} else {unset($this->gmtOffset);}

	$this->iso = trim($localISO, '-');
	}

	public function getISO(){
		return $this->iso;
	}
}
?>