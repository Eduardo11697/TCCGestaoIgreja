<?php
require_once("../../conexao.php");
@session_start();
$id_usuario = @$_SESSION['id_usuario'];
$pagina = 'receber';
$descricao = $_POST['descricao'];
$membro = $_POST['membro'];
$valor = $_POST['valor'];
$vencimento = $_POST['vencimento'];
$igreja = $_POST['igreja'];

$valor = str_replace(',', '.', $valor);

$id = @$_POST['id'];


if($id == "" || $id == 0){
	$query = $pdo->prepare("INSERT INTO $pagina SET descricao = :descricao, membro = :membro, valor = :valor, data = curDate(), vencimento = :vencimento, usuario_cad = '$id_usuario', pago = 'Não', igreja = '$igreja'");

}else{
	
		$query = $pdo->prepare("UPDATE $pagina SET descricao = :descricao, membro = :membro, valor = :valor, vencimento = :vencimento, usuario_cad = '$id_usuario' where id = '$id'");
	

}


	$query->bindValue(":descricao", "$descricao");
	$query->bindValue(":membro", "$membro");
	$query->bindValue(":valor", "$valor");
	$query->bindValue(":vencimento", "$vencimento");
	$query->execute();


echo 'Salvo com Sucesso';


?>