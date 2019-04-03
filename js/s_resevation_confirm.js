////////////////////////////////////////
// 変数一覧
////////////////////////////////////////
// 日時データ
array;
// console.log(array);

////////////////////////////////////////
// クリック処理
////////////////////////////////////////
// 修正するをクリックした場合
$('.back').on('click', function(e){
    e.preventDefault();
    let clicked = $(this).attr('class');
    if(clicked.match(/clicked/)){
        return;
    }
    // フォーム送信
    edit.submit();
})

// 送信する
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
            action:'resevation',
            sid:sid,
            consulid:consulid,
            dateInfo:array
        }
    })
    .done((data)=>{
        if(data == 'dataError'){
            alert('登録できませんでした。\n再度、送信処理をお願いします');
            return;
        }else if(data == 'OK'){
            alert('日程打診が完了しました');
            window.location.href="s_mypage.php?id="+sid;
        }
    })
    .fail((data)=>{
        console.log(data);
    })
})
