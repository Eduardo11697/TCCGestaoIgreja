<?php
require_once("../../conexao.php");
$pagina = 'tarefas';
$titulo = $_POST['titulo'];
$descricao = $_POST['descricao'];
$data = $_POST['data'];
$hora = $_POST['hora'];
$igreja = $_POST['igreja'];
$id = @$_POST['id'];


$query = $pdo->query("SELECT * FROM $pagina where data = '$data' and hora = '$hora'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$id_reg = @$res[0]['id'];
if(@count($res) > 0 and $id_reg != $id){
	echo 'O horário está indisponível!';
	exit();
}


if($id == "" || $id == 0){
	$query = $pdo->prepare("INSERT INTO $pagina SET titulo = :titulo, descricao = :descricao, data = '$data', hora = '$hora', igreja = '$igreja', status = 'Agendada'");

}else{
	$query = $pdo->prepare("UPDATE $pagina SET titulo = :titulo, descricao = :descricao, data = '$data', hora = '$hora' where id = '$id'");
}

$query->bindValue(":descricao", "$descricao");
$query->bindValue(":titulo", "$titulo");
$query->execute();
echo 'Salvo com Sucesso';


?>