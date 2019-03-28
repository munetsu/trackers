$(document).on('click', '#btn', function(){
    let email = $('input[name="email"]').val();
    if(email == null){
        alert('メールアドレスが未入力です');
        return;
    }
    let pass = $('input[name="password"]').val();
    if(pass == null){
        alert('パスワードが未入力です');
        return;
    }
    login.submit();
})