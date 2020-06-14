<?php
require_once("config/sqlconnect.php");
$fail=false;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['useracc']) && !empty($_POST['useracc']) && !empty($_POST['password']) && !empty(['uname'])) {
        $uacc = $_POST["useracc"];
        $uname = $_POST["uname"];
        $password = $_POST["password"];
        $sql="select username from users where username='".$uacc."';";
        $result = mysqli_query($con, $sql);
        if (mysqli_num_rows($result) == 0) {
            $sql = "INSERT INTO users (username, password, name) values ('".$uacc."','".sha1($password)."', '".$uname."');";
            $result = mysqli_query($con, $sql);
            header("Refresh:3;url=login.php");
            die("註冊成功，3秒後轉跳登入頁");
        } else {
            header("Refresh:3;url=register.php");
            die("帳號重複，3秒後回上一頁");
        }
    } else {
        header("Refresh:3;url=register.php");
        die("無效的資料，3秒後回上一頁");
    }
}

?>


<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="static/css/register.css">
    <title>註冊</title>
</head>
<body>
    <div class="container">
            <h1>註冊帳號</h1>
            <form id="reg" action="register.php" method="post" onsubmit="return check();">
            <label for="uacc">*使用者帳號:</label><br>
            <input type="text" name="useracc" id="uacc">
            <small id="accerr" style="color:#f00;display: none;"><br>必填欄位</small>
            <br>
            <label for="uname">*使用者名稱:</label><br>
            <input type="text" name="uname" id="uname">
            <small id="nameerr" style="color:#f00;display: none;"><br>必填欄位</small>
            <br>
            <label for="upass">*密碼:</label><br>
            <input type="password" name="password" id="upass">
            <small id="pwderr" style="color:#f00;display: none;"><br>需要8個字元</small>
            <br>
            <label for="cpass">*確認密碼:</label><br>
            <input type="password" name="cpassword" id="cupass">
            <small id="cpwderr" style="color:#f00;display: none;"><br>密碼不一致</small>
            <br>
            <input type="submit" value="註冊" id="loginbtn">
            </form>
            <a href="login.php">已有帳號?前往登入</a>
    </div>
    <script type="text/javascript">
            form = document.getElementById("reg");
        function check() {
            if (form.useracc.value == "") {
                document.getElementById("accerr").style.removeProperty('display');
                form.useracc.focus();
            } else if (form.uname.value == "") {
                document.getElementById("nameerr").style.removeProperty('display');
                form.uname.focus();
            } else if (form.password.value.length < 8) {
                document.getElementById("pwderr").style.removeProperty('display');
                form.password.focus();
            } else if (form.password.value != form.cpassword.value) {
                document.getElementById("cpwderr").style.removeProperty('display');
            } else {
                return true;
            }
            return false;
        }
    </script>
</body>
</html>