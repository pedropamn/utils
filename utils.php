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

	//Snippet para geração de excel à partir de uma tabela em HTML
	function gera_excel($html_tabela){
		$arquivo = 'planilha.xls';
		header ("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
		header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
		header ("Cache-Control: no-cache, must-revalidate");
		header ("Pragma: no-cache");
		header ("Content-type: application/x-msexcel");
		header ("Content-Disposition: attachment; filename=\"{$arquivo}\"" );
		header ("Content-Description: PHP Generated Data" );
		// Envia o conteúdo do arquivo
		echo $html_tabela;
	}
	
	//Snippet que inicia uma sessão. Deve ser usado em todas as páginas protegidas e na página que verifica o login
	function inicia_sessao(){
		if(!isset($_SESSION)){session_start();}
		//$_SESSION['logado'] = true;
	}

	/* 
		Obtém um áudio, via TTS do Google tradutor (https://stackoverflow.com/questions/9893175/google-text-to-speech-api/)
		O aúdio pode ser chamado via Javascript posteriormente:
		<script>
			var audio = new Audio('tts.php');
			audio.play();
		</script>
	
	*/
	function tts($txt,$lang){
		header("Content-Type: audio/mpeg");
		$tts = file_get_contents("https://translate.google.com/translate_tts?ie=UTF-8&q=".$txt."?&tl=".$lang."&client=tw-ob");
	}
?>
