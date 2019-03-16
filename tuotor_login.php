<?php
    session_start();
    include('funcs/funcs.php');
    chkSsid();
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <div>
        <p>ログイン画面</p>
        <form action="mvc/controller.php" method="POST">
        <input type="hidden" name="action" value="login">
            <div>
                <p>メールアドレス</p>
                <input type="text" name="email">
            </div>
            <div>
                <p>パスワード</p>
                <input type="password" name="password">
            </div>
            <button>ログイン</button>
        </form>
    </div>
</body>
</html>