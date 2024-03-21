<?php
require_once("../../conexao.php");
$pagina = 'grupos';
$nome = $_POST['nome'];
$dias = $_POST['dias'];
$local = $_POST['local'];
$hora = $_POST['hora'];
$pastor = $_POST['pastor'];
$regente = $_POST['regente'];
$secretario = $_POST['secretario'];
$tesoureiro = $_POST['tesoureiro'];
$lider1 = $_POST['lider1'];
$lider2 = $_POST['lider2'];
$igreja = $_POST['igreja'];
$id = @$_POST['id'];


$query = $pdo->query("SELECT * FROM $pagina where nome = '$nome' and igreja = '$igreja'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$id_reg = @$res[0]['id'];
if(@count($res) > 0 and $id_reg != $id){
	echo 'O nome já está indisponível!';
	exit();
}


if($id == "" || $id == 0){
	$query = $pdo->prepare("INSERT INTO $pagina SET nome = :nome, dias = :dias, hora = :hora, local = :local, igreja = '$igreja', pastor = '$pastor', regente = '$regente', secretario = '$secretario', tesoureiro = '$tesoureiro', lider1 = '$lider1', lider2 = '$lider2'");

}else{
	$query = $pdo->prepare("UPDATE $pagina SET nome = :nome, dias = :dias, hora = :hora, local = :local,  pastor = '$pastor', regente = '$regente', secretario = '$secretario', tesoureiro = '$tesoureiro', lider1 = '$lider1', lider2 = '$lider2' where id = '$id'");
}

$query->bindValue(":nome", "$nome");
$query->bindValue(":dias", "$dias");
$query->bindValue(":hora", "$hora");
$query->bindValue(":local", "$local");
$query->execute();
echo 'Salvo com Sucesso';


?>