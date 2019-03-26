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
    if($academic != 0){
        $schoolname = h($_POST['schoolname']);
    }
    $howto = h($_POST['howto']);
    $howmany = h($_POST['howmany']);

    // 配列データ
    $kindstatus = ['会社員', '役員', '学生', '主婦・主夫', 'フリーター・パート', 'その他'];
    $kindacademic = ['大学院卒', '大学卒', '専門・高専卒', '高校卒', '中卒', '非回答'];
    $kindhow = ['独学', '資格学校', '通信教育'];

?>
<!DOCTYPE html>
<html lang="ja">
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
        <p>内容の確認をお願いします</p>
        <form action="t_signUp_confirm.php" method="POST" name="signUp">
        <table>
                <tr>
                    <td>氏名</td>
                    <td><input type="text" name="k_familyname" class="text" value=<?php echo $k_fa_name ?>><input type="text" name="k_firstname" class="text" value=<?php echo $k_f_name ?>></td>
                </tr>
                <tr>
                    <td>NAME</td>
                    <td><input type="text" name="a_familyname" class="text" value=<?php echo $a_fa_name ?>><input type="text" name="a_firstname" class="text" value=<?php echo $a_f_name ?>></td>
                </tr>
                <tr>
                    <td>E-mail</td>
                    <td><input type="text" name="email" class="text" value=<?php echo $email ?>></td>
                </tr>
                <tr>
                    <td>電話番号</td>
                    <td><input type="text" name="tel" class="text" value=<?php echo $tel ?>></td>
                </tr>
                <tr>
                    <td>生年月日</td>
                    <td><input type="text" name="birthyear" value=<?php echo $birthyear ?>>年／<input type="text" name="birthmonth" value=<?php echo $birthmonth ?>>月</td>
                </tr>
                <tr>
                    <td>職業</td>
                    <td><select name="status" class="status"></select></td>
                </tr>
                <tr>
                    <td>学歴</td>
                    <td><select name="academic" class="academic"></select></td>
                </tr>
                <tr>
                    <td>勉強方法</td>
                    <td><select name="howto" class="howto"></select></td>
                </tr>
                <?php if($howto != 0): ?>
                <tr class="howtoschool">
                    <td>学校・サービス</td>
                    <td><input type="text" name="shcoolname" value=<?php echo $schoolname ?>></td>
                </tr>
                <?php endif; ?>
                <tr>
                    <td>受験回数</td>
                    <td><select name="howmany" class="howmany"></select></td>
                </tr>
            </table>          
        </form>
    </div>
    <div>
        <a href="" id="btn">確認</a>
    </div>
    <script>
        let status = <?php echo $status ?>;
        let academic = <?php echo $academic ?>;
        let howto = <?php echo $howto ?>;
        let howmany = <?php echo $howmany ?>;
    </script>
    <script src="js/t_signUp_edit.js"></script>
</body>
</html>