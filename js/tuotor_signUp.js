// 利用規約に同意しているか否か
$('#rule').click(function() {
    if ( $(this).prop('checked') == false ) {
      $('.main').css('display','none');
      $('#btn').attr('disabled','disabled');
    } else {
        $('.main').css('display','block');
        $('#btn').removeAttr('disabled');
    }
});

// 生年月日
$(function(){
    let now = new Date();
    let year = now.getFullYear();
    let view = '';
    for(let i=1970;i<year;i++){
        if(i == 1990){
            view += '<option selected>'+i+'</option>';
        }else{
            view += '<option>'+i+'</option>';
        }
    }
    $('.birthyear').append(view);
})

$(function(){
    let view = '';
    for(let i=1; i<13; i++){
        view += '<option>'+i+'</option>';
    }
    $('.birthmonth').append(view);
})

