/////////////////////////////////////////////////////////////
// 変数一覧
/////////////////////////////////////////////////////////////
// コンサル確定リスト
lists;
console.log(lists);

// 生徒ID
sid;

/////////////////////////////////////////////////////////////
// VIEW
/////////////////////////////////////////////////////////////
// リスト作成
function consullist(array, i){
    let view = `
        <div class="list">
            <table>
                <tr>
                    <td>名前</td>
                    <td>`+array[i][0]['k_familyname']+` `+array[i][0]['k_firstname']+`</td>
                </tr>
                <tr>
                    <td>実施日時</td>
                    <td>`+array[i]['confirmDate']+`／ `+array[i]['confirmTime']+`〜</td>
                </tr>
            </table>
            <div>
            <a href="" class="tuotor" data-tuotor=`+array[i]['tuotor_id']+`>チューター詳細</a>
            </div>
        </div>
    `;
    return view;
}

/////////////////////////////////////////////////////////////
// 読み込み時に描画
/////////////////////////////////////////////////////////////
for(let i=0;i<lists.length;i++){
    $('.main').append(consullist(lists, i));
}

/////////////////////////////////////////////////////////////
// クリック処理
/////////////////////////////////////////////////////////////
$(document).on('click', '.tuotor', function(e){
    e.preventDefault();
    let tid = $(this).attr('data-tuotor');
    // サイズを指定すると新規ウィンドウで開く
    window.open('/trackers/s_tuotorDetail.php?tid='+tid, '_blank', 'width=800,height=600');
})




