<?php

$data = file_get_contents('data/voina_mir_utf8.txt');

$data = mb_strtolower($data, 'UTF-8');

$letters = "абвгдеёжзийклмнопрстуфхцчьыъэюя";

$counts = array();

for ($i = 0; $i < mb_strlen($letters, 'UTF-8'); $i++)
{
	for ($j = 0; $j < mb_strlen($letters, 'UTF-8'); $j++)
	{
		$letter1 = mb_substr($letters, $i, 1, 'UTF-8');
		$letter2 = mb_substr($letters, $j, 1, 'UTF-8');

		$counts[$letter1.$letter2] = 0;
	}
}

$data_len = mb_strlen($data, 'UTF-8');
$all_len = $data_len;
$cur_symbol = 0;
for ($i = 0; $i < $data_len - 1; $i++)
{
	$cur_symbol++;
	$cur_key = mb_substr($data, $i, 2, 'UTF-8');
	if (isset($counts[$cur_key]))
	{
		$counts[$cur_key]++;
	}
	if ($i >= 10000)
	{
		echo sprintf("%0.2f\n", $cur_symbol / $all_len * 100);
		flush();
		$data = mb_substr($data, $i, $data_len - $i, 'UTF-8');
		$data_len = mb_strlen($data, 'UTF-8');
		$i = 0;
	}
}

file_put_contents('specters/raw.php', '<?php return '.var_export($counts, TRUE).';');