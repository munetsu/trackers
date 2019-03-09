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

function sliced(data){
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
            view += '<div class="tuotorImage">';
            view += '<p><img src="'+images[i]+'" style="width:25vh;height:25vh;"></p>';
            view += '</div>';
            view += '<div class="offerDate">';
                view += '<div class="Date">';
                view += '<p>第１希望日：</p><p>'+substr(offerDetail[i][0]['date1_start'])+'</p>';
                view += '<p>'+sliced(offerDetail[i][0]['date1_start'])+' 〜 '+sliced(offerDetail[i][0]['date1_finish'])+'</p>'
                view += '</div>';
                let judge = substr(offerDetail[i][0]['date2_start']);
                console.log(judge);
                if(judge === '未選択'){
                    view += '</div>';
                    view += '</div>'
                    continue;
                } else {
                    view += '<div class="Date">';
                    view += '<p>第２希望日：</p><p>'+substr(offerDetail[i][0]['date2_start'])+'</p>';
                    view += '<p>'+sliced(offerDetail[i][0]['date2_start'])+' 〜 '+sliced(offerDetail[i][0]['date2_finish'])+'</p>';
                    view += '</div>';
                    let judge2 = substr(offerDetail[i][0]['date3_start']);
                    if(judge2 === '未選択'){
                        view += '</div>';
                        view += '</div>'
                        continue;
                    } else {
                        view += '<div class="Date">';
                        view += '<p>第３希望日：</p><p>'+substr(offerDetail[i][0]['date3_start'])+'</p>';
                        view += '<p>'+sliced(offerDetail[i][0]['date3_start'])+' 〜 '+sliced(offerDetail[i][0]['date3_finish'])+'</p>'    
                        view += '</div>';
                        view += '</div>';
                    }
                }
        view += '</div>'
    }

    $('#main').html(view)
}



function footerRender(){
    let view ='<div class="footerList">';
        view += '<img src="img/search.svg" class="footerImage">';
        view += '<p>資格検索</p>';
        view += '</div>';
        view += '<div class="footerList">';
        view += '<img src="img/human.svg" class="footerImage">';
        view += '<p>担当</p>';
        view += '</div>';
        view += '<div class="footerList">';
        view += '<img src="img/calendar.svg" class="footerImage">';
        view += '<p>面談依頼中</p>';
        view += '</div>';
        view += '<div class="footerList">';
        view += '<img src="img/list.svg" class="footerImage">';
        view += '<p>候補リスト</p>';
        view += '</div>';
    let data = $('#footer').html(view);
    return data;
}

function addClass(data, n){
    data.ready(function(){
        console.log('check',n)
        $('.footerList').eq(n).addClass('footerFirst');
        let src = $('.footerImage').eq(n).addClass('footerImageWhite');
        imageChange(src);
    })
}

function strIns(str, idx, val){
    var res = str.slice(0, idx) + val + str.slice(idx);
    return res;
};

function imageChange(src){
    src.ready(function(){
        let src = $('.footerImageWhite').attr('src');
        src = strIns(src, -4, '_white');
        src =$('.footerImageWhite').attr('src', src);
        console.log(src);
        return src;
    })
}


// ////////////////////////////////////////////
// 関数実行部分
// ////////////////////////////////////////////

if(renderNumber == 0){

} else if(renderNumber == 1){
    
} else if(renderNumber == 2){
    mainOfferRender()
} else {

}

addClass(footerRender(), renderNumber);



