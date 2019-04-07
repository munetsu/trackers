//////////////////////////////////////////////////
// 変数一覧
//////////////////////////////////////////////////
let count = 1;

let bookInfo = {
    id:'',
    title:'',
    imageUrl:'',
    url:''
}

const bookLists = [];

//////////////////////////////////////////////////
// 読み込み時の処理
//////////////////////////////////////////////////
// 表示領域の確立
$('.flex').append(viewBook(count));

//////////////////////////////////////////////////
// 動的処理
//////////////////////////////////////////////////
// 書籍検索処理（amazon）
$('input[name="amazon"]').on('blur', function(){
    
    // 登録内容取得
    let url = $(this).val();

    // 空の場合は抜ける
    if(url == ''){
        return;
    }

    // // 文字列分割
    let string = url.split('/');
    console.log(string);

    // // ドメイン取得
    let domain = string[2];
    // // 文字列のデコード
    let title = decodeURI(string[3]);
    
    // // amazonリンクか確認
    if(domain != 'www.amazon.co.jp'){
        alert('amazonのリンクを記載してください');
        $(this).val('');
        return;
    }

    $('div[data-id='+count+']').append(
        '<p data-id='+count+'>'+title+'</p><img src="img/icon/noimage.svg" data-id='+count+'/><br><button class="deleBtn" data-id='+count+'>削除</button>'
    );
    // 配列追加処理
    newObject(bookInfo, count, title, 'img/icon/noimage.svg', url, bookLists);

    count++;
    // 表示領域の確立
    $('.flex').append(viewBook(count));
    // console.log(bookLists);
    $(this).val('');

})

// GoogleBookAPI
$('input[name="google"]').on('blur', function(){
    
    // 登録内容取得
    let isbn = $(this).val();

    // 空の場合は抜ける
    if(isbn == ''){
        return;
    }

    // 検索中の場合
    let status = $(this).attr('class');
    if(status =- 'searching'){
        alert('検索中です。少々お待ちください');
        return;
    }

    // 二度の検索をさせないために
    $(this).addClass('searching');

    // 書籍検索
    googleBookAPI(isbn, count);

})

// 書籍削除処理
$(document).on('click', '.deleBtn', function(){
    let id = $(this).attr('data-id');
    $('div[data-id='+id+']').remove();
    arrayDelete(bookLists, id);
    console.log(bookLists);
})

// 書籍登録上限数判定
if(bookLists.length == 10){
    alert('登録最大数に達しました');
}

// スマホアプリYes
$(document).on('click', '#yes', function(){
    window.location.href = 't_signUp3.php?id='+tuotor_id;
})

// スマホアプリNo
$(document).on('click', '#no', function(){
    window.location.href = 't_mypage.php?id='+tuotor_id;
})

//////////////////////////////////////////////////
// 関数処理
//////////////////////////////////////////////////
// GoogleBooksAPI
function googleBookAPI(isbn, id){

    const isbnNum = 978+isbn;
    const url = "https://www.googleapis.com/books/v1/volumes?q=isbn:" + isbnNum;
    // console.log(url);
    
    $.getJSON(url, function(data) {
      if(!data.totalItems) {
        // 検索結果がなかった場合
        alert('対象書籍が見つかりませんでした');
        $('input[name="google"]').val('');
        // 重複検索条件を外す
        $('input[name="google"]').removeClass('searching');
        return;

      } else {

// 該当書籍が存在した場合、JSONから値を取得して入力項目のデータを取得する

        $('div[data-id='+id+']').append(
            '<p data-id='+id+'>'+data.items[0].volumeInfo.title+'</p><img src=\"'+data.items[0].volumeInfo.imageLinks.smallThumbnail+ '\" data-id='+id+'/><br><button class="deleBtn" data-id='+id+'>削除</button>'
        );
        // 配列追加処理
        newObject(bookInfo, id, data.items[0].volumeInfo.title, data.items[0].volumeInfo.imageLinks.smallThumbnail, url, bookLists);
        count++;
        // 表示領域の確立
        $('.flex').append(viewBook(count));
        $('input[name="google"]').val('');
        // 重複検索条件を外す
        $('input[name="google"]').removeClass('searching');
        // console.log(bookLists);
        };
    })
    
};

// オブジェクト処理
function newObject(object, id, title, imageurl, url, array){
    const newarray = Object.assign({},object);
        newarray.id = id;
        newarray.title = title;
        newarray.imageUrl = imageurl;
        newarray.url = url
        array.push(newarray);
}

// 配列データの削除
function arrayDelete(array, key){
    $.each(array,function(index,value){
        // console.log(value['id']+':'+key);
        if(value['id'] == key){
            array.splice(index, 1);
            return false;
        } 
    })
}


//////////////////////////////////////////////////
// VIEW部分
//////////////////////////////////////////////////

// 書籍表示部分
function viewBook(m){
    let view = `
        <div class="bookarea" data-id="`+m+`"></div>
    `;
    return view;
}

// Yes/Noダイアログ
function viewAlert(){
    let view = `
        <div id="dialog" style="width: 30vw;
                    margin: auto;
                    padding: 30px 20px;
                    text-align: center;
                    border: 1px solid #aaa;
                    box-shadow: 2px 2px 4px #888;">
            <p>スマホアプリは利用していましたか？</p>
            <button id="yes">はい</button>
            <button id="no">いいえ</button>
        </div>
    `;
    return view;
}

//////////////////////////////////////////////////
// ajax処理
//////////////////////////////////////////////////
$('#regBtn').on('click', function(e){
    e.preventDefault();
    // console.log(bookLists);
    $.ajax({
        type:'POST',
        url:'mvc/controller.php',
        data:{
            action:'bookLists',
            bookInfo:bookLists,
            id:tuotor_id
        }
    })
    .done((data)=>{
        if(data == 'nodata'){
            if(!confirm('テキストなしで登録しますがよろしいですか？')){
                // キャンセルの場合
                location.reload();
            }
        }else{
            console.log(data);
            $('.textarea').empty();
            $('.textarea').append(viewAlert());
        }
    })
    .fail((data)=>{
        console.log(data);
        alert('データ登録に失敗しました\n申し訳ありませんが、もう一度登録をお願いします');
    })
})