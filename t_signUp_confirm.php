<?php
    session_start();
    include('funcs/funcs.php');
    chkSsid();

    $k_fa_name = h($_POST['k_familyname']);
    $k_f_name = h($_POST['k_firstname']);
    $a_fa_name = h($_POST['a_familyname']);
    $a_f_name = h($_POST['a_firstname']);
    $email = h($_POST['email']);
    $tel = h($_POST['tel']);
    $birthyear = h($_POST['birthyear']);
    $birthmonth = h($_POST['birthmonth']);
    $status = h($_POST['status']);
    $academic = h($_POST['academic']);
    $howto = h($_POST['howto']);
    if($howto != 1){
        $schoolname = h($_POST['schoolname']);
    }
    $howmany = h($_POST['howmany']);

    // 配列データ
    $kindstatus = ['', '会社員', '役員', '学生', '主婦・主夫', 'フリーター・パート', 'その他'];
    $kindacademic = ['', '大学院卒', '大学卒', '専門・高専卒', '高校卒', '中卒', '非回答'];
    $kindhow = ['', '独学', '資格学校', '通信教育'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="css/t_signUp_confirm.css">
    <!-- jQuery本体-->
    <script src="http://code.jquery.com/jquery-3.2.1.min.js"></script>
</head>
<body>
    <div>
        <p>内容の確認をお願いします。修正する場合は、下記修正ボタンから戻ってください。</p>
        <form action="" method="POST" name="signUp">
            <input type="hidden" name="action" value="t_signUp">
            <table>
                <tr>
                    <td>氏名</td>
                    <td><input type="hidden" name="k_familyname" class="text" value=<?php echo $k_fa_name ?>><input type="hidden" name="k_firstname" class="text" value=<?php echo $k_f_name ?>><?php echo $k_fa_name ?>&nbsp;<?php echo $k_f_name ?></td>
                </tr>
                <tr>
                    <td>NAME</td>
                    <td><input type="hidden" name="a_familyname" class="text" value=<?php echo $a_fa_name ?>><input type="hidden" name="a_firstname" class="text" value=<?php echo $a_f_name ?>><?php echo $a_fa_name ?>&nbsp;<?php echo $a_f_name ?></td>
                </tr>
                <tr>
                    <td>E-mail</td>
                    <td><input type="hidden" name="email" class="text" value=<?php echo $email ?>><?php echo $email ?></td>
                </tr>
                <tr>
                    <td>電話番号</td>
                    <td><input type="hidden" name="tel" class="text" value=<?php echo $tel ?>><?php echo $tel ?></td>
                </tr>
                <tr>
                    <td>生年月日</td>
                    <td><input type="hidden" name="birthyear" value=<?php echo $birthyear ?>><?php echo $birthyear ?>年／<input type="hidden" name="birthmonth" value=<?php echo $birthmonth ?>><?php echo $birthmonth ?>月</td>
                </tr>
                <tr>
                    <td>職業</td>
                    <td><input type="hidden" name="status" value=<?php echo $status ?>><?php echo $kindstatus[$status] ?></td>
                </tr>
                <tr>
                    <td>学歴</td>
                    <td><input type="hidden" name="academic" value=<?php echo $academic ?>><?php echo $kindacademic[$academic] ?></td>
                </tr>
                <tr>
                    <td>勉強方法</td>
                    <td><input type="hidden" name="howto" value=<?php echo $howto ?>><?php echo $kindhow[$howto] ?></td>
                </tr>
                <?php if($howto != 1): ?>
                <tr>
                    <td>学校・サービス</td>
                    <td><input type="hidden" name="schoolname" value=<?php echo $schoolname ?>><?php echo $schoolname ?></td>
                </tr>
                <?php endif; ?>
                <tr>
                    <td>受験回数</td>
                    <td><input type="hidden" name="howmany" value=<?php echo $howmany ?>><?php echo $howmany ?>回</td>
                </tr>
            </table>          
        </form>
    </div>
    <div class="flex">
        <div>
            <a href="" class="btn" data-id="edit">修正</a>
        </div>
        <div>
            <a href="" class="btn" data-id="register">登録</a>
        </div>
    </div>
    <script src="js/t_signUp_confirm.js"></script>
</body>
</html>