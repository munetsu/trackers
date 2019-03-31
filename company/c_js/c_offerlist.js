///////////////////////////////////////////
// 変数一覧
///////////////////////////////////////////
const item = [
    'a_familyname', //0
    'a_firstname', //1
    'academic', //2
    'birthmonth', //3
    'birthyear', //4
    'email', //5
    'k_familyname', //6
    'k_firstname', //7
    'tel',  //8
    'tuotor_id' //9
]

// 申請待ちリスト
lists;

///////////////////////////////////////////
// 読み込み時に処理
///////////////////////////////////////////
for(let i=0; i<lists.length;i++){
    $('.main').append(viewMain(lists[i]));    
}


///////////////////////////////////////////
// VIEW
///////////////////////////////////////////
// 枠組み
function viewMain(list){
    let view = `
        <div class="tuotor_id" data-id="`+list[item[9]]+`">
            <p class="id">チューターID：`+list[item[9]]+`</p>
            <p>氏名：`+list[item[6]]+list[item[7]]+`</p>
            <p>生年月日：`+list[item[4]]+`年`+list[item[3]]+`月</p>
            <p data-id="`+list[item[9]]+`">Email：`+list[item[5]]+`</p>
            <p>携帯：`+list[item[8]]+`</p>
            <a href="" class="ok" data-id="`+list[item[9]]+`">承認</a>
        </div>
    `;
    return view;
}

// メール文面
function viewMail(){
    let view = `
        身分証明書等の送付ありがとうございました。
        ご確認させていただきました。
        続いて、資格試験の勉強方法に関してのご登録をお願いします。


        【ログインページ】
        <a href="http://yumefukuro.sakura.ne.jp/trackers/login.php?status=tuotor">\n
        http://yumefukuro.sakura.ne.jp/trackers/login.php?status=tuotor</a>\n


        ご不明点等ございましたら、下記アドレスまでご連絡ください\n
        連絡先：info@trackers.co.jp
    `;
    // encode
    view = encodeURIComponent(view);
    return view;
}

///////////////////////////////////////////
// クリック処理
///////////////////////////////////////////
// 承認処理（ajax）
$(document).on('click', '.ok', function(e){
    e.preventDefault();
    let id = $(this).attr('data-id');
    let email = $('p[data-id='+id+']').text();
    $.ajax({
        url:'c_controller.php',
        type:'POST',
        data:{
            action:'ok',
            id:id,
            email:email
        }
    })
    .done((data)=>{
        console.log(data);
        alert(data);
        $('a[data-id='+id+']').remove();
        $('div[data-id='+id+']').append('<a href="mailto:'+email+'?subject=【Trackers】ご登録ありがとうございます。&amp;body='+viewMail()+'" target="_blank">メール送信</a>');
    })
    .fail((data)=>{
        alert(data);
    })
})


