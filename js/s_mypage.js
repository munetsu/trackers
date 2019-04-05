///////////////////////////////////////////
// 変数一覧
///////////////////////////////////////////
// 資格一覧
certifications;
// console.log(certifications);

// student_id
student_id;

// 日程調整用のアラート
alertcheck;
// 0->日程調整なし、1->日程調整必要

///////////////////////////////////////////
// VIEW
///////////////////////////////////////////
// 資格リスト
function viewcertificationList(num, certifications){
    let view = `
        <li data-certification="`+num+`">`+certifications+`</li>
    `;
    $('.certificaionList').append(view);
}

///////////////////////////////////////////
// 動的処理
///////////////////////////////////////////
// 資格描画（マウスホバー）
$('.search').hover(function(){
    // マウスホバー時
    $.each(certifications, function(index, value){
        viewcertificationList(index, value['certification_kind']);
        // console.log(index+value['certification_kind']);
    });
    }, function(){
        // マウスホバーを外した場合
        $('.certificaionList').empty();
    }
)

// チューター個人をクリックした場合
$(document).on('click', '.tuotor', function(){
    let tuotor_id = $(this).attr('data-id');
    window.location.href="s_tuotorDetail.php?tid="+tuotor_id+"&sid="+student_id;
})

///////////////////////////////////////////
// アラート
///////////////////////////////////////////
if(alertcheck == 1){
    alert('チューターより日程打診があります。ご返信をお願いします');
    window.location.href="s_adjustmentlist.php";
}

