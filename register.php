<?php require_once("Connections/conn_db.php"); ?>
<?php (!isset($_SESSION)) ? session_start() : ""; ?>
<?php require_once('php_lib.php'); ?>
<!DOCTYPE html>
<html lang="zh-TW">

<head>
    <!-- head -->
    <?php require_once('headfile.php'); ?>
    <script type="text/javascript" src="commlib.js"></script>
    <style type="text/css">
        span.error-tips,
        span.error-tips::before {
            font-family: "Font Awesome 5 Free";
            color: red;
            font-weight: 900;
            content: "\f6a9";
        }

        span.valid-tips,
        span.valid-tips::before {
            font-family: "Font Awesome 5 Free";
            color: greenyellow;
            font-weight: 900;
            content: "\f00c";
        }
    </style>
</head>

<body>
    <section id="header">
        <!-- 導覽列 -->
        <?php require_once('navbar.php'); ?>
    </section>
    <?php
    if (isset($_POST['formctl']) && $_POST['formctl'] == 'reg') {
        $email = $_POST['email'];
        $pw1 = md5($_POST['pw1']);
        $cname = $_POST['cname'];
        $tssn = $_POST['tssn'];
        $birthday = $_POST['birthday'];
        $mobile = $_POST['mobile'];
        $myzip = $_POST['myZip'] == '' ? NULL : $_POST['myZip'];
        $address = $_POST['address'] == '' ? NULL : $_POST['address'];
        $imgname = $_POST['uploadname'] == '' ? NULL : $_POST['uploadname'];
        $insertsql = "INSERT INTO member (email,pw1,cname,tssn,birthday,imgname) VALUES ('" . $email . "','" . $pw1 . "','" . $cname . "','" . $tssn . "','" . $birthday . "','" . $imgname . "') ";
        $Result = mysqli_query($link, $insertsql);
        if ($Result) {
            //讀剛新增會員編號
            $sqlstring = sprintf("SELECT emailid FROM member WHERE email='%s'", $email);
            $Result = mysqli_query($link, $sqlstring);
            $data = mysqli_fetch_array($Result);
            //將會員的姓名、電話、地址寫入addbook
            $insertsql = "INSERT INTO addbook (emailid,setdefault,cname,mobile,myzip,address) VALUES ('" . $data['emailid'] . "','1','" . $cname . "','" . $mobile . "','" . $myzip . "','" . $address . "')";
            $Result = mysqli_query($link, $insertsql);
            //設定會員註冊完直接登入
            $_SESSION['login'] = true;
            $_SESSION['emailid'] = $data['emailid'];
            $_SESSION['email'] = $email;
            $_SESSION['cname'] = $cname;
            echo "<script language='javascript'>alert('謝謝您，會員資料已完成註冊');location.href='index.php';</script>";
        }
    }

    ?>
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
                    <!-- 會員註冊頁面 -->
                    <div class="row">
                        <div class="col-lg-12 text-center">
                            <h1>會員註冊頁面</h1>
                            <p>請輸入相關資料，*為必需輸入欄位</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-8 offset-2 text-left">
                            <form id="reg" name="reg" action="register.php" method="POST">
                                <div class="row form-group">
                                    <input type="email" name="email" id="email" class="form-control" placeholder="*請輸入email帳號">
                                </div>
                                <div class="row form-group">
                                    <input type="password" name="pw1" id="pw1" class="form-control" placeholder="*請輸入密碼">
                                </div>
                                <div class="row form-group">
                                    <input type="password" name="pw2" id="pw2" class="form-control" placeholder="*請再次確認密碼">
                                </div>
                                <div class="row form-group">
                                    <input type="text" name="cname" id="cname" class="form-control" placeholder="*請輸入姓名">
                                </div>
                                <div class="row form-group">
                                    <input type="text" name="tssn" id="tssn" class="form-control" placeholder="請輸入身份證字號">
                                </div>
                                <div class="row form-group">
                                    <input type="text" name="birthday" id="birthday" onfocus="(this.type='date')" class="form-control" placeholder="*請選擇生日">
                                </div>
                                <div class="row form-group">
                                    <input type="text" name="mobile" id="mobile" class="form-control" placeholder="請輸入手機號碼">
                                </div>
                                <div class="row form-group">
                                    <select name="myCity" id="myCity" class="form-control">
                                        <option value="">請選擇市區</option>
                                        <?php $city = "SELECT * FROM `city` WHERE State=0";
                                        $city_rs = mysqli_query($link, $city);
                                        while ($city_rows = mysqli_fetch_array($city_rs)) { ?>
                                            <option value="<?php echo $city_rows['AutoNo']; ?>"><?php echo $city_rows['Name']; ?></option>
                                        <?php } ?>
                                    </select><br>
                                    <select name="myTown" id="myTown" class="form-control">
                                        <option value="">請選擇地區</option>
                                    </select>
                                </div>
                                <div class="row form-group">
                                    <p id="zipcode" name="zipcode">郵遞區號：地址</p>
                                    <input type="hidden" name="myZip" id="myZip" value="">
                                    <input type="text" name="address" id="address" class="form-control" placeholder="請輸入後續地址">
                                </div>
                                <div class="row form-group">
                                    <p style="margin-bottom:0px;">上傳相片：</p>
                                    <input type="file" name="fileToUpload" id="fileToUpload" class="form-control" title="請上傳相片圖示" accept="image/x-png,image/jpeg,image/gif,image/jpg">
                                    <p><button type="button" class="btn btn-danger" id="uploadForm" name="uploadForm" style="margin-top:5px;">開始上傳</button> </p>
                                    <div id="progress-div01" class="progress" style="width:100%;display:none;">

                                        <div id="progress-bar01" class="progress-bar progress-bar-striped" role="progressbar" style="width:0%" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100">0%</div>
                                    </div>
                                    <input type="hidden" name="uploadname" id="uploadname" value="" />
                                    <img id="showimg" name="showimg" src="" alt="photo" style="display:none;">

                                </div>
            <div class="row form-group">
                <input type="hidden" name="captcha" id="captcha" value=''>
                <a href="javascript:void(0);" title="按我更新認證碼" onclick="gencode01(60, 35, 10, 8,'blue','white',5,250,5,'captcha','renew');">
                    <script type="text/javascript">
                        gencode01(60, 35, 10, 8, 'blue', 'white', 5, 250, 5, 'captcha', 'new');
                    </script>
                </a>
                <input type="text" name="recaptcha" id="recaptcha" class="form-control" placeholder="請輸入認證碼">
            </div>
            <input type="hidden" name="formctl" id="formctl" value="reg">
            <div class="row form-group">
                <button type="submit" class="btn-success btn-lg">送出</button>
            </div>
                            </form>
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
    <script type="text/javascript" src="jquery.validate.js"></script>
    <script type="text/javascript">
        //取得縣代碼後查鄕鎮市的名稱
        $("#myCity").change(function() {
            var CNo = $('#myCity').val();
            //將鄕鎮市的名稱從後台資料庫取回
            $.ajax({
                url: 'Town_ajax.php',
                type: 'post',
                dataType: 'json',
                data: {
                    CNo: CNo,
                },
                success: function(data) {
                    if (data.c == true) {
                        $('#myTown').html(data.m);
                        $('#myZip').val("");
                    } else {
                        alert(data.m);
                    }
                },
                error: function(data) {
                    alert("系統目前無法連接到後台資料庫");
                }
            });
        });
        //取得鄕鎮市代碼，查詢郵遞區號放入#myZip,#zipcode
        $("#myTown").change(function() {
            var AutoNo = $('#myTown').val();
            $.ajax({
                url: 'Zip_ajax.php',
                type: 'get',
                dataType: 'json',
                data: {
                    AutoNo: AutoNo,
                },
                success: function(data) {
                    if (data.c == true) {
                        $('#myZip').val(data.Post);
                        $('#zipcode').html(data.Post + data.Cityname + data.Name);
                    } else {
                        alert(data.m);
                    }
                },
                error: function(data) {
                    alert("系統目前無法連接到後台資料庫");
                }
            });
        });
        $(function() {
            //自訂身份證格式驗證
            jQuery.validator.addMethod("tssn", function(value, element, param) {
                var tssn = /^[a-zA-z]{1}[1-2]{1}[0-9]{8}$/;
                return this.optional(element) || (tssn.test(value));
            }, "身份證格式有誤！");
            //自訂手機格式驗證
            jQuery.validator.addMethod("checkphone", function(value, element, param) {
                // var checkphone=/^[a-zA-z]{1}[1-2]{1}[0-9]{8}$/;
                var checkphone = /^[0]{1}[9]{1}[0-9]{8}$/;
                return this.optional(element) || (checkphone.test(value));
            }, "電話格式有誤！");

            //圖示上傳處理
            $("#uploadForm").click(function(e) {
                var fileName = $('#fileToUpload').val();
                var idxDot = fileName.lastIndexOf(".") + 1;
                let extFile = fileName.substr(idxDot, fileName.length).toLowerCase();
                if (extFile == "jpg" || extFile == "jpeg" || extFile == "png" || extFile == "gif") {
                    $('#progress-div01').css("display", "flex");
                    let file1 = getId("fileToUpload").files[0];
                    let formdata = new FormData();
                    formdata.append("file1", file1);
                    let ajax = new XMLHttpRequest();
                    ajax.upload.addEventListener("progress", progressHandler, false);
                    ajax.addEventListener("load", completeHandler, false);
                    ajax.addEventListener("error", errorHandler, false);
                    ajax.addEventListener("abort", abortHandler, false);
                    ajax.open("POST", "file_upload_parser.php");
                    ajax.send(formdata);
                    return false
                } else {
                    alert('目前只支援jpg,jpeg,png,gif檔案格式上傳!');
                }
            });
            $('#reg').validate({
                rules: {
                    email: {
                        required: true,
                        email: true,
                        remote: 'checkemail.php'
                    },
                    pw1: {
                        required: true,
                        maxlength: 20,
                        minlength: 4,
                    },
                    pw2: {
                        required: true,
                        equalTo: '#pw1'
                    },
                    cname: {
                        required: true,
                    },
                    tssn: {
                        //    required:true,
                        tssn: true,
                    },
                    birthday: {
                        required: true,
                    },
                    mobile: {
                        required: true,
                        checkphone: true,
                    },
                    address: {
                        required: true,
                    },
                    recaptcha: {
                        required: true,
                        equalTo: '#captcha',
                    },

                },
                messages: {
                    email: {
                        required: 'email信箱不得為空白!!',
                        email: 'email信箱格式有誤',
                        remote: 'email信箱已經註冊'
                    },
                    pw1: {
                        required: '密碼不得為空白!!',
                        maxlength: '密碼最大長度為20位(4-20位英文字母與數字的組合)',
                        minlength: '密碼最小長度為4位(4-20位英文字母與數字的組合)',
                    },
                    pw2: {
                        required: '確認密碼不得為空白!!',
                        equalTo: '兩次輸入的密碼必須一致！'
                    },
                    cname: {
                        required: '使用者名稱不得為空白!!',
                    },
                    tssn: {
                        //    required:'使用者身份證不得為空白!!',
                        tssn: '身分證ID格式有誤',
                    },
                    birthday: {
                        required: '生日不得為空白!!',
                    },
                    mobile: {
                        required: '手機號碼不得為空白!!',
                        checkphone: '手機號碼格式有誤',
                    },
                    address: {
                        required: '地址不得為空白!!',
                    },
                    recaptcha: {
                        required: '驗證碼不得為空白!!',
                        equalTo: '驗證碼需相同!!',
                    },
                },

            });

        });
        // 取得元素ID
        function getId(el) {
            return document.getElementById(el)
        }
        // 上傳過程顯示百分比
        function progressHandler(event) {
            let percent = Math.round((event.loaded / event.total) * 100)
            $("#progress-bar01").css("width", percent + "%")
            $("#progress-bar01").html(percent + "%")
        }
        // 上傳完成處理顯示圖片
        function completeHandler(event) {
            let data = JSON.parse(event.target.responseText)
            if (data.success == 'true') {
                $('#uploadname').val(data.fileName)
                $('#showimg').attr({
                    'src': 'uploads/' + data.fileName,
                    'style': 'display:block;'
                })
                $('button.btn.btn-danger').attr({
                    'style': 'display:none;'
                })
            } else {
                alert(data.error)
            }
        }

        function errorHandler(event) {
            alert('Upload Failed: 上傳發生錯誤')
        }

        function abortHandler(event) {
            alert('Upload Aborted: 上傳作業取消')
        }
    </script>
</body>

</html>