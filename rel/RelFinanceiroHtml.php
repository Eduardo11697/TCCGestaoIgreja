<?php 
require_once("../conexao.php"); 

$igreja = $_GET['igreja'];
$tipo = $_GET['tipo'];
$dataInicial = $_GET['dataInicial'];
$dataFinal = $_GET['dataFinal'];
$movimento = $_GET['movimento'];

if($movimento == 'Conta'){
	$movimento = 'Conta à Pagar';
}

$dataInicialF = implode('/', array_reverse(explode('-', $dataInicial)));
$dataFinalF = implode('/', array_reverse(explode('-', $dataFinal)));

if($dataInicial == $dataFinal){
	$texto_apuracao = 'APURADO EM '.$dataInicialF;
}else if($dataInicial == '1980-01-01'){
	$texto_apuracao = 'APURADO EM TODO O PERÍODO';
}else{
	$texto_apuracao = 'APURAÇÃO DE '.$dataInicialF. ' ATÉ '.$dataFinalF;
}


$query = $pdo->query("SELECT * FROM igrejas where id = '$igreja'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$nome_igreja = $res[0]['nome'];
$tel_igreja = $res[0]['telefone'];
$end_igreja = $res[0]['endereco'];
$imagem_igreja = $res[0]['imagem'];
$pastor_igreja = $res[0]['pastor'];

//EXTRAIR EXTENSÃO DO ARQUIVO
$ext = pathinfo($imagem_igreja, PATHINFO_EXTENSION);   
if($ext == 'jpg'){ 
	$imagem_igreja = $imagem_igreja;

}else{
	$imagem_igreja = 'logo-rel.jpg';
}

$query = $pdo->query("SELECT * FROM pastores where id = '$pastor_igreja'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$nome_pastor = $res[0]['nome'];



if($tipo == 'Entrada'){
	$tipo_rel = ' de Entradas';
}else if($tipo == 'Saída'){
	$tipo_rel = ' de Saídas';
}else{
	$tipo_rel = '';
}


if($movimento == 'Conta à Pagar'){
	$movimento_rel = 'Contas à Pagar';
}else if($movimento == 'Dízimo'){
	$movimento_rel = 'Dízimos';
}else if($movimento == 'Oferta'){
	$movimento_rel = 'Ofertas';
}else if($movimento == 'Doação'){
	$movimento_rel = 'Doações';
}else if($movimento == 'Venda'){
	$movimento_rel = 'Vendas';
}else{
	$movimento_rel = '';
}


if($movimento == ''){
	$titulo_rel = 'Relatório de Movimentações'. $tipo_rel;
}else{
	$titulo_rel = 'Relatório de '.$movimento;
}


if($movimento == 'Conta à Pagar' || $tipo == 'Saída' ){
	$classe_total = 'text-danger';
}else{
	$classe_total = 'text-success';
}



$tipo = '%'.$tipo.'%';
$movimento = '%'.$movimento.'%';





setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
date_default_timezone_set('America/Sao_Paulo');
$data_hoje = utf8_encode(strftime('%A, %d de %B de %Y', strtotime('today')));



?>

<!DOCTYPE html>
<html>
<head>
	<title>Relatório Financeiro</title>
	<link rel="shortcut icon" href="../img/favicon.ico" />

	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-wEmeIV1mKuiNpC+IOBjI7aAzPcEZeedi5yW5f2yOq55WWLwNGmvvx4Um1vskeMj0" crossorigin="anonymous">


	<style>

		@page {
			margin: 0px;

		}

		body{
			margin-top:0px;
			font-family:Times, "Times New Roman", Georgia, serif;
		}


		<?php if($relatorio_pdf == 'Sim'){ ?>

			.footer {
				margin-top:20px;
				width:100%;
				background-color: #ebebeb;
				padding:5px;
				position:absolute;
				bottom:0;
			}

		<?php }else{ ?>
			.footer {
				margin-top:20px;
				width:100%;
				background-color: #ebebeb;
				padding:5px;

			}

		<?php } ?>

		.cabecalho {    
			padding:10px;
			margin-bottom:30px;
			width:100%;
			font-family:Times, "Times New Roman", Georgia, serif;
		}

		.titulo_cab{
			color:#0340a3;
			font-size:17px;
		}

		
		
		.titulo{
			margin:0;
			font-size:28px;
			font-family:Arial, Helvetica, sans-serif;
			color:#6e6d6d;

		}

		.subtitulo{
			margin:0;
			font-size:12px;
			font-family:Arial, Helvetica, sans-serif;
			color:#6e6d6d;
		}



		hr{
			margin:8px;
			padding:0px;
		}


		
		.area-cab{
			
			display:block;
			width:100%;
			height:10px;

		}

		
		.coluna{
			margin: 0px;
			float:left;
			height:30px;
		}

		.area-tab{
			
			display:block;
			width:100%;
			height:30px;

		}



		

	</style>


</head>
<body>

	<section class="area-cab">
		<div class="cabecalho">
			<div class="coluna titulo_cab" style="width:50%"> <u><?php echo $titulo_rel ?></u></div>
			<div align="right" class="coluna" style="width:50%"> <img style="margin-top:5px" src="<?php echo $url_sistema ?>img/igrejas/<?php echo $imagem_igreja ?>" width="30px"> <?php echo mb_strtoupper($nome_igreja) ?></div>
		</div>
	</section>

	<br>

	<section class="area-cab">
		<div class="cabecalho">
			<div class="coluna" style="width:60%"><small> <small><small><?php echo mb_strtoupper($data_hoje) ?></small></small></small></div>
			<div align="right" class="coluna" style="width:40%"><small> <small><small> <?php echo $end_igreja ?></small></small></small></div>
		</div>
	</section>

	<br>
	<div class="cabecalho" style="border-bottom: solid 1px #0340a3">
	</div>

	<div class="mx-2" style="padding-top:10px ">

		<section class="area-cab">
			
			<div class="coluna" style="width:50%">
				<small><small><small><u><?php echo $texto_apuracao ?></u></small></small></small>
			</div>

			<div class="coluna" style="width:50%" align="right">
				<small><small><small>
					<span class="mx-4"><img src="<?php echo $url_sistema ?>img/verde.jpg" width="8px" style="margin-top:6px"> Entradas </span>
					<span class="mx-4"><img src="<?php echo $url_sistema ?>img/vermelho.jpg" width="8px" style="margin-top:6px"> Saídas </span>

				</small></small></small>
			</div>

		</section>

		<br>

		<?php 
		$query = $pdo->query("SELECT * FROM movimentacoes where igreja = '$igreja' and tipo LIKE '$tipo' and movimento LIKE '$movimento' and data >= '$dataInicial' and data <= '$dataFinal' order by data asc, id asc");
		$res = $query->fetchAll(PDO::FETCH_ASSOC);
		$total_reg = count($res);

		$total = 0;
				$entradas = 0;
				$saidas = 0;
				$saldo = 0;
				
		if($total_reg > 0){
			?>



			<small><small>
				<section class="area-tab" style="background-color: #f5f5f5;">
					
					<div class="linha-cab" style="padding-top: 5px;">
						<div class="coluna" style="width:20%">MOVIMENTO</div>
						<div class="coluna" style="width:30%">DESCRIÇÃO</div>
						<div class="coluna" style="width:15%">VALOR</div>
						<div class="coluna" style="width:15%">DATA</div>
						<div class="coluna" style="width:20%">USUÁRIO</div>
						
					</div>
					
				</section><small></small>

				<div class="cabecalho mb-1" style="border-bottom: solid 1px #e3e3e3;">
				</div>

				<?php
				
				for($i=0; $i < $total_reg; $i++){
					foreach ($res[$i] as $key => $value){}
						$usuario = $res[$i]['usuario'];
					$tipo = $res[$i]['tipo'];

					$query_con = $pdo->query("SELECT * FROM usuarios where id = '$usuario'");
					$res_con = $query_con->fetchAll(PDO::FETCH_ASSOC);
					if(count($res_con) > 0){
						$nome_usuario= $res_con[0]['nome'];
					}else{
						$nome_usuario = '';
					}

					
					if($tipo == "Entrada"){
						$classe_item = 'verde.jpg';
						$classe_valor = 'text-success';
						$entradas += $res[$i]['valor'];
					}else{
						$classe_item = 'vermelho.jpg';
						$classe_valor = 'text-danger';
						$saidas += $res[$i]['valor'];
					}

					$total += $res[$i]['valor'];
					$saldo = $entradas - $saidas;

					if($saldo >= 0){
						$classe_saldo = 'text-success';
					}else{
						$classe_saldo = 'text-danger';
					}
					
					?>

					<section class="area-tab" style="padding-top:5px">					
						<div class="linha-cab">				
							<div class="coluna" style="width:20%">
								<span class=""><img src="<?php echo $url_sistema ?>img/<?php echo $classe_item ?>" width="9px" style="margin-top:4px"> </span>
								<?php echo $res[$i]['movimento'] ?></div>

								<div class="coluna" style="width:30%"><?php echo $res[$i]['descricao'] ?></div>

								<div class="coluna <?php echo $classe_valor ?>" style="width:15%">R$ <?php echo number_format($res[$i]['valor'], 2, ',', '.'); ?></div>

								<div class="coluna" style="width:15%"><?php echo implode('/', array_reverse(explode('-', $res[$i]['data']))) ?></div>



								<div class="coluna" style="width:20%"><?php echo $nome_usuario ?></div>		


							</div>
						</section>
						<div class="cabecalho" style="border-bottom: solid 1px #e3e3e3;">
						</div>

					<?php } ?>

				</small>



			</div>


			<div class="cabecalho mt-3" style="border-bottom: solid 1px #0340a3">
			</div>


		<?php }else{
			echo '<div style="margin:8px"><small><small>Sem Registros no banco de dados!</small></small></div>';
		} ?>


		<?php if($movimento != "%%"){ ?>

		<div class="col-md-12 p-2">
			<div class="" align="right">
				<small><small>TOTAL R$ <span class="<?php echo $classe_total ?>"> <?php echo number_format($total, 2, ',', '.'); ?></span></small></small>  
			</div>
		</div>
		<div class="cabecalho" style="border-bottom: solid 1px #0340a3">
		</div>

	<?php }else{ ?>

		<div class="col-md-12 p-2">
			<div class="" align="right">
				<span class="mx-4"><small><small>ENTRADAS R$ <span class="text-success"> <?php echo number_format(@$entradas, 2, ',', '.'); ?></span></small></small> </span>  / 

				<span class="mx-4"><small><small>SAÍDAS R$ <span class="text-danger"> <?php echo number_format(@$saidas, 2, ',', '.'); ?></span></small></small> </span> 

				&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;

				<span class="mx-4"><small><small>SALDO R$ <span class="<?php echo $classe_saldo ?>"> <?php echo number_format(@$saldo, 2, ',', '.'); ?></span></small></small> </span> 
			</div>
		</div>
		<div class="cabecalho" style="border-bottom: solid 1px #0340a3">
		</div>

	<?php } ?>


	




		<div class="footer"  align="center">
			<span style="font-size:10px"><?php echo $end_igreja ?> - Telefone: <?php echo $tel_igreja ?> - Pastor Responsável: <?php echo $nome_pastor ?></span> 
		</div>



	</body>
	</html>