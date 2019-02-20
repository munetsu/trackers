<?php
    include('php/controller.php');
    include('php/include/funcs.php');
    chkSsid();
   
    
    // 資格IDの取得
    $subId = $_GET['subject'];
    // var_dump($subId);
    // exit();
    $list = new CONTROLLER;
    // 対象チューターの取得
    $lists = $list->subjectsTuotors($subId);
    // var_dump($lists);
    // exit();
   
    // ユーザー情報の取得
    $userData = $list->userDetail();
    // $userData = $userData[0];
    // var_dump($userData);
    // exit();

    // マッチング係数
    $lists = $list->matching($userData, $lists);

    // var_dump($lists);
    // exit();

    // $lists = $list->tuotorsList();
    $lists = json_encode($lists, JSON_UNESCAPED_UNICODE);
    // var_dump($lists);
    // exit();
    $year = date("Y");
    $month = date("m");
    $uid = $_SESSION['id']
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
</head>
<body>
    <div id="app"></div>
    
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"
        integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
        crossorigin="anonymous">
    </script>
    <script
        src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"
        integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU="
        crossorigin="anonymous">
    </script>
    <script>
        let lists = <?php echo $lists ?>;
        let year = <?php echo $year ?>;
        let month = <?php echo $month ?>;
        let uid = <?php echo $uid ?>;
    </script>
    <script src="js/main.js"></script>
    <script src="js/CircularLoader-v1.3.js"></script>
    

    
</body>
</html>

