<?php
	//conexão com o banco utilizando PDO
	function conectar(){

	try{
//	 $pdo = new PDO("mysql:host=localhost;dbname=ceiitaco_cei", "ceiitaco_maikon", "monteiro@10");
	$pdo = new PDO("mysql:host=localhost;dbname=cei", "root", "");
	 
}catch(PDOException $e){

	echo $e->getMessage();

}
return $pdo;
}

?>