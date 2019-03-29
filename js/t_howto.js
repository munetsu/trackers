/////////////////////////////////////////////
// 変数一覧
/////////////////////////////////////////////
// 選択月
const selectMonth = [];

// 利用テキスト
const text = [];

// カウント用
let count = 0;

// console.log(howto);
/////////////////////////////////////////////
// 読み込み時に処理
/////////////////////////////////////////////
// 月作成
for(let i = 1;i<13;i++){
    let view = checkedMonth(i)
    if(i <=6){
        $('.monthList').append(view);
    }else{
        $('.monthList2').append(view);
    }
}

// テキストリスト作成
$(function(){
    // 登録テキスト数の確認
    let bookNum = bookListLength();
    // 勉強法によって描画変更
    if(howto != 1){
        $('.textList').append(viewSchool());
    }
    // 書籍登録数分を描画
    for(let i=1;i<=bookNum;i++){
        let view = viewtextList(i, bookLists);
        $('.textList').append(view);
    }
})
/////////////////////////////////////////////
// 関数一覧
/////////////////////////////////////////////
// 登録済み月処理
function checkedMonth(i){
    for(let k =0;k<monthly.length;k++){
        var month = parseInt(monthly[k]['monthly'], 10);
        if(i == month){
            var view = '<li class="month gray" id="month'+i+'">'+i+'月</li>';
            break;
        }else{
            var view = '<li class="month" id="month'+i+'">'+i+'月</li>';
        }
    }
    return view;  
}

// 配列操作(selectMonth)
function checkArray(array, data){
    if(array.length == 0){
        array.push(data);
    }else{
        let check = 0;
        for(let i=0;i<array.length;i++){
            // 配列内に既にあるか確認
            if(array[i] == data){
                console.log(array[i],data);
                array.splice(i,1);
                check =1;
                break;
            }
        }
        if(check != 1){
            array.push(data);
        }
    }
}

// 登録テキスト数の確認
function bookListLength(){
    let bookListNum = 0;
    for(let i =1;i<11;i++){
        if(bookLists['title'+i] != null){
            bookListNum++;
        }
    }
    return bookListNum;
}


//////////////////////////////////////////////////////////////////////
//クリック・動的イベント
//////////////////////////////////////////////////////////////////////
// 月選択
$(document).on('click', '.month', function(){
    let classed = $(this).attr('class');
    // 月を取得
    let month = $(this).text();
    month = month.replace('月', '');
    
    // 既に選択済みの場合は、選択させない
    if(classed.match(/gray/)){
        alert(month+'月は既に登録済みです。')
    }else{
        $(this).toggleClass('selected');
        // 数値変換
        month = parseInt(month, 10);
        checkArray(selectMonth, month);
        console.log(selectMonth);
    }
})

// 書籍選択
$(document).on('click', '.book', function(){
    let id = $(this).attr('data-id');
    let title = $(this).find('p').text();

    $(this).toggleClass('bookselect');
    checkArray(text, title);
    console.log(text);
})

//////////////////////////////////////////////////////////////////////
// VIEW
//////////////////////////////////////////////////////////////////////
function viewtextList(num, booklists){
    let view = `
        <div class="book" data-id=`+num+`>
            <p>`+booklists['title'+num]+`</p>
            <img src="`+booklists['imageUrl'+num]+`" class="bookimg">
        </div>
    `;
    return view;
}

function viewSchool(){
    let view = `
        <div class="book" data-id=0>
            <p>学校・通信教材</p>
            <img src="img/school.png" class="bookimg">
        </div>
    `;
    return view;
}