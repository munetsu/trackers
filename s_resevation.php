<?php
    session_start();
    include('funcs/funcs.php');
    chkSsid();

    $id = h($_GET['sid']);
    include('mvc/model.php');
    $model = new MODEL;
    $column = '*';
    $where = 'WHERE student_id ='.$id;
    $code = $model->s_studentsAnySelect($column, $where);

    // 不正ログインチェック
    if($_SESSION['security_code'] != $code['security_code']){
        echo '不正アクセスです';
        exit();
    }

    $consul_id = h($_GET['consulid']);
    $table = 'matchConsultations';
    $column = '`security_code`';
    $where = 'WHERE `matchConsultation_id` ='."'".$consul_id."'";
    $matchSecurity = $model->anyselect($table, $column, $where);
    // マッチングリストの照合
    if($_SESSION['matchSecurity'] != $matchSecurity['security_code']){
        echo 'エラーが起きています。';
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
    <!-- jQuery UI -->
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <!-- Datepicker日本語化 -->
    <script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1/i18n/jquery.ui.datepicker-ja.min.js"></script>
    <!-- jQuery UI のCSS -->
    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
</head>
<body>
    <div>
        <p>希望の時間帯を3つほどご提示ください。<br>
        <span>本日より1週間後から1ヶ月後までの期間内で登録できます</span></p>
        <!-- 面談希望日時 -->
        <div>
            <p>面談希望日時</p>
            <form action="s_resevation_confirm.php" method="POST" name="booking">
                <input type="hidden" name="sid" value=<?php echo $id ?>>
                <input type="hidden" name="consulid" value=<?php echo $consul_id ?>>
                <p>
                    第1希望：
                    <input type="text" name="offerDate1" class="datepicker" placeholder="クリックして日付選択">
                </p>
                <div>
                    希望時間<br>
                    開始時間：<select class="time" name="offerStarttime1h"></select>：<select class="minute" name="offerStarttime1m"></select> 〜 終了時間：<select class="time" name="offerFinishtime1h"></select>：<select class="minute" name="offerFinishtime1m"></select>
                </div>
                <p>
                    第2希望：
                    <input type="text" name="offerDate2" class="datepicker" placeholder="クリックして日付選択">
                </p>
                
                <div>
                    希望時間<br>
                    開始時間：<select class="time" name="offerStarttime2h"></select>：<select class="minute" name="offerStarttime2m"></select> 〜 終了時間：<select class="time" name="offerFinishtime2h"></select>：<select class="minute" name="offerFinishtime2m"></select>
                </div>
                <p>
                    第3希望：
                    <input type="text" name="offerDate3" class="datepicker" placeholder="クリックして日付選択">
                </p>
                <div>
                    希望時間<br>
                    開始時間：<select class="time" name="offerStarttime3h"></select>：<select class="minute" name="offerStarttime3m"></select> 〜 終了時間：<select class="time" name="offerFinishtime3h"></select>：<select class="minute" name="offerFinishtime3m"></select>
                </div>
            </form>
        </div>
        <div>
            <a href="" class="btn">確認する</a>
        </div>
    </div>
</body>
<script>
    let consul_id = <?php echo $consul_id ?>;
</script>
<script src="js/s_resevation.js"></script>
</html>