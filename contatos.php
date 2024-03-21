<?php 

require_once("cabecalho.php"); 
?>

<div class="container-wrap">
<div class="row" style="margin:10px">

<div class="container-wrap">
		
		<div id="fh5co-contact">
			<div class="row animate-box">
				<div class="col-md-6 col-md-offset-3 text-center fh5co-heading">
					<h2>Contate-nos</h2>
					
				</div>
			</div>
			<div class="row">
				<div class="col-md-3 col-md-push-8 animate-box">
					<h3>Endereço</h3>
					<ul class="contact-info">
						<li><i class="icon-location4"></i><?php echo $endereco_igreja ?></li>
						<li><i class="icon-phone3"></i><?php echo $telefone_igreja ?></li>
						<li><i class="icon-mail3"></i><?php echo $email_igreja ?></li>
					
					</ul>
				</div>
				<div class="col-md-7 col-md-pull-2 animate-box">
					<div class="row">
						<form method="POST" action="enviar.php">
						<div class="col-md-12">
							<div class="form-group">
								<input type="text" class="form-control" name="nome" placeholder="Nome" required="">
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<input type="email" class="form-control" name="email" placeholder="Email" required="">
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<input type="telefone" class="form-control" name="telefone" placeholder="Telefone" >
							</div>
						</div>
						<div class="col-md-12">
							<div class="form-group">
								<textarea class="form-control" id="" cols="30" rows="7" placeholder="Menssage" name="mensagem" required=""></textarea>
							</div>
						</div>
						<div class="col-md-12">
							<div class="form-group">
								<input type="submit" value="Enviar Mensagem" class="btn btn-primary btn-modify">
							</div>
						</div>

						<input type="hidden" class="form-control" name="nome_igreja" value="<?php echo $nome_igreja ?>">
						<input type="hidden" class="form-control" name="email_igreja" value="<?php echo $email_igreja ?>">

						</form>
					</div>
				</div>
			</div>
		</div>
		

</div>


<?php 

require_once("rodape.php"); 

?>