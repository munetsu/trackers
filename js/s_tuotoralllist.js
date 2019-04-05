///////////////////////////////////////////////////
// 変数一覧
///////////////////////////////////////////////////
// チューター情報
lists;
console.log(lists);
// 書籍情報
// lists[i][0]
// チューター情報
// lists[i]

// 今年
thisyear;
// 今月
thismonth;
// console.log(thismonth);

// 勉強法
howtolist;
// console.log(howtolist);

///////////////////////////////////////////
// 関数一覧
///////////////////////////////////////////
// 年齢計算
function calculate(year, month){
    let age = 0;
    if((thismonth - month) <0){
        age = (thisyear - year +1);
    }else{
        age = (thisyear - year);
    }
    return age;
}

///////////////////////////////////////////////////
// VIEW
///////////////////////////////////////////////////
function viewMain(array, i){
    let view = `
        <div class="card">
            <table>
                <tr>
                    <td>名前</td>
                    <td>`+array[i]['k_familyname']+` `+array[i]['k_firstname']+`(`+calculate(array[i]['birthyear'], array[i]['birthmonth'])+`)</td>
                </tr>
                <tr>
                    <td>勉強方法</td>
                    <td>`+howtolist[(array[i]['howto']-1)]['howto_kind']+`</td>
                <tr>
            </table>
            <div class="bookarea">
                <p>利用書籍</p>
                <p>`+array[i][0]['title']+`</p>
                `+array[i][0]['imageUrl']+`
            </div>
            <a href="" class="tuotor" data-tuotor=`+array[i]['tuotor_id']+`>詳細を見る</a>
        </div>
    `;
    return view;
}

///////////////////////////////////////////////////
// 読み込み時に描画
///////////////////////////////////////////////////
for(let i =0;i<lists.length;i++){
    $('.main').append(viewMain(lists, i));
}

/////////////////////////////////////////////////////////////
// クリック処理
/////////////////////////////////////////////////////////////
$(document).on('click', '.tuotor', function(e){
    e.preventDefault();
    let tid = $(this).attr('data-tuotor');
    // サイズを指定すると新規ウィンドウで開く
    // window.open('/trackers/s_tuotorDetail.php?tid='+tid, '_blank', 'width=800,height=600');
    window.open("s_tuotorDetail.php?tid="+tid, '_blank');
})