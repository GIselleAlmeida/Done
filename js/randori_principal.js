$(document).ready(function(){
  //code here...
  var code = $(".codemirror-textarea")[0];
  var editor = CodeMirror.fromTextArea(code, {
    lineNumbers : true,
    theme: "eclipse",
    mode: "text/x-java", //this is for JAVA
      matchBrackets: true

  });
});

function sendResposta() {
  setTimeout("sendResposta()", 1600);
  //console.log("aqui1");
    
  //document.getElementById("resposta").value = "Fifth Avenue, New York City";  
  //var respos =  document.getElementById("resposta");
  var text = editor;
  //var respos = document.getElementsByTagName("textarea");
  console.log(text);

  var code1 = code;
  //var respos = document.getElementsByTagName("textarea");
  console.log(code1);

  //console.log
/*  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
        response = this.responseText;
        if (response != "randori-oficial.php") {
          //console.log("if");
          document.getElementById("msg").innerHTML = response;
        } else {
          console.log(response);
          window.location.href = response;
          //console.log("else");
          //document.clear();
          //document.write(response);
        }
    }
  };
  xhttp.open("POST", "resposta.php", true);
  xhttp.send("new_resposta="+);*/
}

sendResposta();