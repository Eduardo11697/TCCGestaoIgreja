<?php 
require_once("sistema/conexao.php");


//TRAZER OS DADOS DA IGREJA
@session_start();
if(@$_SESSION['url_igreja'] == "" ||  @$_GET['nome'] != ""){
	@$_SESSION['url_igreja'] = @$_GET['nome'];
}
$url = @$_SESSION['url_igreja'];

//VERIFICAR SE EXISTE URL DO EVENTO
if(@$_GET['evento'] != ""){
	$url_ev = @$_GET['evento'];
	$query = $pdo->query("SELECT * FROM eventos where url = '$url_ev'");
	$res = $query->fetchAll(PDO::FETCH_ASSOC);
	$id_ig_ev = $res[0]['igreja'];

	$query = $pdo->query("SELECT * FROM igrejas where id = '$id_ig_ev'");
	$res = $query->fetchAll(PDO::FETCH_ASSOC);
	$url = $res[0]['url'];
	@$_SESSION['url_igreja'] = $url;
}

$query = $pdo->query("SELECT * FROM igrejas where url = '$url'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
if(@count($res) > 0){

$nome_igreja = $res[0]['nome'];
$foto_igreja = $res[0]['imagem'];
$endereco_igreja = $res[0]['endereco'];
$telefone_igreja = $res[0]['telefone'];
$youtube = $res[0]['youtube'];
$instagram = $res[0]['instagram'];
$facebook = $res[0]['facebook'];
$id_igreja = $res[0]['id'];
$pastor_id = $res[0]['pastor'];
$video_igreja = $res[0]['video'];
$email_igreja = $res[0]['email'];

$query = $pdo->query("SELECT * FROM pastores where id = '$pastor_id'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$pastor_resp = $res[0]['nome'];
}else{
	echo "<script>window.location='index.php'</script>";
}


//TOTAIS
$query = $pdo->query("SELECT * FROM membros where igreja = '$id_igreja'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_membros = @count($res);

$query = $pdo->query("SELECT * FROM igrejas");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_igrejas = @count($res);

$query = $pdo->query("SELECT * FROM celulas where igreja = '$id_igreja'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_celulas = @count($res);

$query = $pdo->query("SELECT * FROM grupos where igreja = '$id_igreja'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_grupos = @count($res);
 ?>
<!DOCTYPE HTML>
<html>
	<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title><?php echo $nome_igreja ?></title>
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
		
	<!-- <div class="fh5co-loader"></div> -->
	
	<div id="page">

<nav class="fh5co-nav" role="navigation">
		<div class="container-wrap">
			<div class="top-menu">
				<div class="row">
					<div class="col-md-12 col-offset-0 text-center">
						<div id="fh5co-logo"><a class="" href="igreja<?php echo $url ?>"><img style="margin-top:-10px; margin-right:8px" src="sistema/img/igrejas/<?php echo $foto_igreja ?>" width="30px"><span class="ml-2"><?php echo mb_strtoupper($nome_igreja) ?></span></a>

						</div>

					</div>
					<div class="col-md-12 col-md-offset-0 text-center menu-1">
						<ul>
							<li class="active"><a href="igreja<?php echo $url ?>">Home</a></li>
							<li><a href="eventos.php">Eventos</a></li>
							<li class="has-dropdown">
								<a href="#">Igrejas</a>
								<ul class="dropdown">

									<?php 
									$query = $pdo->query("SELECT * FROM igrejas order by matriz desc, nome asc");
						$res = $query->fetchAll(PDO::FETCH_ASSOC);
						$total_reg = count($res);

						
						if($total_reg > 0){
							for($i=0; $i < $total_reg; $i++){
								foreach ($res[$i] as $key => $value){} 
										$nome = $res[$i]['nome'];
						$url = $res[$i]['url'];
									 ?>
									<li><a href="igreja<?php echo $url ?>"><?php echo $nome ?></a></li>

								<?php } } ?>
									
								</ul>
							</li>
							<li><a href="pregacoes.php">Pregações</a></li>
							<li><a href="sobre.php">Sobre</a></li>
							<li><a href="contatos.php">Contato</a></li>
							<li><a target="_blank" href="sistema">Login</a></li>
						</ul>
					</div>
				</div>
				
			</div>
		</div>
	</nav>




<style type="text/css">
    .alerta{
      background-color: #060d54; color:#FFF; padding:15px; font-family: Arial; text-align:center; position:fixed; bottom:0; width:100%; opacity: 80%; z-index: 100;
    }

     .alerta.hide{
       display:none !important;
    }

    .link-alerta{
      color:#f2f2f2; 
    }

    .link-alerta:hover{
      text-decoration: underline;
      color:#FFF;
    }

    .botao-aceitar{
      background-color: #e3e3e3; padding:7px; margin-left: 15px; border-radius: 5px; border: none; margin-top:3px;
    }

    .botao-aceitar:hover{
      background-color: #f7f7f7;
      text-decoration: none;

    }

  </style>

<div class="alerta hide">
  A gente guarda estatísticas de visitas para melhorar sua experiência de navegação, saiba mais em nossa  <a class="link-alerta" title="Ver as políticas de privacidade" data-toggle="modal" href="#modalTermosCondicoes"" >política de privacidade.</a>
  <a class="botao-aceitar text-dark" href="#">Aceitar</a>
</div>


<script>
        if (!localStorage.meuCookie) {
            document.querySelector(".alerta").classList.remove('hide');
        }

        const acceptCookies = () => {
            document.querySelector(".alerta").classList.add('hide');
            localStorage.setItem("meuCookie", "accept");
        };

        const btnCookies = document.querySelector(".botao-aceitar");

        btnCookies.addEventListener('click', acceptCookies);
    </script>







<style type="text/css">
    .alertasite{
      background-color: #8c0608; color:#FFF; padding:15px; font-family: Arial; text-align:center; position:fixed; bottom:0; width:300px; opacity: 80%; z-index: 100;
    }
</style>

<?php 
	$query = $pdo->query("SELECT * FROM alertas where ativo = 'Sim' and data >= curDate()");
	$res = $query->fetchAll(PDO::FETCH_ASSOC);
	if(@count($res) > 0){

	$titulo = $res[0]['titulo'];
	$descricao = $res[0]['descricao'];
	$link = $res[0]['link'];
	$imagem = $res[0]['imagem'];

 ?>
 <a href="#" onclick="modalAlerta('<?php echo $titulo ?>', '<?php echo $descricao ?>', '<?php echo $link ?>', '<?php echo $imagem ?>')">
<div class="alertasite">
  <?php echo $titulo ?><br>
  <small>Saiba Mais!</small>
</div>
</a>
<?php } ?>


<div class="modal fade" tabindex="-1" id="modalAlerta">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title"><span id="tituloModal"><span id="titulo-dados"></span></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<span id="descricao-dados"></span> <hr style="margin:5px">

				<div id="divlink">
					<a href="" id="link-dados"><span>Clique aqui para acessar a página</span></a> <hr style="margin:5px">
				</div>

				<div id="divimg">
					<img src="" id="foto-dados" width="100%">
				</div>

				
				

			</div>

		</div>
	</div>
</div>



<script type="text/javascript">
	function modalAlerta(titulo, descricao, link, imagem){

		$('#titulo-dados').text(titulo);
		
		$('#descricao-dados').text(descricao);

		$('#foto-dados').attr('src', 'sistema/img/alertas/' + imagem);
		$('#link-dados').attr('href', link);

		if(link == ""){
			document.querySelector("#divlink").style.display = "none";
		}

		if(imagem == "sem-foto.jpg"){
			document.querySelector("#divimg").style.display = "none";
		}

		$('#modalAlerta').modal('show');

	}
</script>