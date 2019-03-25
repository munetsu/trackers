<?php 
    // if($_GET['status'] == 'registeredowksmdndjchfifu93744rfif8j4bfkd87jenf0f9iwlwls0s8wj2hdpdudn'){
    //     $alert = 1;
    // }else{
    //     $alert = 0;
    // }

?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>【Trackers】資格チューター募集</title>
    <link rel="stylesheet" href="css/tuotor.css">
    <!-- jQuery本体-->
    <script src="http://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
</head>
<body>
    <div>
        <!-- トップ画像 -->
        <div class="top">
            <div class="topimage">
                <!-- 写真 -->
                <div class="image"></div>
                <!-- トップ画像上のテキスト -->
                <div class="topText">
                    <h3>あなたの資格活かせます</h3>
                    <p>チューターとして副業しませんか？？</p>
                </div>
            </div>
        </div>

        <!-- 業務内容 -->
        <div class="workDetail">
            <h3>業務内容</h3>
            <div class="flex">
                <div class="three">
                    <h5>勉強計画の策定</h5>
                </div>
                <div class="three">
                    <h5>週1回50分のテレビ電話サポート</h5>
                </div>
                <div class="three">
                    <h5>質問への回答</h5>
                </div>
            </div>
        </div>

        <!-- チューター契約まで -->
        <div class="process">
            <h3>チューター契約までのステップ</h3>
            <div class="flex">
                <div class="fifth">
                    <h5>Step1</h5>
                    <p>テレビ電話面接</p>
                </div>
                <div class="icon">
                    <img src="img/icon/yajirushi.svg" alt="">
                </div>
                <div class="fifth">
                    <h5>Step2</h5>
                    <p>合格体験記登録</p>
                </div>
                <div class="icon">
                    <img src="img/icon/yajirushi.svg" alt="">
                </div>
                <div class="fifth">
                    <h5>Step3</h5>
                    <p>生徒とのテレビ電話面談</p>
                </div>
            </div>
        </div>

        <!-- 収入 -->
        <div>
            <h3>報酬</h3>
            <table>
                <tr>
                    <td>体験記</td>
                    <th class="tableContent">3,000円</th>
                </tr>
                <tr>
                    <td>個別サポート対応</td>
                    <th class="tableContent">7,000円／人</th>
                </tr>
            </table>
            <p>※面談通過者は3,000円の報酬担保</p>
        </div>

        <!-- チューター登録条件 -->
        <div>
            <h3>登録条件</h3>
            <table>
                <tr>
                    <td>合格時期：</td>
                    <th>直近1年以内合格者</th>
                </tr>
                <tr>
                    <td>対象資格：</td>
                    <th>宅建士／行政書士／簿記2級</th>
                </tr>    
                <tr>
                    <td>設備：</td>
                    <th>Googleアカウント／テレビ電話ができる環境</th>
                </tr>
                <tr>
                    <td>その他：</td>
                    <th>週一回50分の時間を確保できる方</th>
                </tr>
            </table>
            <p>※対象資格については、順次増やしていく予定です。</p>
        </div>

        <!-- 登録フォーム -->
        <div>
            <h5>登録希望者はこちら</h5>
            <a href="t_signUp.php">こちらをクリックしてください</a>
            <!-- <a href="" id="mail" class="mail-contact">こちらをクリックしメール送信お願いします</a> -->
            <!-- <p><a href="tuotorRegister.php">こちらから登録お願いします</a></p> -->
        </div>
    </div>
    <script src="js/tuotor.js"></script>
</body>
</html>