<?php
require_once("../includes/admincheck.php");
require_once("../includes/template.php");
require_once("../config/sqlconnect.php");

$frame = new Content("frame.html");
$index = new Content("accounts.html");

$frame->put("css","../static/css/frame.css");
$frame->put('homepage', "../index.php");
$frame->put('calendar', "../user/calendar.php");


$frame->put("lout", "block");
$frame->put("logout", "../logout.php");
$frame->put("login", "../user/settings.php");
$frame->put("user", "HI! ".$_SESSION["nickname"]);

$sql = "SELECT uid, username, name, isadmin from users;";
$result = mysqli_query($con, $sql);

$list = "";

while ($row = mysqli_fetch_assoc($result)) {
    $list .= "<tr>";
    $list .= "<td>".$row['uid']."</td>";
    $list .= "<td>".$row['username']."</td>";
    $list .= "<td>".$row['name']."</td>";
    $list .= "<td><button onclick=\"delacc(".$row['uid'].")\">刪除</button></td>";
    $list .= "<td><input type=\"checkbox\" ".($row['isadmin']?"checked=\"checked\"":"")."\" onclick=\"".($row['isadmin']?"deadmin(".$row['uid'].")":"setadmin(".$row['uid'].")")."\"></td>";
    $list .= "</tr>";
}

$index->put("users", $list);

$frame->put("container", $index->get());
echo $frame->get();

?>