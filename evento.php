<?php 

require_once("cabecalho.php"); 

$url = @$_GET['evento'];

//PEGAR PAGINA ATUAL PARA PAGINAÇAO
if(@$_GET['pagina'] != null){
    $pag = $_GET['pagina'];
}else{
    $pag = 0;
}

$limite = $pag * @$itens_por_pagina;
$pagina = $pag;
$nome_pag = 'pregacoes.php';

?>

<div class="container-wrap">

<?php 
$query = $pdo->query("SELECT * FROM eventos where igreja = '$id_igreja' and url = '$url' ");
	$res = $query->fetchAll(PDO::FETCH_ASSOC);
	$total_reg = count($res);
	if($total_reg > 0){
 ?>

<aside id="fh5co-hero">
			<div class="flexslider">
				<ul class="slides">

					<?php 
					
					
						$titulo = $res[0]['titulo'];
						$subtitulo = $res[0]['subtitulo'];						
						$data_evento = $res[0]['data_evento'];
						$id = $res[0]['id'];
						$banner = $res[0]['banner'];
						$url = $res[0]['url'];
						$video = $res[0]['video'];
						$pregador = $res[0]['pregador'];
						$descricao1 = $res[0]['descricao1'];
						$descricao2 = $res[0]['descricao2'];
						$descricao3 = $res[0]['descricao3'];
						$imagem = $res[0]['imagem'];

						$data_eventoF = implode('/', array_reverse(explode('-', $data_evento)));


						if($video != ''){
							$classe_video = '';
						}else{
							$classe_video = 'd-none';
						}

						?>


						<li style="background-image: url(sistema/img/eventos/<?php echo $banner ?>);">
							<div class="overlay"></div>
							<div class="container-fluid">
								<div class="row">
									<div class="col-md-6 col-md-offset-3 text-center">
										<div class="slider-text">
											<div class="slider-text-inner">
												<h1><?php echo $titulo ?> </h1>
												<span style="color:#FFF"><?php echo $subtitulo ?></span>
												<h2 style="margin-top:10px">Dia <?php echo $data_eventoF ?></h2>

												<?php if($pregador != ""){ ?>
												<p style="margin-top:8px; color:#FFF"><u>PREGADOR: <?php echo mb_strtoupper($pregador) ?></u></p>
												<?php } ?>
												
												</div>
											</div>
										</div>
									</div>
								</div>
							</li>

						

					</ul>
				</div>
			</aside>


			<div class="row" style="padding:20px;">

				<?php if($descricao1 != ""){ ?>
				<div class="col-md-6" style="margin-top:25px">
					<p><?php echo $descricao1 ?></p>
				</div>
				<?php } ?>

				<?php if($video != ""){ ?>
				<div class="col-md-6" style="margin-top:25px">
					<iframe id="video-dados" width="100%" height="300" src="<?php echo $video ?>" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
				</div>
				<?php }else{ 
				if($imagem != ""){
					?>
					<div class="col-md-6" style="margin-top:25px">
					<img src="sistema/img/eventos/<?php echo $imagem ?>" width="100%">
					</div>
				<?php } } ?>

				

				<?php if($descricao2 != ""){ ?>
				<div class="col-md-12" style="margin-top:25px">
					<p><?php echo $descricao2 ?></p>
				</div>
				<?php } ?>

				<?php if($descricao3 != ""){ ?>
				<div class="col-md-12" style="margin-top:25px">
					<p><?php echo $descricao3 ?></p>
				</div>
				<?php } ?>

			</div>


<?php }  ?>

</div>

<?php 

require_once("rodape.php"); 

?>