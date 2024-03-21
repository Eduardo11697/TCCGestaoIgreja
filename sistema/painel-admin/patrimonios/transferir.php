<?php
require_once("../../conexao.php");
$pagina = 'patrimonios';
@session_start();
$id_usuario = @$_SESSION['id_usuario'];

$id = @$_POST['id-transferir'];
$id_igreja = @$_POST['igreja'];

$query = $pdo->query("UPDATE $pagina SET igreja_item = '$id_igreja', usuario_emprestou = '$id_usuario', data_emprestimo = curDate()  where id = '$id'");

echo 'Alterado com Sucesso';
?>