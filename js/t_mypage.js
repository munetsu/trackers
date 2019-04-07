//////////////////////////////////////////////////
// 変数一覧
//////////////////////////////////////////////////
// 日程調整中リスト
lists;
// 0->生徒からの連絡待ち、1->チューターからの連絡待ち、10->日程確定
// console.log(lists[10]);


//////////////////////////////////////////////////
// 読み込み時に描画
//////////////////////////////////////////////////
$('.main').append(viewMain(lists));


//////////////////////////////////////////////////
// VIEW
//////////////////////////////////////////////////
// step2の場合（メールで送信してもらう画面）
function viewStep2(){
    let view = `
        <div>
            <p>登録ありがとうございました。下記メール先まで必要資料の送付をお願いします。<br>
            メール受信後、3営業日以内に審査結果をメールにてご連絡します。
            </p>
            <dl>
                <dt>必要資料</dt>
                    <dd>・写真付き身分証明書の写真</dd>
                    <dd>・資格取得証明書など取得している事が分かる資料</dd>
                <dt>メール先</dt>
                    <dd><a href="mailto:info@trackers.co.jp?subject=【資格証明書等の送付】" target="_blank">info@trackers.co.jp</a></dd>
                <dt>注意事項</dt>
                    <dd>・メール本文に必ず氏名(フルネーム)の記載を忘れないようにお願いします</dd>
                    <dd>・件名：【資格証明書等の送付】は変更しないようお願いします</dd>
                    <dd>・登録頂いたメールアドレスから送信をお願いします<br>
                        (※)登録アドレスと異なるアドレスからメール送信頂いた場合は確認のご連絡をさせて頂く可能性があります</dd>
            </dl>
        </div>
    `;   
    return view;
}

// viewMain
function viewMain(lists){
    let view = `
        <div class="lists">
            <div class="area">
                <p><a href="t_adjustmentlist.php" >日程調整中（生徒から日程打診あり）<a/></p>
                <p><span>`+lists[0]+`</span>件</p>
            </div>
            <div class="area">
                <p><a href="t_resevationlist.php" >日程調整中（生徒からの日程連絡待ち）<a/></p>
                <p><span>`+lists[1]+`</span>件</p>
            </div>
            <div class="area">
                <p><a href="t_donelist.php" >実施予定リスト<a/></p>
                <p><span>`+lists[10]+`</span>件</p>
            </div>

        </div>
    `;
    return view;
}



