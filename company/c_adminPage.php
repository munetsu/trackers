<?php
    session_start();
    include('../funcs/funcs.php');
    chkSsid();

    // 面談リスト取得
    include('c_model.php');
    $model = new C_MODEL;
    $interviewLists = $model->interviewList();
    // var_dump($interviewLists);
    // exit();

    // view取得
    // header部分
    include('c_view.php');
    $view = new C_VIEW;
    $headerView = $view->headerView();
    // sideBar部分
    $sideBar = $view->sideBar();
    // メイン部分
    $count = 0;

?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <!-- jQuery本体-->
    <script src="http://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script src="c_js/c_adminPage.js"></script>
</head>
<body>
    <div>
        <!-- ヘッダー -->
        <?php echo $headerView; ?>
        <!-- サイドバー -->
        <?php echo $sideBar; ?>
        <!-- メイン部分 -->
        <!-- 面談リスト -->
        <div class="interviewList">
            <a href="https://docs.google.com/spreadsheets/d/1CaRHTu-Hw-QsJOfFM2GGgcViDfuXrr7fUNbeY9uXxv4/edit#gid=0" target="_blank">日程調整Sheet</a>
            <p>日程調整前リスト</p>
            <?php foreach($interviewLists as $interviewList){ ?>
                <?php if($count%3 == 0){ ?>
                    <div class="flex">
                    <div>
                <?php }else{ ?>
                    <div>                    
                <?php }?>

                    <p>氏名：<?php echo $interviewList['name'] ?></p>
                    <p>アドレス：<?php echo $interviewList['email'] ?></p>
                    <p>電話番号：<?php echo $interviewList['tel'] ?></p>
                    <div>
                        <form action="c_controller.php" method="POST">
                            <input type="hidden" name="action" value="interviewConfirm">
                            <input type="hidden" name="tuotorRegisterId" value=<?php echo $interviewList['id'] ?>>
                            <div>
                                <label><input type="radio" name="interviewDate" value=<?php echo $interviewList['firstDate']."/".$interviewList['ftime']?>>
                                第一候補日：<?php echo $interviewList['firstDate'] ?><br></label>
                                時間：<?php echo $interviewList['ftime'] ?>
                            </div>
                            <div>
                                <label><input type="radio" name="interviewDate" value=<?php echo $interviewList['secondDate']."/".$interviewList['stime'] ?>>
                                第二候補日：<?php echo $interviewList['secondDate'] ?><br></label>
                                時間：<?php echo $interviewList['stime'] ?>
                            </div>
                            <div>
                                <label><input type="radio" name="interviewDate" value=<?php echo $interviewList['thirdDate']."/".$interviewList['ttime'] ?>>
                                第三候補日：<?php echo $interviewList['thirdDate'] ?><br></label>
                                時間：<?php echo $interviewList['ttime'] ?>
                            </div>
                            <input type="hidden" name="itime" value="" id="itime">
                            <button>日程確定</button>
                        </form>
                    </div>
                <?php if($count%3 == 2){ ?>
                    </div>
                    </div>
                <?php }else{ ?>
                    </div>
                <?php } ?>
                <?php $count .= 1 ?>
            <?php }?>
        </div>

    </div>
</body>
</html>