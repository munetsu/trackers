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
        $('.ui-dialog').css('background-color','gray');
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
        $('#bookarea').append(
            '<input type="hidden" name="bookTitle" value=""><input type="hidden" name="bookImage" value="">'
        )
        $('#isbnNum').val('');
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

        $('#bookarea').html(
            '<p>'+data.items[0].volumeInfo.title+'</p><img src=\"'+data.items[0].volumeInfo.imageLinks.smallThumbnail+ '\" />');
        $('#bookarea').append(
            '<input type="hidden" name="bookTitle" value="'+data.items[0].volumeInfo.title+'"><input type="hidden" name="bookImage" value="'+data.items[0].volumeInfo.imageLinks.smallThumbnail+'">'
        )
      }

    });
  });
