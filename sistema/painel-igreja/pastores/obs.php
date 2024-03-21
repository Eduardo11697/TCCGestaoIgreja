<?php
require_once("../../conexao.php");
$pagina = 'pastores';
$obs = $_POST['obs'];
$id = @$_POST['id-obs'];

$query = $pdo->prepare("UPDATE $pagina SET obs = :obs where id = '$id'");
$query->bindValue(":obs", "$obs");
$query->execute();

echo 'Salvo com Sucesso';


?>