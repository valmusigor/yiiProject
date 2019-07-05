window.onload = () =>{
    let editTask=document.querySelectorAll('.editTask');
    for(let i=0;i<editTask.length;i++)
    editTask[i].addEventListener('click',(event)=>{
      let input = document.createElement('input');
      input.type="text";
      input.name=`edit_${event.target.id}`;
      let btn = document.createElement('button');
      btn.type="submit";
      btn.innerHTML='save';
      let mas=event.target.parentNode.querySelector('.des').innerHTML.split('|');
      input.value=mas[0];
      let time=mas[1].split(' ');
      let hour=document.createElement('select');
      hour.name=`hour_${event.target.id}`;
      for(let i=0;i<24;i++)
      {
        if(i<10 && i==time[0].slice(1,2))
        hour.innerHTML+=`<option selected value='${(i<10)?'0'+i:i}'>${(i<10)?'0'+i:i}</option>`;
        else if(i==+(time[0].slice(0,2)))
        hour.innerHTML+=`<option selected value='${(i<10)?'0'+i:i}'>${(i<10)?'0'+i:i}</option>`;
        else hour.innerHTML+=`<option value='${(i<10)?'0'+i:i}'>${(i<10)?'0'+i:i}</option>`;
      }
      let minutes=document.createElement('select');
      minutes.name=`minutes_${event.target.id}`;
      for(let i=0;i<60;i++)
      {
        if(i<10 && i==time[0].slice(4,5))
        minutes.innerHTML+=`<option selected value='${(i<10)?'0'+i:i}'>${(i<10)?'0'+i:i}</option>`;
        else if(i==+(time[0].slice(3,5)))
        minutes.innerHTML+=`<option selected value='${(i<10)?'0'+i:i}'>${(i<10)?'0'+i:i}</option>`;
        else minutes.innerHTML+=`<option value='${(i<10)?'0'+i:i}'>${(i<10)?'0'+i:i}</option>`;
      }
      let calendar = document.createElement('input');
      calendar.type="date";
      calendar.name=`calendar_${event.target.id}`;
      calendar.value=time[1].substring(0, time[1].length);
      event.target.parentNode.insertBefore(input,event.target.parentNode.querySelector('.des'));
      event.target.parentNode.insertBefore(hour,event.target.parentNode.querySelector('.des'));
      event.target.parentNode.insertBefore(minutes,event.target.parentNode.querySelector('.des'));
      event.target.parentNode.insertBefore(calendar,event.target.parentNode.querySelector('.des'));
      event.target.parentNode.insertBefore(btn,event.target.parentNode.querySelector('.des'));
      event.target.parentNode.removeChild(event.target.parentNode.querySelector('.des'));
      event.target.parentNode.removeChild(event.target);
    });
    }