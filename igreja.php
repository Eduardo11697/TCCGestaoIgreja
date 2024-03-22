<?php 

require_once("cabecalho.php"); 

?>

<div class="container-wrap">

	<?php 
	$query = $pdo->query("SELECT * FROM eventos where igreja = '$id_igreja' and ativo = 'Sim' and banner != 'sem-foto.jpg' order by id desc limit 4");
	$res = $query->fetchAll(PDO::FETCH_ASSOC);
	$total_reg = count($res);
	if($total_reg > 0){
		?>
		<aside id="fh5co-hero">
			<div class="flexslider">
				<ul class="slides">

					<?php 
					for($i=0; $i < $total_reg; $i++){
						foreach ($res[$i] as $key => $value){} 

							$titulo = $res[$i]['titulo'];
						$subtitulo = $res[$i]['subtitulo'];						
						$data_evento = $res[$i]['data_evento'];
						$id = $res[$i]['id'];
						$banner = $res[$i]['banner'];
						$url = $res[$i]['url'];
						$video = $res[$i]['video'];

						

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
												<h1><?php echo $titulo ?></h1>
												<h5 class="pcarac"><?php echo $subtitulo ?></h5>
												<p style="margin-top:10px">
													<a class="btn btn-primary btn-demo <?php echo $classe_video ?>" href="#" onclick="videoBanner('<?php echo $video ?>', '<?php echo $titulo ?>')"> <i class="icon-play4"></i> Ver Vídeo</a>

													<a class="btn btn-primary btn-learn" href="evento-<?php echo $url ?>">Veja Mais <i class="icon-arrow-right3"></i></a></p>
												</div>
											</div>
										</div>
									</div>
								</div>
							</li>

						<?php }  ?>

					</ul>
				</div>
			</aside>
		<?php } ?>
		<div id="fh5co-intro">
			<div class="row animate-box">
				<div class="col-md-12 col-md-offset-0 text-center">
					<h2>Vivendo na Maravilhosa Graça de Deus!</h2>
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
			</div>
		</div>
		<hr>
		<div id="fh5co-counter" class="fh5co-counters">
			
			<div class="row animate-box">
				<div class="col-md-8 col-md-offset-2">
					<div class="row">
						<div class="col-md-3 col-sm-6 col-xs-6 text-center">
							<span class="fh5co-counter js-counter" data-from="0" data-to="<?php echo $total_membros ?>" data-speed="1000" data-refresh-interval="50"></span>
							<span class="fh5co-counter-label">Membros</span>
						</div>
						<div class="col-md-3 col-sm-6 col-xs-6 text-center">
							<span class="fh5co-counter js-counter" data-from="0" data-to="<?php echo $total_igrejas ?>" data-speed="1000" data-refresh-interval="50"></span>
							<span class="fh5co-counter-label">Ministérios</span>
						</div>
						<div class="clearfix visible-sm-block visible-xs-block"></div>
						<div class="col-md-3 col-sm-6 col-xs-6 text-center">
							<span class="fh5co-counter js-counter" data-from="0" data-to="<?php echo $total_grupos ?>" data-speed="1000" data-refresh-interval="50"></span>
							<span class="fh5co-counter-label">Grupos</span>
						</div>
						<div class="col-md-3 col-sm-6 col-xs-6 text-center">
							<span class="fh5co-counter js-counter" data-from="0" data-to="<?php echo $total_celulas ?>" data-speed="1000" data-refresh-interval="50"></span>
							<span class="fh5co-counter-label">Células</span>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div id="fh5co-services" class="fh5co-light-grey">
			<div class="row animate-box">
				<div class="col-md-6 col-md-offset-3 text-center fh5co-heading">
					<h2>Eventos</h2>
					<p>Confira os próximos e os últimos eventos da nossa igreja! </p>
				</div>
			</div>
			<div class="row">

				<?php 
						$query = $pdo->query("SELECT * FROM eventos where igreja = '$id_igreja' and ativo = 'Sim' and tipo = 'Evento' order by  data_evento desc, id desc limit 3");
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

							?>

				<div class="col-md-4 animate-box">
					<div class="services">
						<a href="evento-<?php echo $url ?>" class="img-holder"><img class="img-responsive" src="sistema/img/eventos/<?php echo $imagem ?>" alt="<?php echo $titulo ?>"></a>
						<div class="desc">
							<h3><a href="evento-<?php echo $url ?>"><?php echo $titulo ?></a></h3>
							<p><?php echo $subtitulo ?></p>

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
		</div>

		<div id="fh5co-sermon">
			<div class="row animate-box">
				<div class="col-md-6 col-md-offset-3 text-center fh5co-heading">
					<h2>Pregações</h2>
					<p>Confira as últimas pregações!!</p>
				</div>
			</div>
			<div class="row">

				<?php 
						$query = $pdo->query("SELECT * FROM eventos where igreja = '$id_igreja' and ativo = 'Sim' and tipo = 'Pregação' order by data_evento desc, id desc limit 3");
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
						$data_evento = $res[$i]['data_evento'];

						$data_eventoF = implode('/', array_reverse(explode('-', $data_evento)));

						if($data_evento >= date('Y-m-d')){
							$classe_data = 'text-primary';
							}else{
								$classe_data = 'text-danger';
							}

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

				
			</div>
		</div>
		<div id="fh5co-bible-verse">
			<div class="overlay"></div>
			<div class="row">
				<div class="col-md-10 col-md-offset-1">
					<div class="row animate-box">
						<div class="owl-carousel owl-carousel-fullwidth">
							<div class="item">
								<div class="bible-verse-slide active text-center">
									<blockquote>
										<p>&ldquo;O amor é paciente, o amor é bondoso. Não inveja, não se vangloria, não se orgulha. Não maltrata, não procura seus interesses, não se ira facilmente, não guarda rancor. O amor não se alegra com a injustiça, mas se alegra com a verdade. Tudo sofre, tudo crê, tudo espera, tudo suporta.&rdquo;</p>
										<span>1 Coríntios 13:4-7</span>
									</blockquote>
								</div>
							</div>
							<div class="item">
								<div class="bible-verse-slide active text-center">
									<blockquote>
										<p>&ldquo;Não fui eu que ordenei a você? Seja forte e corajoso! Não se apavore nem desanime, pois o Senhor, o seu Deus, estará com você por onde você andar&rdquo;</p>
										<span>Josué 1:9</span>
									</blockquote>
								</div>
							</div>
							<div class="item">
								<div class="bible-verse-slide active text-center">
									<blockquote>
										<p>&ldquo;"Eu disse essas coisas para que em mim vocês tenham paz. Neste mundo vocês terão aflições; contudo, tenham ânimo! Eu venci o mundo".&rdquo;</p>
										<span>João 16:33</span>
									</blockquote>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	

		<div id="fh5co-news" class="fh5co-light-grey">
			<div class="row animate-box">
				<div class="col-md-6 col-md-offset-3 text-center fh5co-heading">
					<h2>Eventos Recentes</h2>
					
				</div>
			</div>
			<div class="row">
				<?php 
						$query = $pdo->query("SELECT * FROM eventos where igreja = '$id_igreja' and ativo = 'Sim' and tipo = 'Evento' and data_evento < curDate() order by  data_evento desc, id desc limit 4");
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

							?>

				<div class="col-md-3 animate-box">
					<div class="news">
						<a href="evento-<?php echo $url ?>" class="img-holder"><img class="img-responsive" src="sistema/img/eventos/<?php echo $imagem ?>" alt="Free HTML5 Website Template by freehtml5.co"></a>
						<div class="desc">
							<span class="date">Data: <?php echo $data_eventoF ?></span>
							<h3><a href="evento-<?php echo $url ?>"><?php echo $titulo ?></a></h3>
							
							<a href="evento-<?php echo $url ?>">Veja Mais <i class="icon-arrow-right3"></i></a>
						</div>
					</div>
				</div>

			<?php } } ?>
				
				
			</div>
		</div>
	</div><!-- END container-wrap -->

	
<?php 

require_once("rodape.php"); 

?>


<div class="modal fade" tabindex="-1" id="modalVideo">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title"><span id="tituloModal"><span id="nome-obs"></span></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<iframe id="video-dados" width="100%" height="400" src="" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
			</div>

		</div>
	</div>
</div>



<script type="text/javascript">
	function videoBanner(video, titulo){
		console.log(titulo)
		$('#nome-obs').text(titulo);
		$('#video-dados').attr('src', video);

		$('#modalVideo').modal('show');

		
	}
</script>





