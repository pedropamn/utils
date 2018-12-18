<?php
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

//Evita cache
function no_cache(){
	header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
	header("Cache-Control: post-check=0, pre-check=0", false);
	header("Pragma: no-cache");
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