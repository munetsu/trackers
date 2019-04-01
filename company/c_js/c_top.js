//////////////////////////////////////////
// 変数一覧
//////////////////////////////////////////
// チューター証明書待ち
num;
console.log(num);
// console.log(num);
// 勉強法承認待ち
howtoNum;
console.log(howtoNum);


//////////////////////////////////////////
// 読み込み時処理
//////////////////////////////////////////
$('.main').append(viewdashboard(num, howtoNum));

//////////////////////////////////////////
// 条件分岐
//////////////////////////////////////////
function numJudge(num, i){
    if(num[i]['step'] == 10 || num[i]['step'] == 2){
        let view = '<span>'+num[i]['COUNT("*")']+'</span>件';
        return view;
    }else{
        let view = '<span>0件</span>';
        return view;
    }
}

// 書籍登録
function howtoJudge(howtoNum, i){
    if(howtoNum[i]['agree'] == 1){
        let view = '<span>'+howtoNum[i]['COUNT("*")']+'</span>件';
        return view;
    }else{
        let view = '<span>0件</span>';
        return view;
    }
}

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
                    `+numJudge(num, 0)+`
                </div>
                <div class="t_step2">
                    <p>チューター（書籍登録件数）</p>
                    `+numJudge(num, 1)+`
                </div>
            </div>
            <div class="t_howto">
                <p>勉強法承認待ち</p>
                `+howtoJudge(howtoNum, 0)+`
            </div>
        </div>
    `;
    return view;
}
