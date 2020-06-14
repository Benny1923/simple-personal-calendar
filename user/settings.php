<?php
require_once("../includes/template.php");
require_once("../config/sqlconnect.php");
require_once("../includes/logincheck.php");
$frame = new Content("frame.html");
$index = new Content("settings.html");

$index->put('userid', $_SESSION['username']);
$index->put('username', $_SESSION['nickname']);

$frame->put("css","../static/css/frame.css");
$frame->put('homepage', "../index.php");
$frame->put('calendar', "calendar.php");


$frame->put("lout", "block");
$frame->put("logout", "../logout.php");
$frame->put("login", "settings.php");
$frame->put("user", "HI! ".$_SESSION["nickname"]);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!empty(['uname'])) {
        $uacc = $_SESSION['username'];
        $uname = $_POST["uname"];
        if (isset($_POST['password']) && !empty($_POST['password'])) {
            $password = $_POST["password"];
            $sql = "UPDATE users SET name = '".$uname."', password = '".sha1($password)."' where username = '".$uacc."';";
        } else {
            $sql = "UPDATE users SET name = '".$uname."' where username = '".$uacc."';";
        }
        $result = mysqli_query($con, $sql);
        $_SESSION['nickname'] = $uname;
        header("Refresh:3;url=settings.php");
        $frame->put('container', "修改成功，3秒後回上一頁");
    } else {
        header("Refresh:3;url=settings.php");
        $frame->put('container', "無效的資料，3秒後回上一頁");
    }
} else {
    if ($_SESSION['isadmin']) {
        $index->put("admin", "block");
    } else {
        $index->put("admin", "none");
    }
    $frame->put("container", $index->get());
}
echo $frame->get();

?>