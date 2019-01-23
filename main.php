<?php
    include('php/controller.php');
    include('php/include/funcs.php');
    chkSsid();
   
    $list = new CONTROLLER;
    $lists = $list->tuotorsList();
    $lists = json_encode($lists);
    $year = date("Y");
    $month = date("m");
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
</head>
<body>
    <div id="app"></div>
    
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"
        integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
        crossorigin="anonymous">
    </script>
    <script>
        let lists = <?php echo $lists ?>;
        let year = <?php echo $year ?>;
        let month = <?php echo $month ?>;
    </script>
    <script src="js/main.js"></script>
    
</body>
</html>

