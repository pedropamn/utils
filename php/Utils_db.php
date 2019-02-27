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

//SELECT em todas as colunas com Prepared Statements  (SELECT * FROM tabela WHERE coluna = ?)
function select_multi_column($sql){
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

//SELECT em coluna específica com Prepared Statements (SELECT coluna FROM tabela WHERE coluna = ?)
function select_specific_column($sql){
	$conn = get_conn();	
	//Check connection
	if ($conn->connect_error) {
		//die("Erro ao conectar ao banco: " . $conn->connect_error);
		header('Location: index.php?status=errobanco');
	}
	$stmt = $conn->prepare($sql);
	$stmt->bind_param("i",$var); 
	$stmt->execute();
	$stmt->store_result();	
	$num_de_resultados = $stmt->num_rows;
	//Pega o resultado
	$stmt->bind_result($nome_coluna); //$nome_coluna retornará o valor do SELECT
	$stmt->fetch();
	
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
	if($stmt->affected_rows > 0){
		//ok
	}
}


//UPDATE com Prepared Statements. Ex:"UPDATE tabela SET coluna_a = ?, coluna_b = ? WHERE coluna = ?"); 
function update($sql){
	$conn = get_conn();

	//Check connection
	if ($conn->connect_error) {
		//die("Erro ao conectar ao banco: " . $conn->connect_error);
		header('Location: index.php?status=errobanco');
	}
	$stmt = $conn->prepare($sql);
	$stmt->bind_param("sss", $var1,$var2,$var3);
	$stmt->execute();
	$num_de_resultados = $stmt->affected_rows;
}
?>
