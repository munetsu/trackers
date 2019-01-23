// チューター情報
console.log(lists,year);

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
    let view = '';
    view += '<div>';
        view += '<div><img src="'+url+'" style="width:150px;height:150px;"></div>';
        view += '<div>';
            view += '<div><p>年齢：'+age+'歳</p>';
            view += '<div><p>出身地：'+born+'</p>';
        view += '</div>';
    view += '</div>';
    $('#app').append(view);
}


function render(tuotor){
    let count = 0;
    $.each(tuotor, function(index, value){
        // 2つで折り返す
        if(count <2){
            let url = value['img'];
            let age = value['age'];
            let born = value['born'];        
            view(url, age, born);
            count += 1;
        }else {
            let url = value['img'];
            let age = value['age'];
            let born = value['born'];  
            view(url, age, born);
            count += 0;
        }
    })
}

let list = tuotorslist();
render(list);






