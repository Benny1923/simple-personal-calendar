<?php
require_once("../includes/admincheck.php");
require_once("../config/sqlconnect.php");

if ($_GET['op'] == "del" && !empty($_GET['uid'])) {
    $sql="DELETE FROM users WHERE uid=".$_GET['uid'].";";
} else if ($_GET['op'] == "setadmin" && !empty($_GET['uid']) && ($_GET['admin'] == 0 || $_GET['admin'] == 1)) {
    $sql="UPDATE users set isadmin=".$_GET['admin']." WHERE uid=".$_GET['uid'].";";
} else {
    header("Refresh:3;url=accounts.php");
    die("未知的操作，回上一頁");
}

mysqli_query($con, $sql);
header("Refresh:0;url=accounts.php");
?>