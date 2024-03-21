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
$nome_pag = 'eventos.php';

?>

<div class="container-wrap">
<div class="row" style="margin:10px">

				<?php 
						$query = $pdo->query("SELECT * FROM eventos where igreja = '$id_igreja' and ativo = 'Sim' and tipo = 'Evento' order by  data_evento desc, id desc LIMIT $limite, $itens_por_pagina");
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

						$data_eventoF = implode('/', array_reverse(explode('-', $data_evento)));

						if($data_evento >= date('Y-m-d')){
							$classe_data = 'text-primary';
							}else{
								$classe_data = 'text-danger';
							}


							//totalizar páginas
							$query_cont = $pdo->query("SELECT * FROM eventos where igreja = '$id_igreja' and ativo = 'Sim' and tipo = 'Evento'");
						$res_cont = $query_cont->fetchAll(PDO::FETCH_ASSOC);
						$total_cont = count($res_cont);
							$num_paginas = ceil($total_cont/$itens_por_pagina);

							?>

				<div class="col-md-4 animate-box" style="margin-bottom:35px">
					<div class="services">
						<a href="evento-<?php echo $url ?>" class="img-holder"><img class="img-responsive" src="sistema/img/eventos/<?php echo $imagem ?>" alt="<?php echo $titulo ?>"></a>
						<div class="desc">
							<h3><a href="evento-<?php echo $url ?>"><?php echo $titulo ?></a></h3>
							

							<span>
						<i class="bi bi-calendar-date <?php echo $classe_data ?> mr-1" style="margin-right:5px"></i><span>Data Evento: <?php echo $data_eventoF ?></span>
						</span>

						<span style="margin-left:15px">
							<a href="evento-<?php echo $url ?>">Veja Mais<i class="icon-arrow-right3"></i></a>
						</span>
						</div>
					</div>
				</div>

			<?php } } ?>

				
			</div>

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