<?php
require_once("../../conexao.php");
@session_start();
$id_usuario = @$_SESSION['id_usuario'];
$pagina = 'pagar';
$descricao = $_POST['descricao'];
$fornecedor = $_POST['fornecedor'];
$valor = $_POST['valor'];
$vencimento = $_POST['vencimento'];
$frequencia = $_POST['frequencia'];
$igreja = $_POST['igreja'];

$valor = str_replace(',', '.', $valor);

$id = @$_POST['id'];


//SCRIPT PARA SUBIR FOTO NO BANCO
$nome_img = date('d-m-Y H:i:s') .'-'.@$_FILES['imagem']['name'];
$nome_img = preg_replace('/[ :]+/' , '-' , $nome_img);

$caminho = '../../img/contas/' .$nome_img;
if (@$_FILES['imagem']['name'] == ""){
	$imagem = "sem-foto.jpg";
}else{
	$imagem = $nome_img;
}

$imagem_temp = @$_FILES['imagem']['tmp_name']; 
$ext = pathinfo($imagem, PATHINFO_EXTENSION);   
if($ext == 'png' or $ext == 'jpg' or $ext == 'jpeg' or $ext == 'gif' or $ext == 'pdf' or $ext == 'rar' or $ext == 'zip'){ 
	move_uploaded_file($imagem_temp, $caminho);
}else{
	echo 'Extensão de Imagem não permitida!';
	exit();
}



if($id == "" || $id == 0){
	$query = $pdo->prepare("INSERT INTO $pagina SET descricao = :descricao, fornecedor = :fornecedor, valor = :valor, data = curDate(), vencimento = :vencimento, usuario_cad = '$id_usuario', pago = 'Não', igreja = '$igreja', frequencia = :frequencia, arquivo = '$imagem'");

}else{
	if($imagem == "sem-foto.jpg"){
		$query = $pdo->prepare("UPDATE $pagina SET descricao = :descricao, fornecedor = :fornecedor, valor = :valor, vencimento = :vencimento, frequencia = :frequencia where id = '$id'");
	}else{

		$query = $pdo->query("SELECT * FROM $pagina where id = '$id'");
		$res = $query->fetchAll(PDO::FETCH_ASSOC);
		$foto = $res[0]['arquivo'];
		if($foto != "sem-foto.jpg"){
			@unlink('../../img/contas/'.$foto);	
		}

		$query = $pdo->prepare("UPDATE $pagina SET descricao = :descricao, fornecedor = :fornecedor, valor = :valor, vencimento = :vencimento, frequencia = :frequencia, arquivo = '$imagem' where id = '$id'");
	}
	

}



	$query->bindValue(":descricao", "$descricao");
	$query->bindValue(":fornecedor", "$fornecedor");
	$query->bindValue(":valor", "$valor");
	$query->bindValue(":frequencia", "$frequencia");
	$query->bindValue(":vencimento", "$vencimento");
	$query->execute();


echo 'Salvo com Sucesso';


?>