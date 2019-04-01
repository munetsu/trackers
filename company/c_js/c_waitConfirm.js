///////////////////////////////////////////////
// 変数一覧
///////////////////////////////////////////////
// 承認待ちリスト
console.log(lists);


///////////////////////////////////////////////
// 読み込み時処理
///////////////////////////////////////////////
for(let i=0;i<lists.length;i++){
    $('.main').append(viewMain(i, lists));
}

///////////////////////////////////////////////
// VIEW
///////////////////////////////////////////////
// 初期描画
function viewMain(num, lists){
    let view = `
        <div data-id="`+lists[num]['howto_id']+`" class="block">
            <p>`+(num+1)+`件目</p>
            <p>登録日:`+lists[num]['Date']+`</p>
        </div>
    `;
    return view;
}

// howto詳細描画
function viewHowtoDetail(lists, books){
    let view = `
        <div data-id="`+lists['howto_id']+`">
            <div>
                <p>【対象月】</p>
                <p>`+lists['month']+`月</p>
            </div>
            <div>
                <p>【勉強時間】</p>
                <p>平日：`+lists['weektime']+`時間 × `+lists['weekday']+`日</p>
                <p>休日：`+lists['holidaytime']+`時間 × `+lists['holiday']+`日</p>
            </div>
            <div>
                <p>【利用テキスト】</p>
                <div class="textarea">
                `+viewBook(books)+`
                </div>
            </div>
            <div>
                <p>【勉強法】</p>
                <pre>`+lists['howto'].replace(/\\r\\n|\\r|\\n/g, '<br>')+`</pre>
            </div>
        </div>
        <div class="judge">
            <div>
                <a href="" class="btn" id="ok" data-id="`+lists['howto_id']+`">承認</a>
            </div>
            <div>
                <a href="" class="btn" id="no" data-id="`+lists['howto_id']+`">不承認</a>
            </div>
        </div>
    `;
    return view;
}

// テキスト描画
function viewBook(books){
    let view = '';
    for(let i=0;i<books.length;i++){
        view += `
            <div>
                <p>タイトル：`+books[i]['title']+`</p>
                `+books[i]['imageUrl']+`
            </div>
        `;
    }
    return view;
}

///////////////////////////////////////////////
// クリック処理
///////////////////////////////////////////////
// howto詳細取得
$(document).on('click', '.block', function(){
    let howto_id = $(this).attr('data-id');
    $.ajax({
        url:'c_controller.php',
        type:'POST',
        data:{
            action:'getHowto',
            howto_id:howto_id
        }
    })
    .done((data)=>{
        data = $.parseJSON(data);
        console.log(data);
        lists = data[0];
        books = data[1];
        $('.main').empty();
        $('.main').append(viewHowtoDetail(lists, books));
    })
    .fail((data)=>{
        console.log(data);
        alert('エラーが発生しました');
    })

})

// 承認処理
$(document).on('click', '#ok', function(e){
    e.preventDefault();
    let howto_id = $(this).attr('data-id');
    $.ajax({
        url:'c_controller.php',
        type:'POST',
        data:{
            action:'howtoJudge',
            howto_id:howto_id,
        }
    })
    .done((data)=>{
        alert('無事に登録が完了しました。\n'+data);
        location.reload();
    })
    .fail((data)=>{
        alert('更新失敗：エラー\n'+data);
    })
})

// 不承認処理
$(document).on('click', '#no', function(e){
    e.preventDefault();
    let howto_id = $(this).attr('data-id');
    $('.judge').append(`
        <textarea data-id="`+howto_id+`"></textarea><br>
        <a href="" id="submit" data-id="`+howto_id+`">送信</a>
    `);
})

// 不承認登録
$(document).on('click', '#submit', function(e){
    e.preventDefault();
    let howto_id = $(this).attr('data-id');
    let reason = $('textarea[data-id="'+howto_id+'"]').val();
    $.ajax({
        url:'c_controller.php',
        type:'POST',
        data:{
            action:'Nohowto',
            howto_id:howto_id,
            reason:reason
        }
    })
    .done((data)=>{
        // console.log(data);
        alert('登録が完了しました\n'+data);
        location.reload();
    })
    .fail((data)=>{
        alert('登録失敗'+data);
    })
})

