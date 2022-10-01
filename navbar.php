<nav class="navbar fixed-top navbar-expand-lg navbar-light">
            <a class="navbar-brand" href="index.php"><img src="images/logo2.png" class="img-fluid rounded-circle" alt="晨升運動中心" title="晨升運動中心"/></a>
            <p style="color:#fff; font-size: 30px; margin:5px;">晨升運動中心</p>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <?php 
            //讀取後台購物車內產品數量
             $SQLstring = "SELECT * FROM cart WHERE orderid is NULL AND ip='".$_SERVER['REMOTE_ADDR']."';";
             $cart_rs = mysqli_query($link, $SQLstring);
            ?>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item"><a class="nav-link" href="register.php">會員註冊</a></li>
                    <?php if(isset($_SESSION['login'])){ ?>
                    <li class="nav-item"><a class="nav-link" href="#" onclick="btn_confirmLink('請確定是否要登出','logout.php');">會員登出</a></li>
                    <?php } else { ?>
                    <li class="nav-item"><a class="nav-link" href="login.php">會員登入</a></li>
                    <?php } ?>    
                    <li class="nav-item"><a class="nav-link" href="#">會員中心</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">最新活動</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">查訂單</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">折價券</a></li>
                    <li class="nav-item"><a class="nav-link" href="cart.php">購物車<span class="badge badge-info"><?php echo ($cart_rs)?$cart_rs->num_rows:''; ?></span></a></li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">企業專區</a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="#">認識企業文化</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#">全台門市資訊</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#">供應商報價服務</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#">加盟專區</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#">投資人專區</a>
                        </div>
                    </li>
                </ul>
            </div>
        </nav>