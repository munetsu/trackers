//////////////////////////////////////////////
// 変数一覧
//////////////////////////////////////////////
// 日程調整リスト
resevationlists;
// console.log(resevationlists[0]['offerDate1']);

// 日付
thisyear;
thismonth;
// console.log(year);

//////////////////////////////////////////////
// 関数一覧
//////////////////////////////////////////////
// 先頭文字取得
function split(string){
    let firstString = string.slice(0,1);
    return firstString;
}

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
            view = '<option value='+i+' selected>00分</option>';        
        }else if(i == 30){
            view = '<option value='+i+' selected>'+i+'分</option>';        
        }else{
            view = '<option value='+i+'>'+i+'分</option>';
        }
        $('.minute').append(view);
    };
}




//////////////////////////////////////////////
// VIEW
//////////////////////////////////////////////
// リスト描画
function viewLists(array, i){
    let view = `
        <div class="block">
            <div class="offer">
                <p>`+split(array[i][0]['a_familyname'])+split(array[i][0]['a_firstname'])+`さん(`+calculate(array[i][0]['birthyear'], array[i][0]['birthmonth'])+`)</p>
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
                <a href="" class="reBtn" data-area=`+i+`>再調整</a>
                <div class="resce" data-area=`+i+`>
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

// 日程再調整VIEW
function rescedule(area){
    let view = `
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
        <div>
        <a href="" class="edit" data-area=`+area+`>確認する</a>
        </div> 
    `;
    return view;
}

//////////////////////////////////////////////
// 読み込み時に描画
//////////////////////////////////////////////
for(let i = 0;i<resevationlists.length;i++){
    $('.main').append(viewLists(resevationlists, i));
}


//////////////////////////////////////////////
// クリックイベント
//////////////////////////////////////////////
// 日程調整部分
$('input[name="select"]').on('click', function(){
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

// 再調整部分
$(document).on('click', '.reBtn', function(e){
    e.preventDefault();
    let classes = $(this).attr('class');

    // 他の調整欄が開いている場合
    if(classes.match(/none/)){
        return;
    }
    
    let area = $(this).attr('data-area');
    $('div[data-area='+area+']').append(rescedule());

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