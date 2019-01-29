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
    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
</head>
<body>
    <div id="body">
        <h3>情報の登録をお願いします</h3>
        <form action="php/ajax.php" method="POST" name="studyForm" enctype="multipart/form-data">
            <input type="hidden" name="action" value="signUp">
            <input type="hidden" name="uid" value=<?php echo $uid ?>>
            <!-- 選択 -->
            <div>
                <p>どちらを選択しますか？</p>
                <label><input type="radio" name="status" value="1">チューター</label>
                <label><input type="radio" name="status" value="2">生徒</label>
            </div>
            <!-- 名前 -->
            <div>
                姓：<input type="text" name="familyNameCharacter" placeholder="資格">
                名：<input type="text" name="firstNameCharacter" placeholder="太郎">
            </div>
            <div>
                姓（カナ）：<input type="text" name="familyNameKana" placeholder="シカク">
                名（カナ）：<input type="text" name="firstNameKana" placeholder="タロウ">
            </div>
            <!-- 画像 -->
            <div class="photo">
                <input type="file" name="upfile" class="file" id="file">
            </div>
            <!-- 年齢 -->
            <div>
                西暦：
                <select name="year" id="year"></select>
                ／月：
                <select name="month" id="month"></select>
                ／日：
                <select name="day" id="day"></select>
            </div>
            <!-- 性別 -->
            <div>
                性別：
                <select name="gender" id="gender">
                    <option value="1">Male</option>
                    <option value="2">Female</option>
                    <option value="3">Other</option>
                    <option value="4">No Answer</option>
                </select>
            </div>
            <!-- 学歴 -->
            <div>
                最終学歴：
                <select name="gakureki" id="gakureki">
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
                専攻：
                <select name="senkou" id="senkou">
                    <option value="1">理系</option>
                    <option value="2">文系</option>
                    <option value="3">どちらも苦手</option>
                </select>
            </div>
            <!-- 出身地 -->
            <div>
                出身地：
                <select name="born" id="born"></select>
            </div>
            <!-- 属性 -->
            <div>
                属性：
                <label><input type="radio" name="zokusei" value="1">会社員</label>
                <label><input type="radio" name="zokusei" value="2">役員</label>
                <label><input type="radio" name="zokusei" value="3">自営業</label>
                <label><input type="radio" name="zokusei" value="4">学生</label>
                <label><input type="radio" name="zokusei" value="5">主婦・主夫</label>
                <label><input type="radio" name="zokusei" value="6">フリーター</label>
                <label><input type="radio" name="zokusei" value="7">その他</label>
            </div>
            <!-- 生活スタイル -->
            <div>
                生活リズム：
                <select name="lifeStyle" id="lifeStyle">
                    <option value="1">朝型</option>
                    <option value="2">夜型</option>
                </select>
            </div>
            <!-- 休み -->
            <div>
                休み：
                <label><input type="radio" name="holiday" value="1">土日・祝</label>
                <label><input type="radio" name="holiday" value="2">シフト制</label>
                <label><input type="radio" name="holiday" value="3">平日</label>
            </div>
            <!-- 勉強スタイル -->
            <div>
                勉強スタイル：
                <label><input type="radio" name="studyStyle" value="1">コツコツ型</label>
                <label><input type="radio" name="studyStyle" value="2">短期集中型</label>
            </div>
            <div>
                勉強タイプ：
                <label><input type="radio" name="studyType" value="1">まずは暗記タイプ</label>
                <label><input type="radio" name="studyType" value="2">いきなり演習タイプ</label>
            </div>
            <div>
                性格：
                <label><input type="radio" name="personality" value="1">理解するまで先に進まない</label>
                <label><input type="radio" name="personality" value="2">不明点があっても、まずは先に進む</label>
            </div>
            <!-- 利用書籍 -->
            <div>
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
            </div>
            <button id="signUpBtn">登録する</button>
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
    <script>
        let year = <?php echo $year ?>;
    </script>
    <script src="js/signUp.js"></script>
</body>
</html>