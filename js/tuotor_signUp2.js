//////////////////////////////////
//radioチェック（テキストに関して）
//////////////////////////////////
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

//////////////////////////////////
//市販テキストを使っていなかった場合
//////////////////////////////////
function renderNotext(){
    let view = '<div>';
        view += '<button>次へ</button>';
        view += '</div>';
    
    return view;
}

////////////////////////////////////////
//カウンター(登録本数を制限するため)
////////////////////////////////////////
let count = 1;

//////////////////////////////////
//市販テキストを利用していた場合
//////////////////////////////////
function renderform(count){
    let view = '<div>';
            view += '<form action="controller.php" method="POST">';
            view += '<input type="hidden" name="action" value="bookRegister">'
            view += '<input type="hidden" name="tuotorId" value='+info+'>';
            view += '<div class="isbnform">'
            view += 'ISBNコード：978-4-<input type="text" name="isbn'+count+'" id="isbnNum'+count+'" class="isbnarea">';
            view += '<button type="button" class="search">検索</button>';
        if(count == 1){
            view += '<div class="isbn">'
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

/////////////////////////////////////////////
//2冊目以降のview
/////////////////////////////////////////////
function renderDiv(count){
    let view = '<div class="isbnform">'
            view += 'ISBNコード：978-4-<input type="text" name="isbn'+count+'" id="isbnNum'+count+'" class="isbnarea">';
            view += '<button type="button" class="search">検索</button>';
        if(count == 1){
            view += '<div class="isbn">';
            view += '<span>ISBNコードとは</span><br>';
            view += '<img src="img/isbn.png">';
            view += '</div>';
        }
            view += '</div>';

        return view;
}



/////////////////////////////////////
//Google Book API
///////////////////////////////////////

// GoogleBooksAPI
$(document).on('click', '.search' ,function(){

    const isbn = $("#isbnNum"+count).val();
    const isbnNum = '9784'+isbn;
    console.log(isbnNum);
    const url = "https://www.googleapis.com/books/v1/volumes?q=isbn:" + isbnNum;

    $.getJSON(url, function(data) {
      if(!data.totalItems) {
        $("#bookarea").append('<p class="bg-warning" id="warning">該当する書籍がありません。</p>');
      } else {

// 該当書籍が存在した場合、JSONから値を取得して入力項目のデータを取得する
        $('.isbn').empty();
        $('#bookarea').append(
            '<p>'+count+'冊目</p><p>'+data.items[0].volumeInfo.title+'</p><img src=\"'+data.items[0].volumeInfo.imageLinks.smallThumbnail+ '\" />');
        $('#bookarea').append(
            '<input type="hidden" name="bookTitle'+count+'" value="'+data.items[0].volumeInfo.title+'"><input type="hidden" name="bookImage'+count+'" value="'+data.items[0].volumeInfo.imageLinks.smallThumbnail+'">'
        )
        count += 1;
        
        // 3冊まで登録させる
        if(count <=3){
            $('.isbnform').append(
                `<div>
                    <span>`+count+`冊目を登録しますか？</span>
                    <label><input type="radio" name="addQuestion" value="yes">はい</label>
                    <label><input type="radio" name="addQuestion" value="no">いいえ</label>
                </div>
                `
            )
        }else{
            $('#bookarea').prepend(
                '<button>登録</button>'
            )
        }
      }

    });
});

/////////////////////////////////////////////////////
// 本追加ボタンを押した場合の処理
/////////////////////////////////////////////////////
$(document).on('click', 'input[name="addQuestion"]' ,function(){
    
    let answer = $(this).val();
    console.log(answer);
    if(answer == 'yes'){
        $('.isbnform').remove();
        $('.main').prepend(renderDiv(count));
        $('.isbnarea').css('border','red 3px double');
    }else{
        $('#bookarea').prepend(
            `
                <button>登録</button>
            `
        )
    }
})




