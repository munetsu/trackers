<?php
    include('php/controller.php');
    include('php/include/funcs.php');
    chkSsid();

    $uid = $_GET['uid'];
    // studentIdの取得
    $cl = new CONTROLLER;
    $studentId = $cl->selectStudentId($uid);

    // チューター情報を取得
    $tuotors = $cl->selectAll('tuotors');
    // var_dump($tuotor);
    // exit();

    // matchingId取得
    $matchingId = $cl->matchingId($studentId);
    if(count($matchingId) == 0){
        // offerId取得
        $offerId = $cl->offerId($studentId);
        // Offer内容取得
        $offerDetail = $cl->offerDetail($offerId);
        // var_dump($offerDetail);
        // exit();
        // チューター画像取得
        $images = array();
        foreach($offerDetail as $tuotorImage){
            foreach($tuotors as $tuotor){
               if($tuotor['id'] == $tuotorImage[0]['tuotor_id']){
                   $images[] = $tuotor['img'];
               }
            }
        }
        // var_dump($images);
        // exit();
        $offerDetail = JSON_ENCODE($offerDetail, JSON_UNESCAPED_UNICODE);
        $images = JSON_ENCODE($images, JSON_UNESCAPED_UNICODE);
        $render = 2;

    } else {
        echo 'エラー';
    }

?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/student_top.css">
</head>
<body>
    <div id="body">
        <!-- <div id="header"></div> -->
        <div id="main"></div>
        <div id="footer"></div>
    </div>
    
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
        let offerDetail = <?php echo $offerDetail ?>;
        let images = <?php echo $images ?>;
        let renderNumber = <?php echo $render ?>;
    </script>
    <script src="js/student_top.js"></script>
</body>
</html>
