// カレンダー部分
$(".datepicker").datepicker({
    dateFormat:'yy/mm/dd',
    minDate: "+3d",
    maxDate: "+14d",
});

// 面談対応可能日の展開
function calendar(data){
    // console.log(data.length);
    let schedules = [];
    let schedule = {'date':'','time':''};
    let date = '';
    let date2 = '';
    const calendarDate = [];
    for(let i=0;i<data.length;i++){
        // オブジェクトコピー
        const newSchedule = Object.assign({},schedule);
        date = data[i]['date'];
        if(i == 0){
            schedules.push(data[i]['time']);
            date2 = data[i]['date'];
        }else{
            date2 = data[i-1]['date'];
            // console.log('date:'+date+',date2:'+date2);
            if(date == date2){
                schedules.push(data[i]['time']);
                // console.log('date='+schedules);
            }else{
                newSchedule.date = date2;
                newSchedule.time = schedules;
                calendarDate.push(newSchedule);
                
                // 配列を空に戻す
                schedules.length = 0;
                // console.log('date!='+schedules);
            }
        }
        // console.log(schedules);

    }
    return calendarDate;
}

// calendar関数実行
let interviewDate = calendar(data);
// console.log(interviewDate[0]['time'][2]);
// カレンダー日付クリック
$(".datepicker").on('change', function(){
    let id = $(this).attr('name');
    $('#'+id).empty();
    let value = $("[name="+id+"]").val();
    let name = id.slice(0,1);
    let view = '<select name="'+name+'time">';
    
    for(let i=0;i<interviewDate.length;i++){
        if(value == interviewDate[i]['date']){
            for(let k=0;k<interviewDate[i]['time'].length;k++){
                view += '<option value="'+interviewDate[i]['time'][k]+'">';
                view += interviewDate[i]['time'][k];
                view += '</option>';
            }
            break;
        }
    }
    view += '</select>';
    $('#'+id).append(view);
})

