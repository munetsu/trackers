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
    let view = '<div class="oneBlock" id="'+id+'">';
        view += '<div><img src="'+url+'" style="width:150px;height:150px;"></div>';
        view += '<div>';
            view += '<p>年齢：'+age+'歳</p>';
            view += '<p>出身地：'+born+'</p>';
        view += '</div>';
        view += '<button class="btn">詳細を見る</button>';
    view += '</div>';
   return view;
}

// 描画処理
function render(tuotor){
    // console.log(tuotor);
    for(let i =0; i<tuotor.length; i++){
        let id = 'tuotor'+tuotor[i]['id'];
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

    // tuotor.forEach((index, value)=>{
    //     // 2つで折り返す
    //     let num = value;
    //     let url = index['img'];
    //     console.log(url);
    //     let age = index['age'];
    //     let born = index['born'];
    //     let viewer = '';
    //     if(num % 2 == 0){
    //         viewer = '<div class="block">';    
    //         viewer += view(url, age, born);
    //         $('#app').append(viewer);
    //         console.log(num);
    //     }else{
    //         viewer = view(url, age, born);
    //         viewer += '</div>';
    //         $('.block').append(viewer);
    //         console.log(num)
    //     }
    // })
}

let tuotor = tuotorslist();
render(tuotor);





