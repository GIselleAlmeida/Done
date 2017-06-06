var code;
var editor;

$(document).ready(function(){
	//code here...
	code = $(".codemirror-textarea")[0];
	editor = CodeMirror.fromTextArea(code, {
		lineNumbers : true,
		theme: "eclipse",
		mode: "text/x-java", //this is for JAVA
  		matchBrackets: true

	});
});

function sendResposta() {
  setTimeout("sendResposta()", 1600);
  var text = editor.getValue();
  console.log(text);
  if (text != "") {
    var xhttp = new XMLHttpRequest();  
    xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
          response = this.responseText;
          console.log(response);
      }
	   };
    xhttp.open("POST", "resposta.php", true);
    var data = new FormData();
    data.append("answer", text);
    xhttp.send(data);
    //  xhttp.open("GET", "randori-home.php", true);
    //xhttp.send();
  }
}
sendResposta();

