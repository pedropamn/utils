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
		
		/* Chamada:
		$conn = get_conn();
		if ($conn->connect_error) {
			//die("Erro ao conectar ao banco: " . $conn->connect_error);
			header("Location: index.php?msg=".lang('GENERAL_DATABASE_ERROR', $username)."&tipo=erro");
		}
		*/
	}

	//SELECT com Prepared Statements
	function select($sql){
		$conn = get_conn();	
		//Check connection
		if ($conn->connect_error) {
			//die("Erro ao conectar ao banco: " . $conn->connect_error);
			header('Location: index.php?status=errobanco');
		}
		$stmt = $conn->prepare($sql);
		$stmt->bind_param('s',$var);
		$stmt->execute();
		$result = $stmt->get_result();
		while ($row = $result->fetch_assoc()) {
			//Iteração
		}
	}

	//INSERT com Prepared Statements. Ex:INSERT INTO tabela (coluna) VALUES (?)"); 
	function insert($sql){
		$conn = get_conn();	
		//Check connection
		if ($conn->connect_error) {
			//die("Erro ao conectar ao banco: " . $conn->connect_error);
			header('Location: index.php?status=errobanco');
		}
		$stmt = $conn->prepare($sql);
		$stmt->bind_param("s", $var);
		$stmt->execute();
		if($stmt->affected_rows == 1){
			//ok
		}
	}
	//UPDATE com Prepared Statements. Ex:"UPDATE tabela SET coluna = ? WHERE coluna = ?"); 
	function update($sql){
		$conn = get_conn();
	
		//Check connection
		if ($conn->connect_error) {
			//die("Erro ao conectar ao banco: " . $conn->connect_error);
			header('Location: index.php?status=errobanco');
		}
		$stmt = $conn->prepare($sql);
		$stmt->bind_param("s", $var1,$var2);
		$stmt->execute();		
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

      //Gerencia um upload com validação de extensão e MIME (Testado com Dropzone.js)
      function get_upload($uploaddir){
      	$uploaddir = './pdf/';
	$uploadfile = $uploaddir . basename($_FILES['fileToUpload']['name']);

	//Checa a extensão e MIME
	$filename = $_FILES['fileToUpload']['name'];
	$ext = pathinfo($filename, PATHINFO_EXTENSION);
	$mime = mime_content_type($_FILES['fileToUpload']['tmp_name']);
	
	  if($mime != 'application/pdf' || $ext != 'pdf'){
		die('Erro. A extensão é '.$ext.' e o MIME é '.$mime);
	  }
	  if (move_uploaded_file($_FILES['fileToUpload']['tmp_name'], $uploadfile)) {
		  echo "O arquivo é valido e foi carregado com sucesso.\n";
	   } else {
		 echo "Algo está errado aqui!\n";
	   }
      }
	
	//Evita cache
    function no_cache(){
    	header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
	header("Cache-Control: post-check=0, pre-check=0", false);
	header("Pragma: no-cache");
    }

	
?>
