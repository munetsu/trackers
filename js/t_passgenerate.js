///////////////////////////////////////////////
// 動的処理
///////////////////////////////////////////////
// 文字表示
$(document).on('keyup', '.pass', function(){
    let val = $(this).val();
    let focus = $(this).attr('name');
    $('.'+focus).empty();
    $('.'+focus).append(val);
})

// password表示
$(document).on('click', '.describe', function(){
    let id = $(this).attr('data-id');
    $('.'+id).css('display', 'block');
})

// パスワードのチェック
$(document).on('change', '.pass', function(){
    let pass = $(this).val();
    // 英数記号の8文字以上100字以内
    let passcheck = pass.match(/^(?=.*[0-9])(?=.*[A-Za-z])(?=.*[!\x22\#$%&@'()*+,-./_])[\w!\x22\#$%&@'()*+,-./]{8,64}$/);
    // let markcheck = pass.match(/^(?=[!\x22\#$%&@'()*+,-./])/);
    // console.log(markcheck);
    if(passcheck == null){
        alert('使えない記号が使われている。または文字数をご確認ください');
        return;
    }
})



// メールアドレスのチェック
$(document).on('change', 'input[type="email"]', function(){
    let value = $(this).val();
    let mailcheck = value.match(/^[-a-z0-9~!$%^&*_=+}{\'?]+(\.[-a-z0-9~!$%^&*_=+}{\'?]+)*@([a-z0-9_][-a-z0-9_]*(\.[-a-z0-9_]+)*\.(aero|arpa|biz|com|coop|edu|gov|info|int|mil|museum|name|net|org|pro|travel|mobi|[a-z][a-z])|([0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}))(:[0-9]{1,5})?$/i);
    console.log(mailcheck);
    if(mailcheck == null){
        alert('メールアドレスが未入力もしくは誤りがあります');
        return;
    }
})

// 登録ボタン
$(document).on('click', '.btn', function(e){
    e.preventDefault();
    let email = $('input[name="email"]').val();
    // メールアドレスチェック
    if(email == null){
        alert('メールアドレスが未入力です');
        return;
    }
    let pass1 = $('input[name="pass1"]').val();
    let pass2 = $('input[name="pass2"]').val();
    // パスワードチェック
    if(pass1 != pass2){
        alert('パスワードが一致していません');
        return;
    }
    account.submit();
})