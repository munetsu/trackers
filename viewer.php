<?php
    session_start();
    $_SESSION["chk_ssid"] = session_id();
    
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div id="body">
        <div id="all" class="all pc-all">
            <!-- ログイン画面 -->
            <div id="login" class="login">
                <p>会員の方はこちら</p>
                <div>
                    <p>ログインID</p>
                    <input type="text" name="email" id="loginId" placeholder="email">
                </div>
                <div>
                    <p>パスワード</p>
                    <input type="password" name="password" id="password" placeholder="password">
                </div>
                <button id="loginBtn" class="btn">ログイン</button>
            </div>
            <!-- サインアップ画面 -->
            <div id="register" class="register">
                <p>会員ではない方はこちら</p>
                <div>
                    <p>メールアドレス</p>
                    <input type="text" name="email" id="registerId" placeholder="メールアドレスを入力">
                </div>
                <div>
                    <p>パスワード</p>
                    <input type="password" name="password" id="registerPassword" placeholder="パスワードを入力">
                </div>
                <div>
                    <p>パスワード（確認用）</p>
                    <input type="password" placeholder="パスワード確認用">
                </div>
                <button id="registerBtn" class="regiterBtn">登録する</button>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"
        integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
        crossorigin="anonymous">
    </script>
    <script src="js/application.js"></script>

</body>
</html>