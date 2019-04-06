<?php 
   

?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>【Trackers】資格チューター募集</title>
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/common.css">
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
                    <p class="topmessageHead">あなたの経験を聞きたい人がいる</p>
                    <p class="topmessage">これから資格を受験する後輩のチューターとして働きませんか？</p>
                </div>
            </div>
        </div>

        <!-- 業務内容 -->
        <div class="workDetail">
            <h3><span>業務内容</span><h3>
            <div class="flex">
                <div class="two">
                    <img src="img/icon/pencil.svg" class="icon"><br>
                    <h5 class="title"><span class="titleString">勉強方法の記載</span></h5>
                    <p class="text">あなたが行ってきた勉強内容・勉強方法、利用した教材などのノウハウを記載をお願いします。</p>
                </div>
                <div class="two">
                    <img src="img/icon/telphone.svg" class="icon"><br>
                    <h5 class="title"><span class="titleString">オンライン相談回答</span></h5>
                    <p class="text">勉強方法やスケジュール、利用テキストの使い方や問題への疑問点など、試験に向けての不安や疑問を持っている生徒の相談を乗って頂きます。</p>
                    <p class="plus">※授業は行いません。あくまで相談・質疑応答のみとなります。</p>
                </div>
            </div>
        </div>

        <!-- チューター契約まで -->
        <div class="process">
            <h3><span>登録からの流れ</span><h3>
            <div class="flex">
                <div class="stepbox">
                    <h5 class="step"><span class="stepString">Step1</h5>
                    <p class="steptext">1.基本情報・テキスト登録<br>2.身分証・合格証明書送付</p>
                </div>
                <div>
                    <img src="img/icon/yajirushi.svg" alt="" class="stepicon"><br>
                    <p class="comwork">確認・審査</p>
                </div>
                <div class="stepbox">
                    <h5 class="step"><span class="stepString">Step2</h5>
                    <p class="steptext">勉強記録登録</p>
                </div>
                <div>
                    <img src="img/icon/yajirushi.svg" alt="" class="stepicon"><br>
                    <p class="comwork">評価・査定</p>
                </div>
                <div class="stepbox">
                    <h5 class="step"><span class="stepString">Step3</h5>
                    <p class="steptext">生徒とのオンライン相談</p>
                </div>
            </div>
        </div>

        <!-- 収入 -->
        <div class="salaryarea">
            <h3><span>報酬</span><h3>
            <table class="salarytable">
                <tr>
                    <td><span class="stepString">Step1</span></td>
                    <td><span class="stepString">Step2</span></td>
                    <td><span class="stepString">Step3</span></td>
                </tr>
                <tr>
                    <td>基本情報・テキスト登録</td>
                    <td>勉強方法登録</td>
                    <td>オンライン相談</td>
                </tr>
                <tr>
                    <td><p class="howmuch">0円</p></td>
                    <td><p class="howmuch">1,000円〜3,000円</p><span class="add">※内容によって前後します</span></td>
                    <td><p class="howmuch">1,500円</p><span class="add">1回30分あたり</span></td>
                </tr>
            </table>
            <p class="addterm">(参考)時給換算:3,000円×160時間=480,000円並の報酬</p>
        </div>

        <!-- チューター登録条件 -->
        <div class="terms">
            <h3><span>登録条件</span><h3>
            <table class="termtable">
                <tr>
                    <td class="titlelist">合格時期：</td>
                    <td>直近1年以内合格者</td>
                </tr>
                <tr>
                    <td class="titlelist">対象資格：</td>
                    <td>宅建士／行政書士／簿記2級</td>
                </tr>    
                <tr>
                    <td class="titlelist">設備：</td>
                    <td>Googleアカウント／Skypeの利用環境</td>
                </tr>
            </table>
            <p class="addterm">※上記対象資格以外にも受付はしております。</p>
        </div>
        <!-- 登録フォーム -->
        <div>
            <h3><span>チューター登録</span><h3>
            <a href="t_signUp.php" class="register">こちらをクリックしてください</a>
        </div>
        <!-- footer -->
        <div class="companyarea">
            <ul class="flex">
                <li>利用規約（作成中）</li>
                <li>特定商取引法に基づく表示（作成中）</li>
                <li>個人情報取り扱いについて（作成中）</li>
                <li>運営会社（登記準備中）</li>
                <li>お問い合わせ</li>
            </ul>
            <div class="copyright">
                <p>Copyright(c) Trackers All Right Reserved</p>
            </div>
        </div>
    </div>
    <script src="js/tuotor.js"></script>
</body>
</html>