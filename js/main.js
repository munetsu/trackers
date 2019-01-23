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
        newToutors.img = lists[i]['img'];
        newToutors.age = ages;
        newToutors.born = lists[i]['born'];
        console.log(newToutors);
        tuotor.push(newToutors);    
    }

    return tuotor;
}

// 描画処理
function view(url, age, born){
    let view = '<div class="oneBlock">';
        view += '<div><img src="'+url+'" style="width:150px;height:150px;"></div>';
        view += '<div>';
            view += '<div><p>年齢：'+age+'歳</p>';
            view += '<div><p>出身地：'+born+'</p>';
        view += '</div>';
    view += '</div>';
   return view;
}


function render(tuotor){
    $.each(tuotor, function(index, value){
        // 2つで折り返す
        let num = index;
        if(num % 2 === 0){
            let url = value['img'];
            let age = value['age'];
            let born = value['born'];
            let viewer = '<div class="block">';    
            viewer += view(url, age, born);
            $('#app').append(viewer);
            console.log(num);
        }else{
            let url = value['img'];
            let age = value['age'];
            let born = value['born'];  
            let viewer2 = view(url, age, born);
            viewer2 += '</div>';
            $('.block').append(viewer2);
            console.log(num)
        }
    })
}

let tuotor = tuotorslist();
render(tuotor);






