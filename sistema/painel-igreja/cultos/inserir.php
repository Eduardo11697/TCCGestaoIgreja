<?php
require_once("../../conexao.php");
$pagina = 'cultos';
$nome = $_POST['nome'];
$descricao = $_POST['descricao'];
$dia = $_POST['dia'];
$hora = $_POST['hora'];
$igreja = $_POST['igreja'];
$id = @$_POST['id'];


$query = $pdo->query("SELECT * FROM $pagina where nome = '$nome' and igreja = '$igreja'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$id_reg = @$res[0]['id'];
if(@count($res) > 0 and $id_reg != $id){
	echo 'O nome já está Cadastrado!';
	exit();
}


if($id == "" || $id == 0){
	$query = $pdo->prepare("INSERT INTO $pagina SET nome = :nome, descricao = :descricao, dia = :dia, hora = '$hora', igreja = '$igreja'");

}else{
	$query = $pdo->prepare("UPDATE $pagina SET nome = :nome, descricao = :descricao, dia = :dia, hora = '$hora' where id = '$id'");
}

$query->bindValue(":descricao", "$descricao");
$query->bindValue(":nome", "$nome");
$query->bindValue(":dia", "$dia");
$query->execute();
echo 'Salvo com Sucesso';


?>