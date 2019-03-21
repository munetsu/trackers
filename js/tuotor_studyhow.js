//////////////////////////////////////////////////////////////////////
//変数・配列一覧
//////////////////////////////////////////////////////////////////////
const selectMonth = [];
let weektime = 3;
let week = 5;
let holidaytime = 5;
let holiday = 2;
let num = 1;

// book情報形式
let bookInfo = {
    'title':'',
    'imageUrl':''
}

// book情報配列
const bookLists = [];

//////////////////////////////////////////////////////////////////////
//読み込み時に描画
//////////////////////////////////////////////////////////////////////
// 月作成
for(let i = 1;i<13;i++){
    let view = '<li class="month" id="month'+i+'">'+i+'月</li>';
    $('.monthList').append(view);
}

// 勉強時間表示
$('.studytime').html(viewStudytime());

// 勉強方法表示
$('.block').html(viewstudyHow(num));

//////////////////////////////////////////////////////////////////////
//クリック・動的イベント
//////////////////////////////////////////////////////////////////////
// 月選択
$(document).on('click', '.month', function(){
    $(this).toggleClass('selected');
    // 月を取得
    let month = $(this).text();
    month = month.replace('月', '');
    // 数値変換
    month = parseInt(month, 10);
    checkArray(month);
    console.log(selectMonth);
})

// 配列操作(selectMonth)
function checkArray(m){
    if(selectMonth.length == 0){
        selectMonth.push(m);
    }else{
        let check = 0;
        for(let i=0;i<selectMonth.length;i++){
            // 配列内に既にあるか確認
            if(selectMonth[i] == m){
                console.log(selectMonth[i],m);
                selectMonth.splice(i,1);
                check =1;
                break;
            }
        }
        if(check != 1){
            selectMonth.push(m);
        }
    }
}

// 勉強ツール選択
$(document).on('change', '.whatlist', function(){
    let selectList = $(this).val();
    selectList = selectList.slice(0,1);
    let focus = $(this).parent('div').attr('data-id');
    if(selectList == 'q' || selectList == 't'){
        $(this).next('div').remove();
        $('#whatlist'+focus).append(viewbookSearch(focus));
    }else{
        $('[data-isbn=whatarea'+focus+']').remove();
    }
})

// ISBN文字数カウント
$(document).on('keyup', '.isbnNumber', function(){
    let dataNum = $(this).attr('data-input');
    let length = $(this).val().length;
    length = 10 - length;
    $('[data-strings='+dataNum+']').remove();
    $(this).parent().append(stringNum(length, dataNum));

    if(length == 0){
        $('[data-btn='+dataNum+']').prop('disabled', false);
    }else{
        $('[data-btn='+dataNum+']').prop('disabled', true);
    }
})

// GoogleBooksAPI
function googleBookAPI(isbn, bookarea){

    $('[data-isbn='+bookarea+']').remove();
    $('.bg-warning').remove();
    
    const isbnNum = '978'+isbn;
    console.log(isbnNum);
    const url = "https://www.googleapis.com/books/v1/volumes?q=isbn:" + isbnNum;

    $.getJSON(url, function(data) {
      if(!data.totalItems) {
        // $(".bookarea").append('<p class="bg-warning" id="warning">該当する書籍がありません。</p>');
        $('[data-book='+bookarea+']').append('<p class="bg-warning" id="warning">該当する書籍がありません。</p><button class="reSreach">再検索</button>');

      } else {

// 該当書籍が存在した場合、JSONから値を取得して入力項目のデータを取得する

        // bookInfoオブジェクト生成
        const newbookInfo = Object.assign({},bookInfo);
        newbookInfo.title = data.items[0].volumeInfo.title;
        newbookInfo.imageUrl = data.items[0].volumeInfo.imageLinks.smallThumbnail;
        bookLists.push(newbookInfo);

        $('[data-book='+bookarea+']').append(
            '<p>'+data.items[0].volumeInfo.title+'</p><img src=\"'+data.items[0].volumeInfo.imageLinks.smallThumbnail+ '\" /><button class="reSreach">再検索</button>');
        };
    })
};

