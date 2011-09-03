<?php

$raw_specter = require 'specters/raw.php';

$encodings = array('windows-1251', 'koi8-r', 'iso8859-5');

$all_symbols = array_sum($raw_specter);

foreach ($encodings as $encoding)
{
	$specter = array();
	foreach ($raw_specter as $key => $count)
	{
		$weight = $count / $all_symbols;

		$letter1 = mb_substr($key, 0, 1, 'UTF-8');
		$letter2 = mb_substr($key, 1, 1, 'UTF-8');

		$key1 = iconv('UTF-8', $encoding, $letter1.$letter2);
		$key2 = iconv('UTF-8', $encoding, mb_strtoupper($letter1, 'UTF-8').$letter2);
		$key3 = iconv('UTF-8', $encoding, $letter1.mb_strtoupper($letter2, 'UTF-8'));
		$key4 = iconv('UTF-8', $encoding, mb_strtoupper($letter1, 'UTF-8').mb_strtoupper($letter2, 'UTF-8'));

		$specter[$key1] = $weight;
		$specter[$key2] = $weight;
		$specter[$key3] = $weight;
		$specter[$key4] = $weight;
	}

	file_put_contents('specters/'.$encoding.'.php', '<?php return '.var_export($specter, TRUE).';');
}