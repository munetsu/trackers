<?php
    session_start();
    include('php/include/funcs.php');
    chkSsid();

    $uid = $_SESSION['id'];
    var_dump($uid);
    exit();

