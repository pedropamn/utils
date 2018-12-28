<?php 
//Get connection
function get_conn(){
		$host = "127.0.0.1";
		$user = "root";
		$pass = "";
		$db = "nome_db";
		
		$conn = new mysqli($host, $user, $pass, $db);
		mysqli_set_charset($conn,"utf8");
		return $conn;
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
	$stmt->store_result();
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
?>
