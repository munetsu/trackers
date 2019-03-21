//////////////////////////////////////////////////////////////////////
//変数・配列一覧
//////////////////////////////////////////////////////////////////////
const selectMonth = [];
let weektime = 3;
let week = 5;
let holidaytime = 5;
let holiday = 2;
let num = 1;

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
        $('#whatlist'+focus).append(viewbookSearch());
    }
})

// ISBN文字数カウント
$(document).on('keyup', '.isbnNumber', function(){
    let length = $(this).val().length;
    length = 10 - length;
    $('.isbnString').remove();
    $(this).parent().append(stringNum(length));

    if(length == 0){
        $(this).parent().next('.isbnBtn').prop('disabled', false);
    }else{
        $(this).parent().next('.isbnBtn').prop('disabled', true);
    }
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
        <div class="flex">
            <div class="what" id="whatlist`+num+`" data-id="`+num+`">
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
            <div><img src="img/icon/minus.svg" class="plusminus"></div>
        </div>
        `;
    return view;
}

// 書籍検索
function viewbookSearch(){
    let view = `
        <div class="isbn">
            <p>ISBNコードを入力してください。<img src="img/isbn.png" class="img"></p>
            <p>ISBNコード:978-<input type="number" name="isbn" max-length="10" class="isbnNumber"></p>
            <button class="isbnBtn" disabled>検索</button>
        </div>
        `;
    return view;
}

// 文字数表示
function stringNum(m){
    let view =`
        <p class="isbnString">あと<span class="number">`+m+`文字</p>
    `;
    return view;
}

