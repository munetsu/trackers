<?php
    // include('php/controller.php');
    // include('php/include/funcs.php');
    // chkSsid();

    // //ユーザーID取得
    // $uid = $_SESSION['id'];
    // var_dump($uid);
    // exit();

    
    $data = "https://www.googleapis.com/books/v1/volumes?q=isbn:9784813274858";
    $json = file_get_contents($data);
    $json_decode = json_decode($json);

    // jsonデータ内の『entry』部分を複数取得して、postsに格納
    $posts = $json_decode->items;
    var_dump($posts);
    

?>

