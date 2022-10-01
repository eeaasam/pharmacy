<?php require_once("Connections/conn_db.php"); ?>
<?php (!isset($_SESSION)) ? session_start() : ""; ?>
<?php require_once('php_lib.php'); ?>
<?php
//取得要返回的php頁面
if (isset($_GET['sPath'])) {
    $sPath = $_GET['sPath'] . ".php";
} else {
    //登入完成預設要進入首頁
    $sPath = "index.php";
}
//檢查是否完成登入驗證
if (isset($_SESSION['login'])) {
    header(sprintf("location: %s", $sPath));
}
?>
<!DOCTYPE html>
<html lang="zh-TW">

<head>
    <!-- head -->
    <?php require_once('headfile.php'); ?>
    <style type="text/css">
        .col-md-10 {
            background-repeat: no-repeat;
            background-image: linear-gradient(rgb(104, 145, 162), rgb(12, 97, 33));
        }

        .mycard.mycard-container {
            max-width: 400px;
            height: 450px;
        }

        .mycard {
            background-color: #f7f7f7;
            padding: 20px 25px 30px;
            margin: 0 auto 25px;
            margin-top: 50px;
            -moz-border-radius: 10px;
            -webkit-border-radius: 10px;
            border-radius: 10px;
        }

        .profile-img-card {
            margin: 0 auto 10px auto;
            display: block;
            width: 100px;
        }

        .profile-name-card {
            font-size: 20px;
            text-align: center;
        }

        .form-signin input[type="email"],
        .form-signin input[type="password"],
        .form-signin button {
            width: 100%;
            height: 44px;
            font-size: 16px;
            display: block;
            margin-bottom: 20px;
        }

        .btn.btn-signin {
            font-weight: 700;
            background-color: rgb(104, 145, 162);
            color: white;
            height: 38px;
            transition: background-color 1s;
        }

        .btn.btn-signin:hover,
        .btn.btn-signin:active,
        .btn.btn-signin:focus {
            background-color: rgb(12, 97, 33);
        }

        .other a {
            color: rgb(104, 145, 162);
            font-size: 14pt;
        }

        .other a:hover,
        .other a:active,
        .other a:focus {
            color: rgb(12, 97, 33);
        }
    </style>
</head>

<body>
    <section id="header">
        <!-- 導覽列 -->
        <?php require_once('navbar.php'); ?>
    </section>
    <section id="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-2">
                    <!-- 商品分類 -->
                    <?php require_once('sidebar.php'); ?>
                    <!-- 熱銷商品 -->
                    <?php require_once('hot.php'); ?>

                </div>
                <!-- banner -->
                <div class="col-md-10">
                    <!-- 會員登入html -->
                    <div class="mycard mycard-container">
                        <img id="profile-img" class="profile-img-card" src="images/logo03.svg" alt="logo">
                        <p id="profile-name" class="profile-name-card">電商藥粧：會員登入</p>
                        <form action="" method="POST" class="form-signin" id="form1">
                            <input type="email" id="inputAccount" name="inputAccount" class="form-control" placeholder="Account" required autofocus />
                            <input type="password" id="inputPassword" name="inputPassword" class="form-control" placeholder="Password" required />
                            <button type="submit" class="btn btn-signin mt-4">sign in</button>
                        </form>
                        <div class="other mt-5 text-center">
                            <a href="register.php">New user/</a><a href="#">Forgot the passowrd?</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section id="scontent">
        <!-- 服務說明 -->
        <?php require_once('scontent.php'); ?>
    </section>
    <section id="footer">
        <!-- 頁尾-聯絡資訊 -->
        <?php require_once('footer.php'); ?>
    </section>
    <!-- javascript file -->
    <?php require_once('jsfile.php'); ?>
    <script type="text/javascript" src="commlib.js"></script>
    <script type="text/javascript">
        $(function() {
            $("#form1").submit(function() {
                const inputAccount = $("#inputAccount").val();
                const inputPassword = MD5($("#inputPassword").val());
                $("#loading").show();
                //利用$ajax函數呼叫後台的auth_user.php驗證帳號密碼
                $.ajax({
                    url: 'auth_user.php',
                    type: 'post',
                    dataType: 'json',
                    data: {
                        inputAccount: inputAccount,
                        inputPassword: inputPassword,
                    },
                    success: function(data) {
                        if (data.c == true) {
                            alert(data.m);
                            // window.location.reload();
                            window.location.href = "<?php echo $sPath; ?>";
                        } else {
                            alert(data.m);
                        }
                    },
                    error: function(data) {
                        alert("系統目前無法連接到後台資料庫");
                    }
                });
            });
        });
    </script>

    <div id="loading" name="loading" style="display:none;position:fixed;width:100%;height:100%;top:0;left:0;background-color:rgba(255,255,255,.5);z-index:9999;"><i class="fas fa-spinner fa-spin fa-5x fa-fw" style="position:absolute;top:50%;left:50%"></i>
    </div>
</body>

</html>