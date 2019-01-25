<?php
    include('php/controller.php');
    include('php/include/funcs.php');
    chkSsid();

    // 科目一覧取得
    $subjectLists = new CONTROLLER;
    $subjectLists = $subjectLists->subjectSelect();
    $subjectLists = json_encode($subjectLists,JSON_UNESCAPED_UNICODE);
    // var_dump($subject
    
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="css/reset.css">
</head>
<body>
    <div id="app">
    </div>

    <script src="https://code.jquery.com/jquery-3.3.1.min.js"
        integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
        crossorigin="anonymous">
    </script>
    <script>
        let subjectList = <?php echo $subjectLists ?>
    </script>
    <script src="js/selectSubject.js"></script>

</body>
</html>


