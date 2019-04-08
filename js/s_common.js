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

// 資格リスト
function viewcertificationList(num, certifications){
    let view = `
        <li data-certification="`+(num+1)+`"><a href="s_tuotoralllist.php?certificationid=`+(num+1)+`">`+certifications+`</a></li>
    `;
    $('.certificaionList').append(view);
}