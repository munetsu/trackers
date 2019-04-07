<?php
    session_start();
    $_SESSION["chk_ssid"] = session_id();

    // 条件分岐用のデータ取得
    $status = $_GET['status'];
    if($status == 'tuotor'){
        $side = 1;
    }else if($status == 'student'){
        $side = 2;
    }else{
        echo '不正アクセス';
        exit();
    }
   

?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>【Trackers】ログイン</title>
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/common.css">
    <link rel="stylesheet" href="css/login.css">
    <!-- jQuery本体-->
    <script src="http://code.jquery.com/jquery-3.2.1.min.js"></script>
</head>
<body>
    <div>
        <img src="img/logo.png" class="logo">
    </div>
    <div class="flex">
        <div class="img">
            <img src="img/image.jpg" class="picture">
        </div>
        <div class="login">
            <form action="mvc/controller.php" method="POST" name="login">
                <input type="hidden" name="action" value="login">
                <input type="hidden" name="status" value=<?php echo $side ?>>
                <div>
                    <p class="title">メールアドレス</p>
                    <input type="text" name="email" size="30">
                </div>
                <div>
                    <p class="title">パスワード</p>
                    <input type="password" name="password" size="30">
                </div>
            </form>
            <div id="btn">
                <a href="" class="btn">ログイン</a>
            </div>
        </div>
    </div>
</body>
<script src="js/login.js"></script>
</html>
