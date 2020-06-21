<?php
require_once("../includes/template.php");
require_once("../includes/logincheck.php");
require_once("../config/sqlconnect.php");
$frame = new Content("frame.html");
$index = new Content("todo.html");

$frame->put("css","../static/css/frame.css");
$frame->put('homepage', "../index.php");
$frame->put('calendar', "calendar.php");


$frame->put("lout", "block");
$frame->put("logout", "../logout.php");
$frame->put("login", "settings.php");
$frame->put("user", "HI! ".$_SESSION["nickname"]);

if (!empty($_GET['date'])) {
    $y = (int)explode('-',$_GET['date'])[0];
    $m = (int)explode('-',$_GET['date'])[1];
    $d = (int)explode('-',$_GET['date'])[2];
} else {
    header("Refresh:3;url=calendar.php");
    die("未知的操作，回上一頁");
}

if (isset($_POST["act"]) && $_POST["act"] == "add") {
    $sql = "INSERT INTO `events`(`etime`, `level`, `descr`, `uid`) VALUES (\"".$y."-".$m."-".$d." ".$_POST['time'].":00\",".$_POST['level'].",\"".$_POST['descr']."\",".$_SESSION['uid'].")";
    mysqli_query($con, $sql);
} else if (isset($_POST["act"]) && $_POST["act"] == "del") {
    $sql = "DELETE FROM `events` WHERE cid = ".$_POST['cid']." and  uid = ".$_SESSION['uid'].";";
    mysqli_query($con, $sql);
}

$sql = "SELECT * FROM `events` WHERE etime >= \"".$y."-".$m."-".$d."\" and etime <= \"".$y."-".$m."-".$d." 23:59:59\" and uid = ".$_SESSION['uid']." order by etime;";
$result = mysqli_query($con, $sql);

$list = "";
while ($row = mysqli_fetch_assoc($result)) {
    $list .= "<tr>";
    //$list .= "<td>".."</td>";
    $list .= "<td>".explode(' ', $row['etime'])[1]."</td>";
    if ($row['level'] == 1) {
        $list .= "<td>重要</td>";
    } else if ($row['level'] == 2) {
        $list .= "<td>普通</td>";
    } else {
        $list .= "<td>提醒</td>";
    }
    $list .= "<td>".$row['descr']."</td>";
    $list .= "<td><form action='' method='post'><input type='hidden' name='act' value='del'><input type='hidden' name='cid' value='".$row['cid']."'><input type='submit' value='刪除'></form></td>";
    $list .= "</tr>";
}

$index->put("events", $list);

$frame->put("container", $index->get());
echo $frame->get();
?>