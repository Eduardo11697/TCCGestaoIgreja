<?php 
require_once("../conexao.php");
$membrosSede = 0;
$membrosCadastrados = 0;
$pastoresCadastrados = 0;
$igrejasCadastradas = 0;

$query = $pdo->query("SELECT * FROM igrejas");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$igrejasCadastradas = @count($res);

$query = $pdo->query("SELECT * FROM pastores");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$pastoresCadastrados = @count($res);

$query_m = $pdo->query("SELECT * FROM membros where igreja = 1 and ativo = 'Sim'");
$res_m = $query_m->fetchAll(PDO::FETCH_ASSOC);
$membrosSede = @count($res_m);

$query_m = $pdo->query("SELECT * FROM membros where ativo = 'Sim'");
$res_m = $query_m->fetchAll(PDO::FETCH_ASSOC);
$membrosCadastrados = @count($res_m);

?>


<div class="container-fluid " >
	<section id="minimal-statistics" style="margin-right:20px">
		<div class="row mb-2">
			<div class="col-12 mt-3 mb-1">
				<h4 class="text-uppercase textocinzaescuro">Estatísticas do Sistema</h4>

			</div>
		</div>




		<div class="row mb-4">

			<div class="col-xl-3 col-sm-6 col-12 linkcard"> 
				<a href="index.php?pag=igrejas">
					<div class="card">
						<div class="card-content">
							<div class="card-body">
								<div class="row">
									<div class="align-self-center col-3">
										<i class="bi bi-house-door-fill text-success fs-1 float-start"></i>
									</div>
									<div class="col-9 text-end">
										<h3> <span class="text-success"><?php echo @$igrejasCadastradas ?></span></h3>
										<span class="textocinzaescuro">Igrejas Cadastradas</span>
									</div>
								</div>
							</div>
						</div>
					</div>
				</a>
			</div>

			


			<div class="col-xl-3 col-sm-6 col-12 linkcard"> 
				<a href="index.php?pag=pastores">
					<div class="card">
						<div class="card-content">
							<div class="card-body">
								<div class="row">
									<div class="align-self-center col-3">
										<i class="bi bi-people text-dark fs-1 float-start"></i>
									</div>
									<div class="col-9 text-end">
										<h3> <span class="text-dark"><?php echo @$pastoresCadastrados ?></span></h3>
										<span class="textocinzaescuro">Pastores Cadastrados</span>
									</div>
								</div>
							</div>
						</div>
					</div>
				</a>
			</div>


			<div class="col-xl-3 col-sm-6 col-12 linkcard"> 
				<a href="index.php?pag=membros">
					<div class="card">
						<div class="card-content">
							<div class="card-body">
								<div class="row">
									<div class="align-self-center col-3">
										<i class="bi bi-person-fill text-primary fs-1 float-start"></i>
									</div>
									<div class="col-9 text-end">
										<h3> <span class="text-primary"><?php echo @$membrosSede ?></span></h3>
										<span class="textocinzaescuro">Membros da Sede</span>
									</div>
								</div>
							</div>
						</div>
					</div>
				</a>
			</div>


			<div class="col-xl-3 col-sm-6 col-12 linkcard"> 
				<a href="index.php?pag=membros">
					<div class="card">
						<div class="card-content">
							<div class="card-body">
								<div class="row">
									<div class="align-self-center col-3">
										<i class="bi bi-people-fill text-danger fs-1 float-start"></i>
									</div>
									<div class="col-9 text-end">
										<h3> <span class="text-danger"><?php echo @$membrosCadastrados ?></span></h3>
										<span class="textocinzaescuro">Total de Membros</span>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</a>
		</div>





	</section>


	<div class="text-xs font-weight-bold text-secondary text-uppercase mt-4"><small>IGREJAS - SEDE E FILIAIS</small></div>
	<hr> 

	<div class="row" style="margin-right:10px">

		<?php 

		$query = $pdo->query("SELECT * FROM igrejas order by matriz desc, nome asc");
		$res = $query->fetchAll(PDO::FETCH_ASSOC);
		$total_reg = count($res);

		for($i=0; $i < $total_reg; $i++){
			foreach ($res[$i] as $key => $value){} 

				$nome = $res[$i]['nome'];
					//$pastor = $res[$i]['pastor'];
			$imagem = $res[$i]['imagem'];
			$matriz = $res[$i]['matriz'];
			$pastor = $res[$i]['pastor'];
			$id_ig = $res[$i]['id'];

			if($matriz == 'Sim'){
				$bordacard = 'bordacardsede';
				$classe = 'text-danger';
			}else{
				$bordacard = 'bordacard';
				$classe = 'text-primary';
			}

			$query_m = $pdo->query("SELECT * FROM membros where igreja = '$id_ig' and ativo = 'Sim'");
			$res_m = $query_m->fetchAll(PDO::FETCH_ASSOC);
			$membrosCad = @count($res_m);


			$query_con = $pdo->query("SELECT * FROM pastores where id = '$pastor'");
			$res_con = $query_con->fetchAll(PDO::FETCH_ASSOC);
			if(count($res_con) > 0){
				$nome_p = $res_con[0]['nome'];
			}else{
				$nome_p = 'Não Definido';
			}

			?>

			<div class="col-xl-3 col-md-6 col-12 mb-4 linkcard">
				<a href="../painel-igreja/index.php?igreja=<?php echo $id_ig ?>">
					<div class="card <?php echo $classe ?> shadow h-100 py-2 <?php echo $bordacard ?>">
						<div class="card-body">
							<div class="row no-gutters align-items-center">
								<div class="col mr-2">
									<div class="text-xs font-weight-bold <?php echo $classe ?> text-uppercase titulocard"><?php echo $nome ?></div>
									<div class="text-xs text-secondary subtitulocard"><?php echo mb_strtoupper($nome_p) ?> </div>
								</div>
								<div class="col-auto" align="center">
									<img src="../img/igrejas/<?php echo $imagem ?>" width="50px" height="50px"><br>
									<span class="text-xs totaiscard <?php echo $classe ?>"><?php echo @$membrosCad ?> MEMBROS</span>
								</div>
							</div>
						</div>
					</div>
				</a>
			</div>



		<?php } ?>

	</div>
</div>