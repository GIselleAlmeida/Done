var flagSendResquest = true;
console.log("randori");

function threadSendResquest() {
	console.log("aqui");
	if(flagSendResquest == true) {
		//console.log("pasei");
		loadSemaforo();
   }
   setTimeout("threadSendResquest()", 2000);
}

threadSendResquest();

/*$(document).ready(function(){
	$("#btnRandori").click(function(){
   	flagSendResquest = true;
   	console.log("pasei aqu");
	});
});
*/
function loadSemaforo() {
  var xhttp = new XMLHttpRequest();
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
  xhttp.open("GET", "randori-home.php", true);
  xhttp.send();
}
