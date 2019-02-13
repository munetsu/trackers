<?php
    include('php/controller.php');
    include('php/include/funcs.php');
    chkSsid();

    // 資格登録ID
    $certificationId = $_GET['num'];
    // 生徒=1,チューター=2
    $status = $_GET['status'];

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
        <form action="php/ajax.php" method="POST" name="certificationUpdate">
            <input type="hidden" name="id" value=<?php echo $certificationId ?>>
            <input type="hidden" name="status" value=<?php echo $status ?>>
            <input type="hidden" name="action" value="certificationUpdate">
            <!-- 選択 -->
            <div>
                <p>勉強期間</p>
                <input type="text" name="period" placeholder="何ヶ月">ヶ月
            </div>
            <div>
                <p>勉強方法</p>
                <label><input type="radio" name="how" value="1">独学</label>
                <label><input type="radio" name="how" value="2">資格学校(TACなど)</label>
                <label><input type="radio" name="how" value="3">通信教育(ユーキャンなど)</label>
            </div>
            <div>
                <p>前提知識</p>
                <label><input type="radio" name="knowhow" value="1">全くなし</label>
                <label><input type="radio" name="knowhow" value="2">業務経験あり</label>
                <label><input type="radio" name="knowhow" value="3">学生時代に勉強していた</label>
            </div>
            <!-- 利用書籍 -->
            <div>
                市販の参考書をお使いですか？
                <label><input type="radio" name="books" value="yes" class="useBooks">はい</label>
                <label><input type="radio" name="books" value="no" class="useBooks">いいえ</label>
            </div>
            <div id="isbnDivsion" style="display:none;">
                ISBNコードを入力ください：<br />
                ISBNコード：978 -4- <input type="number" name="isbn" style="border:solid;" id="isbnNum"><button id="search" type="button">検索</button>
                <div id="bookarea"></div>
                <a href="" id="isbnDesc">ISBNコードとは？</a>
                <div id="dialog" style="display:none;">
                    <img src="img/isbn.jpg" alt="" style="width:80%;height:80%;">
                </div>
            </div>
            <button id="btn">登録する</button>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.3.1.min.js"
        integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
        crossorigin="anonymous">
    </script>
     <script
        src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"
        integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU="
        crossorigin="anonymous">
    </script>
    <script src="js/certification.js"></script>
</body>
</html>

