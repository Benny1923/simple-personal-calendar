<?php

$server="127.0.0.1";
$port="3306";
$username="root";
$password="1234";
$dbname="spclander";

@$con = new mysqli($server,$username,$password,$dbname,$port);

if (mysqli_connect_errno()) {
    die("無法連線至資料庫:".mysqli_connect_error());
}

mysqli_query($con, "SET NAMES utf8");

?>