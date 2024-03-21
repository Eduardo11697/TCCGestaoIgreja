<?php 
require_once("../conexao.php"); 

$id = $_GET['id'];

$nome_sede = $nome_igreja_sistema;

$query = $pdo->query("SELECT * FROM membros where id = '$id'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$nome = $res[0]['nome'];
$igreja = $res[0]['igreja'];
$cpf = $res[0]['cpf'];
$foto = $res[0]['foto'];
$data_nasc = $res[0]['data_nasc'];
$cargo = $res[0]['cargo'];

$query = $pdo->query("SELECT * FROM igrejas where id = '$igreja'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$nome_igreja = $res[0]['nome'];
$tel_igreja = $res[0]['telefone'];
$end_igreja = $res[0]['endereco'];
$imagem_igreja = $res[0]['imagem'];
$pastor_igreja = $res[0]['pastor'];
$logo_rel = $res[0]['logo_rel'];
$cart_rel = $res[0]['carteirinha_rel'];


if($logo_rel != 'sem-foto.jpg'){ 
	$imagem_igreja = $logo_rel;

}else{
	$imagem_igreja = 'logo-rel.jpg';
}


if($cart_rel != 'sem-foto.jpg'){ 
	$imagem_carteirinha = $cart_rel;

}else{
	$imagem_carteirinha = 'carteirinha-cab.jpg';
}

$dados_igreja = $end_igreja . ' '.$tel_igreja;




$query = $pdo->query("SELECT * FROM cargos where id = '$cargo'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$nome_cargo = $res[0]['nome'];


$data_nasc = implode('/', array_reverse(explode('-', $data_nasc)));
$data_hoje = 'Emitida em: '. implode('/', array_reverse(explode('-', date('Y-m-d'))));
?>

<!DOCTYPE html>
<html>
<head>
	<title>Carteirinha do Membro</title>
	<link rel="shortcut icon" href="../img/favicon.ico" />

	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-wEmeIV1mKuiNpC+IOBjI7aAzPcEZeedi5yW5f2yOq55WWLwNGmvvx4Um1vskeMj0" crossorigin="anonymous">

	
	<style>

 @page {
            margin: 0px;
            
        }


.imagem {
width: 99%;
}


.imagem-igreja {
position: absolute;
margin-top: 5px;
width:60px;
margin-left: 10px;
}	

.nome-membro {
position: absolute;
margin-top: 52px;
margin-left: 95px;
color:#913610;
font-size:9px;
width:100%;

}


.imagem-membro {
width:100%;
height:100%;
border-radius:7px;
}	

.area-foto{
position: absolute;
margin-top: 75px;
width:65px;
height:78px;
margin-left: 15px;
border-radius:7px;
}

.nome-sede {
position: absolute;
margin-top: 9px;
margin-left: 95px;
color:#545454;
font-size:11px;
width:100%;

}


.dados-igreja {
position: absolute;
margin-top: 24px;
margin-left: 95px;
color:#545454;
font-size:5px;
width:100%;

}


.data-atual {
position: absolute;
margin-top: 154px;
margin-left: 20px;
color:#545454;
font-size:5px;
width:100%;

}


.cargo {
position: absolute;
margin-top: 84px;
margin-left: 95px;
color:#545454;
font-size:8px;
width:100%;

}


.congregacao {
position: absolute;
margin-top: 113px;
margin-left: 95px;
color:#545454;
font-size:8px;
width:100%;

}


.nascimento {
position: absolute;
margin-top: 143px;
margin-left: 95px;
color:#545454;
font-size:8px;
width:100%;

}


.cpf {
position: absolute;
margin-top: 143px;
margin-left: 240px;
color:#545454;
font-size:8px;
width:100%;
}





</style>


<body>


<div class="congregacao"> <?php echo mb_strtoupper($nome_igreja); ?></div>
<div class="nome-membro"> <?php echo mb_strtoupper($nome); ?></div>
<div class="cargo"> <?php echo mb_strtoupper($nome_cargo); ?></div>
<div class="nascimento"> <?php echo $data_nasc; ?></div>
<div class="cpf"><?php echo $cpf; ?> </div>
<div class="data-atual"><?php echo $data_hoje; ?> </div>

<div class="area-foto">
<img class="imagem-membro" src="<?php echo $url_sistema ?>img/membros/<?php echo $foto ?>">
</div>


<?php if($cabecalho_rel_img != 'Sim'){ ?>
<div class="nome-sede"> <?php echo mb_strtoupper($nome_igreja); ?></div>
<div class="dados-igreja"> <?php echo $dados_igreja; ?></div>
<img class="imagem-igreja" src="<?php echo $url_sistema ?>img/igrejas/<?php echo $imagem_igreja ?>">
<img class="imagem" src="<?php echo $url_sistema ?>img/carteirinha.jpeg">
<?php }else{ ?>
<img class="imagem" src="<?php echo $url_sistema ?>img/igrejas/<?php echo $imagem_carteirinha ?>">
<?php } ?>


</body>


</html>