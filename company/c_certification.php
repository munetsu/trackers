<?php
    session_start();
    include('../funcs/funcs.php');
    chkSsid();
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
        <p>新規資格登録フォーム</p>
        <form action="c_controller.php" method="POST">
            <input type="hidden" name="action" value="certification">
            <div>
                <p>資格名：<input type="text" size="30" name="certification"></p>
            </div>
            <button>登録</button>
        </form>
    </div>
</body>
</html>