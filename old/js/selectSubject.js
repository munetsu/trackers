// console.log(num);

// 資格情報
// function render(){
//     let view = '<form action="php/ajax.php" method="POST" name="sub">';
//     view += '<input type="hidden" name="action" value="subject">';
//     view += '<input type="hidden" name="uid" value="'+uid+'">';
//     for(let i= 0; i<subjectList.length; i++){
//         if(i % 2 == 0){
//             view += '<div class="flex">';
//                 view += '<div><label class="subject"><input type="radio" name="subject" value="'+subjectList[i]['id']+'" style="display:none;">'+subjectList[i]['kinds']+'</label></div>';
//         }else{
//             view += '<div><label class="subject"><input type="radio" name="subject" value="'+subjectList[i]['id']+'" style="display:none;">'+subjectList[i]['kinds']+'</label></div>';
//             view += '</div>';
//         }
//     }
//     view += '</form>';
//     $('#app').append(view);
// }

function renderTuotor(){
    let view = '<form action="php/ajax.php" method="POST" name="sub">';
    view += '<input type="hidden" name="action" value="subjectTuotor">';
    view += '<input type="hidden" name="uid" value="'+uid+'">';
    view += '<input type="hidden" name="status" value="'+num+'">';
    for(let i= 0; i<subjectList.length; i++){
        if(i % 2 == 0){
            view += '<div class="flex">';
                view += '<div class="one"><label class="subject"><input type="radio" name="subject" value="'+subjectList[i]['id']+'" style="display:none;">'+subjectList[i]['kinds']+'</label></div>';
        }else{
            view += '<div class="one"><label class="subject"><input type="radio" name="subject" value="'+subjectList[i]['id']+'" style="display:none;">'+subjectList[i]['kinds']+'</label></div>';
            view += '</div>';
        }
    }
    view += '</form>';
    $('#app').append(view);
}

renderTuotor()

// Form送信処理
$(document).on('click', 'input', function(){
    // let id = $(this).attr('value');
    sub.submit();
})
