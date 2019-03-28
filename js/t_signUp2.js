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
        '<p data-id='+count+'>'+title+'</p><img src="img/icon/noimage.svg" data-id='+count+'/><button class="deleBtn" data-id='+count+'>削除</button>'
    );
    // 配列追加処理
    newObject(bookInfo, count, title, 'img/icon/noimage.svg', bookLists);

    count++;
    // 表示領域の確立
    $('.flex').append(viewBook(count));
    console.log(bookLists);

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
})

// Google
$('input[name="google"]').on('blur', function(){
    
    // 登録内容取得
    let isbn = $(this).val();

    // 空の場合は抜ける
    if(isbn == ''){
        return;
    }

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
if(count == 11){
    alert('登録最大数に達しました');
}

//////////////////////////////////////////////////
// 関数処理
//////////////////////////////////////////////////
// GoogleBooksAPI
function googleBookAPI(isbn, id){

    const isbnNum = 978+isbn;
    const url = "https://www.googleapis.com/books/v1/volumes?q=isbn:" + isbnNum;
    console.log(url);
    
    $.getJSON(url, function(data) {
      if(!data.totalItems) {
        // 検索結果がなかった場合
        alert('対象書籍が見つかりませんでした');
        return;

      } else {

// 該当書籍が存在した場合、JSONから値を取得して入力項目のデータを取得する

        $('div[data-id='+id+']').append(
            '<p data-id='+id+'>'+data.items[0].volumeInfo.title+'</p><img src=\"'+data.items[0].volumeInfo.imageLinks.smallThumbnail+ '\" data-id='+id+'/><button class="deleBtn" data-id='+id+'>削除</button>'
        );
        // 配列追加処理
        newObject(bookInfo, id, data.items[0].volumeInfo.title, data.items[0].volumeInfo.imageLinks.smallThumbnail, bookLists);
        count++;
        // 表示領域の確立
        $('.flex').append(viewBook(count));
        console.log(bookLists);
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

//////////////////////////////////////////////////
// ajax処理
//////////////////////////////////////////////////
$('#regBtn').on('click', function(e){
    e.preventDefault();
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
        console.log(data)
    })
    .fail((data)=>{
        console.log(data)
    })
})