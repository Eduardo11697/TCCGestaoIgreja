<?php
require_once("../../conexao.php");
$pagina = 'fornecedores';
$nome = $_POST['nome'];
$produto = $_POST['produto'];
$email = $_POST['email'];
$endereco = $_POST['endereco'];
$telefone = $_POST['telefone'];
$id = @$_POST['id'];
$id_igreja = @$_POST['id_igreja'];

if($id_igreja == ""){
	$id_igreja = 1;
}

if($email != ""){
	$query = $pdo->query("SELECT * FROM $pagina where email = '$email'");
	$res = $query->fetchAll(PDO::FETCH_ASSOC);
	$id_reg = @$res[0]['id'];
	if(@count($res) > 0 and $id_reg != $id){
		echo 'O Email já está cadastrado!';
		exit();
	}

}



if($id == "" || $id == 0){
	$query = $pdo->prepare("INSERT INTO $pagina SET nome = :nome, email = :email, telefone = :telefone, endereco = :endereco, produto = :produto, igreja = '$id_igreja'");
	
}else{
	$query = $pdo->prepare("UPDATE $pagina SET nome = :nome, email = :email, telefone = :telefone, endereco = :endereco, produto = :produto where id = '$id'");
	
}

$query->bindValue(":nome", "$nome");
$query->bindValue(":email", "$email");
$query->bindValue(":telefone", "$telefone");
$query->bindValue(":endereco", "$endereco");
$query->bindValue(":produto", "$produto");
$query->execute();

echo 'Salvo com Sucesso';


?>