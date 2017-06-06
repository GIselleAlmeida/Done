
function updatePiloto() {
  t = setTimeout("updatePiloto()", 3000);
  var xhttp = new XMLHttpRequest();  
  xhttp.onreadystatechange = function() {
  if (this.readyState == 4 && this.status == 200) {
        response = this.responseText;
        console.log("cronometro");
        console.log(response);
        if(response.split(":").length >= 2){
          var piloto = document.getElementById("pilototag");
          var aux = response.split(":");
          piloto.innerHTML =  '<i class="fa fa-user fa-fw"></i>'+ aux[1] + '<span class="pull-right text-muted small"><em>Piloto</em> <i class="fa fa-android fa-fw"></i> </span>';
         // clearTimeout(t);
        }
     }
	};
 xhttp.open("GET", "piloto.php", true);
 xhttp.send();
  //  xhttp.open("GET", "randori-home.php", true);
  //xhttp.send();
}
updatePiloto();