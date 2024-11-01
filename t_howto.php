<?php
    session_start();
    include('funcs/funcs.php');
    chkSsid();

    // $id = h($_GET['id']);
    $id = $_SESSION['tuotor_id'];
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

    // ステップ取得
    $step = $info['step'];

    // 勉強方法取得
    $howto = $info['howto'];
    
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
    <title>【Trackers】チューター勉強法登録</title>
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/common.css">
    <link rel="stylesheet" href="css/t_howto.css">
    <!-- jQuery本体-->
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
</head>
<body>
    <div>
        <p class="title">資格試験の勉強方法を登録してください</p>
        <div>
            <p class="monthText">月を選択してください（勉強方法が同じ場合は、該当月全て選択してください）</p>
            <ul class="monthList flex"></ul>
            <ul class="monthList2 flex"></ul>
        </div>
        <div class="studytime">
            <p class="title">勉強時間を記載してください</p>
            <span>（内訳）</span>
            <ul>
                <li>平日：<input type="text" name="weektime">時間<img src="img/icon/batsu.svg" class="batsu"><input type="text" name="weekday">日</li>
                <li>休日：<input type="text" name="holidaytime">時間<img src="img/icon/batsu.svg" class="batsu"><input type="text" name="holiday">日</li>
            </ul>
        </div>
        <div class="textarea">
            <p class="title">利用テキスト等を選択してください</p>
            <div class="textList flex"></div>
        </div>
        <div class="howtoarea">
            <p class="title">勉強方法を記載してください</p>
            <textarea id="howtostudy" rows="10" placeholder="記載例を参考にご記入ください"></textarea><br>
            <a href="t_howtoEx.php" target="_blank" style="pointer-events: none;">記載例はこちら（準備中）</a>
        </div>
        <div class="flex btnarea">
            <div id="next" class="btn">続けて登録</div>
            <div id="stop" class="btn">一時保存</div>
            <div id="finish" class="btn">登録完了</div>
            <div id="mypage" class="btn">Mypageへ戻る</div>
        </div>
    </div>
    
</body>
<script>
        let tuotor_id = <?php echo $id ?>;
        let howto = <?php echo $howto ?>;
        let monthly = <?php echo $month ?>;
        let bookLists = <?php echo $books ?>;
        let step = <?php echo $step ?>;
    </script>
    <script src="js/t_howto.js"></script>
</html>