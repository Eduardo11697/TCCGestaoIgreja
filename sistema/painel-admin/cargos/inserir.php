<?php
require_once("../../conexao.php");
$pagina = 'cargos';
$nome = $_POST['nome'];
$id = @$_POST['id'];


$query = $pdo->query("SELECT * FROM $pagina where nome = '$nome'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$id_reg = @$res[0]['id'];
if(@count($res) > 0 and $id_reg != $id){
	echo 'O Cargo já está cadastrado!';
	exit();
}


if($id == "" || $id == 0){
	$query = $pdo->prepare("INSERT INTO $pagina SET nome = :nome");
	$query->bindValue(":nome", "$nome");
	$query->execute();
	
}else{
	$query = $pdo->prepare("UPDATE $pagina SET nome = :nome where id = '$id'");
	$query->bindValue(":nome", "$nome");
	$query->execute();
}

echo 'Salvo com Sucesso';


?>