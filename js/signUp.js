// 西暦
for(let i =1970; i<=year; i++){
    let view = '';
    view = '<option value='+i+'>'+i+'</option>'
    $('#year').append(view);
}

// 月
for(let k = 1; k <13; k++){
    let view = '';
    view = '<option value='+k+'>'+k+'</option>'
    $('#month').append(view);
}

// 日
for(let n = 1; n <32; n++){
    let view = '';
    view = '<option value='+n+'>'+n+'</option>'
    $('#day').append(view);
}

// 出身地
let born = ['都道府県','北海道','青森','岩手','宮城','秋田','山形','福島','茨城','栃木','群馬','埼玉','千葉','東京','神奈川','新潟','富山','石川','福井','山梨','長野','岐阜','静岡','愛知','三重','滋賀','京都','大阪','兵庫','奈良','和歌山','鳥取','島根','岡山','広島','山口','徳島','香川','愛媛','高知','福岡','佐賀','長崎','熊本','大分','宮崎','鹿児島','沖縄','America','中国','韓国','Thailand','Europe','Others'];
for(let m = 0; m<born.length; m++){
    let land = born[m];
    let view = '<option value='+born[m]+'>'+land+'</option>';
    $('#born').append(view);
}

// 写真選択
$(function(){
    //画像ファイルプレビュー表示のイベント追加 fileを選択時に発火するイベントを登録
    $('form').on('change', 'input[type="file"]', function(e) {
        var file = e.target.files[0],
            reader = new FileReader(),
            $preview = $(".photo");
            t = this;

        // 画像ファイル以外の場合は何もしない
        if(file.type.indexOf("image") < 0){
        return false;
        }

        // ファイル読み込みが完了した際のイベント登録
        reader.onload = (function(file) {
        return function(e) {
            // .prevewの領域の中にロードした画像を表示するimageタグを追加
            $preview.append($('<img>').attr({
                    src: e.target.result,
                    width: "150px",
                    height: "150px",
                    class: "preview",
                    title: file.name
                }));
        };
        })(file);

        reader.readAsDataURL(file);
    });
});

// 参考書利用の有無
$('.useBooks').on('change', function(){
    let value = $(this).val();
    if(value === 'yes'){
        $('#isbnDivsion').css('display','block');
    } else{
        $('#isbnDivsion').css('display','none');
    }
});

// // ダイアログ表示
$(function(){
    $('#dialog').dialog({
        autoOpen: false,
        modal: true,
        title:'ISBNコード'
    });
    $('#isbnDesc').on('click', function(e){
        e.preventDefault();
        $('#dialog').dialog("open");
    });
});

// GoogleBooksAPI
$("#search").on('click', function(){
    const isbn = $("#isbnNum").val();
    const isbnNum = '9784'+isbn;
    console.log(isbnNum);
    const url = "https://www.googleapis.com/books/v1/volumes?q=isbn:" + isbnNum;

    $.getJSON(url, function(data) {
      if(!data.totalItems) {
        // $("#isbn").val("");
        // $("#BookTitle").text("");
        // // $("#BookAuthor").text("");
        // // $("#isbn10").text("");
        // // $("#isbn13").text("");
        // // $("#PublishedDate").text("");
        // $("#BookThumbnail").text("");
        // $("#BookDescription").text("");
        // $("#BookMemo").val("");

        $("#bookarea").html('<p class="bg-warning" id="warning">該当する書籍がありません。</p>');
        // $('#message > p').fadeOut(3000);

      } else {

// 該当書籍が存在した場合、JSONから値を取得して入力項目のデータを取得する

        // $("#BookTitle").text(data.items[0].volumeInfo.title);
        // $("#isbn13").text(data.items[0].volumeInfo.industryIdentifiers[0].identifier);
        // $("#isbn10").text(data.items[0].volumeInfo.industryIdentifiers[1].identifier);
        // $("#BookAuthor").text(data.items[0].volumeInfo.authors[0]);
        // $("#PublishedDate").text(data.items[0].volumeInfo.publishedDate);
        // $("#BookDescription").text(data.items[0].volumeInfo.description);
        // $("#BookThumbnail").html('<img src=\"' + data.items[0].volumeInfo.imageLinks.smallThumbnail + '\" />');

        $('#bookarea').html('<p>'+data.items[0].volumeInfo.title+'</p><img src=\"'+data.items[0].volumeInfo.imageLinks.smallThumbnail+ '\" />');
      }

    });
  });


