/////////////////////////////////////////////
// 読み込み時に処理
/////////////////////////////////////////////
// 月作成
for(let i = 1;i<13;i++){
    let view = checkedMonth(i)
    if(i <=6){
        $('.monthlist').append(view);
    }else{
        $('.monthlist').append(view);
    }
}

/////////////////////////////////////////////
// 関数一覧
/////////////////////////////////////////////
// 登録済み月処理
function checkedMonth(i){
    for(let k =0;k<monthly.length;k++){
        var month = parseInt(monthly[k]['month'], 10);
        if(i == month){
            var view = '<li class="month" data-month="'+i+'">'+i+'月</li>';
            break;
        }else{
            var view = '<li class="month gray" data-month="'+i+'">'+i+'月</li>';
        }
    }
    return view;  
}

// 勉強法（書籍リスト描画）
function viewHowtoBooks(howto){
    let view = '';
    for(let i=1;i<=11;i++){
        if(howto['title'+i] == null){
            continue;
        }else{
            view += 
            `<div class="books">
                <p>`+howto['title'+i]+`</p>
                `+howto['imageUrl'+i]+`
           </div>`
        }
    }
    return view;
}

/////////////////////////////////////////////
// VIEW
/////////////////////////////////////////////
// 勉強法描画
function viewHowto(howto){
    let view = `
        <div>
            <table>
                <tr>
                    <td>１週間の合計勉強時間：</td>
                    <td>`+((howto['weektime']*howto['weekday']) +(howto['holidaytime']*howto['holiday']))+`時間</td>
                </tr>
                <tr>
                    <td>平日の勉強時間：</td>
                    <td>`+howto['weektime']+`時間× `+howto['weekday']+`日</td>
                </tr>
                <tr>
                    <td>休日の勉強時間：</td>
                    <td>`+howto['holidaytime']+`時間× `+howto['holiday']+`日</td>
                </tr>
            </table>
        </div>
        <div class="howtoText">`
        +viewHowtoBooks(howto)+
        `</div>
        <div>
            <pre>`+howto['howto']+`</pre>
        </div>
    `;
    return view;
}


/////////////////////////////////////////////
// クリック処理
/////////////////////////////////////////////
// 利用書籍の取得
$(document).on('click', '.textajax', function(e){
    e.preventDefault();
    let clicked = $(this).attr('class');
    if(clicked.match(/clicked/)){
        $('.textarea').empty();
        $(this).removeClass('clicked');
        $(this).text('表示する');
        return;
    }
    $(this).addClass('clicked');
    $(this).text('非表示にする');

    $.ajax({
        url:'mvc/controller.php',
        type:'POST',
        data:{
            action:'tuotorDetailBooks',
            tuotor_id:tuotor_id
        }
    })
    .done((data)=>{
        let booklist = $.parseJSON(data);
        if(booklist.length == 0){
            $('.textarea').append('<span>市販テキストの利用はありません</span>');
        }else{
            for(let i=0;i<booklist.length;i++){
                $('.textarea').append('<div class="amazon">'+booklist[i]['link']+'</div>');
            }
        }
    })
    .fail((data)=>{
        $(this).css('pointer-event', 'auto');
        alert('データが取得できませんでした。もう一度、お試しください');
    })
})

// 勉強法取得
$(document).on('click', '.month', function(){
    let selectMonth = $(this).attr('data-month');
    let getclass = $(this).attr('class');
    // 未登録月をクリックした場合
    if(getclass.match(/gray/)){
        alert('勉強法が登録されていません。\n黒塗り以外の月を選択してください');
        return;
    }
    $.ajax({
        url:'mvc/controller.php',
        type:'POST',
        data:{
            action:'tuotorDetailHowto',
            tuotor_id:tuotor_id,
            selectMonth:selectMonth
        }
    })
    .done((data)=>{
        let howto = $.parseJSON(data);
        $('.howtobody').empty();
        if(!howto){
            $('.howtobody').append('<span>勉強法が登録されていません</span>');
        }else{
            $('.howtobody').append(viewHowto(howto));
        }
    })
    .fail((data)=>{
        alert('データ取得できませんでした');
    })
})

// 参考リストに追加処理
$('.like').on('click', function(e){
    e.preventDefault();
    let clicked = $(this).attr('class');
    if(clicked.match(/clicked/)){
        alert('「参考にするリスト」に追加済みです');
        return;
    }

    // ajax処理
    $.ajax({
        url:'mvc/controller.php',
        type:'POST',
        data:{
            action:'matchLike',
            tuotor_id:tuotor_id,
            student_id:student_id
        }
    })
    .done((data)=>{
        console.log(data);
        if(data == 'selected'){
            alert('「参考にするリスト」に追加済みです');
            $(this).text('参考リスト追加済');
            $(this).addClass('clicked');
        }else if(data == '' || data == 'NULL'){
            alert('「参考リスト」に追加しました');
            $(this).text('参加リスト追加済み');
            $(this).addClass('clicked');
        }else{
            alert('登録時にエラーが発生しました。\nもう一度、クリックお願いします');
            return;
        }
    })
    .fail((data)=>{
        alert('登録時にエラーが発生しました。\nもう一度、クリックお願いします');
    })
})

// 相談リストに追加
$('.consultation').on('click', function(e){
    e.preventDefault();
    let clicked = $(this).attr('class');
    if(clicked.match(/clicked/)){
        alert('「相談したいリスト」に追加済みです');
        return;
    }

    // ajax処理
    $.ajax({
        url:'mvc/controller.php',
        type:'POST',
        data:{
            action:'matchConsul',
            tuotor_id:tuotor_id,
            student_id:student_id
        }
    })
    .done((data)=>{
        console.log(data);
        if(data == 'registered'){
            alert('このチューターには依頼済みです。\n相談リストをご確認ください');
            return;
        }else{
            window.location.href="s_resevation.php?consulid="+data;
        }
    })
    .fail((data)=>{
        alert('登録時にエラーが発生しました。\nもう一度、クリックお願いします');
    })
})