//////////////////////////////////////////
// 変数一覧
//////////////////////////////////////////
// チューター証明書待ち
num;
// console.log(num);
// 勉強法承認待ち
howtoNum;
console.log(howtoNum);


//////////////////////////////////////////
// 読み込み時処理
//////////////////////////////////////////
$('.main').append(viewdashboard(num, howtoNum));

//////////////////////////////////////////
// VIEW部分
//////////////////////////////////////////
function viewdashboard(num, howtoNum){
    let view = `
        <div>
            <p>申請一覧</p>
            <div class="t_step">    
                <div class="t_step1">
                    <p>チューター（証明書待ち件数）</p>
                    <span>`+num[0]['COUNT("*")']+`</span>件
                </div>
                <div class="t_step2">
                    <p>チューター（書籍登録件数）</p>
                    <span>`+num[1]['COUNT("*")']+`</span>件
                </div>
            </div>
            <div class="t_howto">
                <p>勉強法承認待ち</p>
                <span>`+howtoNum[0]['COUNT("*")']+`</span>件
            </div>
        </div>
    `;
    return view;
}
