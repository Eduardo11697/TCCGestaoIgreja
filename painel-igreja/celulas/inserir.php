<?php
require_once("../../conexao.php");
$pagina = 'celulas';
$nome = $_POST['nome'];
$dias = $_POST['dias'];
$local = $_POST['local'];
$hora = $_POST['hora'];
$pastor = $_POST['pastor'];
$coordenador = $_POST['coordenador'];
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
	$query = $pdo->prepare("INSERT INTO $pagina SET nome = :nome, dias = :dias, hora = :hora, local = :local, igreja = '$igreja', pastor = '$pastor', coordenador = '$coordenador', lider1 = '$lider1', lider2 = '$lider2'");

}else{
	$query = $pdo->prepare("UPDATE $pagina SET nome = :nome, dias = :dias, hora = :hora, local = :local,  pastor = '$pastor', coordenador = '$coordenador', lider1 = '$lider1', lider2 = '$lider2' where id = '$id'");
}

$query->bindValue(":nome", "$nome");
$query->bindValue(":dias", "$dias");
$query->bindValue(":hora", "$hora");
$query->bindValue(":local", "$local");
$query->execute();
echo 'Salvo com Sucesso';


?>