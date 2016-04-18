<?php
if (isset($_GET['pullType']) && isset($_GET['startIndex'])){
	$pullType = $_GET['pullType'];
	$startIndex = $_GET['startIndex'];
	print listBuilder($pullType, $startIndex);
}

function listBuilder($pullType = 'videos', $startIndex = '1'){
	$pullCount = '10';
	$url = 'http://ign-apis.herokuapp.com/' . $pullType . '?startIndex=' . $startIndex . '&count=' . $pullCount;
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	$data = curl_exec($ch);
	curl_close($ch);
	$apiData = json_decode($data);
	$stringBuilder = '';
	$currentItem = $startIndex;
	for($i = 0; $i < $pullCount; $i++){
		
		if($pullType === 'videos'){
			$thumbnail = $apiData->data[$i]->thumbnail;
			$title = $apiData->data[$i]->metadata->title;
			$description = $apiData->data[$i]->metadata->description;
			$duration = $apiData->data[$i]->metadata->duration;
			$minutes = floor($duration/60);
			$seconds = $duration % 60;
			if($seconds < 10){$seconds = '0' . $seconds;}
			$duration = $minutes . ':' . $seconds;
			$url = $apiData->data[$i]->metadata->url;
		} else {
			$thumbnail = $apiData->data[$i]->thumbnail;
			$title = $apiData->data[$i]->metadata->headline;
			if(isset($apiData->data[$i]->metadata->subHeadline)){
				$description = $apiData->data[$i]->metadata->subHeadline;
			} else {
				$description = '';	
			}
			$duration = '';
			$url = '';
		}
		$stringBuilder .= "<a href='$url' class='row ignLink'>";
		$stringBuilder .= "<div style=\"background-image:url('$thumbnail');\" class=\"bg\"></div>";
		$stringBuilder .= "<div class='fg'></div>";
		if($currentItem == 1){
			$stringBuilder .= '<div id="redBlock"></div>';	
		}
		if($currentItem < 10){
			$currentItem = '0' . $currentItem;	
		}
		$stringBuilder .= '<p class="count col-xs-1">' . $currentItem . '</p>';
		$stringBuilder .= '<div class="titleBlock col-xs-8">';
		$stringBuilder .= '<p class="title">' . $title . '</p>';
		$stringBuilder .= '<p class="description">' . $description . '</p>';
		$stringBuilder .= '</div>';
		$stringBuilder .= '<p class="duration col-xs-2 col-md-3">' . $duration . '</p>';
		$stringBuilder .= '</a>';
		$currentItem++;
	}
	return $stringBuilder;
}
?>
