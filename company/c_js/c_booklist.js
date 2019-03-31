///////////////////////////////////////////
// 変数一覧
///////////////////////////////////////////
let bookInfo = {
    no:'',
    isbn:'',
    title:'',
    imageUrl:'',
    link:''
}

const bookInfoLists = [];

let bookhowmany = 0;

///////////////////////////////////////////
// 読み込み時に処理
///////////////////////////////////////////
for(let i=0; i<lists.length;i++){
    $('.main').append(viewlist(lists[i]));    
}

///////////////////////////////////////////
// オブジェクト登録処理
///////////////////////////////////////////
$(document).on('click', '#save', function(){
    let no = $(this).attr('data-num');
    let isbn = $('input[name="isbn'+no+'"]').val();
    let title = $('textarea[name="title'+no+'"]').val();
    let imageUrl = $('textarea[name="image'+no+'"]').val();
    let link = $('textarea[name="link'+no+'"]').val();
    if(no == '' || isbn == '' || title == '' || imageUrl == '' || link == ''){
        alert('記載漏れがあります');
        return;
    }
    const newarray = Object.assign({},bookInfo);
            newarray.no = no;
            newarray.isbn = isbn;
            newarray.title = title;
            newarray.imageUrl = imageUrl;
            newarray.link = link;
            bookInfoLists.push(newarray);
    $(this).prop('disabled', true);
    console.log(bookInfoLists);
})


///////////////////////////////////////////
// VIEW
///////////////////////////////////////////
// 初期VIEW
function viewlist(list){
    let view = `
        <div data-id="`+list['tuotor_id']+`">
            <p>tutor_ID：`+list['tuotor_id']+`</p>
            <a href="" class="edit" data-id="`+list['tuotor_id']+`">編集</a>
        </div>
    `;
    return view;
}

// 本編集用
function viewedit(booklist, i, k){
    let view = `
        <p>`+k+`冊目</p>
        <div class="booklist">    
            <div class="original">
                <p>タイトル：`+booklist[i]['title'+k]+`</p>
                <img src="`+booklist[i]['imageUrl'+k]+`">
            </div>
            <div class="editarea">
                <p>ISBN10 :<input type="text" name="isbn`+k+`" data-num="`+k+`"></p>
                <p>title :<textarea name="title`+k+`" col="30" data-num="`+k+`"></textarea></p>
                <p>image :<textarea name="image`+k+`" col="30" data-num="`+k+`"></textarea></p>
                <p>link :<textarea name="link`+k+`" col="30" data-num="`+k+`"></textarea></p>
                <button id="save" data-num="`+k+`">保存</button>
            </div>
        </div>
    `;
    return view;
}



///////////////////////////////////////////
// クリック処理
///////////////////////////////////////////
// ajax処理（booklist取得）
$(document).on('click', '.edit', function(e){
    e.preventDefault();
    let id = $(this).attr('data-id');
    $.ajax({
        url:'c_controller.php',
        type:'POST',
        data:{
            action:'bookedit',
            id:id
        }
    })
    .done((data)=>{
        let booklists = $.parseJSON(data);
        $('.main').empty();
        for(let i=0;i<booklists.length;i++){
            for(let k=1;k<=10;k++){
                if(booklists[i]['title'+k] == null){
                    bookhowmany = (k-1);
                    console.log(bookhowmany);
                    break;
                }
                $('.main').append(viewedit(booklists, i, k));
            }
        }                
        $('.main').append('<a href="" data-id="'+id+'" class="bookBtn">登録</a>');
    })
    .fail((data)=>{
        console.log(data);
    })
})

// book登録処理
$(document).on('click', '.bookBtn', function(e){
    e.preventDefault();
    let id = $(this).attr('data-id');
    if(bookhowmany != bookInfoLists.length){
        alert('登録漏れがあります');
        return;
    }
    $.ajax({
        url:'c_controller.php',
        type:'POST',
        data:{
            action:'booklist',
            tuotor_id:id,
            bookInfoLists:bookInfoLists
        }
    })
    .done((data)=>{
        alert('登録処理が無事、完了しました');
        location.reload();
    })
    .fail((data)=>{
        console.log(data);
    })
})