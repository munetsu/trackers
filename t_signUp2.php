<?php
    session_start();
    include('funcs/funcs.php');
    chkSsid();

    $id = $_SESSION['tuotor_id'];
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
    <title>【Trackers】チューター登録</title>
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/common.css">
    <link rel="stylesheet" href="css/t_signUp2.css">
    <!-- jQuery本体-->
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
</head>
<body>
    <div class="main">
        <!-- textエリア -->
        <div class="textarea">
            <div>
                <div class="title">
                    <p>利用していた市販テキストを登録してください(最大10冊まで)<br>
                        シリーズの場合はシリーズの1冊だけの登録で大丈夫です。</p>
                </div>
                <div>
                    <div class="search">
                        <p>下記にISBN13コードの入力をお願いします。</p>
                        <p>・お手元に書籍がある方はこちらの画像を参照ください。
                            <a href="img/isbn.png" target="_blank">（参考）記載場所</a>
                        </p>
                        <p>・書籍がお手元にない方はAmazonのページから番号を検索し記載してください。
                            <a href="img/amazonIsbn.png" target="_blank">（参考）Amazonページでの記載場所</a>
                        </p>
                        <span>（ISBNコードで書籍が見つからない場合は、<a href="https://www.amazon.co.jp/b/ref=s9_acss_bw_cg_BooksCat_md1_w?ie=UTF8&node=492228&pf_rd_m=A3P5ROKL5A1OLE&pf_rd_s=merchandised-search-1&pf_rd_r=CR1TVHH0KY0JM2KXN1DR&pf_rd_t=101&pf_rd_p=b53052f5-e7be-4669-a64a-81e8a5264c33&pf_rd_i=465610" class="amazonlink" target="_blank">AmazonのページURL</a>を記載してください）</span>
                        
                    </div>
                    <div class="searchbook">
                        <p class="isbn">ISBN-13：978-<input type="text" name="google"></p>
                        <p class="isbn">Amazon：<input type="text" name="amazon"></p>
                    </div>
                    <div class="flex"></div>
                </div>
            </div>
        </div>
        <!-- 登録ボタン -->
        <div class="regBtn">
            <a href="" id="regBtn">登録</a>
        </div>
    </div>
    <script>
        let tuotor_id = <?php echo $id ?>;
    </script>
    <script src="js/t_signUp2.js"></script>
</body>
</html>