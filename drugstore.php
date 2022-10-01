<?php require_once('Connections/conn_db.php'); ?>
<?php (!isset($_SESSION)) ? session_start() : ""; ?>
<?php require_once('php_lib.php'); ?>

<!doctype html>
<html lang="zh-TW">

</html>

<head>
    <!-- css link與相關設定 -->
    <?php require_once('headfile.php'); ?>
</head>

<body style="padding-top:45px;">
    <section id="header">
        <!-- 導覽列 -->
        <?php require_once('navbar.php'); ?>
    </section>

    <section id="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-2">
                    <!-- 產品類別 -->
                    <?php require_once('sidebar.php'); ?>
                    <!-- 熱銷商品 -->
                    <?php require_once('hot.php'); ?>
                </div>
                <div class="col-md-10">
                    <!-- 建立類別分項 -->
                    <?php require_once('breadcrumb.php'); ?>
                    <!-- product藥粧商品 -->
                    <?php require_once('product_list.php'); ?>
                </div>
            </div>
        </div>
    </section>
    <hr>
    <section id="scontent">
        <!-- 服務說明 -->
        <?php require_once('scontent.php'); ?>
    </section>
    <section id="footer">
        <!-- 聯絡資訊 -->
        <?php require_once('footer.php'); ?>
    </section>
    <!-- javascript檔 -->
    <?php require_once('jsfile.php'); ?>
</body>

</html>
