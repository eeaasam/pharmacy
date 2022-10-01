<?php require_once('Connections/conn_db.php'); ?>
<?php (!isset($_SESSION)) ? session_start() : ""; ?>
<?php require_once('php_lib.php'); ?>

<!doctype html>
<html lang="zh-TW">

</html>

<head>
    <!-- css link與相關設定 -->
    <?php require_once('headfile.php'); ?>
    <link rel="stylesheet" href="css/jquery.lightbox-0.5.css" type="text/css">
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
                    <!-- 產品詳細資訊 -->
                    <?php require_once('goods_content.php'); 
                    ?>
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
    <script language="javascript" src="js/jquery.lightbox-0.5.js"></script>
    <script type="text/javascript">
        $(function() {
            //定義在滑鼠滑過圖片即將圖片檔名填入主圖src中
            $(".card .row.mt-2 .col-md-4 a").mouseover(function() {
                var imgsrc = $(this).children("img").attr("src");
                $("#showGoods").attr({
                    "src": imgsrc
                });
            });
            //將子圖片放到lightbox展示
            $(".card .row.mt-2 .col-md-4 a").lightBox({
                maxHeight: $(window).height() * 0.9,
                maxWidth: $(window).width() * 0.9
            });
        });
    </script>
    <script type="text/javascript">
        
    </script>
</body>

</html>