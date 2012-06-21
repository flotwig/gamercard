<?php
require_once('global.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Gamercard Generator</title>
<link href="style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="jscolor/jscolor.js"></script>
</head>
<body>
<div style="float:right;position:relative;margin-right:10px;margin-top:10px;">
<img src="card.php/flotwig/default.png" alt="Example Gamercard">
</div>
<div class="container">
	<div class="header"><a href="index.html"><img src="images/header.png" width="308" height="30" alt="header"/></a></div><!--Header-->
    <div class="main-wrapper"><!--Start Wrapper-->
    	<div class="welcome">Welcome to the Xbox 360 gamercard generator! <br /> It's pretty raw, but it does what it's supposed to do.</div>
<?php 
if (isset($_POST['gamertag'])&&isset($_POST['theme'])) {
$_GET['gamertag'] = urlencode(urldecode($_GET['gamertag']));
$img = 'http://experiments.chary.us/gamercard/card.php/' . urlencode($_POST['gamertag']) . '/' . urlencode($_POST['theme']) . '.png';
$args = array();
if ($_POST['a_gc']!=='') {
$args['a_gc'] = hex2RGB($_POST['a_gc'],TRUE);
}
if ($_POST['a_mc']!=='') {
$args['a_mc'] = hex2RGB($_POST['a_mc'],TRUE);
}
$query = http_build_query($args);
if ($query!=='') {
$img .= '?' . $query;
}
?>
<!--Results-->
<div class="result-main">
Your Gamercard<br />
	<div class="card"><img src="<?php echo $img; ?>"></div>
	<div class="link">
<strong>BBcode</strong> (for use on forums)<br/>
<textarea style="width:100%;">[url=http://experiments.chary.us/gamercard/][img]<?php echo $img; ?>[/img][/url]</textarea><br/>
<strong>HTML</strong> (for use on blogs and websites)<br/>
<textarea style="width:100%;"><a href="http://experiments.chary.us/gamercard/"><img src="<?php echo $img; ?>"></a></textarea><br/>
<strong>Raw image URL</strong><br/>
<textarea style="width:100%;"><?php echo $img; ?></textarea></div>
</div>
<!--End of Results-->           
<?php
} else {
?>
<!--Main Form-->
<div class="main-forms">
<form action="index.php" method="POST">
Gamertag: <br /> <input type="text" name="gamertag" class="tag" /><br />
Gamercard Design: <br /> 
<table style="width:100%;">
<tr><td style="text-align:right;"><input type="radio" name="theme" value="mintgreen"> Mint Green <a href="card.php/flotwig/mintgreen.png">(view example)</a></td>
<td style="text-align:left;"><input type="radio" name="theme" value="default" checked="checked"> Card <a href="card.php/flotwig/default.png">(view example)</a></td></tr>
<tr><td style="text-align:right;"><input type="radio" name="theme" value="sig"> Signature <a href="card.php/flotwig/sig.png">(view example)</a></td>
<td style="text-align:left;"><input type="radio" name="theme" value="retro"> Retro <a href="card.php/flotwig/retro.png">(view example)</a></td></tr>
<tr><td style="text-align:right;"><input type="radio" name="theme" value="red"> Red <a href="card.php/flotwig/red.png">(view example)</a></td>
<td style="text-align:left;"><input type="radio" name="theme" value="retrosig"> Retro Sig <a href="card.php/flotwig/retrosig.png">(view example)</a></td></tr>
</table>
<br />
Gamertag Color: <br /> <input class="color {required:false}" name="a_gc"><br />
Gamerscore and Rep Color: <br /> <input class="color {required:false}" name="a_mc"><br />
<input type="submit" name="generate"  class="generate" />
</form>
</div>
<!--End Main Form-->
<?php
}
?>
    </div>
<!--End Wrapper-->
<div class="footer">
 <div class="za">Created and coded by <a href="http://za.chary.us/">za.chary.us</a>. Designs generously donated by ska @ GTAForums. Thanks, ska! Page designed by Aaron Cornwell.</div>
</div>
 
</div>
</body>
</html>
