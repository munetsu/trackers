///////////////////////////////////////////
// 変数一覧
///////////////////////////////////////////
// 日程調整リスト
lists;
// console.log(lists);
// チューター情報
// lists[i][0]
// 日程情報
// lists[i]

// 職業
// console.log(academiclist);


///////////////////////////////////////////
// 関数一覧
///////////////////////////////////////////
// 年齢計算
function calculate(year, month){
    let age = 0;
    if((thismonth - month) <0){
        age = (thisyear - year +1);
    }else{
        age = (thisyear - year);
    }
    return age;
}

// 時間部分
function hour(){
    for(let i=0;i<=23;i++){
        let view = '';
        if(i == 12){
            view = '<option value='+i+' selected>'+i+'時</option>';        
        }else{
            view = '<option value='+i+'>'+i+'時</option>';
        }
        $('.time').append(view);
    };    
}

// 分部分
function minute(){
    for(let i=00;i<=59;i+=10){
        let view = '';
        if(i == 0){
            view = '<option value=00 selected>00分</option>';        
        }else if(i == 30){
            view = '<option value='+i+' selected>'+i+'分</option>';        
        }else{
            view = '<option value='+i+'>'+i+'分</option>';
        }
        $('.minute').append(view);
    };
}

///////////////////////////////////////////
// VIEW
///////////////////////////////////////////
// 日程打診リスト
function viewlist(array, i){
    let view = `
        <div class="area">
            <p>チューター：`+array[i][0]['k_familyname']+array[i][0]['k_firstname']+`</p>
            <table>
                <tr>
                    <th>希望順</th>
                    <th>希望日時</th>
                    <th>希望時間</th>
                </tr>
                <tr>
                    <td>第一希望</td>
                    <td>`+array[i]['offerDate1']+`</td>
                    <td>`+array[i]['offerStarttime1']+`〜`+array[i]['offerFinishtime1']+`</td>
                </tr>
                <tr>
                    <td>第二希望</td>
                    <td>`+array[i]['offerDate2']+`</td>
                    <td>`+array[i]['offerStarttime2']+`〜`+array[i]['offerFinishtime2']+`</td>
                </tr>
                <tr>
                    <td>第三希望</td>
                    <td>`+array[i]['offerDate3']+`</td>
                    <td>`+array[i]['offerStarttime3']+`〜`+array[i]['offerFinishtime3']+`</td>
                </tr>
            </table>
            <div class="btnarea">
                <div class="tuotor">
                <a href="" class="tuotorBtn" data-tuotor=`+array[i]['tuotor_id']+`>チューター詳細</a>
                </div>
                <div class="date">
                <a href="" class="dateBtn" data-num=`+i+`>日程回答</a>
                </div>
            </div>
        </div>
    `;
    return view;
}

// チューター詳細
function viewTuotorDetail(array){
    let view = `
        <div>
            <div class="toparea">
                <div class="picture">
                    <img src=`+array['picture']+`>
                </div>
                <div class="profile">
                <table>
                    <tr>
                        <td>NAME</td>
                        <td>`+array['a_familyname']+' '+array['a_firstname']+`</td>
                    <tr>
                    <tr>
                        <td>名前</td>
                        <td>`+array['k_familyname']+' '+array['k_firstname']+`</td>
                    </tr>
                    <tr>
                        <td>年齢</td>
                        <td>`+calculate(array['birthyear'], array['bitrhmonth'])+`歳</td>
                    <tr>
                    <tr>
                        <td>職業</td>
                        <td>`+statuslist[(array['status']-1)]['status_kind']+`</td>
                    </tr>
                    <tr>
                        <td>学歴</td>
                        <td>`+academiclist[(array['academic']-1)]['academy_kind']+`</td>
                    </tr>
                    <tr>
                        <td>勉強法</td>
                        <td>`+howtolist[(array['howto']-1)]['howto_kind']+`</td>
                    </tr>
                </table>
            </div>
            <div class="textarea">
            <a href="" class="textajax" data_tid=`+array['tuotor_id']+`>表示する</a>
            </div>
        </div>    
    `;
    return view;
}

