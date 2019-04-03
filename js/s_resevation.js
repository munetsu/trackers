//////////////////////////////////////////////////////////
// 読み込み時に描画
//////////////////////////////////////////////////////////
// カレンダー部分
$(".datepicker").datepicker({
    dateFormat:'yy/mm/dd',
    minDate: "+7d",
    maxDate: "+40d",
});

// 時間部分
for(let i=0;i<=23;i++){
    let view = '';
    if(i == 12){
        view = '<option value='+i+' selected>'+i+'時</option>';        
    }else{
        view = '<option value='+i+'>'+i+'時</option>';
    }
    $('.time').append(view);
};

// 分部分
for(let i=00;i<=59;i+=10){
    let view = '';
    if(i == 30){
        view = '<option value='+i+' selected>'+i+'分</option>';        
    }else{
        view = '<option value='+i+'>'+i+'分</option>';
    }
    $('.minute').append(view);
};

//////////////////////////////////////////////////////////
// クリック処理
//////////////////////////////////////////////////////////
// 確認ボタン
$('.btn').on('click', function(e){
    e.preventDefault();
    let clicked = $(this).attr('class');
    if(clicked.match(/clicked/)){
        return;
    }
    // 未選択がないか確認
    for(let i=1; i<=3;i++){
        let offerdate = $('input[name="offerDate'+i+'"]').val();
        if(offerdate == ''){
            alert('第'+i+'希望日が選択されていません')
            return;
        }
    }
    $(this).addClass('clicked');
    booking.submit();
})