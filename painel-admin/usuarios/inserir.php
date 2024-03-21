<?php
require_once("../../conexao.php");
$pagina = 'usuarios';
$senha = $_POST['senha'];
$id = @$_POST['id'];

$query = $pdo->prepare("UPDATE $pagina SET senha = :senha where id = '$id'");
$query->bindValue(":senha", "$senha");
$query->execute();

echo 'Salvo com Sucesso';


?>