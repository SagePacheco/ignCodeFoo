<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>IGN Time Challenge</title>
<!-- Bootstrap -->
<link href="css/bootstrap.min.css" rel="stylesheet">
<link href="css/styles.css" rel="stylesheet">

<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
<div id="content" class="container">
<div id="inputBlock" class="center-block">
<h1>ISO Date/Time Converter</h1>
<input name="dt" autocomplete="no" id="letters" type="text" placeholder="Enter Date" autofocus>
<button id="convertBtn">Convert</button>
</div>
<div id="responseBlock" class="text-center">
</div>
</div>
<div class="container">
<?php
require 'php/iso.php';
$timeExamples = [
	'3/20/2016',
	'4:05:07 PM',
	'Sunday, March 20, 2016',
	'Sunday, March 20, 2016 4:05 PM',
	'Sunday, March 20, 2016 4:05:07 PM',
	'Sunday 20th of March 2016 04:05:07 PM',
	'Sunday, MAR 20, 2016',
	'3/20/2016 4:05:07 PM',
	'March 20, 2016',
	'March 20',
	'March, 2016',
	'Sun, 20 Mar 2016 16:05:07 GMT',
	'Sun, 20 Mar 2016 16:05:07 -0800',
	'20160320 16:05:07',
	'20160320',
	'2016.03.20',
	'20/03/2016',
	'20 March 2016',
	'2016-20-03T16:05:07-08:00'
];
$currentExample = 0;
for($i = 0; $i < 5; $i++){
	print '<div class="row">';
	for($j = 0; $j < 4; $j++){
		$timeObject = new ignTime($timeExamples[$currentExample]);
		if(isset($timeExamples[$currentExample])){
			print '<div class="col-xs-6 col-md-3 exampleItem"><h1>Input</h1>';
			print '<p>' . $timeExamples[$currentExample] . '</p>';
			print '<h1>Result</h1>';
			print '<p>' . $timeObject->getISO() . '</p>';
			print '</div>';
			$currentExample++;
		}
	}
	print '</div>';
}
?>

</div>
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) --> 
<script src="js/jquery-1.11.3.min.js"></script>

<!-- Include all compiled plugins (below), or include individual files as needed --> 
<script src="js/bootstrap.min.js"></script>
<script src="js/frontEndLogic.js"></script>
</body>
</html>

