<?php
//Snippet que inicia uma sessão. Deve ser usado em todas as páginas protegidas e na página que verifica o login
function inicia_sessao(){
	if(!isset($_SESSION)){session_start();}
	//$_SESSION['logado'] = true;
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
?>