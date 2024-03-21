<div class="container-wrap">
		<footer id="fh5co-footer" role="contentinfo">
			<div class="col-md-4 text-center">
				<h3><?php echo $endereco_igreja ?></h3>
				<h3><?php echo $telefone_igreja ?></h3>
			</div>
			<div class="col-md-4 text-center">
				<h2><a href="#">Cultos</a></h2>
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

							<span style="margin-right:10px"><i class="bi bi-check text-light mr-1"></i><?php echo $dia ?> <?php echo $hora ?> </span><br>

						<?php } } ?>
			</div>
			<div class="col-md-4 text-center">
				<p>
					<ul class="fh5co-social-icons">
						<?php if($youtube != ""){ ?>
						<li><a href="<?php echo $youtube ?>" target="_blank"><i class="icon-youtube2"></i></a></li>
						<?php } ?>
						<?php if($facebook != ""){ ?>
						<li><a href="<?php echo $facebook ?>" target="_blank"><i class="icon-facebook2"></i></a></li>
						<?php } ?>
						<?php if($instagram != ""){ ?>
						<li><a href="<?php echo $instagram ?>" target="_blank"><i class="icon-instagram"></i></a></li>
						<?php } ?>
					</ul>
				</p>
			</div>
			<div class="row copyright">
				<div class="col-md-12 text-center">
					
				</div>
			</div>
		</footer>
	</div><!-- END container-wrap -->
</div>

<div class="gototop js-top">
	<a href="#" class="js-gotop"><i class="icon-arrow-up2"></i></a>
</div>

<!-- jQuery -->
<script src="js/jquery.min.js"></script>
<!-- jQuery Easing -->
<script src="js/jquery.easing.1.3.js"></script>
<!-- Bootstrap -->
<script src="js/bootstrap.min.js"></script>
<!-- Waypoints -->
<script src="js/jquery.waypoints.min.js"></script>
<!-- Flexslider -->
<script src="js/jquery.flexslider-min.js"></script>
<!-- Carousel -->
<script src="js/owl.carousel.min.js"></script>
<!-- Magnific Popup -->
<script src="js/jquery.magnific-popup.min.js"></script>
<script src="js/magnific-popup-options.js"></script>
<!-- Counters -->
<script src="js/jquery.countTo.js"></script>
<!-- Main -->
<script src="js/main.js"></script>

</body>
</html>


