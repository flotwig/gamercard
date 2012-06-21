<?php
$t = 0;
$i = 0;
$f = 0;
$gamertags = glob('cache/*.json');
foreach ($gamertags as $tag) {
	$i++;
	$t++;
	$f = $f + filesize($tag);
	unlink($tag);
	echo $tag . ' removed...<br>';
}
echo 'Gamertag cache cleared, ' . $i . ' gamertags cleared.<br>';
$i=0;
$avatars = glob('cache/avatars/*.png');
foreach ($avatars as $ava) {
	$i++;
	$t++;
	$f = $f + filesize($ava);
	unlink($ava);
	echo $ava . ' removed...<br>';
}
echo 'Avatar cache cleared, ' . $i . ' avatars cleared.<br>';
echo $t . ' items removed and ' . round($f/(1024*1024),2) . 'MB of space cleared.';
?>