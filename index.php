<!--
signature: f9e60e0a1be1e83dfa1c1c0b6cd6c46eedccd497
Its a simple spell but quite unbreakable.
-->

<?php
require_once("includes/template.php");
session_start();
$frame = new Content("frame.html");
$index = new Content("index.html");

$frame->put("css", "static/css/frame.css");
$frame->put('homepage', "index.php");
$frame->put('calendar', "user/calendar.php");

if (!isset($_SESSION['username'])) {
  $frame->put("login", "login.php");
  $frame->put("user", "登入");
  $frame->put("lout", "none");
} else {
  $frame->put("lout", "block");
  $frame->put("logout", "logout.php");
  $frame->put("login", "user/settings.php");
  $frame->put("user", "HI! ".$_SESSION["nickname"]);
}

$frame->put("container", $index->get());
echo $frame->get();

?>

