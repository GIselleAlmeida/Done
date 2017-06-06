function btn_send(){

   var xhttp = new XMLHttpRequest();  
   xhttp.onreadystatechange = function() {
   if (this.readyState == 4 && this.status == 200) {
      response = this.responseText;
      console.log(response);
      document.getElementById('btn-input').value = "";
   	}
	};
   
   xhttp.open("POST", "chat.php", true);
	var text = document.getElementById('btn-input').value;
   var data = new FormData();
   data.append("msg", text);
   xhttp.send(data);


}

function getChat() {
  setTimeout("getChat()", 1600);

  var xhttp = new XMLHttpRequest();  
  xhttp.onreadystatechange = function() {
  if (this.readyState == 4 && this.status == 200) {
        //console.log(this.responseText);
         response = this.responseText;
         aux = response.split("!");
         value = "";
         for (i=0; i<aux.length; i++) {
            console.log(aux[i]);
            auxV = aux[i].split("$");
            if (auxV[0] != null && auxV[1] != null) {
               value = value + '<li class="left clearfix">' + 
               '<div class="chat-body clearfix"> <div class="header">' +
               '<strong class="primary-font">'+auxV[0]+'</strong> </div><p>'+auxV[1]+'</p></div></li>';
            }
         }

         document.getElementById('listChat').innerHTML = value;
     }
   };
 xhttp.open("GET", "chat.php", true);
 xhttp.send();

}
getChat();