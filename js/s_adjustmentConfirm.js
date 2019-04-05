/////////////////////////////////////////////
// 変数一覧
/////////////////////////////////////////////
// 日程リスト
offerlist;
// console.log(offerlist);

// コンサルID
consulid;
// console.log(consulid);

/////////////////////////////////////////////
// クリック処理
/////////////////////////////////////////////
$('.confirm').on('click', function(e){
    e.preventDefault();
    let clicked = $(this).attr('class');
    if(clicked.match(/clicked/)){
        return;
    }
    // ajax
    $.ajax({
        url:'mvc/controller.php',
        type:'POST',
        data:{
            action:'consuldateEdit',
            consulid:consulid,
            dateInfo:offerlist
        }
    })
    .done((data)=>{
        if(data == 'dataError'){
            alert('登録できませんでした。\n再度、送信処理をお願いします');
            return;
        }else if(data == 'OK'){
            alert('日程打診が完了しました');
            window.location.href="t_mypage.php";
        }
    })
    .fail((data)=>{
        console.log(data)
    })
})
