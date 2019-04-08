<?php

    session_start();
    include('funcs/funcs.php');
    chkSsid();

    // $id = $_GET['id'];
    $id = $_SESSION['student_id'];
    include('mvc/model.php');
    $model = new MODEL;
    $column = 'security_code';
    $where = 'WHERE student_id ='.$id;
    $code = $model->s_studentsAnySelect($column, $where);

    // 不正ログインチェック
    if($_SESSION['security_code'] != $code['security_code']){
        echo '不正アクセスです';
        exit();
    }
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>【Trackers】仮ログイン画面</title>
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/common.css">
    <link rel="stylesheet" href="css/s_passgenerate.css">
    <!-- jQuery本体-->
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
</head>
<body>
    <form action="mvc/controller.php" method="POST" name="account">
        <input type="hidden" name="action" value="s_passgene">
        <input type="hidden" name="student_id" value=<?php echo $id ?>>
        <p class="text">先ほど登録したメールアドレスを記載してください</p>
        <input type="email" name="email">
        <p class="title">パスワードを設定してください<br>
            (半角英数と記号を含む8文字以上64文字以内)<br>
            利用可能な記号は「!"#$%&@'()*+,-./」となります</p>
        <input type="password" name="pass1" class="pass"><span data-id="pass1" class="describe">表示する▼</span><br>
        <span class="pass1" style="display:none" data-id="pass1"></span>
        <p class="title">パスワード確認用</p>
        <input type="password" name="pass2" class="pass"><span data-id="pass2" class="describe">表示する▼</span><br>
        <span class="pass2" style="display:none" data-id="pass2"></span>
    </form>
    <div id="btn">
        <a href="" class="btn">登録</a>
    </div>
</body>
<script src="js/s_passgenerate.js"></script>
</html>