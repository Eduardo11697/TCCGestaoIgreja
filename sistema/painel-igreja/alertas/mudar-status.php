<?php
require_once("../../conexao.php");
$pagina = 'alertas';
$id = @$_POST['id'];
$ativar = @$_POST['ativar'];

$query = $pdo->query("SELECT * FROM $pagina where id = '$id'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$id_igreja =$res[0]['igreja'];

if($ativar == 'Sim'){
	$query = $pdo->query("SELECT * FROM $pagina where igreja = '$id_igreja' and ativo = 'Sim'");
	$res = $query->fetchAll(PDO::FETCH_ASSOC);
	$total_reg = count($res);
	if($total_reg > 0){
		echo 'Nao é possível ter dois alertas ativos, desative um dos alertas para ativar este!';
		exit();
	}
}

$query = $pdo->query("UPDATE $pagina SET ativo = '$ativar' where id = '$id'");

echo 'Alterado com Sucesso';
?>