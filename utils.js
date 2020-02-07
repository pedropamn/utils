//Buscar qualquer informação em uma tabela. Insira onkeyup="Busca()" no campo de input.
function Busca() {
  // Declare variables 
  var input, filter, table, tr, td, i;
  input = document.getElementById("myInput"); //Id do campo input
  filter = input.value.toUpperCase();
  table = document.getElementById("myTable"); //Id da tabela
  tr = table.getElementsByTagName("tr");

  // Loop through all table rows, and hide those who don't match the search query
  for (i = 0; i < tr.length; i++) {
	  td = tr[i].getElementsByTagName("td");
	  for(var x=0;x<td.length;x++){
			var td_atual = td[x];
			if (td_atual) {
			  if (td_atual.innerHTML.toUpperCase().indexOf(filter) > -1) {
				tr[i].style.display = "";
				break;
			  } else {
				tr[i].style.display = "none";
			  }
			} 
	  }

  }
}


//Ajax via Jquery
 $.ajax({
	url: url,
        type: 'GET', 
	//dataType: 'json',
	success: function(result){
		
	},
	error: function(){
		
	}
});

//Obter parâmetros GET
var urlParams = new URLSearchParams(window.location.search);
var test = urlParams.get('test'); //index.php?test=123
