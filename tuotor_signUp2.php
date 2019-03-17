<?php
    session_start();
    include('funcs/funcs.php');
    chkSsid();

    $id = $_GET['id'];

    // modelへ引き継ぎ
    // 対象チューター情報取得
    include('mvc/model.php');
    $model = new MODEL;
    $info = $model->tuotorInfo($id);

    // 不正ログインチェック
    if($_SESSION['security_code'] != $info['security_code']){
        echo '不正アクセスです';
        exit();
    }

    // $info = JSON_ENCODE($info,JSON_UNESCAPED_UNICODE);

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
        <p>登録ステップ2</p>
        <div>
            <p>市販テキストを利用していましたか？</p>
            <label><input type="radio" name="textbook" value="1" class="bookcheck">Yes</label>
            <label><input type="radio" name="textbook" value="2" class="bookcheck">No</label>
        </div>
        <div class="main"></div>
    </div>
    <script>
        let info = <?php echo $info['tuotor_id'] ?>;
    </script>
    <script src="js/tuotor_signUp2.js"></script>
</body>
</html>