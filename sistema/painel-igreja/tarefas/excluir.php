<?php
require_once("../../conexao.php");
$pagina = 'tarefas';
$id = @$_POST['id-excluir'];

$query = $pdo->query("DELETE FROM $pagina where id = '$id'");


echo 'Excluído com Sucesso';
?>