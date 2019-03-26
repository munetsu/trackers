///////////////////////////////////////////
// 変数一覧
///////////////////////////////////////////
let checkpoint = 0;



///////////////////////////////////////////
// 関数（読み込み時に実行）
///////////////////////////////////////////
// 利用規約の書き込み
$('#useRule').val(viewUseRule());

// 個人情報取り扱い
$('#privacyPolicy').val(viewUseRule());

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
    let kindstatus = ['会社員', '役員', '学生', '主婦・主夫', 'フリーター・パート', 'その他'];
    let view = '';
    for(let i=0;i<kindstatus.length;i++){
        view = '<option value="'+i+'">'+kindstatus[i]+'</option>';
        $('#status').append(view);
    }
}

// 学歴
function academic(){
    let kindacademic = ['大学院卒', '大学卒', '専門・高専卒', '高校卒', '中卒', '非回答'];
    let view = '';
    for(let i=0;i<kindacademic.length;i++){
        view = '<option value="'+i+'">'+kindacademic[i]+'</option>';
        $('#academic').append(view);
    }
}

// 勉強方法
function howto(){
    let kindhow = ['独学', '資格学校', '通信教育'];
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
    if(value != 0){
        let view = `<div id="howtoSchool">学校・サービス名：<input type="text" name="shcoolname"></div>`;
        $(this).parent('p').append(view);
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
            mainAppend();
        }
    }else{
        checkpoint -= value;
    }
});

// 登録フォーム表示
function mainAppend(){
    $('.itemList').append(viewMain());
    birthyear();
    birthmonth();
    status();
    academic();
    howto();
    howmany();
}





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

// 登録情報
function viewMain(){
    let view = `
        <form action="mvc/controller.php" method="POST" name="signUp">
            <p>氏名<span>*</span>：<input type="text" name="k_familyname" class="text" placeholder="(例)田中"><input type="text" name="k_firstname" class="text" placeholder="(例)太郎"></p>
            <p>NAME<span>*</span>：<input type="text" name="a_familyname" class="text" placeholder="(例)tanaka"><input type="text" name="a_firstname" class="text" placeholder="(例)tarou"></p>
            <p>E-mail<span>*</span>：<input type="text" name="email" class="text" placeholder="(例)sample@trackers.co.jp"></p>
            <p>携帯番号<span>*</span>：<input type="number" name="tel" class="text" placeholder="(例)09011111111"></p>
            <p>生年月日<span>*</span>：<select id="birthyear"></select>年／<select id="birthmonth"></select>月</p>
            <p>属性<span>*</span>：<select id="status"></select></p>
            <p>学歴<span>*</span>：<select id="academic"></select></p>
            <p>勉強方法<span>*</span>：<select id="howto"></select></p>
            <p>受験回数<span>*</span>：<select id="howmany"></select></p>
        </form>
    `;
    return view;
}

// 登録フォーム送信ボタン
function viewBtn(){
    let view = `
        <div>
        <a href="" id="btn">登録</a>
        </div>
    `;
    return view;

}
