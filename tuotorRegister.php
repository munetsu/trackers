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
                <input type="date" name="firstDate">
            </p>
            <p>
                開始時間：
                <input type="time" name="f_startTime">
                〜終了時間：
                <input type="time" name="f_finishTime">
            </p>
            <p>
                第二希望：
                <input type="date" name="secondDate">
            </p>
            <p>
                開始時間：
                <input type="time" name="s_startTime">
                〜終了時間：
                <input type="time" name="s_finishTime">
            </p>
            <p>
                第三希望：
                <input type="date" name="thirdDate">
            </p>
            <p>
                開始時間：
                <input type="time" name="t_startTime">
                〜終了時間：
                <input type="time" name="t_finishTime">
            </p>
            <span>対応可能時間：</span>
            <table>
                <tr>
                    <td>平日</td>
                    <th>9:00　〜 22:00開始まで</th>
                </tr>
                <tr>
                    <td>土日祝</td>
                    <th>9:00　〜 18:00開始まで</th>
                </tr>
            </table>
        </div>
        <button>登録する</button>
    </form>
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"
        integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
        crossorigin="anonymous">
    </script>
     <script
        src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"
        integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU="
        crossorigin="anonymous">
    </script>
    <script>
        const data = <?php echo $schedule ?>;
    </script>
    <script src="js/tuotorRegister.js"></script>
</body>
</html>