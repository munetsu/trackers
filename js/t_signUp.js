///////////////////////////////////////////
// 変数一覧
///////////////////////////////////////////
let checkpoint = 0;

let error = 0;
let academiccheck = 0;


///////////////////////////////////////////
// 関数（読み込み時に実行）
///////////////////////////////////////////
// 利用規約の書き込み
$('#useRule').val(viewUseRule());

// 個人情報取り扱い
$('#privacyPolicy').val(viewUseRule());

// 登録フォーム追記
mainAppend();

// 生年月日(西暦)
// 西暦
function birthyear(){
    let now = new Date();
    let year = now.getFullYear();
    let view = '';
    for(let i=1900;i<year;i++){
        if(i == 1990){
            view += '<option selected>'+i+'</option>';
        }else{
            view += '<option>'+i+'</option>';
        }
    }
    $('#birthyear').append(view);
}

// 月
function birthmonth(){
    let view = '';
    for(let i=1; i<13; i++){
        if(i == 6){
            view += '<option selected>'+i+'</option>';
        }else{
            view += '<option>'+i+'</option>';
        }
    }
    $('#birthmonth').append(view);
}

// 属性
function status(){
    let kindstatus = ['', '会社員', '役員', '学生', '主婦・主夫', 'フリーター・パート', 'その他'];
    let view = '';
    for(let i=0;i<kindstatus.length;i++){
        view = '<option value="'+i+'">'+kindstatus[i]+'</option>';
        $('#status').append(view);
    }
}

// 学歴
function academic(){
    let kindacademic = ['', '大学院卒', '大学卒', '専門・高専卒', '高校卒', '中卒', '非回答'];
    let view = '';
    for(let i=0;i<kindacademic.length;i++){
        view = '<option value="'+i+'">'+kindacademic[i]+'</option>';
        $('#academic').append(view);
    }
}

// 勉強方法
function howto(){
    let kindhow = ['', '独学', '資格学校', '通信教育'];
    let view = '';
    for(let i=0;i<kindhow.length;i++){
        view = '<option value="'+i+'">'+kindhow[i]+'</option>';
        $('#howto').append(view);
    }
}

// どの学校・通信教育か
$(document).on('change', '#howto', function(){
    $('#howtoSchool').remove();
    let value = $(this).val();
    if(value != 1){
        academiccheck = 1;
        let view = `<div id="howtoSchool">学校・サービス名：<input type="text" name="shcoolname"></div>`;
        $(this).parent('p').append(view);
    }else{
        academiccheck = 0;
    }
})

// 受験回数
function howmany(){
    for(let i = 1;i<=5;i++){
        if(i == 5){
            let view = `<option value="`+i+`">`+i+`回以上</option>`;
            $('#howmany').append(view);
        }else{
            let view = `<option value="`+i+`">`+i+`回</option>`;
            $('#howmany').append(view);
        }
    }

}


///////////////////////////////////////////
// 関数（動的に実行）
///////////////////////////////////////////
// 利用規約など読んだか確認
// スクロールさせる要素を取得
$('.scrollArea').on('scroll', function(e){
    let id = $(this).attr('id');
    const elm = $('#'+id);
   
    let maxheight = elm.height();
    let height = e.target.scrollHeight;
    let height2 = e.target.offsetHeight;
    
    // 現在の表示位置の高さ 
    var scrollPosition = elm.scrollTop();

    // 最後になったら、チェックボックスを有効化
    if((height -(height2+scrollPosition) <0)){
        elm.parent().find('input').prop('disabled', false);
    }
});

// 規約・個人情報取り扱い同意の確認
$('.checkpoint').on('change', function(){
    let id = $(this).attr('id');
    let status = $('#'+id).prop('checked');
    let value = $('#'+id).val();
    value = parseInt(value, 10);
    if(status){
        checkpoint += value;
        if(checkpoint == 11){
            $('.itemList').append(viewBtn());
        }
    }else{
        checkpoint -= value;
        if(checkpoint != 11){
            $('#confirmBtn').remove();
        }
    }
});

// 登録フォーム表示
function mainAppend(){
    birthyear();
    birthmonth();
    status();
    academic();
    howto();
    howmany();
}

// メールアドレスのチェック
$(document).on('blur', 'input[type="email"]', function(){
    let value = $(this).val();
    let mailcheck = value.match(/^[-a-z0-9~!$%^&*_=+}{\'?]+(\.[-a-z0-9~!$%^&*_=+}{\'?]+)*@([a-z0-9_][-a-z0-9_]*(\.[-a-z0-9_]+)*\.(aero|arpa|biz|com|coop|edu|gov|info|int|mil|museum|name|net|org|pro|travel|mobi|[a-z][a-z])|([0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}))(:[0-9]{1,5})?$/i);
    if(mailcheck == null){
        error = 0;
        $('#errormail').remove();
        $(this).parent('p').append('<span id="errormail">メールアドレスの確認をお願いします</span>');
    }else{
        error = 1;
        $('#errormail').remove();
    }
})

// 電話番号のチェック
$(document).on('blur', 'input[name="tel"]', function(){
    $('#telnumber').remove();
    let value = $(this).val();
    for(let i=0;i<value.length;i++){
        value = value.replace(/-/, '');
    }
    $(this).val(value)
    if(value.length != 11){
        error = 1;
        $(this).parent('p').append('<span id="telnumber">番号を確認してください</span>');
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
    if(academiccheck == 1){
        if($('input[name="shcoolname"]').val() == ''){
            alert('学校名・サービス名を記載してください')
            return;
        }
    }
    if(error != 0){
        alert('emailもしくは電話番号をご確認ください')
    }
    signUp.submit();
})



///////////////////////////////////////////
// view部分
///////////////////////////////////////////
// 利用規約
function viewUseRule(){
    let view = 
    `利用規約
    本サービスを利用するにあたり、下記内容を確認ください。
    利用にあたって、・・・・・・・
    利用にあたって、・・・・・・・
    利用にあたって、・・・・・・・
    利用にあたって、・・・・・・・
    利用にあたって、・・・・・・・
    利用にあたって、・・・・・・・
    利用にあたって、・・・・・・・
    利用にあたって、・・・・・・・
    利用にあたって、・・・・・・・
    利用にあたって、・・・・・・・
    利用にあたって、・・・・・・・
    利用にあたって、・・・・・・・
    利用にあたって、・・・・・・・
    利用にあたって、・・・・・・・
    利用にあたって、・・・・・・・
    利用にあたって、・・・・・・・
    利用にあたって、・・・・・・・
    利用にあたって、・・・・・・・
    利用にあたって、・・・・・・・
    利用にあたって、・・・・・・・
    利用にあたって、・・・・・・・
    利用にあたって、・・・・・・・
    利用にあたって、・・・・・・・
    利用にあたって、・・・・・・・
    利用にあたって、・・・・・・・
    利用にあたって、・・・・・・・
    利用にあたって、・・・・・・・
    利用にあたって、・・・・・・・
    利用にあたって、・・・・・・・
    ご利用にあたって、・・・・・・・
    ご利用にあたって、・・・・・・・
    `;
    return view;
}

// 個人情報取り扱いについて
function viewPrivacyPolicy(){

}



// 登録フォーム送信ボタン
function viewBtn(){
    let view = `
        <div id="confirmBtn">
        <a href="" id="btn">確認画面</a>
        </div>
    `;
    return view;
}
