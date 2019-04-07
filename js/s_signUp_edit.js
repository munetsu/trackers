///////////////////////////////////////////
// 変数一覧
///////////////////////////////////////////
let checkpoint = 0;

let error = 0;
let nameerror = 0;

///////////////////////////////////////////
// 関数（動的に実行）
///////////////////////////////////////////
// アルファベットチェック
$(document).on('change', '.alpha', function(){
    let value = $(this).val();
    let check = value.match(/^[a-zA-Z]+$/);
    if(check == null){
        alert('アルファベットでの入力をお願いします');
        $(this).val('');
    }
})

// メールアドレスのチェック
$(document).on('change', 'input[type="email"]', function(){
    let value = $(this).val();
    let mailcheck = value.match(/^[-a-z0-9~!$%^&*_=+}{\'?]+(\.[-a-z0-9~!$%^&*_=+}{\'?]+)*@([a-z0-9_][-a-z0-9_]*(\.[-a-z0-9_]+)*\.(aero|arpa|biz|com|coop|edu|gov|info|int|mil|museum|name|net|org|pro|travel|mobi|[a-z][a-z])|([0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}))(:[0-9]{1,5})?$/i);
    if(mailcheck == null){
        error = +10;
        alert('メールアドレスの確認をお願いします')
    }else{
        error = 0;
    }
})

// 電話番号のチェック
$(document).on('change', 'input[name="tel"]', function(){
    $('#telnumber').remove();
    let value = $(this).val();
    for(let i=0;i<value.length;i++){
        value = value.replace(/-/, '');
        value = value.replace(/[^0-9]/g, '');
    }
    $(this).val(value)
    if(value.length != 11){
        error = +100;
        alert(`電話番号をもう一度ご確認ください。\n「-」など記号は入力できません`);
    }else{
        error = 0;
    }
})

// 確認画面への処理
$(document).on('click', '#btn', function(e){
    e.preventDefault();
    let test = [];
    test.push($('input[name="k_familyname"]').val());
    test.push($('input[name="k_firstname"]').val());
    test.push($('input[name="a_familyname"]').val());
    test.push($('input[name="a_firstname"]').val());
    test.push($('input[name="email"]').val());
    test.push($('input[name="tel"]').val());
    for(let i=0;i<test.length;i++){
        if(test[i] == ''){
            alert('未記入欄があります');
            return;
        }
    }
    // バリデーションチェック
    let name1 = test[2];
    let name2 = test[3];
    name1 = name1.match(/^[a-zA-Z]+$/);
    name2 = name2.match(/^[a-zA-Z]+$/);
    if(name1 == null || name2 == null){
        alert('「NAME」欄はアルファベットでの記載をお願いします');
        return;
    }
    let email = test[4];
    email = email.match(/^[-a-z0-9~!$%^&*_=+}{\'?]+(\.[-a-z0-9~!$%^&*_=+}{\'?]+)*@([a-z0-9_][-a-z0-9_]*(\.[-a-z0-9_]+)*\.(aero|arpa|biz|com|coop|edu|gov|info|int|mil|museum|name|net|org|pro|travel|mobi|[a-z][a-z])|([0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}))(:[0-9]{1,5})?$/i);
    if(email == null){
        alert('メールアドレスをご確認ください');
        return;
    }

    let tel = test[5];
    console.log(tel);
    telcheck = tel.match(/^\d+$/);
    
    if(telcheck == null || tel.length != 11){
        alert('電話番号をご確認ください');
        return;
    }

    signUp.submit();
})
