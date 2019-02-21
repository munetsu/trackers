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
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/common.css">
    <link rel="stylesheet" href="css/signUp.css">
</head>
<body>
    <div class="logo"></div>
    <div id="body">
        <form action="php/ajax.php" method="POST" name="certificationUpdate">
            <input type="hidden" name="id" value=<?php echo $certificationId ?>>
            <input type="hidden" name="status" value=<?php echo $status ?>>
            <input type="hidden" name="action" value="certificationUpdate">
            <!-- 選択 -->
            <div>
                <p>勉強期間を選択してください。</p>
                <select name="period" id="month">
                    <option selected disabled hidden>選択▼</option>
                </select>
                ヶ月
            </div>
            <div class="certification">
                <p>勉強方法</p>
                <input type="radio" name="how" value="1" id="how1">
                <label for="how1">独学</label><br>
                <input type="radio" name="how" value="2" id="how2">
                <label for="how2">資格学校(TACなど)</label><br>
                <input type="radio" name="how" value="3" id="how3">
                <label for="how3">通信教育(ユーキャンなど)</label>
            </div>
            <div class="certification">
                <p>予備知識</p>
                <input type="radio" name="knowhow" value="1" id="knowhow1">
                <label for="knowhow1">全くなし</label><br>
                <input type="radio" name="knowhow" value="2" id="knowhow2">
                <label for="knowhow2">業務経験あり</label><br>
                <input type="radio" name="knowhow" value="3" id="knowhow3">
                <label for="knowhow3">学生時代に勉強していた</label>
            </div>
            <!-- 利用書籍 -->
            <div class="certification">
                <p>市販の参考書をお使いですか？</p>
                <input type="radio" name="books" value="yes" class="useBooks" id="books1">
                <label for="books1">はい</label><br>
                <input type="radio" name="books" value="no" class="useBooks" id="books2">
                <label for="books2">いいえ</label>
            </div>
            <div id="isbnDivsion" style="display:none;">
                <p>ISBNコードを入力ください：</p> 
                ISBNコード：978 -4- <input type="number" name="isbn" style="border:solid;" id="isbnNum"><button id="search" type="button">検索</button>
                <div id="bookarea"></div>
                <a href="" id="isbnDesc">ISBNコードとは？</a>
                <div id="dialog" style="display:none;">
                    <img src="img/isbn.jpg" alt="" style="width:80vw;height:70vh;">
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

