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
        born:''
    };
    const tuotor = [];

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
        tuotor.push(newToutors);    
    }

    return tuotor;
}

// 描画内容
function view(id,url, age, born){
    let view = '<div class="oneBlock">';
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
    // console.log(tuotor);
    for(let i =0; i<tuotor.length; i++){
        let id = tuotor[i]['id'];
        let url = tuotor[i]['img'];
        let age = tuotor[i]['age'];
        let born = tuotor[i]['born'];
        let viewer = '';
        if(i % 2 == 0){
            viewer = '<div class="flex block'+i+'">';    
            viewer += view(id,url, age, born);
            $('#app').append(viewer);
        }else {
            let num = i -1;
            viewer = view(id,url, age, born);
            viewer += '</div>';
            $('.block'+num).append(viewer);
        }
    }
}

let tuotor = tuotorslist();
render(tuotor);

$(document).on('click','.oneBlock',function(){
    let target = $(this).find('img').attr('id');
    let age = $(this).find('p').attr('id');
    // console.log(age);
    // console.log('クリックされてる',target);
    $.ajax({
        url: 'php/ajax.php',
        type: 'POST',
        data: {
            action: 'tuotorList',
            id : target,
            age: age
        }
    })
    .done((data)=>{
        console.log(data);
        // let data = json_encode(data);
        $('#app').html(data);
    })
})



