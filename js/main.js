// 降順ソート
function rsort(){
    lists.sort(function(a,b){
        if(a.index<b.index) return 1;
        if(a.index>b.index) return -1;
        return 0;
    });
    return lists;
}

// チューター情報
// 年齢算定
function ageCulculate(m, y){
    if((month - m) <0){
        let age = year - y;
        age = age -1;
        return age;
    }else{
        let age = year - y;
        return age;
    }
}

function tuotorslist(){
    // 必要データの抜き出し
    let toutors = {
        id:0,
        img:'',
        age:0,
        born:'',
        index: 0
    };
    const tuotor = [];

    // 降順に変更
    rsort();
    console.log(lists);

    // チューターデータ整理
    for(let i=0; i<lists.length; i++){
        // 年齢計算
        let birthYear = lists[i]['year'];
        let birthMonth = lists[i]['month'];
        let ages = ageCulculate(birthMonth, birthYear);
        // オブジェクトコピー
        const newToutors = Object.assign({},toutors);
        newToutors.id = lists[i]['id'];
        newToutors.img = lists[i]['img'];
        newToutors.age = ages;
        newToutors.born = lists[i]['born'];
        newToutors.index = lists[i]['index'];
        tuotor.push(newToutors);    
    }

    return tuotor;
}

// 描画内容
function view(index, id,url, age, born){
    let view = '<div class="oneBlock" id="'+index+'">';
        view += '<div><img src="'+url+'" id="'+id+'" style="width:150px;height:150px;"></div>';
        view += '<div>';
            view += '<p id="'+age+'">年齢：'+age+'歳</p>';
            view += '<p>出身地：'+born+'</p>';
        view += '</div>';
    view += '</div>';
   return view;
}

// 描画処理
function render(tuotor){
    let number = tuotor.length;
    // console.log(tuotor.length);
    // チューターが1名もいない場合
    if(number == 0){
        let view = '<div><p>現在、準備中です。申し訳ありません。</p></div>';
        $('#app').append(view);
    }else{
        // 1名以上いる場合
        for(let i =0; i<tuotor.length; i++){
            let index = tuotor[i]['index'];
            let id = tuotor[i]['id'];
            let url = tuotor[i]['img'];
            let age = tuotor[i]['age'];
            let born = tuotor[i]['born'];
            let viewer = '';
            if(i % 2 == 0){
                viewer = '<div class="flex block'+i+'">';    
                viewer += view(index,id,url, age, born);
                $('#app').append(viewer);
            }else {
                let num = i -1;
                viewer = view(index,id,url, age, born);
                viewer += '</div>';
                $('.block'+num).append(viewer);
            }
        }
    }
}

// HTMLへ記載
let tuotor = tuotorslist();
render(tuotor);

// チューター詳細情報取得
$(document).on('click','.oneBlock',function(){
    $('#dialog').remove();
    $('.ui-dialog').remove();
    let target = $(this).find('img').attr('id');
    let age = $(this).find('p').attr('id');
    let index = $(this).attr('id');
    // console.log(age);
    // console.log('クリックされてる',target);
    $.ajax({
        url: 'php/ajax.php',
        async:true,
        type: 'POST',
        data: {
            action: 'tuotorList',
            id : target,
            age: age,
            index: index
        },
    })
    .done((data)=>{
        $('body').append(data);
        dialog();
        $('.clProg').attr('disabled','disabled');
    })
    .fail((data)=>{
        console.log('NG');
    })
})

// ダイアログ表示
function dialog(){
    $('#dialog').dialog({
        modal:'true',
        title:'チューター詳細',
        buttons:{
            "面談希望":function(){
                console.log('テスト');
                window.location.href="contract.php";
            },
            "リスト登録":function(){
                $(this).dialog("close");
            }
        }
    })
};



