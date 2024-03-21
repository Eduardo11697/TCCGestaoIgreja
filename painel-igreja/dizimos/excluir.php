<?php
require_once("../../conexao.php");
$pagina = 'dizimos';
$id = @$_POST['id-excluir'];

require_once("../verificar-tesoureiro.php");
$query = $pdo->query("DELETE FROM $pagina where id = '$id'");
$query = $pdo->query("DELETE FROM movimentacoes where id_mov = '$id' and movimento = 'Dízimo'");

echo 'Excluído com Sucesso';
?>