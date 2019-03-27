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
        <!-- textエリア -->
        <div class="textarea">
            <div>
                <p>利用していた市販テキストを登録してください<br>
                    シリーズものの場合はシリーズの1冊だけの登録で大丈夫です。</p>
                <div>
                    <p>Amazonの商品リンクを下記に貼ってください</p>
                    <input type="text" name="amazonurl">
                    <div class="flex"></div>
                </div>
            </div>
        </div>
    </div>
    <script src="js/t_signUp2.js"></script>
</body>
</html>