// 書籍検索クリック
$(document).on('click', '.isbnBtn', function(){
    let data_num = $(this).attr('data-btn');
    let isbn = $('[data-input='+data_num+']').val();
    console.log(data_num);
    // let isbn = $(this).parents().find('.isbnNumber').val();
    // let bookarea = $(this).parents('div').find('.what').attr('data-focus');
    // console.log(bookarea);
    $(this).parents('.what').append(viewbook(data_num));
    googleBookAPI(isbn, data_num);
})

// 再検索クリック
$(document).on('click', '.reSreach', function(){
    let data_focus = $(this).parents('div').attr('data-book');
    $('[data-book='+data_focus+']').remove();
    $('[data-booksearch='+data_focus+']').append(viewbookSearch(focus));
})

// delete処理
$(document).on('click', '.delete', function(){
    let data_focus = $(this).attr('data-focus');
    if(!confirm('削除しますか？')){
        // キャンセル
        return false;
    }else{
        // 削除処理
        $('[data-div='+data_focus+']').remove();
    }
})

// plus処理
$(document).on('click', '.plus', function(){
    num += 1;
    $('.block').append(viewstudyHow(num));
})

//////////////////////////////////////////////////////////////////////
//VIEW
//////////////////////////////////////////////////////////////////////
// 勉強時間(class="studytime")
function viewStudytime(){
    let view = `
    <div>
        <p>勉強時間を記載してください</p>
        <p>内訳</p>
        <ul>
            <li>平日：<input type="number" name="weektime">時間<img src="img/icon/batsu.svg" style="width:1vw;height:1vw;"><input type="number" name="weekday">日</li>
            <li>休日：<input type="number" name="holidaytime">時間<img src="img/icon/batsu.svg" style="width:1vw;height:1vw;"><input type="number" name="holiday">日</li>
        </ul>
    </div>
    `;
    return view;
}

// 勉強方法
function viewstudyHow(num){
    let view = `
        <div class="flex whatarea" data-div="whatarea`+num+`">
            <div class="what" id="whatlist`+num+`" data-id="`+num+`" data-booksearch="whatarea`+num+`">
                <select class="whatlist">
                    <option selected disabled hidden>選択▼</option>
                    <option></option>
                    <option value="text`+num+`">テキスト</option>
                    <option value="question`+num+`">過去問・問題集</option>
                    <option value="word`+num+`">単語帳</option>
                    <option value="other`+num+`">その他</option>
                </select>
            </div>
            <div>
                <p>利用方法</p>
                <textarea class="howto" name="howto`+num+`" col="30" placeholder="どのように使っていたか記載してください"></textarea>
            </div>
            <div class="delete" data-focus="whatarea`+num+`">
                <img src="img/icon/minus.svg" class="plusminus"><br>
                <span>削除</span>
            </div>
        </div>
        `;
    return view;
}

// 書籍検索
function viewbookSearch(focus){
    let view = `
        <div class="isbn" data-isbn="whatarea`+focus+`" data-id="`+focus+`">
            <p>ISBNコードを入力してください。<img src="img/isbn.png" class="img"></p>
            <p>ISBNコード:978-<input type="number" name="isbn" max-length="10" class="isbnNumber" data-input="whatarea`+focus+`"></p>
            <button class="isbnBtn" data-btn="whatarea`+focus+`" disabled>検索</button>
        </div>
        `;
    return view;
}

// 文字数表示
function stringNum(m,dataNum){
    let view =`
        <p class="isbnString" data-strings="`+dataNum+`">あと<span class="number">`+m+`文字</p>
    `;
    return view;
}

// 書籍検索表示
function viewbook(bookarea){
    let view =`
        <div class="bookarea" data-book="`+bookarea+`"></div>
    `;
    return view;
}

