<?php
require_once("../../conexao.php");
$pagina = 'frequencias';
$frequencia = $_POST['frequencia'];
$dias = $_POST['dias'];
$id = @$_POST['id'];


$query = $pdo->query("SELECT * FROM $pagina where frequencia = '$frequencia'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$id_reg = @$res[0]['id'];
if(@count($res) > 0 and $id_reg != $id){
	echo 'A frequencia já está cadastrado!';
	exit();
}


if($id == "" || $id == 0){
	$query = $pdo->prepare("INSERT INTO $pagina SET frequencia = :frequencia, dias = '$dias'");
	$query->bindValue(":frequencia", "$frequencia");
	$query->execute();
	
}else{
	$query = $pdo->prepare("UPDATE $pagina SET frequencia = :frequencia, dias = '$dias' where id = '$id'");
	$query->bindValue(":frequencia", "$frequencia");
	$query->execute();
}

echo 'Salvo com Sucesso';


?>