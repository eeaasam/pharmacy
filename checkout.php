<?php require_once('Connections/conn_db.php'); ?>
<?php (!isset($_SESSION)) ? session_start() : ""; ?>
<?php require_once('php_lib.php'); ?>
<?php
if (!isset($_SESSION['login'])) {
    $sPath = "login.php?sPath=checkout";
    header(sprintf("Location: %s", $sPath));
}
?>
<!doctype html>
<html lang="zh-TW">

</html>

<head>
    <!-- css link與相關設定 -->
    <?php require_once('headfile.php'); ?>
    <style type="text/css">
        .table td,
        .table th {
            padding: .75rem;
            vertical-align: top;
            border-bottom: none;
            border-top: 1px solid #dee2e6;
        }
    </style>
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
                    <!-- 結帳主頁 -->
                    <?php require_once('chkout_content.php'); ?>
                   
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
    <script type="text/javascript">
        $(function() {
            //取得縣市碼後查詢鄕鎮市名稱放入#myTown
            $('#myCity').change(function() {
                var CNo = $('#myCity').val();
                $.ajax({
                    url: 'Town_ajax.php',
                    type: 'post',
                    dataType: 'json',
                    data: {
                        CNo: CNo
                    },
                    success: function(data) {
                        if (data.c == true) {
                            $('#myTown').html(data.m);
                        } else {
                            alert("Database reponse error：" + data.m);
                        }
                    },
                    error: function(data) {
                        alert("ajax request error");
                    }
                });
            });
            //選鄕鎮市後，查詢郵遞區號放入#myzip,#add_label
            $('#myTown').change(function() {
                var AutoNo = $('#myTown').val();
                $.ajax({
                    url: 'Zip_ajax01.php',
                    type: 'get',
                    dataType: 'json',
                    data: {
                        AutoNo: AutoNo
                    },
                    success: function(data) {
                        if (data.c == true) {
                            $('#myzip').val(data.Post);
                            $('#add_label').html('郵遞區號：' + data.Post + data.Cityname + data.Name);
                        } else {
                            alert("Database reponse error：" + data.m);
                        }
                    },
                    error: function(data) {
                        alert("ajax request error");
                    }
                });
            });
            //建立新增收件人處理程序
            $('#recipient').click(function() {
                var validate = 0,
                    msg = "";
                var cname = $("#cname").val();
                var mobile = $("#mobile").val();
                var myzip = $('#myzip').val();
                var address = $('#address').val();
                if (cname == "") {
                    msg = msg + "收件人不得為空白！;\n";
                    validate = 1;
                }
                if (mobile == "") {
                    msg = msg + "電話不得為空白！;\n";
                    validate = 1;
                }
                if (myzip == "") {
                    msg = msg + "郵遞區號不得為空白！;\n";
                    validate = 1;
                }
                if (address == "") {
                    msg = msg + "地址不得為空白！;\n";
                    validate = 1;
                }
                if (validate) {
                    alert(msg);
                    return false;
                }
                $.ajax({
                    url: 'addbook.php',
                    type: 'post',
                    dataType: 'json',
                    data: {
                        cname: cname,
                        mobile: mobile,
                        myzip: myzip,
                        address: address,
                    },
                    success: function(data) {
                        if (data.c == true) {
                            window.location.reload();
                        } else {
                            alert("Database reponse error：" + data.m);
                        }
                    },
                    error: function(data) {
                        alert("ajax request error");
                    }
                });

            });
            //更換收件人處理程序
            $('input[name=gridRadios]').change(function() {
                var addressid = $(this).val();
                $.ajax({
                    url: 'changeaddr.php',
                    type: 'post',
                    dataType: 'json',
                    data: {
                        addressid:addressid,
                    },
                    success: function(data) {
                        if (data.c == true) {
                            alert(data.m);
                            window.location.reload();
                        } else {
                            alert("Database reponse error：" + data.m);
                        }
                    },
                    error: function(data) {
                        alert("ajax request error");
                    }
                });
            });
            //系統進行結帳處理
            $('#btn04').click(function() {
                let msg = "系統將進行結帳處理，請確認產品金額與收件人是否正確！";
                if (!confirm(msg)) return false; 
                $("#loading").show();
                var addressid = $('input[name=gridRadios]:checked').val();
                $.ajax({
                    url: 'addorder.php',
                    type: 'post',
                    dataType: 'json',
                    data: {
                        addressid:addressid,
                    },
                    success: function(data) {
                        if (data.c == true) {
                            alert(data.m);
                            window.location.href="index.php";
                        } else {
                            alert("Database reponse error：" + data.m);
                        }
                    },
                    error: function(data) {
                        alert("ajax request error");
                    }
                });
            });
        });
    </script>
    <!-- Modal收件人地址處理對話框 -->
    <?php
    // 取得所有收件人資料
    $SQLstring = sprintf("SELECT *,city.Name AS ctName,town.Name AS toName FROM addbook,city,town WHERE emailid='%d' AND addbook.myzip=town.Post AND town.AutoNo=city.AutoNo", $_SESSION['emailid']);
    $addbook_rs = mysqli_query($link, $SQLstring);
    ?>
    <div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">收件人資訊</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="row">
                            <div class="col">
                                <input type="text" name="cname" id="cname" class="form-control" placeholder="收件者姓名">
                            </div>
                            <div class="col">
                                <input type="number" name="mobile" id="mobile" class="form-control" placeholder="收件者電話">
                            </div>
                            <div class="col">
                                <select name="myCity" id="myCity" class="form-control">
                                    <option value="">請選擇市區</option>
                                    <?php $city = "SELECT * FROM `city` where State=0";
                                    $city_rs = mysqli_query($link, $city);
                                    while ($city_rows = mysqli_fetch_array($city_rs)) { ?>
                                        <option value="<?php echo $city_rows['AutoNo']; ?>">
                                            <?php echo $city_rows['Name']; ?>
                                        </option>
                                    <?php } ?>
                                </select><br>

                            </div>
                            <div class="col">
                                <select name="myTown" id="myTown" class="form-control">
                                    <option value="">請選擇地區</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <input type="hidden" name="myzip" id="myzip" value="">
                                <label for="address" id="add_label" name="add_label">郵遞區號：</label>
                                <input type="text" name="address" id="address" class="form-control" placeholder="地址">
                            </div>
                        </div>
                        <div class="row mt-4 justify-content-center">
                            <div class="col-auto">
                                <button type="button" class="btn btn-success" id="recipient" name="recipient">新增收件人</button>
                            </div>
                        </div>
                    </form>
                    <hr>
                    <div class="row">
                        <table class="table">
                            <thead class="thead-dark">
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">收件者姓名</th>
                                    <th scope="col">電話</th>
                                    <th scope="col">地址</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($data = mysqli_fetch_array($addbook_rs)) { ?>
                                    <tr>
                                        <th scope="row"><input type="radio" name="gridRadios" id="gridRadios[]" value="<?php echo $data['addressid'] ?>" <?php echo ($data['setdefault']) ? 'checked' : ''; ?>></th>
                                        <td><?php echo $data['cname']; ?></td>
                                        <td><?php echo $data['mobile']; ?></td>
                                        <td><?php echo $data['myzip'] . $data['ctName'] . $data['toName'] . $data['address']; ?></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">關閉Close</button>
                </div>
            </div>
        </div>
    </div>
    <div id="loading" name="loading" style="display:none;position:fixed;width:100%;height:100%;top:0;left:0;background-color:rgba(255,255,255,.5);z-index:9999;"><i class="fas fa-spinner fa-spin fa-5x fa-fw" style="position:absolute;top:50%;left:50%;"></i></div>
</body>

</html>
<?php

?>