<?php
session_start();
if ($_SESSION['isadmin'] != 1) {
    die("不符合權限的操作，轉跳至首頁 <script>window.location=\"../index.php\"</script>");
}
?>