<?php 
require_once("../conexao.php");

@session_start();
$nivel_usu = @$_SESSION['nivel_usuario'];

if($nivel_usu == 'tesoureiro'){
	$esc_tesoureiro = 'd-none';
	$esc_pastor = '';
}else if($nivel_usu == 'secretario'){
	$esc_secretario = 'd-none';
	$esc_pastor = '';
}else{
	$esc_tesoureiro = '';
	$esc_pastor = 'd-none';

	if(@$_GET['mostrar'] == 'sim'){
		$esc_pastor = '';
		$icone_plus = 'bi-dash-square';
		$mostrar = 'nao';
	}else{
		$esc_pastor = 'd-none';
		$icone_plus = 'bi-plus-square';
		$mostrar = 'sim';
	}
}



$totalDizimos = 0;
$membrosCadastrados = 0;
$gruposCadastrados = 0;
$celulasCadastradas = 0;
$totalOfertas = 0;
$totalGastos = 0;
$totalVendas = 0;
$totalDoacoes = 0;
$saldoMes = 0;
$patCadastrados = 0;

$pagarVencidas = 0;
$pagarHoje = 0;
$receberHoje = 0;

$query = $pdo->query("SELECT * FROM membros where igreja = '$id_igreja' and ativo = 'Sim'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$membrosCadastrados = @count($res);

$query = $pdo->query("SELECT * FROM pagar where igreja = '$id_igreja' and vencimento = curDate() and pago != 'Sim'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$pagarHoje = @count($res);

$query = $pdo->query("SELECT * FROM receber where igreja = '$id_igreja' and vencimento = curDate() and pago != 'Sim'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$receberHoje = @count($res);

$query = $pdo->query("SELECT * FROM pagar where igreja = '$id_igreja' and vencimento < curDate() and pago != 'Sim'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$pagarVencidas = @count($res);


$query = $pdo->query("SELECT * FROM grupos where igreja = '$id_igreja'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$gruposCadastrados = @count($res);

$query = $pdo->query("SELECT * FROM celulas where igreja = '$id_igreja'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$celulasCadastradas = @count($res);

$query = $pdo->query("SELECT * FROM patrimonios where igreja_cad = '$id_igreja' and ativo = 'Sim'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$patCadastrados = @count($res);


$mes_atual = Date('m');
$ano_atual = Date('Y');
$dataInicioMes = $ano_atual."-".$mes_atual."-01";


$query = $pdo->query("SELECT * FROM movimentacoes where igreja = '$id_igreja' and data >= '$dataInicioMes' and data <= curDate()");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_reg = @count($res);
if($total_reg > 0){
	for($i=0; $i < $total_reg; $i++){
		foreach ($res[$i] as $key => $value){} 
			$tipo = $res[$i]['tipo'];
		$movimento = $res[$i]['movimento'];

		if($tipo == 'Saída'){
			$totalGastos += $res[$i]['valor'];
		}

		if($movimento == 'Dízimo'){
			$totalDizimos += $res[$i]['valor'];
		}

		if($movimento == 'Oferta'){
			$totalOfertas += $res[$i]['valor'];
		}

		if($movimento == 'Venda'){
			$totalVendas += $res[$i]['valor'];
		}

		if($movimento == 'Doação'){
			$totalDoacoes += $res[$i]['valor'];
		}

	}
}

$saldoMes = $totalDizimos + $totalOfertas + $totalVendas + $totalDoacoes - $totalGastos;
if($saldoMes < 0){
	$classeSaldo = 'text-danger';
}else{
	$classeSaldo = 'text-success';
}

$totalGastos = number_format($totalGastos, 2, ',', '.');
$totalDizimos = number_format($totalDizimos, 2, ',', '.');
$totalOfertas = number_format($totalOfertas, 2, ',', '.');
$totalVendas = number_format($totalVendas, 2, ',', '.');
$totalDoacoes = number_format($totalDoacoes, 2, ',', '.');
$saldoMes = number_format($saldoMes, 2, ',', '.');

?>


<div class="container-fluid mt-4" >
	<section id="minimal-statistics" style="margin-right:20px">

		<div class="row mb-2 <?php echo $esc_secretario ?>">
			<div class="col-10 mt-3 mb-1">
				<h4 class="text-uppercase textocinzaescuro"><small><small><?php echo $nome_igreja ?> </small></small></h4>

			</div>

			<div class="col-2 mt-3 mb-1" align="right">
				<small>Saldo Mês : <span class="<?php echo $classeSaldo ?>">R$ <?php echo $saldoMes ?></span></small>
			</div>
		</div>




		<div class="row mb-4">

		
			<div class="col-xl-3 col-sm-6 col-12 linkcard mb-2 <?php echo $esc_secretario ?>"> 
				<a href="index.php?pag=dizimos">
					<div class="card">
						<div class="card-content">
							<div class="card-body">
								<div class="row">
									<div class="align-self-center col-3">
										<i class="bi bi-piggy-bank text-success fs-1 float-start"></i>
									</div>
									<div class="col-9 text-end">
										<h3> <span class="text-success">R$ <?php echo @$totalDizimos ?></span></h3>
										<span class="textocinzaescuro">Dízimos do Mês</span>
									</div>
								</div>
							</div>
						</div>
					</div>
				</a>
			</div>

			


			<div class="col-xl-3 col-sm-6 col-12 linkcard mb-2 <?php echo $esc_secretario ?>"> 
				<a href="index.php?pag=ofertas">
					<div class="card">
						<div class="card-content">
							<div class="card-body">
								<div class="row">
									<div class="align-self-center col-3">
										<i class="bi bi-cash text-primary fs-1 float-start"></i>
									</div>
									<div class="col-9 text-end">
										<h3> <span class="text-primary">R$ <?php echo @$totalOfertas ?></span></h3>
										<span class="textocinzaescuro">Ofertas do Mês</span>
									</div>
								</div>
							</div>
						</div>
					</div>
				</a>
			</div>


			<div class="col-xl-3 col-sm-6 col-12 linkcard mb-2 <?php echo $esc_secretario ?>"> 
				<a href="index.php?pag=pagar">
					<div class="card">
						<div class="card-content">
							<div class="card-body">
								<div class="row">
									<div class="align-self-center col-3">
										<i class="bi bi-currency-dollar text-danger fs-1 float-start"></i>
									</div>
									<div class="col-9 text-end">
										<h3> <span class="text-danger">R$ <?php echo @$totalGastos ?></span></h3>
										<span class="textocinzaescuro">Gastos do Mês</span>
									</div>
								</div>
							</div>
						</div>
					</div>
				</a>
			</div>


			<div class="col-xl-3 col-sm-6 col-12 linkcard mb-2 <?php echo $esc_secretario ?>"> 
				<a href="index.php?pag=vendas">
					<div class="card">
						<div class="card-content">
							<div class="card-body">
								<div class="row">
									<div class="align-self-center col-3">
										<i class="bi bi-cash-coin text-success fs-1 float-start"></i>
									</div>
									<div class="col-9 text-end">
										<h3> <span class="text-success">R$ <?php echo @$totalVendas ?></span></h3>
										<span class="textocinzaescuro">Vendas do Mês</span>
									</div>
								</div>
							</div>
						</div>
					</div>
				</a>
			</div>



			<div class="col-xl-3 col-sm-6 col-12 linkcard mb-2 <?php echo $esc_secretario ?>"> 
				<a href="index.php?pag=doacoes">
					<div class="card">
						<div class="card-content">
							<div class="card-body">
								<div class="row">
									<div class="align-self-center col-3">
										<i class="bi bi-cash text-primary fs-1 float-start"></i>
									</div>
									<div class="col-9 text-end">
										<h3> <span class="text-primary">R$ <?php echo @$totalDoacoes ?></span></h3>
										<span class="textocinzaescuro">Doações do Mês</span>
									</div>
								</div>
							</div>
						</div>
					</div>
				</a>
			</div>




			<div class="col-xl-3 col-sm-6 col-12 mb-2 linkcard <?php echo $esc_tesoureiro ?>"> 
				<a href="index.php?pag=membros">
					<div class="card">
						<div class="card-content">
							<div class="card-body">
								<div class="row">
									<div class="align-self-center col-3">
										<i class="bi bi-people-fill text-secondary fs-1 float-start"></i>
									</div>
									<div class="col-9 text-end">
										<h3> <span class="text-secondary"><?php echo @$membrosCadastrados ?></span></h3>
										<span class="textocinzaescuro">Total de Membros</span>
									</div>
								</div>
							</div>
						</div>
					</div>
				</a>
			</div>


			<div class="col-xl-3 col-sm-6 col-12 mb-2 linkcard <?php echo $esc_tesoureiro ?>"> 
				<a href="index.php?pag=grupos">
					<div class="card">
						<div class="card-content">
							<div class="card-body">
								<div class="row">
									<div class="align-self-center col-3">
										<i class="bi bi-person-lines-fill text-warning fs-1 float-start"></i>
									</div>
									<div class="col-9 text-end">
										<h3> <span class="text-warning"><?php echo @$gruposCadastrados ?></span></h3>
										<span class="textocinzaescuro">Total de Grupos</span>
									</div>
								</div>
							</div>
						</div>
					</div>
				</a>
			</div>


			<div class="col-xl-3 col-sm-6 col-12 mb-2 linkcard <?php echo $esc_tesoureiro ?>"> 
				<a href="index.php?pag=celulas">
					<div class="card">
						<div class="card-content">
							<div class="card-body">
								<div class="row">
									<div class="align-self-center col-3">
										<i class="bi bi-person-plus text-info fs-1 float-start"></i>
									</div>
									<div class="col-9 text-end">
										<h3> <span class="text-info"><?php echo @$celulasCadastradas ?></span></h3>
										<span class="textocinzaescuro">Total de Células</span>
									</div>
								</div>
							</div>
						</div>
					</div>
				</a>
			</div>



			<div class="col-xl-3 col-sm-6 col-12 mb-2 linkcard <?php echo $esc_tesoureiro ?> <?php echo $esc_pastor ?>"> 
				<a href="index.php?pag=patrimonios">
					<div class="card">
						<div class="card-content">
							<div class="card-body">
								<div class="row">
									<div class="align-self-center col-3">
										<i class="bi bi-box text-success fs-1 float-start"></i>
									</div>
									<div class="col-9 text-end">
										<h3> <span class="text-info"><?php echo @$patCadastrados ?></span></h3>
										<span class="textocinzaescuro">Patrimônio / Itens</span>
									</div>
								</div>
							</div>
						</div>
					</div>
				</a>
			</div>




			<div class="col-xl-3 col-sm-6 col-12 mb-2 linkcard <?php echo $esc_pastor ?> <?php echo $esc_secretario ?>"> 
				<a href="index.php?pag=pagar">
					<div class="card">
						<div class="card-content">
							<div class="card-body">
								<div class="row">
									<div class="align-self-center col-3">
										<i class="bi bi-calendar-week text-warning fs-1 float-start"></i>
									</div>
									<div class="col-9 text-end">
										<h3> <span class="text-warning"><?php echo @$pagarHoje ?></span></h3>
										<span class="textocinzaescuro">Contas à Pagar Hoje</span>
									</div>
								</div>
							</div>
						</div>
					</div>
				</a>
			</div>


			<div class="col-xl-3 col-sm-6 col-12 mb-2 linkcard <?php echo $esc_pastor ?> <?php echo $esc_secretario ?>"> 
				<a href="index.php?pag=receber">
					<div class="card">
						<div class="card-content">
							<div class="card-body">
								<div class="row">
									<div class="align-self-center col-3">
										<i class="bi bi-calendar-week text-success fs-1 float-start"></i>
									</div>
									<div class="col-9 text-end">
										<h3> <span class="text-success"><?php echo @$receberHoje ?></span></h3>
										<span class="textocinzaescuro">Contas à Receber Hoje</span>
									</div>
								</div>
							</div>
						</div>
					</div>
				</a>
			</div>


			<div class="col-xl-3 col-sm-6 col-12 mb-2 linkcard <?php echo $esc_pastor ?> <?php echo $esc_secretario ?>"> 
				<a href="index.php?pag=pagar">
					<div class="card">
						<div class="card-content">
							<div class="card-body">
								<div class="row">
									<div class="align-self-center col-3">
										<i class="bi bi-calendar-week text-danger fs-1 float-start"></i>
									</div>
									<div class="col-9 text-end">
										<h3> <span class="text-danger"><?php echo @$pagarVencidas ?></span></h3>
										<span class="textocinzaescuro">Contas à Pagar Vencidas</span>
									</div>
								</div>
							</div>
						</div>
					</div>
				</a>
			</div>

			<div class="<?php echo $esc_tesoureiro ?> <?php echo $esc_secretario ?>" align="right"><a href="index.php?mostrar=<?php echo $mostrar ?>" class="text-dark"><i class="bi <?php echo $icone_plus ?>"></i></a></div>

		</div>

	</section>

	<?php 
	$query = $pdo->query("SELECT * FROM tarefas where status = 'Agendada' and igreja = '$id_igreja' order by status asc, data asc, hora asc LIMIT $quantidade_tarefas");
	$res = $query->fetchAll(PDO::FETCH_ASSOC);
	$total_reg = count($res);
	?>

	<div class="text-xs font-weight-bold text-secondary text-uppercase mt-2"><small>AGENDA / <?php echo $total_reg ?> TAREFAS PENDENTES</small></div>
	<hr> 

	<div class="row" style="margin-right:10px">

		<?php 


		if($total_reg > 0){
			for($i=0; $i < $total_reg; $i++){
				foreach ($res[$i] as $key => $value){} 

					$titulo = $res[$i]['titulo'];	
				$data = $res[$i]['data'];
				$hora = $res[$i]['hora'];
				$descricao = $res[$i]['descricao'];
				$status = $res[$i]['status'];

				$id = $res[$i]['id'];

				$dataF = implode('/', array_reverse(explode('-', $data)));


				if($data < $data_atual || $hora < $hora_atual){
					$classe_icon = 'text-danger';
					$borda_card = 'bordacardsede';
				}else{
					$classe_icon = 'text-primary';
					$borda_card = 'bordacardtarefa';
				}


				?>

				<div class="col-xl-3 col-md-6 col-12 mb-4 linkcard">
					<a href="index.php?pag=tarefas">
						<div class="card text-danger shadow h-100 <?php echo $borda_card ?>">
							<div class="card-body">
								<div class="row no-gutters align-items-center">
									<div class="col mr-2">
										<div class="text-xs font-weight-bold text-primary text-uppercase titulocard"><?php echo $dataF ?></div>
										<div class="text-xs font-weight-bold text-danger text-uppercase titulocard"><?php echo $titulo ?></div>
										<div class="text-xs text-secondary subtitulocard"><?php echo$descricao ?> </div>
									</div>
									<div class="col-auto" align="center">
										<h2 style="margin:1px" class="bi bi-calendar2-check <?php echo $classe_icon ?>"></h2>
										<span class="text-xs totaiscard text-danger"><?php echo $hora ?></span>
									</div>
								</div>
							</div>
						</div>
					</a>
				</div>



			<?php } }else{
				echo '<small>Não existem tarefas Pendentes!!</small>';
			} ?>

		</div>
	</div>