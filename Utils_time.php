<?php 
//Default Timezone Set
date_default_timezone_set('America/Sao_Paulo');

//Data para o dd/mm/aaaa 
function formata_data($data){
	return date('d/m/Y',strtotime($data));
}


//Data e hora para dd/mm/aaaa hh:mm:ss
function formata_data_hora($data){
	return date('d/m/Y H:i:s',strtotime($data));
}

//Datas para o formato do Mysql aaaa-mm-dd
function data_iso($data){
	$temp = str_replace('/','-',$data); 
	return date("Y-m-d",strtotime($temp)); //Data no formate DATE para o MySql
}

//Data e Hora para o formato Mysql
function data_hora_iso($data){
	$temp = str_replace('/','-',$data); 
	return date("Y-m-d H:i:s",strtotime($temp)); //Data no formate DATE para o MySql
}

//Diferença entre dois datetimes, no formato yyyy-mm-dd hh:mm (formato Mysql). Retorna no formato '1d 1h 1m	'
function dif_entre_datetimes($dt1,$dt2){
	$datetime1 = new DateTime($dt1);
	$datetime2 = new DateTime($dt2);
	$interval = $datetime1->diff($datetime2);
	return $interval->format('%dd %hh %im');
}

//Calcula a diferença entre hoje e uma determinada data. Retorna resultados negativos, zero ou positivos, estes dois últimos com o sinal de '+'
function data_dif($data){
	$hoje = new DateTime(date('Y-m-d',strtotime("now")));
	$data = new DateTime(data_iso($data));

	$interval = $hoje->diff($data);
	return $interval->format('%R%a');
}
?>