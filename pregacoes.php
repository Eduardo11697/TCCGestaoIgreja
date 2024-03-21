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


				<?php 
						$query = $pdo->query("SELECT * FROM eventos where igreja = '$id_igreja' and ativo = 'Sim' and tipo = 'Pregação' order by  data_evento desc, id desc LIMIT $limite, $itens_por_pagina");
						$res = $query->fetchAll(PDO::FETCH_ASSOC);
						$total_reg = count($res);

						
						if($total_reg > 0){
							for($i=0; $i < $total_reg; $i++){
								foreach ($res[$i] as $key => $value){} 

									$titulo = $res[$i]['titulo'];
						$subtitulo = $res[$i]['subtitulo'];						
						$data_evento = $res[$i]['data_evento'];
						$id = $res[$i]['id'];
						$imagem = $res[$i]['imagem'];
						$url = $res[$i]['url'];
						$video = $res[$i]['video'];
						$pregador = $res[$i]['pregador'];

						$data_eventoF = implode('/', array_reverse(explode('-', $data_evento)));

						if($data_evento >= date('Y-m-d')){
							$classe_data = 'text-primary';
							}else{
								$classe_data = 'text-danger';
							}


							//totalizar páginas
							$query_cont = $pdo->query("SELECT * FROM eventos where igreja = '$id_igreja' and ativo = 'Sim' and tipo = 'Pregação'");
						$res_cont = $query_cont->fetchAll(PDO::FETCH_ASSOC);
						$total_cont = count($res_cont);
							$num_paginas = ceil($total_cont/$itens_por_pagina);

							?>

				<div class="col-md-4 text-center animate-box">
					<div class="sermon-entry">
						<div class="sermon" style="background-image: url(images/sermon-1.jpg);">
							<div class="play">
								<iframe width="100%" height="250" src="<?php echo $video ?>" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
							</div>
						</div>
						<h3><a href="evento-<?php echo $url ?>"><?php echo $titulo ?></a></h3>
						<span style="margin-left:15px">
						<i class="bi bi-person mr-1"></i><span><?php echo $pregador ?></span>
						</span>

						<span style="margin-left:15px">
						<i class="bi bi-calendar-date <?php echo $classe_data ?> mr-1" style="margin-right:5px"></i><span><?php echo $data_eventoF ?></span>
						</span>
					</div>
				</div>

			<?php } } ?>

				
			

			<small>
			 <div style="margin:10px">
                <a class="btn btn-primary" href="<?php echo $nome_pag ?>?pagina=0"><i class="bi bi-skip-backward-fill"></i></a>

                <?php 
                    for($i = 0; $i < @$num_paginas; $i++){
                        
                        if($pagina == $i){
                            $estilo = 'btn-danger';
                        }else{
                        	$estilo = 'btn-primary';
                        }

                        if($pagina >= ($i - 2) && $pagina <= ($i + 2)){ ?>
                         <a class="btn <?php echo $estilo ?>"  href="<?php echo $nome_pag ?>?pagina=<?php echo $i ?>"><?php echo $i + 1 ?></a>

                       <?php } 

                    }
                 ?>
                
                
                <a class="btn btn-primary" href="<?php echo $nome_pag ?>?pagina=<?php echo $num_paginas - 1 ?>"><i class="bi bi-skip-forward-fill"></i></a>
            </div>
        </small>

</div>

<?php 

require_once("rodape.php"); 

?>