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


//Diff entre datas
function parseDate(str) {
    var mdy = str.split('/');
    return new Date(mdy[2], mdy[1], mdy[0]);
}

function datediff(first, second) {
    // Take the difference between the dates and divide by milliseconds per day.
    // Round to nearest whole number to deal with DST.
    return Math.round((second-first)/(1000*60*60*24));
}

//Usage:
datediff(parseDate('01/01/2022'), parseDate('03/01/2022'));


////ISO (2022-08-07T17:00:52.268Z) to dd/mm/aaaa
function isotodate(isoformat){
	var date = new Date(isoformat);

	return date.toLocaleDateString('pt-BR'); 'dd/mm/aaaa'
}
