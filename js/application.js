// ログイン部分
$(document).on('click','#loginBtn',function(){
    $.ajax({
        url: 'php/ajax.php',
        type: 'POST',
        data:{
            action: 'login',
            id: $('#loginId').val(),
            pass: $('#password').val()
        } 
    })
    .done((data) => {
       console.log(data);
       window.location.href=data;
    })
    .fail((data) => {
        $('body').html('ネットワークエラーです')
    })
    }
)

