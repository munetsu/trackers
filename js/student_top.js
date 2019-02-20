// console.log(images, offerDetail)

function render(){
    let view = '';
    for(let i=0; i<offerDetail.length; i++){
        view += '<div>';
        view += '<p><img src="'+images[i]+'" style="width:150px;height:150px;"></p>';
        view += '<p>第一希望日</p>';
        view += '<p>開始時間：'+offerDetail[i][0]['date1_start']+'</p>'
        view += '<p>終了時間：'+offerDetail[i][0]['date1_finish']+'</p>'
        view += '<p>第二希望日</p>';
        view += '<p>開始時間：'+offerDetail[i][0]['date2_start']+'</p>'
        view += '<p>終了時間：'+offerDetail[i][0]['date2_finish']+'</p>'
        view += '<p>第三希望日</p>';
        view += '<p>開始時間：'+offerDetail[i][0]['date3_start']+'</p>'
        view += '<p>終了時間：'+offerDetail[i][0]['date3_finish']+'</p>'
        view += '</div>';
    }

    $('#body').html(view)
}

render()

