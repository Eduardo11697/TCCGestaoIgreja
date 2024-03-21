<?php
require_once("../../conexao.php");
$pagina = 'igrejas';
$id = @$_POST['id-excluir'];


$query = $pdo->query("SELECT * FROM membros where igreja = '$id'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
if(@count($res) > 0) {
	echo 'Essa igreja possui membros cadastrados, primeiro exclua todos os membros para depois fazer a exclusão da igreja!';
	exit();
}


//excluir a imagem
$query = $pdo->query("SELECT * FROM $pagina where id = '$id'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$foto = $res[0]['imagem'];
if($foto != "sem-foto.jpg"){
	@unlink('../../img/igrejas/'.$foto);	
}


$query = $pdo->query("DELETE FROM $pagina where id = '$id'");

echo 'Excluído com Sucesso';
?>