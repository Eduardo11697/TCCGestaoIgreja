<?php 

require_once("sistema/conexao.php"); 

?>


<!DOCTYPE HTML>
<html>
	<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Cadastrar como Membro</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="Site da Igreja Pentecostal" />
	<meta name="keywords" content="" />
	<meta name="author" content="Hugo Vasconcelos" />

	<link href="sistema/img/logo-icone.ico" rel="shortcut icon" type="image/x-icon">



  	<!-- Facebook and Twitter integration -->
	<meta property="og:title" content=""/>
	<meta property="og:image" content=""/>
	<meta property="og:url" content=""/>
	<meta property="og:site_name" content=""/>
	<meta property="og:description" content=""/>
	<meta name="twitter:title" content="" />
	<meta name="twitter:image" content="" />
	<meta name="twitter:url" content="" />
	<meta name="twitter:card" content="" />

	<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,600,700" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Libre+Baskerville:400,400i,700" rel="stylesheet"
	>
	
	<!-- Animate.css -->
	<link rel="stylesheet" href="css/animate.css">
	<!-- Icomoon Icon Fonts-->
	<link rel="stylesheet" href="css/icomoon.css">
	<!-- Bootstrap  -->
	<link rel="stylesheet" href="css/bootstrap.css">

	<!-- Magnific Popup -->
	<link rel="stylesheet" href="css/magnific-popup.css">

	<!-- Flexslider  -->
	<link rel="stylesheet" href="css/flexslider.css">

	<!-- Owl Carousel  -->
	<link rel="stylesheet" href="css/owl.carousel.min.css">
	<link rel="stylesheet" href="css/owl.theme.default.min.css">

	<!-- Theme style  -->
	<link rel="stylesheet" href="css/style.css">

	<!-- Modernizr JS -->
	<script src="js/modernizr-2.6.2.min.js"></script>
	<!-- FOR IE9 below -->
	<!--[if lt IE 9]>
	<script src="js/respond.min.js"></script>
	<![endif]-->

	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">

	</head>
	<body>

<div class="container-wrap">
<div class="row" style="margin:10px">

<div class="container-wrap">
		
		<div id="fh5co-contact">
			
			<div class="row">
				
				<div class="col-md-12 animate-box">
					<div class="row">
						<form method="POST" action="cadastrar.php" enctype='multipart/form-data'>
						<div class="col-md-4">
							<div class="form-group">
								<label>Nome</label>
								<input type="text" class="form-control" name="nome" placeholder="Nome" required="">
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label>CPF</label>
								<input type="text" class="form-control" name="cpf" placeholder="CPF" required="">
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label>Data de Nascimento</label>
								<input type="date" class="form-control" name="data_nasc" placeholder="Data de Nascimento" required="">
							</div>
						</div>
						<div class="col-md-4">
							<label>Email</label>
							<div class="form-group">
								<input type="email" class="form-control" name="email" placeholder="Email" required="">
							</div>
						</div>
						<div class="col-md-4">
							<label>Telefone</label>
							<div class="form-group">
								<input type="telefone" class="form-control" name="telefone" placeholder="Telefone" >
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label>Data de Batismo</label>
								<input type="date" class="form-control" name="data_batismo" placeholder="Data de Batismo" required="">
							</div>
						</div>

						<div class="col-md-8">
							<div class="form-group">
								<label>Endereço</label>
								<input type="text" class="form-control" name="endereco" placeholder="Rua A Bairro x numero x" required="">
							</div>
						</div>

						<div class="col-md-4">
							<div class="form-group">
								<label>Igreja</label>
								<select class="form-control sel2" id="igreja" name="igreja" style="width:100%;" required>
									<option value="">Selecione a Igreja</option>
									<?php 
									$query = $pdo->query("SELECT * FROM igrejas order by matriz desc, nome asc");
									$res = $query->fetchAll(PDO::FETCH_ASSOC);
									$total_reg = count($res);
									if($total_reg > 0){

										for($i=0; $i < $total_reg; $i++){
											foreach ($res[$i] as $key => $value){} 

												$nome_reg = $res[$i]['nome'];
												$id_reg = $res[$i]['id'];
											?>
											<option value="<?php echo $id_reg ?>"><?php echo $nome_reg ?></option>

										<?php }} ?>
									</select>
							</div>
						</div>


						<div class="col-md-8">
							<div class="form-group">
								<label>Foto</label>
								<input type="file" class="form-control" name="imagem" onChange="carregarImg();" id="imagem">
							</div>
						</div>

						<div class="col-md-4">
							<div id="divImg" class="mt-4">
									<img src="sistema/img/membros/sem-foto.jpg"  width="130px" id="target">									
								</div>
						</div>

						<div class="col-md-12" style="margin-top:15px">
							<div class="form-group">
								<input type="submit" value="Cadastrar" class="btn btn-primary btn-modify" >
							</div>
						</div>

						
						</form>
					</div>
				</div>
			</div>
		</div>
		

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


<script>
	function carregarImg() {
    var target = document.getElementById('target');
    var file = document.querySelector("input[type=file]").files[0];
    var arquivo = file['name'];
    resultado = arquivo.split(".", 2);
        //console.log(resultado[1]);
        if(resultado[1] === 'pdf'){
            $('#target').attr('src', "../img/pdf.png");
            return;
        }

        if(resultado[1] === 'rar' || resultado[1] === 'zip'){
            $('#target').attr('src', "../img/rar.png");
            return;
        }

       if(resultado[1] === 'doc' || resultado[1] === 'docx'){
            $('#target').attr('src', "../img/word.png");
            return;
        }

        var reader = new FileReader();

        reader.onloadend = function () {
            target.src = reader.result;
        };

        if (file) {
            reader.readAsDataURL(file);

        } else {
            target.src = "";
        }
    }
</script>