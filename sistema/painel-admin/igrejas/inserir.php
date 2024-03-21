<?php
require_once("../../conexao.php");
$pagina = 'igrejas';
$nome = $_POST['nome'];
$endereco = $_POST['endereco'];
$telefone = $_POST['telefone'];
$pastor = @$_POST['pastor'];
$video = @$_POST['video'];
$email = @$_POST['email'];
$url = @$_POST['url'];
$youtube = @$_POST['youtube'];
$instagram = @$_POST['instagram'];
$facebook = @$_POST['facebook'];
$id = @$_POST['id'];


$nome_novo = strtolower( preg_replace("[^a-zA-Z0-9-]", "-", 
        strtr(utf8_decode(trim($url)), utf8_decode("/áàãâéêíóôõúüñçÁÀÃÂÉÊÍÓÔÕÚÜÑÇ"),
        "-aaaaeeiooouuncAAAAEEIOOOUUNC-")) );
$nome_url = preg_replace('/[ -]+/' , '-' , $nome_novo);


$query = $pdo->query("SELECT * FROM $pagina where nome = '$nome'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$id_reg = @$res[0]['id'];
if(@count($res) > 0 and $id_reg != $id){
	echo 'O Nome da Igreja já está cadastrado!';
	exit();
}

$query = $pdo->query("SELECT * FROM $pagina where email = '$email'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$id_reg = @$res[0]['id'];
if(@count($res) > 0 and $id_reg != $id){
	echo 'O Email da Igreja já está cadastrado!';
	exit();
}


$query = $pdo->query("SELECT * FROM $pagina where url = '$url'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$id_reg = @$res[0]['id'];
if(@count($res) > 0 and $id_reg != $id){
	echo 'A url já está Cadastrada, escolha outra!';
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
if($ext == 'png' or $ext == 'jpg' or $ext == 'JPG' or $ext == 'jpeg' or $ext == 'gif'){ 
	move_uploaded_file($imagem_temp, $caminho);
}else{
	echo 'Extensão de Imagem não permitida!';
	exit();
}



if($id == "" || $id == 0){
	$query = $pdo->prepare("INSERT INTO $pagina SET nome = :nome, telefone = :telefone, endereco = :endereco, imagem = '$imagem', data_cad = curDate(), matriz = 'Não', pastor = '$pastor', logo_rel = 'sem-foto.jpg', cab_rel = 'sem-foto.jpg', carteirinha_rel = 'sem-foto.jpg', video = :video, email = :email, url = :url, youtube = :youtube, instagram = :instagram, facebook = :facebook");


}else{
	if($imagem == "sem-foto.jpg"){
		$query = $pdo->prepare("UPDATE $pagina SET nome = :nome, telefone = :telefone, endereco = :endereco, pastor = '$pastor', video = :video, email = :email, url = :url, youtube = :youtube, instagram = :instagram, facebook = :facebook where id = '$id'");
	}else{

		$query = $pdo->query("SELECT * FROM $pagina where id = '$id'");
		$res = $query->fetchAll(PDO::FETCH_ASSOC);
		$foto = $res[0]['imagem'];
		if($foto != "sem-foto.jpg"){
			@unlink('../../img/igrejas/'.$foto);	
		}

		$query = $pdo->prepare("UPDATE $pagina SET nome = :nome, telefone = :telefone, endereco = :endereco, imagem = '$imagem', pastor = '$pastor', video = :video, email = :email, url = :url, youtube = :youtube, instagram = :instagram, facebook = :facebook where id = '$id'");
	}
	

	
}


	$query->bindValue(":nome", "$nome");
	$query->bindValue(":telefone", "$telefone");
	$query->bindValue(":endereco", "$endereco");
	$query->bindValue(":video", "$video");
	$query->bindValue(":email", "$email");
	$query->bindValue(":url", "$nome_url");
	$query->bindValue(":youtube", "$youtube");
	$query->bindValue(":instagram", "$instagram");
	$query->bindValue(":facebook", "$facebook");
	$query->execute();

echo 'Salvo com Sucesso';


?>