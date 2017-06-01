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