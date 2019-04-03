/////////////////////////////////////////////////
// 読み込み時に処理
/////////////////////////////////////////////////
// カレンダー部分
$(".datepicker").datepicker({
    dateFormat:'yy/mm/dd',
    minDate: "+7d",
    maxDate: "+40d",
});

// 時間側(start)
for(let i=0;i<offerStarttimeh.length;i++){
    let view = '';
    for(let k= 0;k<=23;k++){
        console.log(offerStarttimeh[i]);
        if(offerStarttimeh[i] == k){
            view = '<option value='+k+' selected>'+k+'時</option>';
        }else{
            view = '<option value='+k+'>'+k+'時</option>';
        }
        $('.stime'+(i+1)).append(view);
    }
}

// 時間側(finish)
for(let i=0;i<offerFinishtimeh.length;i++){
    let view = '';
    for(let k= 0;k<=23;k++){
        console.log(offerFinishtimeh[i]);
        if(offerFinishtimeh[i] == k){
            view = '<option value='+k+' selected>'+k+'時</option>';
        }else{
            view = '<option value='+k+'>'+k+'時</option>';
        }
        $('.ftime'+(i+1)).append(view);
    }
}

// 分側(start)
for(let i=0;i<offerStarttimem.length;i++){
    let view = '';
    for(let k= 0;k<=50;k+=10){
        console.log(offerStarttimem[i]);
        if(offerStarttimem[i] == k){
            view = '<option value='+k+' selected>'+k+'分</option>';
        }else{
            view = '<option value='+k+'>'+k+'分</option>';
        }
        $('.sminute'+(i+1)).append(view);
    }
}

// 分側(finish)
for(let i=0;i<offerFinishtimem.length;i++){
    let view = '';
    for(let k= 0;k<=50;k+=10){
        console.log(offerFinishtimem[i]);
        if(offerFinishtimem[i] == k){
            view = '<option value='+k+' selected>'+k+'分</option>';
        }else{
            view = '<option value='+k+'>'+k+'分</option>';
        }
        $('.fminute'+(i+1)).append(view);
    }
}

/////////////////////////////////////////////////
// クリック処理
/////////////////////////////////////////////////
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
