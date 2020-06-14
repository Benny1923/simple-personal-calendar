<?php
require_once("../includes/template.php");
require_once("../includes/logincheck.php");
$frame = new Content("frame.html");
$index = new Content("calendar.html");

$frame->put("css","../static/css/frame.css");
$frame->put('homepage', "../index.php");
$frame->put('calendar', "calendar.php");


$frame->put("lout", "block");
$frame->put("logout", "../logout.php");
$frame->put("login", "settings.php");
$frame->put("user", "HI! ".$_SESSION["nickname"]);


$frame->put("container", $index->get());
echo $frame->get();

?>