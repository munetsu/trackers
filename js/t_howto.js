/////////////////////////////////////////////
// 変数一覧
/////////////////////////////////////////////
// 選択月
const selectMonth = [];

// 利用テキスト
const text = [];

// カウント用
let count = 0;

// console.log(bookLists);
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
    let bookNum = bookLists.length;
    // 勉強法によって描画変更
    if(howto != 1){
        $('.textList').append(viewSchool());
    }
    // 書籍登録数分を描画
    for(let i=0;i<bookNum;i++){
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
        var month = parseInt(monthly[k]['month'], 10);
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
$(document).on('click', '.book', function(e){
    e.preventDefault()
    let id = $(this).attr('data-id');
    // let title = $(this).find('p').text();

    $(this).toggleClass('bookselect');
    checkArray(text, id);
    // console.log(text);
})

// 勉強時間のバリデーション
$('input[type="text"]').on('change', function(){
    let num = $(this).val();
    if(num == ''){
        return;
    }
    let check = num.match(/^\d+$/);
    if(check == null){
        alert('数字のみ入力可能です')
        return;
    }
})

//////////////////////////////////////////////////////////////////////
// VIEW
//////////////////////////////////////////////////////////////////////
function viewtextList(num, booklists){
    let view = `
        <div class="book" data-id="`+booklists[num]['booklist_id']+`">
            <p class="booktitle">`+booklists[num]['title']+`</p>
            `+booklists[num]['imageUrl']+`
        </div>
    `;
    return view;
}

function viewSchool(){
    let view = `
        <div class="book" data-id=0>
            <p class="booktitle">学校・通信教材</p>
            <img src="img/school.png" class="bookimg">
        </div>
    `;
    return view;
}

////////////////////////////////////////////////////////////////
// クリックイベント（ajax含む）
////////////////////////////////////////////////////////////////
$(document).on('click', '.btn', function(){
    $('.btn').css('pointer-event', 'none');
    let select = $(this).attr('id');
    let howtoStudy = $('#howtostudy').val();
    let weektime = $('input[name="weektime"]').val();
    let weekday = $('input[name="weekday"]').val();
    let holidaytime = $('input[name="holidaytime"]').val();
    let holiday = $('input[name="holiday"]').val();

    console.log(howtoStudy);
    if(selectMonth.length == 0){
        alert('月が選択されていません');
        return;
    }else if(howtoStudy == ''){
        alert('勉強方法が記載されていません');
        return;
    }else if(weektime == ''){
        alert('平日の勉強時間が記載されていません');
        return;
    }else if(weekday == ''){
        alert('平日の日数が記載されていません');
        return;
    }else if(holidaytime == ''){
        alert('休日の勉強時間が記載されていません');
        return;
    }else if(holiday == ''){
        alert('休日の日数が記載されていません');
        return;
    }

    if(text.length == 0){
        if(!confirm('「テキストなし」で登録しますか？')){
            // キャンセルの場合
            return;
        }
    }

    // 勉強時間の配列
    const studytime = [];
    studytime.push(weektime, weekday, holidaytime, holiday);
   
    // ajax処理
    $.ajax({
        url:'mvc/controller.php',
        type:'POST',
        data:{
            action:'howto',
            month:selectMonth,
            time:studytime,
            text:text,
            howto:howtoStudy,
            tuotor_id:tuotor_id,
            step:select
        }
    })
    .done((data)=>{    
        // console.log(data);
        if(select == 'next'){
            // リロード
            location.reload();
        }else{
            window.location.href="/trackers/t_mypage.php?id="+tuotor_id;
        }
    })
    .fail((data)=>{
        $('.btn').css('pointer-event', 'auto');
        console.log(data);
        alert('登録できませんでした\n再度、登録処理をお願いします');
    })
})