<?php
    session_start();
    $uid = $_SESSION['id'];
    $year = json_encode(date("Y"));
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>会員登録画面</title>
</head>
<body>
    <div>
        <h3>情報の登録をお願いします</h3>
        <form action="php/ajax.php" method="POST" name="studyForm">
            <input type="hidden" name="action" value="signUp">
            <input type="hidden" name="uid" value=<?php echo $uid ?>>
            <!-- 名前 -->
            <div>
                姓：<input type="text" name="familyNameCharacter" placeholder="資格">
                名：<input type="text" name="firstNameCharacter" placeholder="太郎">
            </div>
            <div>
                姓（カナ）：<input type="text" name="familyNameKana" placeholder="シカク">
                名（カナ）：<input type="text" name="firstNameKana" placeholder="タロウ">
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
            <!-- 生活スタイル -->
            <div>
                生活リズム：
                <select name="lifeStyle" id="lifeStyle">
                    <option value="1">朝型</option>
                    <option value="2">夜型</option>
                </select>
            </div>
            <!-- 勉強スタイル -->
            <div>
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
            </div>
            <button id="signUpBtn">登録する</button>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.3.1.min.js"
        integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
        crossorigin="anonymous">
    </script>
    <script>
        let year = <?php echo $year ?>;
        for(let i =1970; i<=year; i++){
            let view = '';
            view = '<option value='+i+'>'+i+'</option>'
            $('#year').append(view);
        }

        for(let k = 1; k <13; k++){
            let view = '';
            view = '<option value='+k+'>'+k+'</option>'
            $('#month').append(view);
        }

        for(let n = 1; n <32; n++){
            let view = '';
            view = '<option value='+n+'>'+n+'</option>'
            $('#day').append(view);
        }

        // 出身地
        let born = ['都道府県','北海道','青森','岩手','宮城','秋田','山形','福島','茨城','栃木','群馬','埼玉','千葉','東京','神奈川','新潟','富山','石川','福井','山梨','長野','岐阜','静岡','愛知','三重','滋賀','京都','大阪','兵庫','奈良','和歌山','鳥取','島根','岡山','広島','山口','徳島','香川','愛媛','高知','福岡','佐賀','長崎','熊本','大分','宮崎','鹿児島','沖縄','America','中国','韓国','Thailand','Europe','Others'];
        for(let m = 0; m<born.length; m++){
            let land = born[m];
            let view = '<option value='+born[m]+'>'+land+'</option>';
            $('#born').append(view);
        }
    </script>
</body>
</html>