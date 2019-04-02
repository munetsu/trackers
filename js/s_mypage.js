///////////////////////////////////////////
// 変数一覧
///////////////////////////////////////////
// 資格一覧
certifications;
// console.log(certifications);

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




