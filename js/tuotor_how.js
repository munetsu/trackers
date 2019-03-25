//////////////////////////////////////////////////////////////////////
//変数・配列一覧
//////////////////////////////////////////////////////////////////////
const selectMonth = [];
// 格納情報数
const infoLists = [0];

// 写真orUrl
let dataInfo = {
    id:'',
    type:''
}
const dataLists = [];

// textarea情報配列
let textareaInfo = {
    'id':'',
    'content':''
}
const howtoLists = [];

//////////////////////////////////////////////////////////////////////
//読み込み時に描画
//////////////////////////////////////////////////////////////////////
// 月作成
for(let i = 1;i<13;i++){
    let view = checkedMonth(i)
    $('.monthList').append(view);
}

// 登録済み月処理
function checkedMonth(i){
    for(let k =0;k<monthly.length;k++){
        var month = parseInt(monthly[k]['monthly'], 10);
        if(i == month){
            var view = '<li class="month gray" id="month'+i+'">'+i+'月</li>';
            break;
        }else{
            var view = '<li class="month" id="month'+i+'">'+i+'月</li>';
        }
    }
    return view;
}

// 勉強時間表示
$('.studytime').html(viewStudytime());

// 勉強方法表示
$('.block').html(viewstudyHow(0));

//////////////////////////////////////////////////////////////////////
//クリック・動的イベント
//////////////////////////////////////////////////////////////////////
// 月選択
$(document).on('click', '.month', function(){
    let classed = $(this).attr('class');
    // 月を取得
    let month = $(this).text();
    month = month.replace('月', '');
    
    // 既に選択済みの場合は、選択させない
    if(classed.match(/gray/)){
        alert(month+'月は既に登録済みです。')
    }else{
        $(this).toggleClass('selected');
        // 数値変換
        month = parseInt(month, 10);
        checkArray(month);
        console.log(selectMonth);
    }
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

// 写真選択
$(document).on('change', 'input[name="choice"]', function(){
    let selectList = $(this).val();
    let focus = $(this).parents('div').attr('data-id');
    $('div[data-photo="whatarea'+focus+'"]').remove();
    if(selectList == '1'){
        console.log(focus);
        $('#whatlist'+focus).append(viewbookPicture(focus));
    }else{
        $('#whatlist'+focus).append(viewbookUrl(focus));
    }
})

// 写真選択
//画像ファイルプレビュー表示のイベント追加 fileを選択時に発火するイベントを登録
$(document).on('change', 'input[type="file"]', function(e) {
    let focus = $(this).parents('div').attr('data-id');
    let whatarea = 'whatarea'+focus;
    // console.log(focus);
    var file = e.target.files[0],
        reader = new FileReader(),
        $preview = $('div[data-photo="'+whatarea+'"]');
        t = this;

    // 画像ファイル以外の場合は何もしない
    if(file.type.indexOf("image") < 0){
    return false;
    }

    // ファイル読み込みが完了した際のイベント登録
    image = new Image();
    reader.onload = (function(file) {
    return function(e) {
        image.src = reader.result;
        let w = 0;
        let h = 0;
        let standscore = 200;
        image.onload = function() {
            result = {width: image.naturalWidth, height: image.naturalHeight};
            w = result['width'];
            h = result['height'];
            console.log(w,h);

            // 描画サイズの調整
            let keyscore = 0;
            if(w > h){
                keyscore = w / standscore;

            }else{
                keyscore = h / standscore;
            }

            // .prevewの領域の中にロードした画像を表示するimageタグを追加
            $preview.append($('<img>').attr({
                    src: e.target.result,
                    width: w / keyscore,
                    height: h / keyscore,
                    class: "preview",
                    title: file.name
                }));
        }
    };
    })(file);

    // 既に画像ファイルが描画されていたら削除
    $preview.find('img').remove();
    arrayDelete(dataLists, whatarea);

    reader.readAsDataURL(file);

    // オブジェクト転記
    newObject(dataInfo, focus, 'photo', dataLists)
    console.log(dataLists)

});

// amazonリンクかどうか判定
$(document).on('blur', '.amazonUrl', function(){
    let num = $(this).attr('data-input');
    // 既登録データの消去
    let whatarea = 'whatarea'+num;
    arrayDelete(dataLists, whatarea);

    let judge = $(this).val();
    judge = judge.substr(0,25);
    
    // 判定
    if(judge != 'https://www.amazon.co.jp/'){
        alert('amazonのリンクを記載してください');
        $(this).val('');
    }else{
        newObject(dataInfo,  num, 'url', dataLists);
        console.log(dataLists);
    }
})

// delete処理
$(document).on('click', '.delete', function(){
    let data_focus = $(this).attr('data-focus');
    let data_id = $(this).attr('data-id');
    if(!confirm('削除しますか？')){
        // キャンセル
        return false;
    }else{
        // 削除処理
        $('[data-div='+data_focus+']').remove();
        infoLists.splice(data_id, 1);
        let area = 'whatarea';
        arrayDelete(infoLists, (area+data_id));
        arrayDelete(dataLists, (area+data_id));
        // console.log(infoLists);
        // console.log(photoNum);
        // console.log(urlNum);
    }
})

// plus処理
$(document).on('click', '.plus', function(){
    let number = infoLists.length;
    if(number <4){
        number = number++
        infoLists.push(number);
        $('.block').append(viewstudyHow(number));
    }else{
        alert('4つ以上は登録出来ません。');
    }

})

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

// テキストエリアデータ取得（フォーカスが外れた時）
$(document).on('blur', '.howto', function(){
    let id = $(this).attr('name');
    let content = $('textarea[name="'+id+'"]').val();
    // オブジェクト作成
    const newtextareaInfo = Object.assign({},textareaInfo);
    newtextareaInfo.id = id;
    newtextareaInfo.content = content;
    howtoLists.push(newtextareaInfo);
    console.log(howtoLists);
})

// テキストデータ削除
$(document).on('focus', '.howto', function(){
    let id = $(this).attr('name');
    arrayDelete(howtoLists, id);
    console.log(howtoLists);
})

// 登録処理
$('#register').on('click', function(){
    // for(let i=0;i<dataLists.length;i++){
    //     $('form[name="how"]').append('<input name="datakind[]" value="'+dataLists[i]+'">');
    //     console.log(dataLists[i]['type']);
    // }
    $('form[name="how"]').append('<input name="datakind" value='+dataLists+'>');
    console.log(dataLists);
    // $('form[name="how"]').submit();
})

// オブジェクト処理
function newObject(object, focus, type, array){
    const newarray = Object.assign({},object);
        newarray.id ='whatarea'+focus;
        newarray.type = type
        array.push(newarray);
}


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
        <div class="flex whatarea" data-div="whatarea`+num+`" data-id="`+num+`">
            <div class="what" id="whatlist`+num+`" data-id="`+num+`" data-booksearch="whatarea`+num+`">
                <p>手元にテキストなど利用していたものはありますか？</p>
                <label><input type="radio" name="choice" value="1">はい</label>
                <label><input type="radio" name="choice" value="2">いいえ</label>
            </div>
            <div>
                <p>利用方法</p>
                <textarea class="howto" name="whatarea`+num+`" col="30" placeholder="どのように使っていたか記載してください"></textarea>
            </div>
            <div class="delete" data-focus="whatarea`+num+`" data-id="`+num+`">
                <img src="img/icon/minus.svg" class="plusminus"><br>
                <span>削除</span>
            </div>
        </div>
        `;
    return view;
}

// 書籍写真エリア
function viewbookPicture(num){
    let view = `
    <div class="photo" data-photo="whatarea`+num+`" data-id="`+num+`">    
        <p>テキスト・問題集などの写真</p>
        <input type="file" name="upfile`+num+`" class="file" id="file`+num+`">
    </div>
    `;
    return view;
}

// 書籍URLエリア
function viewbookUrl(num){
    let view = `
    <div class="bookurl" data-photo="whatarea`+num+`">    
        <p>手元にテキスト等がない方は、書籍が分かるリンク(Amazonのみ)を貼ってください。</p>
        <input type="text" name="upfie`+num+`" data-input="`+num+`" class="amazonUrl">
    </div>
    `;
    return view;
}

////////////////////////////////////////////////////
// 通知機能
////////////////////////////////////////////////////
// Push.create("Trackers", {
//     body: "新着メッセージがあります!",
//     // timeout: 4000,
//     onClick: function () {
//         window.focus();
//         this.close();
//     }
// });
