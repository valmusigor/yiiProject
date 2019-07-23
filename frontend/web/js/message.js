window.onload = () =>{
  let openMessage = document.querySelectorAll('.openMessage');
  let messageDesk = document.getElementById('messageDesk');
  let sendMessage = document.getElementById('sendMessage');
  let notary_request_id = document.getElementById('notary_request_id');
  let messageIcon= document.querySelectorAll('.messageIcon');
  let chatForm=document.getElementById('chat-form');
  for(let i=0;i<openMessage.length;i++)
  openMessage[i].addEventListener('click',function(event){  
      event.preventDefault();
      notary_request_id.value=this.href.split('?',2)[1];
      if(chatForm.style.display==='none' || chatForm.style.display===''){
        chatForm.style.display='block';  
        messageIcon[i].classList.remove('fa-comment-dots');
        messageIcon[i].classList.add('fa-window-close');
        
      for(let j=0;j<openMessage.length;j++)
        {
          if(i===j) continue;
          openMessage[j].style.display="none";
        }
        
      }
      else {
          chatForm.style.display='none';  
          messageIcon[i].classList.remove('fa-window-close');
          messageIcon[i].classList.add('fa-comment-dots');
          for(let j=0;j<openMessage.length;j++)
        {
          if(i===j) continue;
          openMessage[j].style.display="inline";
        }
      }
      getMessages(this.href);
      
  });
  sendMessage.addEventListener('click',(event)=>{
      let messageInput=document.getElementById('messageInput')
      fetch('/notary/sendmessage?notary_request_'+notary_request_id.value+'&text_message='+messageInput.value).then(res=>res.json()).then(data=>console.log(JSON.parse(data)));
      getMessages('/notary/message?'+notary_request_id.value);
      messageInput.value='';
  });
  const getMessages = ($url)  => {
      fetch($url).then(res => res.json()).then(data=>{
          data=JSON.parse(data);
          console.log(data);
          messageDesk.innerHTML='';
          for(let i=0;i<data.length;i++){
              let container=document.createElement('div');
              container.setAttribute('class','alert alert-light');
              let author = document.createElement('span');
              author.setAttribute('class','badge badge-secondary');
              author.innerHTML =data[i].sender+'    ';
              let text_message = document.createElement('span');
              text_message.innerHTML=data[i].text_message+'  ';
              let time_create = document.createElement('span');
              let data_create=new Date(+data[i].time_create*1000);
              time_create.innerHTML=data_create.getHours()+':'+data_create.getMinutes()+' '+data_create.getDate()
              +'.'+data_create.getMonth()+'.'+data_create.getFullYear();
              container.appendChild(time_create);
              container.appendChild(document.createElement('br'));
              container.appendChild(author);
              container.appendChild(text_message); 
              messageDesk.appendChild(container);
          }
       messageDesk.scrollTop=messageDesk.scrollHeight;
      });
  }
};

