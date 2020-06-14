<?php
session_start();
session_destroy();
echo "成功登出，轉跳至登入頁面";
echo "<script>window.location=\"login.php\"</script>";
?>