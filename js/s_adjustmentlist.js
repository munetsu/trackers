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
                <a href="" class="dateBtn" data-date=`+array[i]['matchConsultation_id']+`>日程回答</a>
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
