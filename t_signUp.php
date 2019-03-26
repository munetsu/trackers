<?php
    
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
        </div>
    </div>
    <script src="js/t_signUp.js"></script>
</body>
</html>
