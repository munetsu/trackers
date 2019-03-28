<?php

    session_start();
    include('funcs/funcs.php');
    chkSsid();

    $id = $_GET['id'];
    include('mvc/model.php');
    $model = new MODEL;
    $column = 'security_code';
    $where = 'WHERE tuotor_id ='.$id;
    $code = $model->t_tuotorsAnySelect($column, $where);
    // // // 不正ログインチェック
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
    <title>Document</title>
    <!-- jQuery本体-->
    <script src="http://code.jquery.com/jquery-3.2.1.min.js"></script>
</head>
<body>
    <div>
        <form action="mvc/controller.php" method="POST" name="account">
            <input type="hidden" name="action" value="passgene">
            <input type="hidden" name="tuotor_id" value=<?php echo $id ?>>
            <p>先ほど登録したメールアドレスを記載してください</p>
            <input type="email" name="email">
            <p>パスワードを設定してください<br>
                (半角英数と記号を含む8文字以上64文字以内)<br>
                利用可能な記号は「!"#$%&@'()*+,-./」となります</p>
            <input type="password" name="pass1" class="pass"><span data-id="pass1" class="describe">表示する</span><br>
            <span class="pass1" style="display:none" data-id="pass1"></span>
            <p>パスワード確認用(コピペ不可）</p>
            <input type="password" name="pass2" class="pass"><span data-id="pass2" class="describe">表示する</span><br>
            <span class="pass2" style="display:none" data-id="pass2"></span>
        </form>
        <div id="btn">登録</div>
    </div>
    <script src="js/t_passgenerate.js"></script>
</body>
</html>