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
function viewTuotorDetail(){
    let view = `
        
    
    
    
    `;
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
    })
    .fail((data)=>{
        
    })
})
