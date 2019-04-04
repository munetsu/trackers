//////////////////////////////////////////////
// 変数一覧
//////////////////////////////////////////////
// 日程調整リスト
resevationlists;
// console.log(resevationlists[0]['offerDate1']);

// 日付
thisyear;
thismonth;
// console.log(year);

//////////////////////////////////////////////
// 関数一覧
//////////////////////////////////////////////
// 先頭文字取得
function split(string){
    console.log(string);
    let firstString = string.slice(0,1);
    return firstString;
}

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

//////////////////////////////////////////////
// VIEW
//////////////////////////////////////////////
// リスト描画
function viewLists(array, i){
    let view = `
        <div class="block">
            <div class="offer">
                <p>`+split(array[i][0]['a_familyname'])+split(array[i][0]['a_firstname'])+`さん(`+calculate(array[i][0]['birthyear'], array[i][0]['birthmonth'])+`)</p>
                <table>
                    <tr>
                        <th>日程選択</th>
                        <th>希望順</th>
                        <th>希望日時</th>
                        <th>希望時間</th>
                    </tr>
                    <tr>
                        <td><input type="checkbox" name="select" value=`+array[i]['offerDate1']+`></td>
                        <td>第一希望</td>
                        <td>`+array[i]['offerDate1']+`</td>
                        <td>`+array[i]['offerStarttime1']+`〜`+array[i]['offerFinishtime1']+`</td>
                    <tr>
                    <tr>
                        <td><input type="checkbox" name="select" value=`+array[i]['offerDate2']+`></td>
                        <td>第二希望</td>
                        <td>`+array[i]['offerDate2']+`</td>
                        <td>`+array[i]['offerStarttime2']+`〜`+array[i]['offerFinishtime2']+`</td>
                    <tr>
                    <tr>
                        <td><input type="checkbox" name="select" value=`+array[i]['offerDate3']+`></td>
                        <td>第三希望</td>
                        <td>`+array[i]['offerDate3']+`</td>
                        <td>`+array[i]['offerStarttime3']+`〜`+array[i]['offerFinishtime3']+`</td>
                    <tr>
                </table>
            </div>
            <div class="answer">
                <a href="" >再調整</a>
            </div>
        </div>
    `;
    return view;
}

//////////////////////////////////////////////
// 読み込み時に描画
//////////////////////////////////////////////
for(let i = 0;i<resevationlists.length;i++){
    $('.main').append(viewLists(resevationlists, i));
}