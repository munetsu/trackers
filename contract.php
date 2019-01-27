<?php
    include('php/controller.php');
    include('php/include/funcs.php');
    chkSsid();

    //ユーザーID取得
    $uid = $_SESSION['id'];
    var_dump($uid);
    exit();


?>