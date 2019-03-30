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
</head>
<body>
    <div>
        <p>内容の確認をお願いします</p>
        <form action="s_signUp_confirm.php" method="POST" name="signUp">
        <table>
                <tr>
                    <td>氏名</td>
                    <td><input type="text" name="k_familyname" class="text" value=<?php echo $k_fa_name ?>><input type="text" name="k_firstname" class="text" value=<?php echo $k_f_name ?>></td>
                </tr>
                <tr>
                    <td>NAME</td>
                    <td><input type="text" name="a_familyname" class="text alpha" value=<?php echo $a_fa_name ?>><input type="text" name="a_firstname" class="text alpha" value=<?php echo $a_f_name ?>></td>
                </tr>
                <tr>
                    <td>E-mail</td>
                    <td><input type="text" name="email" class="text" value=<?php echo $email ?>></td>
                </tr>
                <tr>
                    <td>電話番号</td>
                    <td><input type="tel" name="tel" class="text" value=<?php echo $tel ?>></td>
                </tr>
                <tr>
                    <td>生年月日</td>
                    <td><input type="text" name="birthyear" value=<?php echo $birthyear ?>>年／<input type="text" name="birthmonth" value=<?php echo $birthmonth ?>>月</td>
                </tr>
            </table>          
        </form>
    </div>
    <div>
        <a href="" id="btn">確認</a>
    </div>
    <script src="js/s_signUp_edit.js"></script>
</body>
</html>