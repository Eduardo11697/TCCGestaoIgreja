<?php
require_once("../../conexao.php");
$pagina = 'eventos';
$id = @$_POST['id'];
$ativar = @$_POST['ativar'];

$query = $pdo->query("UPDATE $pagina SET ativo = '$ativar' where id = '$id'");

echo 'Alterado com Sucesso';
?>