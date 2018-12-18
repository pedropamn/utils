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

      //Valida MIME e extensão
	function valida_mime_ext($mime, $ext){
		$allowed_mime = ['application/pdf','image/jpeg','image/png','video/mpeg','video/mp4','text/html','application/octet-stream'];
		$allowed_ext = ['pdf','jpg','png','mpeg','mp4','html'];
		if(in_array($mime,$allowed_mime) && in_array($ext,$allowed_ext)){
			return 'true';
		}
		else{
			return 'false';

		}
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

	//Criptografa senha ao cadastrar usuário
	function cripto_senha($senha){
		$hash_gerado = password_hash($senha, PASSWORD_BCRYPT);
		return $hash_gerado;
	}

	//Verifica senha em texto com o hash
	function verifica_senha($senha, $hash){
		if (password_verify($senha, $hash)) {
			return 'true';
		} else {
			return 'false';
		}
	}

	//String aleatória
	function generateRandomString($length = 10) {
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$charactersLength = strlen($characters);
		$randomString = '';
		for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[rand(0, $charactersLength - 1)];
		}
		return $randomString;
	}

	//Checa o tempo de login. Desloga se ultrapassar o tempo limite
	function check_tempo_login(){
		
		$agora = now();
		$limite_minutos = 10;
		session_start();
		if (isset($_SESSION['LAST_ACTIVITY'])){			
			$datetime1 = new DateTime($agora);
			$datetime2 = new DateTime($_SESSION['LAST_ACTIVITY']);
			$interval = $datetime1->diff($datetime2);
			//return $interval->format('%dd %hh %im');
			$dif = $interval->format('%i'); // minutos
			//die($dif);
			if($dif >= $limite_minutos){
				session_start();
				session_destroy();
				header("Location: ".'http://'.$_SERVER['HTTP_HOST'].'/login');
			}
			else{
				$_SESSION['LAST_ACTIVITY'] = $agora;
			}
		}
		
	}

	//Obtém variáveis $_SERVER
	function get_server_vars(){
		$indicesServer = array('PHP_SELF', 
		'argv', 
		'argc', 
		'GATEWAY_INTERFACE', 
		'SERVER_ADDR', 
		'SERVER_NAME', 
		'SERVER_SOFTWARE', 
		'SERVER_PROTOCOL', 
		'REQUEST_METHOD', 
		'REQUEST_TIME', 
		'REQUEST_TIME_FLOAT', 
		'QUERY_STRING', 
		'DOCUMENT_ROOT', 
		'HTTP_ACCEPT', 
		'HTTP_ACCEPT_CHARSET', 
		'HTTP_ACCEPT_ENCODING', 
		'HTTP_ACCEPT_LANGUAGE', 
		'HTTP_CONNECTION', 
		'HTTP_HOST', 
		'HTTP_REFERER', 
		'HTTP_USER_AGENT', 
		'HTTPS', 
		'REMOTE_ADDR', 
		'REMOTE_HOST', 
		'REMOTE_PORT', 
		'REMOTE_USER', 
		'REDIRECT_REMOTE_USER', 
		'SCRIPT_FILENAME', 
		'SERVER_ADMIN', 
		'SERVER_PORT', 
		'SERVER_SIGNATURE', 
		'PATH_TRANSLATED', 
		'SCRIPT_NAME', 
		'REQUEST_URI', 
		'PHP_AUTH_DIGEST', 
		'PHP_AUTH_USER', 
		'PHP_AUTH_PW', 
		'AUTH_TYPE', 
		'PATH_INFO', 
		'ORIG_PATH_INFO') ; 

		echo '<table cellpadding="10">' ; 
		foreach ($indicesServer as $arg) { 
			if (isset($_SERVER[$arg])) { 
				echo '<tr><td>'.$arg.'</td><td>' . $_SERVER[$arg] . '</td></tr>' ; 
			} 
			else { 
				echo '<tr><td>'.$arg.'</td><td>-</td></tr>' ; 
			} 
		} 
		echo '</table>' ; 
	}

	
?>
