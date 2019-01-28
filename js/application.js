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

// 会員登録部分
$(document).on('click','#registerBtn',function(){
    $.ajax({
        url: 'php/ajax.php',
        type: 'POST',
        data:{
            action: 'register',
            id: $('#registerId').val(),
            pass: $('#registerPassword').val()
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

