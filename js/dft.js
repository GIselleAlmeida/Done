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
  //var text = editor.getValue();
  //console.log(text);
  var xhttp = new XMLHttpRequest();  
  xhttp.onreadystatechange = function() {
  if (this.readyState == 4 && this.status == 200) {
        console.log(this.responseText);
        editor.getDoc().setValue(this.responseText);
        
     }
	};
 xhttp.open("GET", "resposta.php", true);
 xhttp.send();

}
sendResposta();