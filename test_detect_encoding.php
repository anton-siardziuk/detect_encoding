<?php


$possible_encodings = array('windows-1251', 'koi8-r', 'iso8859-5');
/*
$data = 'Русская строка';
$encoding = 'iso8859-5';
$data = iconv('UTF-8', $encoding, 'Очень длинная русская строка');
*/

$data = file_get_contents('test/cp1251_2.html');

$weights = array();
$specters = array();
foreach ($possible_encodings as $encoding)
{
	$weights[$encoding] = 0;
	$specters[$encoding] = require 'specters/'.$encoding.'.php';
}

for ($i = 0; $i < strlen($data) - 1; $i++)
{
	$key = substr($data, $i, 2);

	foreach ($possible_encodings as $encoding)
	{
		if (isset($specters[$encoding][$key]))
		{
			$weights[$encoding] += $specters[$encoding][$key];
		}
	}
}

$sum_weight = array_sum($weights);
foreach ($weights as $encoding => $weight)
{
	$weights[$encoding] = $weight / $sum_weight;
}

var_dump($weights);