<?php
    session_start();
    include('funcs/funcs.php');
    chkSsid();

    $id = $_GET['id'];
    include('mvc/model.php');
    $model = new MODEL;
    $column = 'security_code';
    $where = 'WHERE tuotor_id ='.$id;
    $code = $model->t_tuotorsAnySelect($column, $where);
    // // // 不正ログインチェック
    if($_SESSION['security_code'] != $code['security_code']){
        echo 'ログイン中にエラーが発生しました';
        exit();
    }  
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
        <p>ご利用されていたスマホアプリを登録してください(最大10個)</p>
        <div>
            <span>機種</span>
            <select name="smartphone">
                <option value="iPhone">iPhone</option>
                <option value="Android">Android</option>
            </select>
            <span>アプリ名</span>
            <input type="text" name="app">
            <button id="btn">登録</button>
        </div>
        <div>
            <table class="appArea">
            <tr>
                <th>No.</th>
                <th>スマホ</th>
                <th>アプリ名</th>
                <th></th>
            </tr>
            </table>
        </div>
        <!-- 登録ボタン -->
        <div>
            <a href="" id="regBtn">登録</a>
        </div>
    </div>
    <script>
        let tuotor_id = <?php echo $id ?>;
    </script>
    <script src="js/t_signUp3.js"></script>
</body>
</html>