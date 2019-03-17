<?php
    session_start();
    include('funcs/funcs.php');
    chkSsid();

    $id = $_GET['id'];

    // modelへ引き継ぎ
    // 対象チューター情報取得
    include('mvc/model.php');
    $model = new MODEL;
    $info = $model->tuotorInfo($id);

    // 資格取得
    $certificationList = $model->certificationList($info['certification']);
    // $certificationList = JSON_ENCODE($certificationList,JSON_UNESCAPED_UNICODE);
    // var_dump($certificationList);
    // exit();

    // 不正ログインチェック
    if($_SESSION['security_code'] != $info['security_code']){
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
        <div>
            <p>利用規約を最後までお読みください。</p>
            <textarea name="" id="" rows="10" style="width: 80vw">ああああああああああ
            </textarea><br>
            <label><input type="checkbox" value="1" id="rule">利用規約に同意する</label>
        </div>
        <div class="main" style="display:none">
            <p>下記項目への記入をお願いします。<br>
            <span>既に登録頂いてる部分で変更がある場合は、変更をお願いします</span>

            </p>
            <form action="mvc/controller.php" method="POST" name="signUp" enctype="multipart/form-data">
                <input type="hidden" name="action" value="tuotorSignUp">
                <input type="hidden" name="tuotor_id" value=<?php echo $info['tuotor_id']?>>
                <p>登録資格：<?php echo $certificationList['certification_kind'] ?></p>
                <div>
                    <p>氏名（漢字）:<input type="text" name="c_name" value=<?php echo $info['c_name']?>></p>
                </div>
                <div>
                    <p>氏名（かな）:<input type="text" name="k_name"></p>
                </div>
                <div>
                    <p>email:<input type="text" name="email" value=<?php echo $info['email']?> size="30"></p>
                </div>
                <div>
                    <p>ログインパスワード:<input type="text" name="password"><br>
                    <span>※新しく登録をお願いします</span>
                    </p>
                </div>
                <div>
                    <p>電話番号:<input type="text" name="tel" value=<?php echo $info['tel']?>></p>
                </div>
                <div>
                    <p>顔写真：</p>
                    <input type="file" name="upfile" class="file" id="file"><br>
                    <span>チューター一覧で載せる為、顔写真の登録をお願いします。</span>
                </div>
                <div>
                    <p>生年月日：
                        <select class="birthyear" name="birthyear"></select>年
                        <select class="birthmonth" name="birthmonth"></select>月
                    </p>
                </div>
                <button id="btn" type="button">登録</button>
            </form>

        </div>
    </div>
    <script src="js/tuotor_signUp.js"></script>
</body>
</html>
