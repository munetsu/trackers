//////////////////////////////////////////////////
// 変数一覧
//////////////////////////////////////////////////
let count = 1;

let bookInfo = {
    id:'',
    title:'',
    imageUrl:''
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
// 書籍検索処理
$('input').on('blur', function(){
    
    // 登録内容取得
    let value = $(this).val();
    // 文字列分割
    let string = value.split('/');
    console.log(string);

    // ドメイン取得
    let url = string[2];
    // 文字列のデコード
    let title = decodeURI(string[3]);
    // ISBN10コード取得
    let isbn = string[5];

    // amazonリンクか確認
    if(url != 'www.amazon.co.jp'){
        alert('amazonのリンクを記載してください');
        $(this).val('');
        return;
    }

    // // 商品ページか確認
    // if(string.length <= 5){
    //     alert('商品リンクページを記載してください');
    //     $(this).val('');
    //     return;
    // }

    // // 書籍かどうか確認
    // if(isbn.length != 10){
    //     alert('書籍のリンクを記載してください');
    //     $(this).val();
    //     return;
    // }

    // let check = $.isNumeric(isbn);
    // // kindle番か確認
    // if(check == false){
    //     if(!confirm('資格試験に関するテキストですか？')){
    //         // いいえの場合
    //         return;
    //     }
    // }
  
    // 書籍検索
    googleBookAPI(isbn, title, count);
    count++;
    // 表示領域の確立
    $('.flex').append(viewBook(count));
    console.log(bookLists);
})

// 書籍削除処理

//////////////////////////////////////////////////
// 関数処理
//////////////////////////////////////////////////
// GoogleBooksAPI
function googleBookAPI(isbn, string, id, value){

    const isbnNum = isbn;
    const url = "https://www.googleapis.com/books/v1/volumes?q=isbn:" + isbnNum;
    
    $.getJSON(url, function(data) {
      if(!data.totalItems) {
        // $(".bookarea").append('<p class="bg-warning" id="warning">該当する書籍がありません。</p>');
        $('div[data-id='+id+']').append('<p data-id='+id+'>'+string+'</p><img src="img/icon/noimage.svg" data-id='+id+' style="width:150px;height:150px;"><button class="deleBtn" data-id='+id+'>削除</button>');
        
        // 配列追加処理
        let imageurl = 'img/icon/noimage.svg';
        newObject(bookInfo, id, string, imageurl, bookLists);


      } else {

// 該当書籍が存在した場合、JSONから値を取得して入力項目のデータを取得する

        $('div[data-id='+id+']').append(
            '<p data-id='+id+'>'+data.items[0].volumeInfo.title+'</p><img src=\"'+data.items[0].volumeInfo.imageLinks.smallThumbnail+ '\" data-id='+id+'/><button class="deleBtn" data-id='+id+'>削除</button>');
            // 配列追加処理
            newObject(bookInfo, id, data.items[0].volumeInfo.title, data.items[0].volumeInfo.imageLinks.smallThumbnail, bookLists);
        };
    })
};

// オブジェクト処理
function newObject(object, id, title, url, array){
    const newarray = Object.assign({},object);
        newarray.id = id;
        newarray.title = title;
        newarray.imageUrl = url;
        array.push(newarray);
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

