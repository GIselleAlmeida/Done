
function updatePiloto() {
  t = setTimeout("updatePiloto()", 3000);
  var xhttp = new XMLHttpRequest();  
  xhttp.onreadystatechange = function() {
  if (this.readyState == 4 && this.status == 200) {
        response = this.responseText;
        console.log(response);
        if(response.split(":").length >= 2){
          var piloto = document.getElementById("pilototag");
          var aux = response.split(":");
          var strGrupo = "";

          /*<a href="#" class="list-group-item" id="pilototag">
                <i class="fa fa-user fa-fw"></i> p1l0t0
                <span class="pull-right text-muted small"><em>Piloto</em> <i class="fa fa-android fa-fw"></i> 
                </span>
            </a>
            */

          for (var i=1; i<aux.length; i++) {
            if (aux[i] != "") {
              if(i==1){
                strGrupo =  strGrupo + '<a href="#" class="list-group-item" id="pilototag"><i class="fa fa-user fa-fw"></i>'+ aux[i] + '<span class="pull-right text-muted small"><em>Piloto</em> <i class="fa fa-android fa-fw"></i> </span></a>';
              }
              else{
              strGrupo =  strGrupo + '<a href="#" class="list-group-item" id="pilototag"><i class="fa fa-user fa-fw"></i>'+ aux[i] + '<span class="pull-right text-muted small"><em>Time</em> <i class="fa fa-android fa-fw"></i> </span></a>';
              }
            }
          }

          piloto.innerHTML = strGrupo;
          // clearTimeout(t);
        }
     }
	};
 xhttp.open("GET", "piloto-kata.php", true);
 xhttp.send();
  //  xhttp.open("GET", "randori-home.php", true);
  //xhttp.send();
}
updatePiloto(); 