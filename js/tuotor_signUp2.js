////////////////////////////////////////////////////////
//変数一覧
////////////////////////////////////////////////////////

//カウンター(登録本数を制限するため)
let count = 1; 

// book情報形式
let bookInfo = {
    'title':'',
    'imageUrl':''
}

// book情報配列
const bookLists = [];

////////////////////////////////////////////////////////
//動的処理一覧
////////////////////////////////////////////////////////

//radioチェック（テキストに関して）
$('input[name="textbook"]').on('change', function(){
    let check = $(this).val();
    $('.main').empty();
    if(check != 1){
        // console.log(check);
        $('.main').html(renderNotext());
    }else{
        $('.main').html(renderform(count));
    }
})

// 本追加ボタンを押した場合の処理
$(document).on('click', 'input[name="addQuestion"]' ,function(){
    
    let answer = $(this).val();
    console.log(bookLists);
    if(answer == 'yes'){
        $('.isbnform').remove();
        $('.main').prepend(renderDiv(count));
        $('.isbnarea').css('border','red 3px double');
        // 登録冊数を修正
        $('.number').val(count);
    }else{
        $('#bookarea').prepend('<button type="button" class="registerBtn">登録</button>')
    }
})

// GoogleBooksAPI
$(document).on('click', '.search' ,function(){

    $('#warning').remove();
    $('#btn').remove();
    const isbn = $("#isbnNum"+count).val();
    const isbnNum = '9784'+isbn;
    console.log(isbnNum);
    const url = "https://www.googleapis.com/books/v1/volumes?q=isbn:" + isbnNum;

    $.getJSON(url, function(data) {
      if(!data.totalItems) {
        $("#bookarea").append('<p class="bg-warning" id="warning">該当する書籍がありません。</p>');
        $('#bookarea').prepend('<button type="button" class="registerBtn">登録</button>')
        // 送信カウンターを修正
        // if(count == 1){
        //     $('.number').val(count);
        // }else{
        //     $('.number').val((count-1));
        // }

      } else {

// 該当書籍が存在した場合、JSONから値を取得して入力項目のデータを取得する
        $('.isbn').empty();

        // bookInfoオブジェクト生成
        const newbookInfo = Object.assign({},bookInfo);
        newbookInfo.title = data.items[0].volumeInfo.title;
        newbookInfo.imageUrl = data.items[0].volumeInfo.imageLinks.smallThumbnail;
        bookLists.push(newbookInfo);

        $('#bookarea').append(
            '<p>'+bookLists.length+'冊目</p><p>'+data.items[0].volumeInfo.title+'</p><img src=\"'+data.items[0].volumeInfo.imageLinks.smallThumbnail+ '\" />');
        // $('#bookarea').append(
        //     '<input type="hidden" name="bookTitle'+count+'" value="'+data.items[0].volumeInfo.title+'"><input type="hidden" name="bookImage'+count+'" value="'+data.items[0].volumeInfo.imageLinks.smallThumbnail+'">'
        // )
        count = bookLists.length;
        
        // 3冊まで登録させる
        if(count <=3){
            $('.isbnform').append(
                `<div>
                    <span>`+(count+1)+`冊目を登録しますか？</span>
                    <label><input type="radio" name="addQuestion" value="yes">はい</label>
                    <label><input type="radio" name="addQuestion" value="no">いいえ</label>
                </div>
                `
            )
        }else{
            $('#bookarea').prepend('<button type="button" class="registerBtn">登録</button>')
        }
      }

    });
});

// 登録ボタンを押した時
$(document).on('click', '.registerBtn', function(){
    let data = JSON.stringify(bookLists);
    $.ajax({
        url:"mvc/controller.php",
        type:"POST",
        data:{
            action:'bookRegister',
            volume:bookLists.length,
            tuotor_id:info,
            data:bookLists
        }
    })
    .done((data)=>{
        console.log(data)
    })
    .fail((textStatus)=>{
        console.log('失敗'+textStatus)
    })
})

////////////////////////////////////////////////////////
//VIEW一覧
////////////////////////////////////////////////////////

//市販テキストを利用していた場合
function renderform(count){
    let view = '<div>';
            view += '<form action="mvc/controller.php" method="POST" name="bookForm">';
            view += '<input type="hidden" name="action" value="bookRegister">';
            view += '<input type="hidden" name="tuotor_id" value='+info+'>';
            view += '<div class="isbnform">';
            view += 'ISBNコード：978-4-<input type="text" name="isbn'+count+'" id="isbnNum'+count+'" class="isbnarea">';
            view += '<button type="button" class="search">検索</button>';
        if(count == 1){
            view += '<div class="isbn">';
            view += '<span>ISBNコードとは</span><br>';
            view += '<img src="img/isbn.png">';
            view += '</div>';
        }
            view += '</div>';
            view += '<div id="bookarea"></div>';
            view += '</form>';
        view += '</div>';
    return view;
}

//市販テキストを使っていなかった場合
function renderNotext(){
    let view = '<div>';
        view += '<button>次へ</button>';
        view += '</div>';
    
    return view;
}

//2冊目以降のview
function renderDiv(count){
    let view = '<div class="isbnform">'
            view += 'ISBNコード：978-4-<input type="text" name="isbn'+count+'" id="isbnNum'+count+'" class="isbnarea">';
            view += '<button type="button" class="search">検索</button>';
        if(count == 0){
            view += '<div class="isbn">';
            view += '<span>ISBNコードとは</span><br>';
            view += '<img src="img/isbn.png">';
            view += '</div>';
        }
            view += '</div>';

        return view;
}

