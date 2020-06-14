<?php
session_start();
if (!isset($_SESSION['username'])) {
    die("尚未登入，轉跳至登入頁面 <script>window.location=\"../login.php\"</script>");
}
?>