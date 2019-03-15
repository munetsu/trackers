$(document).on('click', '.list',  function(){
    let id = $(this).attr('id');
    console.log(id);
    $.ajax({
        url:'c_controller.php',
        type: 'POST',
        data: {
            action: id,
        }
    })
    .done((data) => {
        $('#mainArea').empty();
        $('#mainArea').html(data);
    })
    .fail((data) => {
        $('#mainArea').html(errorMessage())
    })
});

// エラー時の表示画面
function errorMessage(){
    let view = '<div>';
        view += '<p>データ取得が出来ませんでした。</p>';
        view += '</div>';
    return view;
}