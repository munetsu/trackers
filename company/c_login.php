<?php
    include('../funcs/funcs.php');

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
        <h5>ログイン画面</h5>
        <form action="mvc/c_controller.php" method="POST">
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
                    <input type="text" name="password" placeholder="パスワードを入力">
                </p>
            </div>
            <button>ログインする</button>
        </form>
        <h5>新規ユーザー作成</h5>
        <form action="mvc/c_controller.php" method="POST">
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
                    <input type="text" name="password" placeholder="パスワードを入力">
                </p>
            </div>
            <button>ログインする</button>
        </form>

    </div>
</body>
</html>