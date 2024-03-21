<?php 
@session_start();
require_once("verificar.php");
require_once("../conexao.php");
$id_usuario = @$_SESSION['id_usuario'];
$nivel_usu = @$_SESSION['nivel_usuario'];

if($nivel_usu == 'tesoureiro'){
	$esc_tesoureiro = 'd-none';
	
}else{
	$esc_tesoureiro = '';
	
}

$data_atual = date('Y-m-d');
$hora_atual = date('H:i:s');

$mes_atual = Date('m');
$ano_atual = Date('Y');
$data_mes = $ano_atual."-".$mes_atual."-01";
$data_ano = $ano_atual."-01-01";

if(@$_GET['igreja'] > 0){
	@$_SESSION['id_igreja'] = @$_GET['igreja'];
}

$id_igreja = @$_SESSION['id_igreja'];

//TRAZER OS DADOS DA IGREJA
$query = $pdo->query("SELECT * FROM igrejas where id = '$id_igreja'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$nome_igreja = $res[0]['nome'];
$foto_igreja = $res[0]['imagem'];

//TRAZER DADOS DO USUÁRIO LOGADO
$query = $pdo->query("SELECT * FROM usuarios where id = '$id_usuario'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$nome_usu = $res[0]['nome'];
$email_usu = $res[0]['email'];
$senha_usu = $res[0]['senha'];
$cpf_usu = $res[0]['cpf'];
$nivel_usu = $res[0]['nivel'];
$foto_usu = $res[0]['foto'];

//TRAZER DADOS DO CONFIG
$query = $pdo->query("SELECT * FROM config");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$email_igr = $res[0]['email'];
$nome_igr = $res[0]['nome'];
$end_igr = $res[0]['endereco'];
$tel_igr = $res[0]['telefone'];

$pag = @$_GET['pag'];
if($pag == ""){
	$pag = 'home';
}
?>
<!DOCTYPE html>
<html>
<head>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
	<link href="../img/logo-icone.ico" rel="shortcut icon" type="image/x-icon">
	<link href="../css/style.css" rel="stylesheet" type="text/css">

	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">

	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

	<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
	<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

	<link rel="stylesheet" type="text/css" href="../DataTables/datatables.min.css"/>
	<script type="text/javascript" src="../DataTables/datatables.min.js"></script>

	<link href="../css/toastr.css" rel="stylesheet" type="text/css">
	<script type="text/javascript" src="../js/toastr.js"></script>

	<title>Painel Administrativo</title>
</head>
<body>

	<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
		<div class="container-fluid">
			<a class="navbar-brand" href="painel-admin"><img src="../img/igrejas/<?php echo $foto_igreja ?>" width="40px" height="40px"></a>
			<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse" id="navbarSupportedContent">
				<ul class="navbar-nav me-auto mb-2 mb-lg-0">
					<li class="nav-item">
						<a class="nav-link active" aria-current="page" href="index.php">Home</a>
					</li>

					<li class="nav-item dropdown">
						<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
							Pessoas
						</a>
						<ul class="dropdown-menu" aria-labelledby="navbarDropdown">
							<li><a class="dropdown-item" href="index.php?pag=membros">Membros</a></li>
							<li><a class="dropdown-item <?php echo $esc_tesoureiro ?>" href="index.php?pag=pastores">Pastores (Presbíteros)</a></li>
							<li><a class="dropdown-item <?php echo $esc_tesoureiro ?>" href="index.php?pag=tesoureiros">Tesoureiros</a></li>
							<li><a class="dropdown-item <?php echo $esc_tesoureiro ?>" href="index.php?pag=secretarios">Secretários</a>
							</li>
							<li><a class="dropdown-item <?php echo $esc_tesoureiro ?>" href="index.php?pag=fornecedores">Fornecedores</a>
							</li>
							<li><hr class="dropdown-divider"></li>
							<li><a class="dropdown-item <?php echo $esc_tesoureiro ?>" href="index.php?pag=usuarios">Usuários</a></li>
							
							
						</ul>
					</li>

					<li class="nav-item dropdown">
						<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
							Cadastros
						</a>
						<ul class="dropdown-menu" aria-labelledby="navbarDropdown">

							<li><a class="dropdown-item" href="index.php?pag=tarefas">Agenda / Tarefas</a></li>
							
							
							
						</ul>
					</li>


					<li class="nav-item dropdown">
						<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
							Financeiro
						</a>
						<ul class="dropdown-menu" aria-labelledby="navbarDropdown">

							<li><a class="dropdown-item" href="index.php?pag=pagar">Contas à Pagar</a></li>

							<li><a class="dropdown-item" href="index.php?pag=receber">Contas à Receber</a></li>
							
							<li><a class="dropdown-item" href="index.php?pag=dizimos">Dízimos</a></li>

							<li><a class="dropdown-item" href="index.php?pag=ofertas">Ofertas</a></li>

							<li><a class="dropdown-item" href="index.php?pag=doacoes">Doações</a></li>

							<li><a class="dropdown-item" href="index.php?pag=vendas">Vendas</a></li>
							
							<li><a class="dropdown-item" href="index.php?pag=movimentacoes">Movimentações</a></li>
							
						</ul>
					</li>


					<li class="nav-item dropdown">
						<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
							Secretária
						</a>
						<ul class="dropdown-menu" aria-labelledby="navbarDropdown">

							<li><a class="dropdown-item" href="index.php?pag=documentos">Documentos</a></li>
														
							<li><a class="dropdown-item" href="index.php?pag=patrimonios">Patrimônio</a></li>

							<li><a class="dropdown-item" href="index.php?pag=celulas">Células</a></li>

							<li><a class="dropdown-item" href="index.php?pag=grupos">Grupos</a></li>

														
						</ul>
					</li>


					<li class="nav-item dropdown">
						<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
							Relatórios
						</a>
						<ul class="dropdown-menu" aria-labelledby="navbarDropdown">

							<li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#modalRelMembros">Membros</a></li>
														
							<li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#modalRelPatrimonios">Patrimônio</a></li>

							<li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#modalRelFinanceiro">Financeiros</a></li>
																					
						</ul>
					</li>

					<li class="nav-item">
						<a class="nav-link active" aria-current="page" href="index.php?pag=anexos">Anexo Sede</a>
					</li>


					
				</ul>
				<div class="d-flex mx-4">
					<img class="img-profile rounded-circle" src="../img/membros/<?php echo $foto_usu ?>" width="40px" height="40px">

					<ul class="navbar-nav ">
						<li class="nav-item dropdown">
							<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
								<?php echo @$nome_usu ?>
							</a>
							<ul class="dropdown-menu" aria-labelledby="navbarDropdown">
								<li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#modalPerfil">Editar Dados</a></li>

								<?php if($nivel_usu == 'bispo'){ ?>
									<li><a class="dropdown-item" href="../painel-admin">Painel Administrador</a></li>

								<?php } ?>

								<li><hr class="dropdown-divider"></li>
								<li><a class="dropdown-item" href="../logout.php">Sair</a></li>
							</ul>
						</li>
					</ul>

				</div>
			</div>
		</div>
	</nav>

	<div class="container-fluid mb-4 mx-4">
		<?php 
		require_once($pag.'.php');
		?>
	</div>

</body>
</html>




<div class="modal fade" id="modalPerfil" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Editar Dados</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<form id="form-usu" method="post">
				<div class="modal-body">
					<div class="row">
						<div class="col-md-8">
							<div class="mb-3">
								<label for="exampleFormControlInput1" class="form-label">Nome</label>
								<input type="text" class="form-control" id="nome_usu" name="nome_usu" placeholder="Insira o Nome" value="<?php echo $nome_usu ?>" required>
							</div>
						</div>
						<div class="col-md-4">
							<div class="mb-3">
								<label for="exampleFormControlInput1" class="form-label">CPF</label>
								<input type="text" class="form-control" id="cpf_usu" name="cpf_usu" placeholder="Insira o CPF" value="<?php echo $cpf_usu ?>" required>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-8">
							<div class="mb-3">
								<label for="exampleFormControlInput1" class="form-label">Email</label>
								<input type="email" class="form-control" id="email_usu" name="email_usu" placeholder="Insira o Email" value="<?php echo $email_usu ?>" required>
							</div>
						</div>

						<div class="col-md-4">
							<div class="mb-3">
								<label for="exampleFormControlInput1" class="form-label">Senha</label>
								<input type="text" class="form-control" id="senha_usu" name="senha_usu" placeholder="Insira a Senha" value="<?php echo $senha_usu ?>" required>
							</div>
						</div>


						<div class="row">
							<div class="col-md-8">
								<div class="mb-3">
									<label for="exampleFormControlInput1" class="form-label">Foto</label>
									<input type="file" class="form-control-file" id="imagem-usu" name="imagem" onChange="carregarImg2();">
								</div>
							</div>
							<div class="col-md-4">
								<div id="divImg" class="mt-4">
									<img src="../img/membros/<?php echo $foto_usu ?>"  width="100px" id="target-usu">									
								</div>
							</div>
						</div>


						<input type="hidden" name="id_usu" value="<?php echo $id_usuario ?>">

					</div>
				</div>
				<small><div align="center" id="msg-usu"></div></small>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="btn-fechar-usu">Fechar</button>
					<button type="submit" class="btn btn-primary">Editar</button>
				</div>
			</form>
		</div>
	</div>
</div>






<div class="modal fade" id="modalRelMembros" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Relatório de Membros</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<form method="post" action="../rel/relMembros.php" target="_blank">
				<div class="modal-body">
					<div class="row">
						<div class="col-md-4">
							<div class="mb-3">
									<label for="exampleFormControlInput1" class="form-label">Cargo / Membros</label>
									<select class="form-select form-select-sm" aria-label="Default select example" name="cargo">  
										<option value="">Todos</option>

										<?php 
									$query = $pdo->query("SELECT * FROM cargos order by id asc");
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
						

						<div class="col-md-4">
							<div class="mb-3">
									<label for="exampleFormControlInput1" class="form-label">Status</label>
									<select class="form-select form-select-sm" aria-label="Default select example" name="status">  
										<option value="">Todos</option>
										<option value="Sim">Ativo</option>
										<option value="Não">Inativo</option>
									</select>
								</div>
						</div>

						<div class="col-md-4">
							
						</div>

						<input type="hidden" name="igreja" value="<?php echo $id_igreja ?>">
					</div>

					
				</div>
			
			<small><div align="center" id="msg-config"></div></small>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="btn-fechar-config">Fechar</button>
				<button type="submit" class="btn btn-primary">Gerar Relatório</button>
			</div>
		</form>
	</div>
</div>
</div>






<div class="modal fade" id="modalRelPatrimonios" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Relatório de Patrimônios</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<form method="post" action="../rel/relPatrimonio.php" target="_blank">
				<div class="modal-body">
					<div class="row">

						<div class="col-md-4">
							<div class="mb-3">
									<label for="exampleFormControlInput1" class="form-label">Itens</label>
									<select class="form-select form-select-sm" aria-label="Default select example" name="itens">  
										<option value="">Todos</option>
										<option value="1">Pertencentes a Igreja</option>
										<option value="2">Emprestados a Outros</option>
										<option value="3">Itens de Outras Igrejas</option>
									</select>
								</div>
						</div>

						<div class="col-md-4">
							<div class="mb-3">
									<label for="exampleFormControlInput1" class="form-label">Status</label>
									<select class="form-select form-select-sm" aria-label="Default select example" name="status">  
										<option value="">Todos</option>
										<option value="Sim">Ativo</option>
										<option value="Não">Inativo</option>
									</select>
								</div>
						</div>

						<div class="col-md-4">
							<div class="mb-3">
									<label for="exampleFormControlInput1" class="form-label">Compra / Doação</label>
									<select class="form-select form-select-sm" aria-label="Default select example" name="entrada">  
										<option value="">Todos</option>
										<option value="Compra">Compra</option>
										<option value="Doação">Doação</option>
									</select>
								</div>
						</div>

						<input type="hidden" name="igreja" value="<?php echo $id_igreja ?>">
					</div>

					<div class="row">
						<div class="col-md-4">
							<div class="mb-3">
									<label for="exampleFormControlInput1" class="form-label">Data Inicial <small><small>(
										<a href="#" class="text-primary" onclick="datas('1980-01-01', 'tudo-pat', 'pat')">
											<span id="tudo-pat">Tudo</span>
										</a> / 
									<a href="#" class="text-dark" onclick="datas('<?php echo $data_atual ?>', 'hoje-pat', 'pat')">
											<span id="hoje-pat">Hoje</span>
										</a> /
										<a href="#" class="text-dark" onclick="datas('<?php echo $data_mes ?>', 'mes-pat', 'pat')">
											<span id="mes-pat">Mês</span>
										</a> /
										<a href="#" class="text-dark" onclick="datas('<?php echo $data_ano ?>', 'ano-pat', 'pat')">
											<span id="ano-pat">Ano</span>
										</a> 
									)</small></small></label>
									<input type="date" class="form-control form-control-sm" name="dataInicial" id="dtInicial-pat" value="1980-01-01">
								</div>
						</div>

						<div class="col-md-4">
							<div class="mb-3">
									<label for="exampleFormControlInput1" class="form-label">Data Final</label>
									<input type="date" class="form-control form-control-sm"  name="dataFinal" id="dtFinal-pat" value="<?php echo $data_atual ?>">
								</div>
						</div>


					</div>

					
				</div>
			
			<small><div align="center" id="msg-config"></div></small>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="btn-fechar-config">Fechar</button>
				<button type="submit" class="btn btn-primary">Gerar Relatório</button>
			</div>
		</form>
	</div>
</div>
</div>







<div class="modal fade" id="modalRelFinanceiro" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Relatório Financeiro <small><small>(
										<a href="#" class="text-primary" onclick="datas('1980-01-01', 'tudo-fin', 'fin')">
											<span id="tudo-fin">Tudo</span>
										</a> / 
									<a href="#" class="text-dark" onclick="datas('<?php echo $data_atual ?>', 'hoje-fin', 'fin')">
											<span id="hoje-fin">Hoje</span>
										</a> /
										<a href="#" class="text-dark" onclick="datas('<?php echo $data_mes ?>', 'mes-fin', 'fin')">
											<span id="mes-fin">Mês</span>
										</a> /
										<a href="#" class="text-dark" onclick="datas('<?php echo $data_ano ?>', 'ano-fin', 'fin')">
											<span id="ano-fin">Ano</span>
										</a> 
									)</small></small></h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<form method="post" action="../rel/relFinanceiro.php" target="_blank">
				<div class="modal-body">
					<div class="row">

						
						<div class="col-md-3">
							<div class="mb-3">
									<label for="exampleFormControlInput1" class="form-label">Movimento</label>
									<select class="form-select form-select-sm" aria-label="Default select example" name="movimento" id="movim">  
										<option value="">Todos</option>
										<option value="Conta">Contas à Pagar</option>
										<option value="Dízimo">Dízimos</option>
										<option value="Oferta">Ofertas</option>
										<option value="Doação">Doações</option>
										<option value="Venda">Vendas</option>
									</select>
								</div>
						</div>


						<div class="col-md-3">
							<div class="mb-3">
									<label for="exampleFormControlInput1" class="form-label">Entradas / Saídas</label>
									<select class="form-select form-select-sm" aria-label="Default select example" name="tipo" id="tip">  
										<option value="">Todas</option>
										<option value="Entrada">Entradas</option>
										<option value="Saída">Saídas</option>
										
									</select>
								</div>
						</div>

						<div class="col-md-3">
							<div class="mb-3">
									<label for="exampleFormControlInput1" class="form-label">Data Inicial </label>
									<input type="date" class="form-control form-control-sm" name="dataInicial" id="dtInicial-fin" value="1980-01-01">
								</div>
						</div>

						<div class="col-md-3">
							<div class="mb-3">
									<label for="exampleFormControlInput1" class="form-label">Data Final</label>
									<input type="date" class="form-control form-control-sm"  name="dataFinal" id="dtFinal-fin" value="<?php echo $data_atual ?>">
								</div>
						</div>

						<input type="hidden" name="igreja" value="<?php echo $id_igreja ?>">
					</div>

										
				</div>
			
			<small><div align="center" id="msg-config"></div></small>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="btn-fechar-config">Fechar</button>
				<button type="submit" class="btn btn-primary">Gerar Relatório</button>
			</div>
		</form>
	</div>
</div>
</div>




<!-- Mascaras JS -->
<script type="text/javascript" src="../js/mascaras.js"></script>

<!-- Ajax para funcionar Mascaras JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.11/jquery.mask.min.js"></script> 


<script type="text/javascript">
	$("#form-usu").submit(function () {

		event.preventDefault();
		var formData = new FormData(this);

		$.ajax({
			url: "editar-dados.php",
			type: 'POST',
			data: formData,

			success: function (mensagem) {
				$('#msg-usu').text('');
				$('#msg-usu').removeClass()
				if (mensagem.trim() == "Salvo com Sucesso") {

					$('#btn-fechar-usu').click();
					window.location="index.php";

				} else {

					$('#msg-usu').addClass('text-danger')
					$('#msg-usu').text(mensagem)
				}


			},

			cache: false,
			contentType: false,
			processData: false,

		});

	});
</script>


<script type="text/javascript">
	$("#form-config").submit(function () {

		event.preventDefault();
		var formData = new FormData(this);

		$.ajax({
			url: "editar-config.php",
			type: 'POST',
			data: formData,

			success: function (mensagem) {
				$('#msg-config').text('');
				$('#msg-config').removeClass()
				if (mensagem.trim() == "Salvo com Sucesso") {

					$('#btn-fechar-config').click();
					window.location="index.php";

				} else {

					$('#msg-config').addClass('text-danger')
					$('#msg-config').text(mensagem)
				}


			},

			cache: false,
			contentType: false,
			processData: false,

		});

	});
</script>


<script type="text/javascript">
	function datas(data, id, campo){
		var data_atual = "<?=$data_atual?>";
		$('#dtInicial-'+campo).val(data);
		$('#dtFinal-pat'+campo).val(data_atual);

		document.getElementById('hoje-'+campo).style.color = "#000";
		document.getElementById('tudo-'+campo).style.color = "#000";
		document.getElementById('mes-'+campo).style.color = "#000";
		document.getElementById('ano-'+campo).style.color = "#000";
		document.getElementById(id).style.color = "blue";		
	}
</script>


<script type="text/javascript">
	$(function(){
		$("#movim").change(function(){
			if($("#movim").val() != ""){
				document.getElementById("tip").options.selectedIndex = 0;
				$('#tip').val($('#tip').val()).change();
				document.getElementById('tip').disabled = true;
			}else{
				document.getElementById('tip').disabled = false;
			}
		})
	})
</script>