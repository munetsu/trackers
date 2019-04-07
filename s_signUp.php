<?php
    session_start();
    include('funcs/funcs.php');
    $_SESSION['chk_ssid'] = session_id();
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>【Trackers】ユーザー登録</title>
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/common.css">
    <link rel="stylesheet" href="css/s_signUp.css">
    <!-- jQuery本体-->
    <script src="http://code.jquery.com/jquery-3.2.1.min.js"></script>
</head>
<body>
    <div>
        <div>
            <p class="text">利用規約を最後までお読みください。</p>
            <textarea id="useRule" rows="10" style="width: 80vw" class="scrollArea">
            </textarea><br>
            <label for="checkbox1"><input type="checkbox" value="1" class="checkpoint" id="checkbox1" disabled>利用規約に同意する</label>
        </div>
        <div>
            <p class="text">個人情報に関する取り扱いを最後までお読みください。</p>
            <textarea id="privacyPolicy" rows="10" style="width: 80vw" class="scrollArea">
            </textarea><br>
            <label for="checkbox2"><input type="checkbox" value="10" class="checkpoint" id="checkbox2" disabled>個人情報取り扱いに同意する</label>
        </div>
        <div class="itemList">
            <p>下記項目の入力をお願いします</p>
            <form action="s_signUp_confirm.php" method="POST" name="signUp">
            <table class="table">
                <tr>
                    <td class="item">資格名<span>*</span></td>
                    <td><input type="text" name="certification" class="text" placeholder="(例)宅建士"></td>
                </tr>
                <tr>
                    <td class="item">氏名<span>*</span></td>
                    <td><input type="text" name="k_familyname" class="text" placeholder="(例)田中"><input type="text" name="k_firstname" class="text" placeholder="(例)太郎"></td>
                </tr>
                <tr>
                    <td class="item">NAME<span>*</span></td>
                    <td><input type="text" name="a_familyname" class="alpha" placeholder="(例)tanaka"><input type="text" name="a_firstname" class="alpha" placeholder="(例)tarou"></td>
                </tr>
                <tr>
                    <td class="item">E-mail<span>*</span></td>
                    <td><input type="email" name="email" class="text" placeholder="(例)sample@trackers.co.jp"></td>
                </tr>
                <tr>
                    <td class="item">電話番号(携帯)<span>*</span></td>
                    <td><input type="text" name="tel" class="tel" placeholder="(例)09011111111"></td>
                </tr>
                <tr>
                    <td class="item">生年月日<span>*</span></td>
                    <td><select name="birthyear" id="birthyear" class="num"></select>年／<select name="birthmonth" id="birthmonth" class="num"></select>月</td>
                </tr>
            </table>
        </form>
        </div>
    </div>
</body>
<script src="js/s_signUp.js"></script>
</html>