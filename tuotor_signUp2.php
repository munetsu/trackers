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

    // 不正ログインチェック
    if($_SESSION['security_code'] != $info['security_code']){
        echo '不正アクセスです';
        exit();
    }

?>