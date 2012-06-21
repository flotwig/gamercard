<?php
require_once('global.php');
$parts = explode('?', $_SERVER['REQUEST_URI']);
$parts = explode("/", $parts[0]);
$th = explode('.',end($parts));
if (end($th)=='png') {
	$_GET['theme']=$th[0];
	$_GET['gamertag']=$parts[count($parts)-2];
}
if ($_GET['theme']=='') { $_GET['theme'] = 'default'; }
$the = end(explode('/',$_GET['theme']));
$theme = json_decode(file_get_contents('./resources/' . $the . '.json'),TRUE);
$theme['tagfont'] = './resources/' . $theme['tagfont'];
if (isset($_GET['a_gc'])) {
	$ag = explode(',',$_GET['a_gc']);
	$ag[0] = (int)$ag[0]; $ag[1] = (int)$ag[1]; $ag[2] = (int)$ag[2]; 
	if (count($ag)==3&&abs($ag[0])<256&&abs($ag[1])<256&&abs($ag[2])<256) {
		$theme['tagcolor'] = $ag;
	}
}
if (isset($_GET['a_mc'])) {
	$ag = explode(',',$_GET['a_mc']);
	$ag[0] = (int)$ag[0]; $ag[1] = (int)$ag[1]; $ag[2] = (int)$ag[2]; 
	if (count($ag)==3&&abs($ag[0])<256&&abs($ag[1])<256&&abs($ag[2])<256) {
		$theme['color'] = $ag;
	}
}
$cachefile = 'cache/' . $_GET['gamertag'] . '.json';
$avacache = 'cache/avatars/' . $_GET['gamertag'] . '-' . $theme['picsize'][0] . 'px.png';
if ($_GET['gamertag']!=='') {
	if (file_exists($cachefile)&&filemtime($cachefile)>(time()-3600)) {
		$gtag = json_decode(file_get_contents($cachefile),TRUE);
	} else {
			$gtag = json_decode(file_get_contents(X360_API . '?gamertag=' . $_GET['gamertag']),TRUE);
		$fh = fopen($cachefile, 'w') or die("can't open file");
		fwrite($fh, json_encode($gtag));
		fclose($fh);
	}
}
$pic = imagecreatefrompng('./resources/' . $theme['image']);
$rep = round($gtag['Reputation']);
$tagcolor = imagecolorallocate($pic,$theme['tagcolor'][0],$theme['tagcolor'][1],$theme['tagcolor'][2]);
$color = imagecolorallocate($pic,$theme['color'][0],$theme['color'][1],$theme['color'][2]);
if ($gtag['GamertagExists']) {
	imagettftext($pic,$theme['fontsize'],0,$theme['taglocation'][0],$theme['taglocation'][1],$tagcolor,$theme['tagfont'],$gtag['Gamertag']);
	imagettftext($pic,$theme['fontsize'],0,$theme['scorelocation'][0],$theme['scorelocation'][1],$color,$theme['tagfont'],$gtag['Gamerscore']);
	if (file_exists($avacache)&&filemtime($avacache)>(time()-3600)) {
		$gpic = imagecreatefrompng($avacache);
	} else {
		$gpic = @imagecreatefrompng($gtag['Pictures']['Tile' . $theme['picsize'][0] . 'px']);
		if ($gpic) {
			imagepng($gpic,$avacache);
		}
	}
	if ($gpic) {
		imagecopy($pic,$gpic,$theme['pic'][0],$theme['pic'][1],0,0,$theme['picsize'][0],$theme['picsize'][1]);
		imagedestroy($gpic);
	}
	if (is_array($gtag['LastPlayed'])) {
		foreach($gtag['LastPlayed'] as $k => $game) {
			if (!file_exists('cache/games/' . strtolower(str_replace(' ','',$game['Title'])) . '.jpeg')) {
				$gpic = imagecreatefromjpeg($game['Pictures']['Tile32px']);
				imagejpeg($gpic,'cache/games/' . strtolower(str_replace(' ','',$game['Title'])) . '.jpeg');
			} else {
				$gpic = imagecreatefromjpeg('cache/games/' . strtolower(str_replace(' ','',$game['Title'])) . '.jpeg');
			}
			imagecopy($pic,$gpic,$theme['gamelocations'][$k][0],$theme['gamelocations'][$k][1],0,0,$theme['gamesizes'][0],$theme['gamesizes'][1]);
			imagedestroy($gpic);
		}
	}
	imagettftext($pic,$theme['fontsize'],0,$theme['replocation'][0],$theme['replocation'][1],$color,$theme['tagfont'],$gtag['Reputation'] . '/5');
} else {
	imagettftext($pic,$theme['fontsize'],0,$theme['taglocation'][0],$theme['taglocation'][1],$tagcolor,$theme['tagfont'],'Invalid gamertag! Supply a' . "\n" . 'valid gamertag in the' . "\n" . '"gamertag" GET variable.');
}
$halfalpha = imagecolorallocatealpha($pic,255,255,255,64);
imagettftext($pic,6,0,imagesx($pic)-60,imagesy($pic)-2,$halfalpha,$theme['tagfont'],'j.mp/xboxgc');
header('Content-Type: image/png'); 
imagepng($pic);
imagedestroy($pic);
die();
?>
