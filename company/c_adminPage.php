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

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
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
            <p>面談希望者一覧</p>
            <?php foreach($interviewLists as $interviewList){ ?>
                <div>
                    <p>氏名：<?php echo $interviewList['name'] ?></p>
                    <p>アドレス：<?php echo $interviewList['email'] ?></p>
                    <p>電話番号：<?php echo $interviewList['tel'] ?></p>
                    <div>
                        <form action="c_controller.php" method="POST">
                            <input type="hidden" name="action" value="interviewConfirm">
                            <input type="hidden" name="tuotorRegisterId" value=<?php echo $interviewList['id'] ?>>
                            <div>
                                <label><input type="radio" name="interviewDate" value=<?php echo $interviewList['firstDate'] ?>>
                                第一候補日：<?php echo $interviewList['firstDate'] ?><br></label>
                                時間：<?php echo $interviewList['firstStartTime'] ?> 〜 <?php echo $interviewList['firstFinishTime'] ?>
                            </div>
                            <div>
                                <label><input type="radio" name="interviewDate" value=<?php echo $interviewList['secondDate'] ?>>
                                第二候補日：<?php echo $interviewList['secondDate'] ?><br></label>
                                時間：<?php echo $interviewList['secondStartTime'] ?> 〜 <?php echo $interviewList['secondFinishTime'] ?>
                            </div>
                            <div>
                                <label><input type="radio" name="interviewDate" value=<?php echo $interviewList['thirdDate'] ?>>
                                第三候補日：<?php echo $interviewList['thirdDate'] ?><br></label>
                                時間：<?php echo $interviewList['thirdStartTime'] ?> 〜 <?php echo $interviewList['thirdFinishTime'] ?>
                            </div>
                            
                        </form>
                    </div>
                </div>
            <?php }?>
        </div>

    </div>
</body>
</html>