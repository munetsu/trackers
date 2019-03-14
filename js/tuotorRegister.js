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

calendar(data);
// console.log(calendar(data));