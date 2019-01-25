console.log(subjectList);

function render(){
    let view = '';
    for(let i= 0; i<subjectList.length; i++){
        if(i % 2 == 0){
            view += '<div class="flex">';
                view += '<div><p>'+subjectList[i]['kinds']+'</p></div>';
        }else{
            view += '<div><p>'+subjectList[i]['kinds']+'</p></div>';
            view += '</div>';
        }
    }
    $('#app').append(view);
}

render();