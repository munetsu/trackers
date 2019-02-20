// console.log(images, offerDetail)

// 画面高さを取得
$(window).on('load',function() {
    //画面高さ取得
    let h = $(window).height();
    $('#body').css('min-height', h + 'px');
});
$(window).on('resize', function() {
    //画面リサイズ時の高さ取得
    let h = $(window).height();
    console.log(h);
    $('#body').css('min-height', h + 'px');
});

function slice(data){
    if(data == null){
        data = '未選択'
    } else {
        // console.log($.type(data));
        data = data.substr(-8, 5);
        // data = data.slice(0, -3);
    }
    return data;
}

function substr(data){
    if(data == null){
        data = '未選択';
    } else {
        data = data.substr(0,10);
    }
    return data;
}

// 面談依頼リスト
function mainOfferRender(){
    let view = '';
    for(let i=0; i<offerDetail.length; i++){
        view += '<div class="block">';
            view += '<div>';
            view += '<p><img src="'+images[i]+'" style="width:150px;height:150px;"></p>';
            view += '</div>';
            view += '<div>';
            view += '<p>第一希望日：'+substr(offerDetail[i][0]['date1_start'])+'</p>';
            view += '<p>'+slice(offerDetail[i][0]['date1_start'])+' 〜 '+slice(offerDetail[i][0]['date1_finish'])+'</p>'
            view += '</div>';
            let judge = substr(offerDetail[i][0]['date2_start']);
            console.log(judge);
            if(judge === '未選択'){
                view += '</div>'
                continue;
            } else {
                view += '<div>';
                view += '<p>第二希望日：'+substr(offerDetail[i][0]['date2_start'])+'</p>';
                view += '<p>'+slice(offerDetail[i][0]['date2_start'])+' 〜 '+slice(offerDetail[i][0]['date2_finish'])+'</p>';
                view += '</div>';

                let judge2 = substr(offerDetail[i][0]['date3_start']);
                if(judge2 === '未選択'){
                    view += '</div>'
                    continue;
                } else {
                    view += '<div>';
                    view += '<p>第三希望日：'+substr(offerDetail[i][0]['date3_start'])+'</p>';
                    view += '<p>'+slice(offerDetail[i][0]['date3_start'])+' 〜 '+slice(offerDetail[i][0]['date3_finish'])+'</p>'    
                    view += '</div>';
                }
            }
        view += '</div>'
    }

    $('#main').html(view)
}

function footerRender(){
    let view = '<div class="footerList">';
        view += '<p>担当チューター</p>';
        view += '</div>';
        view += '<div class="footerList">';
        view += '<p>面談リスト</p>';
        view += '</div>';
        view += '<div class="footerList">';
        view += '<p>お気に入りリスト</p>';
        view += '</div>';
    let data = $('#footer').html(view);
    return data;
}

function addClass(data, n){
    data.ready(function(){
        console.log('check',n)
        $('.footerList').eq(n).addClass('footerFirst');
    })
}

addClass(footerRender(), 0);