// 日程調整用画面
function viewLists(array, i){
    let view = `
        <div class="block">
            <div class="offer">
                <p>都合がつく日程があればチェックをつけてください</p>
                <table>
                    <tr>
                        <th>日程選択</th>
                        <th>希望順</th>
                        <th>希望日時</th>
                        <th>希望時間</th>
                    </tr>
                    <tr>
                        <td><input type="checkbox" data-id=`+array[i]['matchConsultation_id']+` name="select" value=`+array[i]['offerDate1']+` class="check"></td>
                        <td>第一希望</td>
                        <td>`+array[i]['offerDate1']+`</td>
                        <td>`+array[i]['offerStarttime1']+`〜`+array[i]['offerFinishtime1']+`</td>
                    <tr>
                    <tr>
                        <td><input type="checkbox" data-id=`+array[i]['matchConsultation_id']+` name="select" value=`+array[i]['offerDate2']+` class="check"></td>
                        <td>第二希望</td>
                        <td>`+array[i]['offerDate2']+`</td>
                        <td>`+array[i]['offerStarttime2']+`〜`+array[i]['offerFinishtime2']+`</td>
                    <tr>
                    <tr>
                        <td><input type="checkbox" data-id=`+array[i]['matchConsultation_id']+` name="select" value=`+array[i]['offerDate3']+` class="check"></td>
                        <td>第三希望</td>
                        <td>`+array[i]['offerDate3']+`</td>
                        <td>`+array[i]['offerStarttime3']+`〜`+array[i]['offerFinishtime3']+`</td>
                    <tr>
                </table>
            </div>
            <div class="answer" data-id=`+array[i]['matchConsultation_id']+`>
            </div>
            <div class="rescedule">
                <a href="" class="reBtn" data-area=`+array[i]['matchConsultation_id']+`>再調整</a>
                <div class="resce" data-area=`+array[i]['matchConsultation_id']+`>
                </div>
            </div>
        </div>
    `;
    return view;
}

// 日程確定用VIEW
function dateConfrim(date, id){
    let view = `
        <p>日付：`+date+`</p>
        <p>開始時間：<select class="time" name="confirmhour"></select>：<select class="minute" name="confirmminute"></select>〜</p>
        <a href="" class="confirm" data-id=`+id+`>確定</a>
    `;
    return view;
}

function rescedule(area){
    let view = `
        <form action="s_adjustmentConfirm.php" method="POST" name="edit">
        <input type="hidden" name="consulid" value=`+area+`>
        <p>
            第1希望：
            <input type="text" name="offerDate1" class="datepicker" placeholder="クリックして日付選択">
        </p>
        <div>
            希望開始時間<br>
            <select class="time" name="offerStarttimeh1"></select>：<select class="minute" name="offerStarttimem1"></select> 〜 <select class="time" name="offerFinishtimeh1"></select>：<select class="minute" name="offerFinishtimem1"></select>開始まで
        </div>
        <p>
            第2希望：
            <input type="text" name="offerDate2" class="datepicker" placeholder="クリックして日付選択">
        </p>
        <div>
            希望開始時間<br>
            <select class="time" name="offerStarttimeh2"></select>：<select class="minute" name="offerStarttimem2"></select> 〜 <select class="time" name="offerFinishtimeh2"></select>：<select class="minute" name="offerFinishtimem2"></select>開始まで
        </div>
        <p>
            第3希望：
            <input type="text" name="offerDate3" class="datepicker" placeholder="クリックして日付選択">
        </p>
        <div>
            希望開始時間<br>
            <select class="time" name="offerStarttimeh3"></select>：<select class="minute" name="offerStarttimem3"></select> 〜 <select class="time" name="offerFinishtimeh3"></select>：<select class="minute" name="offerFinishtimem3"></select>開始まで
        </div>
        </form>
        <div>
        <a href="" class="edit" data-area=`+area+`>確認する</a>
        </div> 
    `;
    return view;
}

///////////////////////////////////////////
// 読み込み時に描画
///////////////////////////////////////////
for(let i =0;i<lists.length;i++){
    $('.datelist').append(viewlist(lists, i));
};

///////////////////////////////////////////
// クリック処理
///////////////////////////////////////////
// チューター詳細情報
$(document).on('click', '.tuotorBtn', function(e){
    e.preventDefault();
    let tid = $(this).attr('data-tuotor');
    $.ajax({
        url:'mvc/controller.php',
        type:'POST',
        data:{
            action:'tuotorDetail',
            tid:tid
        }
    })
    .done((data)=>{
        if(data == 'NG'){
            alert('通信エラーが発生しました。\n再度、クリックをお願いします');
            return;
        }
        let tuotorInfo = $.parseJSON(data);
        // console.log(tuotorInfo);
        $('.detail').append(viewTuotorDetail(tuotorInfo));
    })
    .fail((data)=>{
        
    })
})

