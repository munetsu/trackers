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


///////////////////////////////////////////
// 動的処理
///////////////////////////////////////////


// チューター個人をクリックした場合
$(document).on('click', '.tuotor', function(){
    let tuotor_id = $(this).attr('data-id');
    window.location.href="s_tuotorDetail.php?tid="+tuotor_id;
})

///////////////////////////////////////////
// ローカルストレージ 
///////////////////////////////////////////
let getStorage = localStorage.getItem('datecheck');

///////////////////////////////////////////
// アラート（日程調整が必要なものがあった場合）
///////////////////////////////////////////
if(alertcheck == 1 && getStorage != date){
    if(!confirm('チューターより日程打診があります。\n今すぐ確認しますか？')){
        // キャンセルの場合
        localStorage.setItem('datecheck', date);
    }else{
        window.location.href="s_adjustmentlist.php";
    }
}

///////////////////////////////////////////
// クリック処理
///////////////////////////////////////////
// 資格ごとのチューター一覧ページへ
$(document).on('click','.alldescribe', function(e){
    e.preventDefault();
    let certificationid = $(this).attr('data-certification');
    window.location.href="s_tuotoralllist.php?certificationid="+certificationid;
})

///////////////////////////////////////////
// スマホ用処理
///////////////////////////////////////////
