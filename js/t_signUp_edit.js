///////////////////////////////////////////
// 変数一覧
///////////////////////////////////////////
let error = 0;
let academiccheck = howto;

///////////////////////////////////////////
// select追記処理
///////////////////////////////////////////

// 属性
function setstatus(){
    let kindstatus = ['','会社員', '役員', '学生', '主婦・主夫', 'フリーター・パート', 'その他'];
    let view = '';
    for(let i=0;i<kindstatus.length;i++){
        if(status == i){
            view = '<option value="'+i+'" selected>'+kindstatus[i]+'</option>';            
        }else{
            view = '<option value="'+i+'">'+kindstatus[i]+'</option>';
        }
        $('.status').append(view);
    }
}

// 学歴
function setacademic(){
    let kindacademic = ['', '大学院卒', '大学卒', '専門・高専卒', '高校卒', '中卒', '非回答'];
    let view = '';
    for(let i=0;i<kindacademic.length;i++){
        if(academic == i){
            view = '<option value="'+i+'" selected>'+kindacademic[i]+'</option>';            
        }else{
            view = '<option value="'+i+'">'+kindacademic[i]+'</option>';
        }
        $('.academic').append(view);
    }
}

// 勉強方法
function sethowto(){
    let kindhow = ['', '独学', '資格学校', '通信教育'];
    let view = '';
    for(let i=0;i<kindhow.length;i++){
        if(howto == i){
            view = '<option value="'+i+'" selected>'+kindhow[i]+'</option>';            
        }else{
            view = '<option value="'+i+'">'+kindhow[i]+'</option>';
        }
        $('.howto').append(view);
    }
}

// どの学校・通信教育か
$(document).on('change', '.howto', function(){
    $('.howtoschool').empty();
    let value = $(this).val();
    if(value != 1){
        academiccheck = 1;
        let view = `
            <td>学校・サービス名</td>
            <td><input type="text" name="shcoolname"></td>
            `;
        $('.howtoschool').append(view);
    }else{
        academiccheck = 0;
    }
})

// 受験回数
function sethowmany(){
    let view = '';
    for(let i = 1;i<=5;i++){
        if(howmany == i){
            view = `<option value="`+i+`" selected>`+i+`回</option>`;
        }else if(i == 5 && howmany == i){
            view = `<option value="`+i+`" selected>`+i+`回以上</option>`;
        }else if(i == 5){
            view = `<option value="`+i+`">`+i+`回以上</option>`;
        }else{
            view = `<option value="`+i+`">`+i+`回</option>`;
        }
        $('.howmany').append(view);
    }
}

//////////////////////////////////////////////////////////////////
// 読み込み時に処理
//////////////////////////////////////////////////////////////////
setstatus();
setacademic();
sethowto();
sethowmany();

///////////////////////////////////////////
// 関数（動的に実行）
///////////////////////////////////////////// 
// メールアドレスのチェック
$(document).on('blur', 'input[name="email"]', function(){
    let value = $(this).val();
    let mailcheck = value.match(/^[-a-z0-9~!$%^&*_=+}{\'?]+(\.[-a-z0-9~!$%^&*_=+}{\'?]+)*@([a-z0-9_][-a-z0-9_]*(\.[-a-z0-9_]+)*\.(aero|arpa|biz|com|coop|edu|gov|info|int|mil|museum|name|net|org|pro|travel|mobi|[a-z][a-z])|([0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}))(:[0-9]{1,5})?$/i);
    if(mailcheck == null){
        error = 0;
        alert('現在のアドレスは登録出来ません');
    }else{
        error = 1
    }
})

// 電話番号のチェック
$(document).on('blur', 'input[name="tel"]', function(){
    let value = $(this).val();
    for(let i=0;i<value.length;i++){
        value = value.replace(/-/, '');
        value = value.replace(/[^0-9]/g, '');
    }
    $(this).val(value)
    if(value.length != 11){
        error = 1;
        alert(`電話番号をもう一度ご確認ください。
    「-」など記号は入力できません`);
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