<?php
    include('php/controller.php');
    include('php/include/funcs.php');
    chkSsid();

    // データ取得
    $tuotorId = $_GET['tuotorId']; //チューターID
    $uid = $_GET['uid']; //生徒のUserID

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

    <div>
        <p>面談希望日時を登録してください</p>
        <p>例）<br>
            面談可能時間が、20時〜22時までの場合<br>
            開始時間：20:00〜終了時間：22:00</p>
        <form action="php/ajax.php" method="POST" name="offer">
            <input type="hidden" name="tuotorId" value=<?php echo $tuotorId ?>>
            <input type="hidden" name="userId" value=<?php echo $uid ?>>
            <input type="hidden" name="action" value="offers">
            <div>
                <p>第一候補日</p>
                日付：<input type="date" name="date1"><span id="date1"></span><br>
                開始時間：<input type="time" name="time1_start"> 〜 終了時間：<input type="time" name="time1_finish">
                <input type="hidden" name="date1ex" value="0">
            </div>
            <div>
                <p>第二候補日</p>
                日付：<input type="date" name="date2"><span id="date2"></span><br>
                開始時間：<input type="time" name="time2_start"> 〜 終了時間：<input type="time" name="time2_finish">
                <input type="hidden" name="date2ex" value="0">
            </div>
            <div>
                <p>第三候補日</p>
                日付：<input type="date" name="date3"><span id="date3"></span><br>
                開始時間：<input type="time" name="time3_start"> 〜 終了時間：<input type="time" name="time3_finish">
                <input type="hidden" name="date3ex" value="0">
            </div>
            <button id="subBtn" type="button">候補日時を送信する</button>
        </form>
    </div>
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"
        integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
        crossorigin="anonymous">
    </script>
    <script src="js/contract.js"></script>
</body>
</html>

