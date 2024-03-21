<?php
require_once("../../conexao.php");
$pagina = 'grupos';
$id = @$_POST['id-excluir'];


$query = $pdo->query("DELETE FROM grupos_membros where grupo = '$id'");
$query = $pdo->query("DELETE FROM $pagina where id = '$id'");


echo 'Excluído com Sucesso';
?>