// 生徒ログイン部分
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
        // $('body').html(data);
        window.location.href="signUp.php";
    })
    .fail((data) => {
        $('body').html('ログインエラーです')
    })
    }
)

// 生徒サインアップ部分
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
        $('body').html(data);
    })
    .fail((data) => {
        $('body').html('すみません、もう一度お試しください');
    })
    }
)

