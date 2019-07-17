window.onload = () =>{
  let openMessage = document.querySelectorAll('.openMessage');
  let messageDesk = document.getElementById('messageDesk');
  let sendMessage = document.getElementById('sendMessage');
  let notary_request_id = document.getElementById('notary_request_id');
  for(let i=0;i<openMessage.length;i++)
  openMessage[i].addEventListener('click',function(event){
       notary_request_id.value=this.href.split('?',2)[1];
      event.preventDefault();
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
          messageDesk.innerHTML='';
          for(let i=0;i<data.length;i++){
              let container=document.createElement('div');
              container.setAttribute('class','alert alert-light');
              let author = document.createElement('span');
              author.setAttribute('class','badge badge-secondary');
              author.innerHTML =data[i].sender+'    ';
              let text_message = document.createElement('span');
              text_message.innerHTML=data[i].text_message;
              container.appendChild(author);
              container.appendChild(text_message);  
              messageDesk.appendChild(container);
          }
      });
  }
};

