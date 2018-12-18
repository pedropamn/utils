<?php
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
?>