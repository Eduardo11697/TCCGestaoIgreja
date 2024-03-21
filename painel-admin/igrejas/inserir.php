<?php
require_once("../../conexao.php");
$pagina = 'igrejas';
$nome = $_POST['nome'];
$endereco = $_POST['endereco'];
$telefone = $_POST['telefone'];
$pastor = @$_POST['pastor'];
$id = @$_POST['id'];


$query = $pdo->query("SELECT * FROM $pagina where nome = '$nome'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$id_reg = @$res[0]['id'];
if(@count($res) > 0 and $id_reg != $id){
	echo 'O Nome da Igreja já está cadastrado!';
	exit();
}



//SCRIPT PARA SUBIR FOTO NO BANCO
$nome_img = date('d-m-Y H:i:s') .'-'.@$_FILES['imagem']['name'];
$nome_img = preg_replace('/[ :]+/' , '-' , $nome_img);

$caminho = '../../img/igrejas/' .$nome_img;
if (@$_FILES['imagem']['name'] == ""){
	$imagem = "sem-foto.jpg";
}else{
	$imagem = $nome_img;
}

$imagem_temp = @$_FILES['imagem']['tmp_name']; 
$ext = pathinfo($imagem, PATHINFO_EXTENSION);   
if($ext == 'png' or $ext == 'jpg' or $ext == 'jpeg' or $ext == 'gif'){ 
	move_uploaded_file($imagem_temp, $caminho);
}else{
	echo 'Extensão de Imagem não permitida!';
	exit();
}



if($id == "" || $id == 0){
	$query = $pdo->prepare("INSERT INTO $pagina SET nome = :nome, telefone = :telefone, endereco = :endereco, imagem = '$imagem', data_cad = curDate(), matriz = 'Não', pastor = '$pastor'");

	$query->bindValue(":nome", "$nome");
	$query->bindValue(":telefone", "$telefone");
	$query->bindValue(":endereco", "$endereco");
	$query->execute();
	
}else{
	if($imagem == "sem-foto.jpg"){
		$query = $pdo->prepare("UPDATE $pagina SET nome = :nome, telefone = :telefone, endereco = :endereco, pastor = '$pastor' where id = '$id'");
	}else{

		$query = $pdo->query("SELECT * FROM $pagina where id = '$id'");
		$res = $query->fetchAll(PDO::FETCH_ASSOC);
		$foto = $res[0]['imagem'];
		if($foto != "sem-foto.jpg"){
			@unlink('../../img/igrejas/'.$foto);	
		}

		$query = $pdo->prepare("UPDATE $pagina SET nome = :nome, telefone = :telefone, endereco = :endereco, imagem = '$imagem', pastor = '$pastor' where id = '$id'");
	}
	


	$query->bindValue(":nome", "$nome");
	$query->bindValue(":telefone", "$telefone");
	$query->bindValue(":endereco", "$endereco");
	$query->execute();

	
}



echo 'Salvo com Sucesso';


?>