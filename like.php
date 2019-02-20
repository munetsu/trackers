<?php
    include('php/controller.php');
    include('php/include/funcs.php');
    chkSsid();

    // データ取得
    $tuotorId = $_POST['tuotorId']; //チューターID
    $uid = $_POST['uid']; //生徒のUserID
    
    $cl = new CONTROLLER;
    // 生徒ID取得
    $studentId = $cl->selectStudentId($uid);

    // お気に入り登録
    $cl->likes($studentId, $tuotorId);
?>

