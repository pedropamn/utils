<?php

date_default_timezone_set('America/Sao_Paulo');
//Database
	function get_conn(){
		$host = "127.0.0.1";
		$user = "root";
		$pass = "";
		$db = "nome_db";
		
		$conn = new mysqli($host, $user, $pass, $db);
		mysqli_set_charset($conn,"utf8");
		return $conn;
	}
	
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
	
	//Calcula a diferença entre hoje e uma determinada data. Retorna resultados negativos, zero ou positivos, estes dois últimos com o sinal de '+'
	function data_dif($data){
		$hoje = new DateTime(date('Y-m-d',strtotime("now")));
		$data = new DateTime(data_iso($data));

		$interval = $hoje->diff($data);
		return $interval->format('%R%a');
	}
?>