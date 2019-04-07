///////////////////////////////////////////
// 変数・オブジェクト一覧
///////////////////////////////////////////
let app = {
    id:'',
    smartphone:'',
    appName:''
};

const appList = [];

let count = 1;

///////////////////////////////////////////
// 関数一覧
///////////////////////////////////////////
// オブジェクト処理
function newObject(object, id, smartphone, appName, array){
    const newarray = Object.assign({},object);
        newarray.id = id;
        newarray.smartphone = smartphone;
        newarray.appName = appName;
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

///////////////////////////////////////////
// イベント処理
///////////////////////////////////////////
// アプリ登録
$('#btn').on('click', function(){
    // 登録上限か確認
    if(appList.length == 10){
        alert('登録上限数に達しています');
        return;
    }

    let smartphone = $('select[name="smartphone"]').val();
    let appName = $('input[name="app"]').val();
    // 配列登録
    newObject(app, count, smartphone, appName, appList);
    // テーブル追加
    $('tbody').append(viewApp(count, smartphone, appName));
    // カウント追加
    count++;
    console.log(appList);
    $('input[name="app"]').val('');
});

// アプリ削除
$(document).on('click', '#dele', function(){
    let id = $(this).attr('data-id');
    $('tr[data-id="'+id+'"]').remove();
    // 配列削除
    arrayDelete(appList, id);
    console.log(appList);
});


///////////////////////////////////////////
// VIEW
///////////////////////////////////////////
// スマホアプリリスト
function viewApp(count, smartphone, app){
    let view = `
        <tr data-id="`+count+`">
            <td>`+count+`</td>
            <td>`+smartphone+`</td>
            <td>`+app+`</td>
            <td><button id="dele" data-id="`+count+`">削除</button></td>
        </tr>
    `;
    return view;
}

//////////////////////////////////////////////////
// ajax処理
//////////////////////////////////////////////////
$('#regBtn').on('click', function(e){
    e.preventDefault();
    if(appList.length == 0){
        if(!confirm('アプリが一つも登録されていませんが、よろしいですか？')){
            // キャンセルの場合
            return;
        }
    }
    $.ajax({
        type:'POST',
        url:'mvc/controller.php',
        data:{
            action:'appLists',
            appInfo:appList,
            id:tuotor_id
        }
    })
    .done((data)=>{
        console.log(data);
        alert('登録が完了しました');
        window.location.href = 't_mypage.php';
        
    })
    .fail((data)=>{
        console.log(data);
        alert('データ登録に失敗しました\n申し訳ありませんが、もう一度登録をお願いします');
    })
})