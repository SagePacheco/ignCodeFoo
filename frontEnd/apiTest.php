<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>API Test</title>
</head>

<body>
<pre>
<?php
$startIndex = '1';
$pullCount = '1';
$pullType = 'articles'; // videos or articles
$url = 'http://ign-apis.herokuapp.com/' . $pullType . '?startIndex=' . $startIndex . '&count=' . $pullCount;
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$data = curl_exec($ch);
curl_close($ch);
$apiData = json_decode($data);
var_dump($apiData);
?>
</pre>
</body>
</html>