<?php
    $data = "https://spreadsheets.google.com/feeds/list/1CaRHTu-Hw-QsJOfFM2GGgcViDfuXrr7fUNbeY9uXxv4/od6/public/values?alt=json";
    $json = file_get_contents($data);
    $json_decode = json_decode($json);
    
    $names = $json_decode->feed->entry;
    // var_dump($names);
    // exit();

    // ○日以内
    function datejudge($m){
        $date = date("Y/m/d",strtotime("+".$m." day"));
        return $date;
    }

    $schedule = array();

    foreach ($names as $name) {
        $res = $name->{'gsx$reservation'}->{'$t'};
        if($res == 0){
            $temp = array();
            $temp = array_merge($temp,array('date' => $name->{'gsx$date'}->{'$t'}));
            $temp = array_merge($temp,array('weekday' => $name->{'gsx$weekday'}->{'$t'}));
            $temp = array_merge($temp,array('time' => $name->{'gsx$time'}->{'$t'}));

            array_push($schedule, $temp);
        }
    }
    // var_dump($schedule);
    $schedule = JSON_ENCODE($schedule,JSON_UNESCAPED_UNICODE);



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
    <h3>面談申し込みフォーム</h3>
    <form action="mvc/controller.php" method="POST" name="tuotorRegister">
    <input type="hidden" name="action" value="tuotorRegister">
        <!-- 氏名 -->
        <div>
            <p>
                氏名：
                <input type="text" name="name">
            </p>
        </div>
        <!-- 対象資格 -->
        <div>
            <p>
                対象資格：
                <select name="certification" id="">
                    <option value="1">宅建士</option>
                    <option value="2">行政書士</option>
                    <option value="3">簿記2級</option>
                </select>
            </p>
        </div>
        <!-- メールアドレス -->
        <div>
            <p>
                メールアドレス(Gmailのみ)：
                <input type="text" name="email">
            </p>
        </div>
        <!-- 電話番号 -->
        <div>
            <p>
                電話番号（携帯）：
                <input type="tel" name="tel" maxlength="11">
            </p>
            <span>(例) 0901111111</span>
        </div>
        <!-- 面談希望日時 -->
        <div>
            <p>面談希望日時</p>
            <p>
                第一希望：
                <input type="text" name="firstDate" class="datepicker" placeholder="クリックして日付選択">
            </p>
            <p>希望時間</p>
            <div id="firstDate"></div>
            <!-- <p>
                開始時間：
                <input type="time" name="f_startTime" class="datepicker">
                〜終了時間：
                <input type="time" name="f_finishTime">
            </p> -->
            <p>
                第二希望：
                <input type="text" name="secondDate" class="datepicker" placeholder="クリックして日付選択">
            </p>
            <p>希望時間</p>
            <div id="secondDate"></div>
            <!-- <p>
                開始時間：
                <input type="time" name="s_startTime">
                〜終了時間：
                <input type="time" name="s_finishTime">
            </p> -->
            <p>
                第三希望：
                <input type="text" name="thirdDate" class="datepicker" placeholder="クリックして日付選択">
            </p>
            <p>希望時間</p>
            <div id="thirdDate"></div>
            <!-- <p>
                開始時間：
                <input type="time" name="t_startTime">
                〜終了時間：
                <input type="time" name="t_finishTime">
            </p> -->
        </div>
        <button>登録する</button>
    </form>
    <script>
        const data = <?php echo $schedule ?>;
    </script>
    <script src="js/tuotorRegister.js"></script>
</body>
</html>