<?php
require_once("../../conexao.php");
@session_start();
$id_usuario = @$_SESSION['id_usuario'];
$pagina = 'alertas';
$titulo = $_POST['titulo'];
$link = $_POST['link'];
$descricao = $_POST['descricao'];
$data = $_POST['data'];

$id = @$_POST['id'];
$igreja = $_POST['igreja'];



//SCRIPT PARA SUBIR FOTO NO BANCO
$nome_img = date('d-m-Y H:i:s') .'-'.@$_FILES['imagem']['name'];
$nome_img = preg_replace('/[ :]+/' , '-' , $nome_img);

$caminho = '../../img/alertas/' .$nome_img;
if (@$_FILES['imagem']['name'] == ""){
	$imagem = "sem-foto.jpg";
}else{
	$imagem = $nome_img;
}

$imagem_temp = @$_FILES['imagem']['tmp_name']; 
$ext = pathinfo($imagem, PATHINFO_EXTENSION);   
if($ext == 'png' or $ext == 'jpg' or $ext == 'JPG' or $ext == 'jpeg' or $ext == 'gif'){ 
	move_uploaded_file($imagem_temp, $caminho);
}else{
	echo 'Extensão de Imagem não permitida!';
	exit();
}



if($id == "" || $id == 0){
	$query = $pdo->prepare("INSERT INTO $pagina SET titulo = :titulo, descricao = :descricao, link = :link, usuario = '$id_usuario', data = '$data', igreja = '$igreja', ativo = 'Não', imagem = '$imagem'");
	
}else{
	if($imagem == "sem-foto.jpg"){
		$query = $pdo->prepare("UPDATE $pagina SET titulo = :titulo, descricao = :descricao, link = :link, usuario = '$id_usuario', data = '$data', igreja = '$igreja', ativo = 'Sim' where id = '$id'");
	}else{

		$query = $pdo->query("SELECT * FROM $pagina where id = '$id'");
		$res = $query->fetchAll(PDO::FETCH_ASSOC);
		$foto = $res[0]['imagem'];
		if($foto != "sem-foto.jpg"){
			@unlink('../../img/alertas/'.$foto);	
		}

		$query = $pdo->prepare("UPDATE $pagina SET titulo = :titulo, descricao = :descricao, link = :link, usuario = '$id_usuario', data = '$data', igreja = '$igreja', ativo = 'Sim', imagem = '$imagem' where id = '$id'");
	}
	
	
}


$query->bindValue(":titulo", "$titulo");
$query->bindValue(":link", "$link");
$query->bindValue(":descricao", "$descricao");

$query->execute();



echo 'Salvo com Sucesso';


?>