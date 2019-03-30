$(document).on('click', '#btn', function(){
    let email = $('input[name="email"]').val();
    let mailcheck = email.match(/^[-a-z0-9~!$%^&*_=+}{\'?]+(\.[-a-z0-9~!$%^&*_=+}{\'?]+)*@([a-z0-9_][-a-z0-9_]*(\.[-a-z0-9_]+)*\.(aero|arpa|biz|com|coop|edu|gov|info|int|mil|museum|name|net|org|pro|travel|mobi|[a-z][a-z])|([0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}))(:[0-9]{1,5})?$/i);
    if(email == ''){
        alert('メールアドレスが未入力です');
        return;
    }else if(mailcheck == null){
        alert('メールアドレスをご確認ください');
        return;
    }

    let pass = $('input[name="password"]').val();
    if(pass == ''){
        alert('パスワードが未入力です');
        return;
    }
    login.submit();
})