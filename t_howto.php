<?php
    session_start();
    include('funcs/funcs.php');
    chkSsid();

    $id = h($_GET['id']);
    include('mvc/model.php');
    $model = new MODEL;
    $column = '*';
    $where = 'WHERE tuotor_id ='.$id;
    $info = $model->t_tuotorsAnySelect($column, $where);
    // // // 不正ログインチェック
    if($_SESSION['security_code'] != $info['security_code']){
        echo 'ログイン上の問題が発生しました';
        exit();
    }

    // 勉強方法取得
    $howto = $info['howto'];
    // // 勉強法リスト取得
    // $howtoLists = $model->howtoList();
    // $howtoLists = JSON_ENCODE($howtoLists,JSON_UNESCAPED_UNICODE);

    // 登録済み勉強方法月を取得
    $select = 'month';
    $month = $model->howtoMonthly($id, $select);
    $monthLength = count($month);
    if($monthLength != 0){
        $month = JSON_ENCODE($month,JSON_UNESCAPED_UNICODE);
    }else{
        array_push($month, 0);
        $month = JSON_ENCODE($month,JSON_UNESCAPED_UNICODE);
    }

    // // 登録済みテキストを取得
    // $booklists = $model->t_booklistSelect($column, $where);
    // $booklistsLength = count($booklists);
    // if($booklistsLength != 0){
    //     $booklists = JSON_ENCODE($booklists,JSON_UNESCAPED_UNICODE);
    // }else{
    //     array_push($booklists, 0);
    //     $booklists = JSON_ENCODE($booklists,JSON_UNESCAPED_UNICODE);
    // }

    // 登録テキストを取得
    $table = 'booklists';
    $column = '*';
    $where = 'WHERE `tuotor_id` ='."'".$id."'";
    $books = $model->anyselectAll($table, $column, $where);
    $books = json($books);
    
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <!-- <link rel="stylesheet" href="css/reset.css"> -->
    <link rel="stylesheet" href="css/tuotor_studyhow.css">
    <!-- jQuery本体-->
    <script src="http://code.jquery.com/jquery-3.2.1.min.js"></script>
</head>
<body>
    <div>
        <p>資格試験の勉強方法を登録してください</p>
        <div>
            <p>月を選択してください（同じ勉強方法の場合は複数選択してください）</p>
            <ul class="monthList flex"></ul>
            <ul class="monthList2 flex"></ul>
        </div>
        <div class="studytime">
            <p>勉強時間を記載してください</p>
            <span>内訳</span>
            <ul>
                <li>平日：<input type="number" name="weektime">時間<img src="img/icon/batsu.svg" style="width:1vw;height:1vw;"><input type="number" name="weekday">日</li>
                <li>休日：<input type="number" name="holidaytime">時間<img src="img/icon/batsu.svg" style="width:1vw;height:1vw;"><input type="number" name="holiday">日</li>
            </ul>
        </div>
        <div>
            <p>利用テキスト等を選択してください</p>
            <div class="textList flex"></div>
        </div>
        <div>
            <p>勉強方法を記載してください</p>
            <textarea id="howtostudy" cols="50" rows="10"></textarea><br>
            <a href="t_howtoEx.php" target="_blank">記載例はこちら</a>
        </div>
        <div class="flex">
            <div id="next" class="btn">他の月も登録</div>
            <div id="stop" class="btn">一時保存</div>
            <div id="finish" class="btn">登録完了</div>
        </div>
    </div>
    <script>
        let tuotor_id = <?php echo $id ?>;
        let howto = <?php echo $howto ?>;
        let monthly = <?php echo $month ?>;
        let bookLists = <?php echo $books ?>;
    </script>
    <script src="js/t_howto.js"></script>
</body>
</html>