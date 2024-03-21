<?php
require_once("../conexao.php");
$nome = $_POST['nome_usu'];
$cpf = $_POST['cpf_usu'];
$senha = $_POST['senha_usu'];
$email = $_POST['email_usu'];
$id = $_POST['id_usu'];

$query = $pdo->query("SELECT * FROM usuarios where id = $id");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$cpf_antigo = $res[0]['cpf'];
$email_antigo = $res[0]['email'];
$nivel_usu = $res[0]['nivel'];
$id_pessoa = $res[0]['id_pessoa'];

if($cpf_antigo != $cpf){
	$query = $pdo->query("SELECT * FROM usuarios where cpf = '$cpf'");
	$res = $query->fetchAll(PDO::FETCH_ASSOC);
	
	if(@count($res) > 0){
		echo 'O CPF já está cadastrado!';
		exit();
	}
}


if($email_antigo != $email){
	$query = $pdo->query("SELECT * FROM usuarios where email = '$email'");
	$res = $query->fetchAll(PDO::FETCH_ASSOC);
	
	if(@count($res) > 0){
		echo 'O Email já está cadastrado!';
		exit();
	}
}



//SCRIPT PARA SUBIR FOTO NO BANCO
$nome_img = date('d-m-Y H:i:s') .'-'.@$_FILES['imagem']['name'];
$nome_img = preg_replace('/[ :]+/' , '-' , $nome_img);

$caminho = '../img/membros/' .$nome_img;
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


if($imagem == "sem-foto.jpg"){
$query = $pdo->prepare("UPDATE usuarios SET nome = :nome, email = :email, cpf = :cpf, senha = :senha where id = '$id'");
}else{

	$query = $pdo->query("SELECT * FROM usuarios where id = '$id'");
		$res = $query->fetchAll(PDO::FETCH_ASSOC);
		$foto = $res[0]['foto'];
		if($foto != "sem-foto.jpg"){
			@unlink('../../img/membros/'.$foto);	
		}

	$query = $pdo->prepare("UPDATE usuarios SET nome = :nome, email = :email, cpf = :cpf, senha = :senha, foto = '$imagem' where id = '$id'");
}

$query->bindValue(":nome", "$nome");
$query->bindValue(":email", "$email");
$query->bindValue(":cpf", "$cpf");
$query->bindValue(":senha", "$senha");


if($nivel_usu == 'bispo'){
	$nome_tab = 'bispos';
}else if($nivel_usu == 'pastor'){
	$nome_tab = 'pastores';
}else if($nivel_usu == 'tesoureiro'){
	$nome_tab = 'tesoureiros';
}else if($nivel_usu == 'secretario'){
	$nome_tab = 'secretarios';
}


if($imagem == "sem-foto.jpg"){
		$query2 = $pdo->prepare("UPDATE $nome_tab SET nome = :nome, email = :email, cpf = :cpf where id = '$id_pessoa'");
	}else{
		$query2 = $pdo->prepare("UPDATE $nome_tab SET nome = :nome, email = :email, cpf = :cpf, foto = '$imagem' where id = '$id_pessoa'");
}



$query2->bindValue(":nome", "$nome");
$query2->bindValue(":email", "$email");
$query2->bindValue(":cpf", "$cpf");
$query2->execute();

if($query2->rowCount() > 0){
	$query->execute();
	echo 'Salvo com Sucesso';
}else{
	echo 'Deu Erro, não possível atualizar o registro, tente novamente!';
}

 ?>