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
    <title>Document</title>
    <!-- jQuery本体-->
    <script src="http://code.jquery.com/jquery-3.2.1.min.js"></script>
</head>
<body>
    <div>
        <div>
            <p>利用規約を最後までお読みください。</p>
            <textarea name="" id="useRule" rows="10" style="width: 80vw" class="scrollArea">
            </textarea><br>
            <label for="checkbox1"><input type="checkbox" value="1" class="checkpoint" id="checkbox1" disabled>利用規約に同意する</label>
        </div>
        <div>
            <p>個人情報に関する取り扱いを最後までお読みください。</p>
            <textarea name="" id="privacyPolicy" rows="10" style="width: 80vw" class="scrollArea">
            </textarea><br>
            <label for="checkbox2"><input type="checkbox" value="10" class="checkpoint" id="checkbox2" disabled>個人情報取り扱いに同意する</label>
        </div>
        <div class="itemList">
            <p>下記項目の入力をお願いします</p>
            <form action="t_signUp_confirm.php" method="POST" name="signUp">
            <p>氏名<span>*</span>：<input type="text" name="k_familyname" class="text" placeholder="(例)田中"><input type="text" name="k_firstname" class="text" placeholder="(例)太郎"></p>
            <p>NAME<span>*</span>：<input type="text" name="a_familyname" class="text" placeholder="(例)tanaka"><input type="text" name="a_firstname" class="text" placeholder="(例)tarou"></p>
            <p>E-mail<span>*</span>：<input type="email" name="email" class="text" placeholder="(例)sample@trackers.co.jp"></p>
            <p>電話番号(携帯)<span>*</span>：<input type="text" name="tel" class="text" placeholder="(例)09011111111"></p>
            <p>生年月日<span>*</span>：<select name="birthyear" id="birthyear"></select>年／<select name="birthmonth" id="birthmonth"></select>月</p>
            <p>属性<span>*</span>：<select name="status" id="status"></select></p>
            <p>学歴<span>*</span>：<select name="academic" id="academic"></select></p>
            <p>勉強方法<span>*</span>：<select name="howto" id="howto"></select></p>
            <p>受験回数<span>*</span>：<select name="howmany" id="howmany"></select></p>
        </form>
        </div>
    </div>
    <script src="js/t_signUp.js"></script>
</body>
</html>
