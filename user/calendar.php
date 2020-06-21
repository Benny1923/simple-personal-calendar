<?php
require_once("../includes/template.php");
require_once("../includes/logincheck.php");
require_once("../config/sqlconnect.php");
$frame = new Content("frame.html");
$index = new Content("calendar.html");

$frame->put("css","../static/css/frame.css");
$frame->put('homepage', "../index.php");
$frame->put('calendar', "calendar.php");


$frame->put("lout", "block");
$frame->put("logout", "../logout.php");
$frame->put("login", "settings.php");
$frame->put("user", "HI! ".$_SESSION["nickname"]);

if (!empty($_GET['m'])) {
    $y = (int)explode('-',$_GET['m'])[0];
    $m = (int)explode('-',$_GET['m'])[1];
} else {
    $y = (int)date("Y");
    $m = (int)date("m");
}

$index->put("yearandmonth", $y."年".$m."月");
$index->put("lastmonth", $m==1?(($y-1)."-"."12"):($y."-".($m-1)));
$index->put("nextmonth", $m==12?(($y+1)."-"."1"):($y."-".($m+1)));

$tbody="";

//mon is 1 sun is 0

$first = date('w', strtotime($y.'-'.$m.'-1'));
$last = date('t', strtotime(date('Y-m-t', strtotime($y.'-'.$m.'-1'))));
$day = 0;

$sql = "SELECT date(etime), min(level),count(cid) FROM `events` WHERE uid = ".$_SESSION['uid']." and date(etime) >= \"".$y."-".$m."-1\" and date(etime) <= \"".$y."-".$m."-".$last."\" group by date(etime)";
$result = mysqli_query($con, $sql);
$arr = [];
while ($tmp = mysqli_fetch_row($result)) {
    //print_r($tmp);
    array_push($arr, $tmp);
}

function search($t) {
    global $arr;
    foreach ($arr as $key => $value) {
        if ((int)explode("-", $value[0])[2] == $t) {
            return $value;
        }
    }
    return false;
}

for ($i=1;$i<=5;$i++) {
    $tbody .= "<tr>";
    for ($j=1;$j<=7;$j++) {
        $tbody .= "<td id=\"w".$i."d".$j."\" >";
        if ($j-1 == $first && !$day) $day = 1;
        if ($day && $day<=$last) {
            if (search($day)) {
                $tbody .= "<a class='l".search($day)[1]." notify' href='todo.php?date=".$y."-".$m."-".$day."'><div>".$day."<p>".search($day)[2]."件待辦事項</p></div></a>";
            } else {
                $tbody .= "<a href='todo.php?date=".$y."-".$m."-".$day."'><div>".$day."</div></a>";
            }
            $day++;
        }
        $tbody .= "</td>";
    }
    $tbody .= "</tr>";
}

$index->put("tbody", $tbody);

$frame->put("container", $index->get());
echo $frame->get();

?>