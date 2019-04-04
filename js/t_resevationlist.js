////////////////////////////////////////
// 変数一覧
////////////////////////////////////////
// リスト情報
resevationlists;
// console.log(resevationlists);

////////////////////////////////////////
// 関数一覧
////////////////////////////////////////
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

// 描画関数
function list(resevationlists){
    let view = '';
    for(let i=0;i<resevationlists.length;i++){
        view += viewlist(resevationlists, i);
    }
    return view;
}

////////////////////////////////////////////
// VIEW
////////////////////////////////////////////
function viewMain(){
    let view = `
        <div class="area">
            <div class="list">
            `+list(resevationlists)+`
            </div>
            <div class="profile">
            </div>
        </div>
    `;
    return view;
}

// リスト一覧
function viewlist(array, i){
    let view  = `
        <div>
            <p>`+array[i][0]['a_familyname']+' '+array[i][0]['a_firstname']+'さん('+calculate(array[i][0]['birthyear'], array[i][0]['birthmonth'])+`)</p>
            <P>予約日時：`+array[i]['confirmDate']+`／`+array[i]['confirmTime']+`〜</p>
            <a href="" class="detail" data-match=`+array[i]['matchConsultation_id']+` data-id=`+array[i]['student_id']+`>詳細を見る</a>
        </div>
    `;
    return view;
}

// profile描画
function viewProfile(array){
    let view = `
        <div class="orofileDetail">
            <div class="picture">
                <img src=`+array['photo']+`>
            </div>
            <div class="text">
            <table>
                <tr>
                    <td>NAME</td>
                    <td>`+array['a_familyname']+array['a_firstname']+`</td>
                </tr>
                <tr>
                    <td>名前</td>
                    <td>`+array['k_familyname']+array['k_firstname']+`</td>
                </tr>
                <tr>
                    <td>年齢</td>
                    <td>`+calculate(array['birthyear'], array['bitrhmonth'])+`歳</td>
                </tr>
                <tr>
                    <td>連絡先（Google Hangout）</td>
                    <td>`+array['email']+`</td>
                <tr>
            </table>
            </div>
        </div>
    `;
    return view;
}

////////////////////////////////////////////
// 読み込み時に描画
////////////////////////////////////////////
$('.main').append(viewMain());

////////////////////////////////////////////
// クリック処理
////////////////////////////////////////////
$(document).on('click', '.detail', function(e){
    e.preventDefault();
    let sid = $(this).attr('data-id');
    let matchid =$(this).attr('data-match');
    $.ajax({
        url:'mvc/controller.php',
        type:'POST',
        data:{
            action:'student_profile',
            sid:sid,
            tid:tid,
            matchid:matchid
        }
    })
    .done((data)=>{
        if(data == 'NG'){
            alert('通信エラーが発生しました。\n通信環境等をご確認の上、もう一度お試しください');
            window.location.reload();
            return;
        }
        let studentInfo = $.parseJSON(data);
        $('.profile').append(viewProfile(studentInfo));
    })
    .fail((data)=>{
        console.log(data);
    })
    
})
