// console.log(subjectList);

// 資格情報描画
function render(){
    let view = '<form action="main.php" method="POST" name="sub">';
    view += '<input type="hidden" name="action" value="subject">';
    for(let i= 0; i<subjectList.length; i++){
        if(i % 2 == 0){
            view += '<div class="flex">';
                view += '<div><label class="subject"><input type="radio" name="subject" value="'+subjectList[i]['id']+'" style="display:none;">'+subjectList[i]['kinds']+'</label></div>';
        }else{
            view += '<div><label class="subject"><input type="radio" name="subject" value="'+subjectList[i]['id']+'" style="display:none;">'+subjectList[i]['kinds']+'</label></div>';
            view += '</div>';
        }
    }
    view += '</form>';
    $('#app').append(view);
}


// Form送信処理
$(document).on('click', '.subject', function(){
    let id = $(this).find('input').attr('value');
    sub.submit();
})

render();