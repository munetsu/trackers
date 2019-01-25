<?php
    include('php/controller.php');
    include('php/include/funcs.php');
    chkSsid();

    // 科目一覧取得
    $subjectLists = new CONTROLLER;
    $subjectLists = $subjectLists->subjectSelect();
    var_dump($subjectLists);
    exit();


