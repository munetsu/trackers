<?php
    session_start();
    include('funcs/funcs.php');
    chkSsid();

    $id = $_GET['id'];
    include('mvc/model.php');
    $model = new MODEL;
    $column = 'security_code';
    $where = 'WHERE tuotor_id ='.$id;
    $code = $model->t_tuotorsAnySelect($column, $where);
    // // // 不正ログインチェック
    if($_SESSION['security_code'] != $code['security_code']){
        echo '不正アクセスです';
        exit();
    }

    
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
        <!-- textエリア -->
        <div class="textarea">
            <div>
                <p>利用していた市販テキストを登録してください(最大10冊まで)<br>
                    シリーズものの場合はシリーズの1冊だけの登録で大丈夫です。</p>
                <div>
                    <p>下記にISBN13コードの入力をお願いします。</p>
                    <p>お手元に書籍がある方はこちらの画像を参照ください
                        <a href="img/isbn.png" target="_blank">（参考）記載場所</a>
                    </p>
                    <p>書籍がお手元にない方はAmazonのページから番号を検索し記載してください
                        <a href="img/amazonIsbn.png" target="_blank">（参考）Amazonページでの記載場所</a>
                    </p>
                    <span>ISBNコードで書籍が見つからない場合は、AmazonのページURLを記載してください</span>
                    <div>
                    <p>ISBN-13：978-<input type="text" name="google"></p>
                    <p>Amazon：<input type="text" name="amazon"></p>
                    </div>
                    <div class="flex"></div>
                </div>
            </div>
        </div>
        <!-- 登録ボタン -->
        <div>
            <a href="" id="regBtn">登録</a>
        </div>
    </div>
    <script>
        let tuotor_id = <?php echo $id ?>;
    </script>
    <script src="js/t_signUp2.js"></script>
</body>
</html>