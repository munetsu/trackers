<?php
    session_start();
    include('../funcs/funcs.php');
    $_SESSION["chk_ssid"] = session_id()

?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <!-- jQuery本体-->
    <script src="http://code.jquery.com/jquery-3.2.1.min.js"></script>
</head>
<body>
    <div>
        <h5>ログイン画面</h5>
        <form action="c_controller.php" method="POST">
        <input type="hidden" name="action" value="login">
            <div>
                <p>
                    メールアドレス：
                    <input type="text" name="email" placeholder="メールアドレスを入力">
                </p>
            </div>
            <div>
                <p>
                    パスワード：
                    <input type="password" name="password" placeholder="パスワードを入力">
                </p>
            </div>
            <button>ログインする</button>
        </form>
        <h5>新規ユーザー作成</h5>
        <form action="c_controller.php" method="POST">
        <input type="hidden" name="action" value="signUp">
            <div>
                <p>
                    氏名：
                    <input type="text" name="name">
                </p>
            </div>
            <div>
                <p>
                    メールアドレス：
                    <input type="text" name="email" placeholder="メールアドレスを入力">
                </p>
            </div>
            <div>
                <p>
                    パスワード：
                    <input type="password" name="password" placeholder="パスワードを入力">
                </p>
            </div>
            <button>新規ユーザー作成</button>
        </form>

    </div>
</body>
</html>