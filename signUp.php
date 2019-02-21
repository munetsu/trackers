<?php
    session_start();
    $uid = $_SESSION['id'];
    include('php/include/funcs.php');
    chkSsid();
    $year = json_encode(date("Y"));
    // var_dump($uid,$_SESSION["chk_ssid"]);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>会員登録画面</title>
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/common.css">
    <link rel="stylesheet" href="css/signUp.css">
    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
    
</head>
<body>
    <div id="body">
        <div class="logo"></div>
        <div class="main">
            <h3>情報の登録をお願いします</h3>
            <form action="php/ajax.php" method="POST" name="studyForm" enctype="multipart/form-data">
                <input type="hidden" name="action" value="signUp">
                <input type="hidden" name="uid" value=<?php echo $uid ?>>
                <!-- 選択 -->
                <div class="status">
                    <p>どちらを選択しますか？</p>
                    <input type="radio" name="status" value="1" id="status1">
                    <label for="status1">チューター</label>
                    <input type="radio" name="status" value="2" id="status2">
                    <label for="status2">生徒</label>
                </div>
                <!-- 名前 -->
                <div class="name">
                    <p>お名前を入力お願いします。</p>
                    姓：<input type="text" name="familyNameCharacter" placeholder="資格" class="character">
                    （カナ）：<input type="text" name="familyNameKana" placeholder="シカク" class="kana">
                </div>
                <div class="name">
                    名：<input type="text" name="firstNameCharacter" placeholder="太郎" class="character">
                    （カナ）：<input type="text" name="firstNameKana" placeholder="タロウ" class="kana">
                </div>
                <!-- 画像 -->
                <div class="photo">
                    <p>写真の登録をお願いします。</p>
                    <input type="file" name="upfile" class="file" id="file">
                </div>
                <!-- 年齢 -->
                <div>
                    <p>生年月日を入力お願いします。</p> 
                    <select name="year" id="year" class="birth"></select>年
                    <select name="month" id="month" class="birth"></select>月
                    <select name="day" id="day" class="birth"></select>日
                </div>
                <!-- 性別 -->
                <div>
                    <p>性別を選択してください。</p>
                    <select name="gender" id="gender">
                    <option selected disabled hidden>選択▼</option>
                        <option value="1">男性</option>
                        <option value="2">女性</option>
                        <option value="3">それ以外</option>
                        <option value="4">答えたくない</option>
                    </select>
                </div>
                <!-- 学歴 -->
                <div>
                    <p>学歴を選択してください。</p>
                    <select name="gakureki" id="gakureki">
                        <option selected disabled hidden>選択▼</option>
                        <option value="1">大学院卒</option>
                        <option value="2">大学卒</option>
                        <option value="3">専門・短大卒</option>
                        <option value="4">高専卒</option>
                        <option value="5">高卒</option>
                        <option value="6">その他</option>
                    </select>
                </div>
                <!-- 得意学科 -->
                <div>
                    <p>専攻科目を選択してください。</p>
                    <select name="senkou" id="senkou">
                        <option selected disabled hidden>選択▼</option>
                        <option value="1">理系</option>
                        <option value="2">文系</option>
                        <option value="3">どちらも苦手</option>
                    </select>
                </div>
                <!-- 出身地 -->
                <div>
                    <p>出身地を選択してください。</p>
                    <select name="born" id="born">
                        <option selected disabled hidden>選択▼</option>
                    </select>
                </div>
                <!-- 属性 -->
                <div>
                    <p>職業を選択してください。</p>
                    <select name="zokusei">
                        <option selected disabled hidden>選択▼</option>
                        <option value="1">会社員</option>
                        <option value="2">役員</option>
                        <option value="3">自営業</option>
                        <option value="4">学生</option>
                        <option value="5">主婦・主夫</option>
                        <option value="6">フリーター</option>
                        <option value="7">その他</option>
                    </select>
                </div>
                <!-- 生活スタイル -->
                <h3>あと少し、ご協力お願いします。</h3>
                <div>
                    <p>生活リズムを選択してください。</p>
                    <select name="lifeStyle" id="lifeStyle">
                        <option selected disabled hidden>選択▼</option>
                        <option value="1">朝型</option>
                        <option value="2">夜型</option>
                    </select>
                </div>
                <!-- 休み -->
                <div>
                    <p>休日を選択してください。</p>
                    <select name="holiday">
                        <option selected disabled hidden>選択▼</option>
                        <option value="1">土日・祝</option>
                        <option value="2">シフト制</option>
                        <option value="3">平日</option>
                    </select>
                </div>
                <!-- 勉強スタイル -->
                <div>
                    <p>勉強期間を選択してください。</p>
                    <select name="studyStyle">
                        <option selected disabled hidden>選択▼</option>
                        <option value="1">コツコツ計画型</option>
                        <option value="2">短期集中型</option>
                    </select>
                </div>
                <div>
                    <p>勉強方法を選択してください。</p>
                    <select name="studyType">
                        <option selected disabled hidden>選択▼</option>
                        <option value="1">まずは参考書を読む</option>
                        <option value="2">いきなり演習問題を解く</option>
                    </select>
                </div>
                <div>
                    <p>性格を選択してください。</p>
                    <select name="personality">
                        <option selected disabled hidden>選択▼</option>
                        <option value="1">理解するまで先に進まない</option>
                        <option value="2">不明点があっても、まずは先に進む</option>
                    </select>
                </div>
                <!-- 利用書籍 -->
                <!-- <div>
                    現在、市販の参考書をお使いですか？
                    <label><input type="radio" name="books" value="yes" class="useBooks">はい</label>
                    <label><input type="radio" name="books" value="no" class="useBooks">いいえ</label>
                </div>
                <div id="isbnDivsion">
                    ISBNコードを入力ください：<br />
                    ISBNコード：978 -4- <input type="number" name="isbn" style="border:solid;" id="isbnNum"><button id="search" type="button">検索</button>
                    <div id="bookarea"></div>
                    <a href="" id="isbnDesc">ISBNコードとは？</a>
                    <div id="dialog" style="display:none;">
                        <img src="img/isbn.jpg" alt="" style="width:80%;height:80%;">
                    </div>
                </div> -->
                <button id="signUpBtn">登録する</button>
            </form>
        </div>
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
    <script>
        let year = <?php echo $year ?>;
    </script>
    <script src="js/signUp.js"></script>
</body>
</html>