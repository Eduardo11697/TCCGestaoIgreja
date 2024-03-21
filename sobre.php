<?php 

require_once("cabecalho.php"); 

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
<div class="row" style="margin:10px">

<div class="col-md-12 col-md-offset-0 text-center" style="margin-top:20px">
					<h3>Pastor Responsável <?php echo $pastor_resp ?></h3>
						Cultos: 
						<?php 
						$query = $pdo->query("SELECT * FROM cultos where igreja = '$id_igreja'");
						$res = $query->fetchAll(PDO::FETCH_ASSOC);
						$total_reg = count($res);
						if($total_reg > 0){
							for($i=0; $i < $total_reg; $i++){
								foreach ($res[$i] as $key => $value){} 

									$dia = $res[$i]['dia'];
									$hora = $res[$i]['hora'];
									$hora = (new DateTime($hora))->format('H:i');
							?>

							<span style="margin-right:10px"><i class="bi bi-check text-success mr-1"></i><?php echo $dia ?> <?php echo $hora ?> </span>

						<?php } } ?>
						
					
				</div>

					<iframe id="video-dados" width="100%" height="500" src="<?php echo $video_igreja ?>" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>

</div>


<?php 

require_once("rodape.php"); 

?>