// 利用書籍
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

    let tid = $(this).attr('data_tid');

    $.ajax({
        url:'mvc/controller.php',
        type:'POST',
        data:{
            action:'tuotorDetailBooks',
            tuotor_id:tid
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

// 日程調整
$(document).on('click', '.dateBtn', function(e){
    e.preventDefault();
    let num = $(this).attr('data-num')
    // 描画
    $('.detail').empty();
    $('.detail').append(viewLists(lists, num));
});

// 日程調整部分
$(document).on('click', 'input[name="select"]', function(){
    if ($(this).prop('checked')){
        // 一旦全てをクリアして再チェックする
        $('.check').prop('checked', false);
        $(this).prop('checked', true);
    }
    let clicked = $(this).attr('class');
    let id = $(this).attr('data-id');

    // 既にチェックされていたか確認
    if(clicked.match(/clicked/)){
        $('.answer').empty();
        $('.rescedule').css('display', 'block');
        $(this).removeClass('clicked');
        return;
    }else{
        $('.rescedule').css('display','none');
        let date = $(this).val();
        $('.answer').empty();
        $('div[data-id='+id+']').append(dateConfrim(date, id));
        // 時間セット
        hour();
        // 分セット
        minute();
    }

    // チェックされているか確認
    $(this).addClass('clicked');
})



// 日程確定処理
$(document).on('click', '.confirm', function(e){
    e.preventDefault();
    let date = $('input[name="select"]').val();
    let time = $('select[name="confirmhour"]').val()+ '：'+$('select[name="confirmminute"]').val();
    let id = $(this).attr('data-id');
    
    if(!confirm('こちらの日程にて確定しますか？\n日時：'+date+'\n時間：'+time)){
        // キャンセルの場合
        return;
    }else{
        // OKの場合
        $.ajax({
            url:'mvc/controller.php',
            type:'POST',
            data:{
                action:'confirm',
                matchid:id,
                date:date,
                time:time
            }
        })
        .done((data)=>{
            if(data == 'dataError'){
                alert('送信中にエラーが発生しました。もう一度、送信をお願いします。')
                return;
            }
            window.location.reload();            
        })
        .fail((data)=>{
            console.log(data);
        })
    }
})

// 再調整部分
$(document).on('click', '.reBtn', function(e){
    e.preventDefault();
    let classes = $(this).attr('class');
    
    // 他の調整欄が開いている場合
    if(classes.match(/none/)){
        return;
    }
    
    let area = $(this).attr('data-area');
    $('div[data-area='+area+']').append(rescedule(area));

    // 再調整時に処理
    // カレンダー部分
    $(".datepicker").datepicker({
        dateFormat:'yy/mm/dd',
        minDate: "+7d",
        maxDate: "+40d",
    });

    // 時間部分
    hour();

    // 分部分
    minute();

    // 他の再調整を無効化する
    $('.reBtn').addClass('none');

    // テキスト変更
    $(this).text('閉じる');
    $(this).removeClass('reBtn');
    $(this).addClass('close');
})

// 閉じるボタンを押した時
$(document).on('click', '.close', function(e){
    e.preventDefault();

    // 無効化していたボタンを復活
    $('.reBtn').removeClass('none');
    $(this).removeClass('none');
    
    let area = $(this).attr('data-area');
    $('div[data-area='+area+']').empty();

    // テキスト変更
    $(this).text('再調整');
    $(this).removeClass('close');
    $(this).addClass('reBtn');
})

// 再調整送信
$(document).on('click', '.edit', function(e){
    e.preventDefault();
    let clicked = $(this).attr('class');
    if(clicked.match(/clicked/)){
        return;
    }

    // 未選択がないか確認
    for(let i=1; i<=3;i++){
        let offerdate = $('input[name="offerDate'+i+'"]').val();
        if(offerdate == ''){
            alert('第'+i+'希望日が選択されていません')
            return;
        }
    }
    $(this).addClass('clicked');
    edit.submit();
})