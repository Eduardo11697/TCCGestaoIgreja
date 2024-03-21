<?php
require_once("../../conexao.php");
@session_start();
$id_usuario = @$_SESSION['id_usuario'];

$pagina = 'vendas';

$valor = $_POST['valor'];
$descricao = $_POST['descricao'];
$data = $_POST['data'];
$igreja = $_POST['igreja'];
$id = @$_POST['id'];


if($id == "" || $id == 0){
	$query = $pdo->prepare("INSERT INTO $pagina SET descricao = '$descricao', valor = :valor, data = '$data', usuario = '$id_usuario', igreja = '$igreja'");

	$query->bindValue(":valor", "$valor");
	$query->execute();
	$ult_id = $pdo->lastInsertId();

	//INSIRO NAS MOVIMENTACOES
$pdo->query("INSERT INTO movimentacoes SET tipo = 'Entrada', movimento = 'Venda', descricao = '$descricao', valor = '$valor', data = '$data', usuario = '$id_usuario', id_mov = '$ult_id', igreja = '$igreja'");

}else{
	require_once("../verificar-tesoureiro.php");
	$query = $pdo->prepare("UPDATE $pagina SET descricao = '$descricao', valor = :valor, data = '$data', usuario = '$id_usuario', igreja = '$igreja' where id = '$id'");

	//INSIRO NAS MOVIMENTACOES
$pdo->query("UPDATE movimentacoes SET descricao = '$descricao', valor = '$valor', data = '$data', usuario = '$id_usuario' where id_mov = '$id' and movimento = 'Venda'");


$query->bindValue(":valor", "$valor");
$query->execute();

}







echo 'Salvo com Sucesso';


?>