// ログイン部分
$('#loginBtn').on('click',function(){
    $.ajax({
        url: '../php/ajax.php',
        type: 'POST',
        data:{
            action: 'login',
            id: $('#loginId').val(),
            pass: $('#password').val()
        } 
    })
    .done((data) => {
        $('#all').html(data)
    })
    .fail((data) => {
        $('#all').html('ログインエラーです')
    })
    }
)

// サインアップ部分
$('#registerBtn').on('click',function(){
    $.ajax({
        url: '../php/ajax.php',
        type: 'POST',
        data:{
            action: 'register',
            id: $('#registerId').val(),
            pass: $('#registerPassword').val()
        } 
    })
    .done((data) => {
        $('#all').html(data)
    })
    .fail((data) => {
        $('#all').html('すでに登録されています')
    })
    }
)