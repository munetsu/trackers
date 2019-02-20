// 曜日を取得
var dayNames = [
    '日曜日',
    '月曜日',
    '火曜日',
    '水曜日',
    '木曜日',
    '金曜日',
    '土曜日'
];
    
// var now = new Date();
// var day = now.getDay();
// var dayName = dayNames[day];

$('input').on('change', function(){
    let name = $(this).attr('name');
    let date = $(this).val();
    date = date.replace(/-/g,'/');
    date = new Date(date);
    let weekday = date.getDay();
    $('#'+name).html(dayNames[weekday]);
    $('input[name='+name+'ex]').val(1);
})

// form内チェック後に送信する処理を記載
$('#subBtn').on('click', function(){
    offer.submit();
})