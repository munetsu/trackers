<?php
    session_start();
    include('funcs/funcs.php');
    chkSsid();

    $id = $_GET['id'];
    
    // modelへ引き継ぎ
    // 対象チューター情報取得
    include('mvc/model.php');
    $model = new MODEL;
    $column = 'security_code';
    $info = $model->tuotorInfo($id, $column);

    // 不正ログインチェック
    // if($_SESSION['security_code'] != $info['security_code']){
    //     echo '不正アクセスです';
    //     exit();
    // }

    // 登録済み勉強方法月を取得
    $select = 'monthly';
    $month = $model->howtoMonth($id, $select);
    $monthLength = count($month);
    if($monthLength != 0){
        $month = JSON_ENCODE($month,JSON_UNESCAPED_UNICODE);
    }else{
        $month = 0;
    }
    
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="css/tuotor_studyhow.css">
    <!-- jQuery本体-->
    <script src="http://code.jquery.com/jquery-3.2.1.min.js"></script>
</head>
<body>
    <div>
        <div>
            <p>対象月を選択してください（複数選択可）</p>
            <ul class="monthList flex"></ul>
        </div>
        <div class="studytime"></div>
        <div>
            <p>勉強方法を記載してください(4つまで登録可）<img src="img/icon/plus.svg" class="plusminus plus">追加</p>
            <form action="mvc/controller.php" method="POST" enctype="multipart/form-data" name="how">
                <input type="hidden" name="action" value="how">
                <input type="hidden" name="tuotor_id" value=<?php echo $id ?>>
                <div class="block"></div>
            </form> 
        </div>
        <div><button id="register">登録</button></div>
    </div>
    <script>
        let tuotor_id = <?php echo $id ?>;
        let monthly = <?php echo $month ?>;
        
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/push.js/0.0.11/push.min.js"></script>
    <script src="js/tuotor_how.js"></script>
</body>
</html>