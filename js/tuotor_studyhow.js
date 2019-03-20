//////////////////////////////////////////////////////////////////////
//変数・配列一覧
//////////////////////////////////////////////////////////////////////
const selectMonth = [];

//////////////////////////////////////////////////////////////////////
//読み込み時に描画
//////////////////////////////////////////////////////////////////////
// 月作成
for(let i = 0;i<13;i++){
    let view = '<li class="month" id="month'+i+'">'+i+'月</li>';
    $('.monthList').append(view);
}

//////////////////////////////////////////////////////////////////////
//クリックイベント
//////////////////////////////////////////////////////////////////////
// 月選択
$(document).on('click', 'li', function(){
    $(this).toggleClass('selected');
    // 月を取得
    let month = $(this).text();
    month = month.replace('月', '');
    // 数値変換
    month = parseInt(month, 10);
    checkArray(month);
    console.log(selectMonth);
})

// 配列操作(selectMonth)
function checkArray(m){
    if(selectMonth.length == 0){
        selectMonth.push(m);
    }else{
        let check = 0;
        for(let i=0;i<selectMonth.length;i++){
            // 配列内に既にあるか確認
            if(selectMonth[i] == m){
                console.log(selectMonth[i],m);
                selectMonth.splice(i,1);
                check =1;
                break;
            }
        }
        if(check != 1){
            selectMonth.push(m);
        }
    }
}

//////////////////////////////////////////////////////////////////////
//VIEW
//////////////////////////////////////////////////////////////////////
// 勉強時間(class="studytime")
function viewStudytime(){
    let view = `
    <div>
        <p>
    </div>

`;
}

