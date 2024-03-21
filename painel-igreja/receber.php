<?php 
require_once("../conexao.php");
require_once("verificar.php");
$pagina = 'receber';
if(@$_GET['filtrar'] == 'Vencidas'){
	$classe_vencidas = 'text-primary';
	$classe_hoje = 'text-dark';
	$classe_todas = 'text-dark';

	$query = $pdo->query("SELECT * FROM $pagina where igreja = '$id_igreja' and vencimento < curDate() and pago != 'Sim' order by vencimento asc, id asc");

}else if(@$_GET['filtrar'] == 'Hoje'){
	$classe_vencidas = 'text-dark';
	$classe_hoje = 'text-primary';
	$classe_todas = 'text-dark';

	$query = $pdo->query("SELECT * FROM $pagina where igreja = '$id_igreja' and vencimento = curDate() and pago != 'Sim' order by vencimento asc, id asc");

}else{
	$classe_vencidas = 'text-dark';
	$classe_hoje = 'text-dark';
	$classe_todas = 'text-primary';

	$query = $pdo->query("SELECT * FROM $pagina where igreja = '$id_igreja' order by pago asc, vencimento asc, id asc");
}



?>

<div class="row my-3">
	<div class="col-md-2">
		<a href="#" onclick="inserir()" type="button" class="btn btn-dark btn-sm">Nova Conta</a>
	</div>

	
	<div class="col-md-10 mt-1">
		<small>
		<a href="index.php?pag=<?php echo $pagina ?>" class="<?php echo $classe_todas ?>"> Todas </a> /
		<a href="index.php?pag=<?php echo $pagina ?>&filtrar=Vencidas" class="<?php echo $classe_vencidas ?>"> Vencidas </a> / 
		<a href="index.php?pag=<?php echo $pagina ?>&filtrar=Hoje" class="<?php echo $classe_hoje ?>"> Vencendo Hoje </a> 
		
		</small>
	</div>
	
</div>


<div class="tabela bg-light">
	<?php 
	$res = $query->fetchAll(PDO::FETCH_ASSOC);
	$total_reg = count($res);
	if($total_reg > 0){

		?>

		<table id="example" class="table table-striped table-light table-hover my-4 my-4" style="width:100%">
			<thead>			
				<tr>
					<th>Descrição</th>
					<th class="esc">Membro</th>
					<th >Valor</th>
					<th class="esc">Vencimento</th>
					<th class="esc">Tesoureiro / Pastor</th>
					<th class="d-none">Pago</th>
					
					<th>Ações</th>
				</tr>		
			</thead>
			<tbody>
				<?php 
				for($i=0; $i < $total_reg; $i++){
					foreach ($res[$i] as $key => $value){} 

						$descricao = $res[$i]['descricao'];
					$membro = $res[$i]['membro'];
					$valor = $res[$i]['valor'];
					$vencimento = $res[$i]['vencimento'];
					
					$pago = $res[$i]['pago'];

					$usuario_cad = $res[$i]['usuario_cad'];
					$usuario_baixa = $res[$i]['usuario_baixa'];
					$data_baixa = $res[$i]['data_baixa'];
					$data = $res[$i]['data'];
					$igreja = $res[$i]['igreja'];
					
					$id = $res[$i]['id'];


					


					if($pago == 'Sim'){
						$classe = 'text-success';
						$ocultar = 'd-none';

					}else{
						$classe = 'text-danger';
						$ocultar = '';
					}

					if($vencimento >= $data_atual){
						$classe_linha = '';

					}else{
						if($pago != 'Sim'){
							$classe_linha = 'text-danger';
						}else{
							$classe_linha = '';
						}						

					}


					$query_con = $pdo->query("SELECT * FROM membros where id = '$membro'");
					$res_con = $query_con->fetchAll(PDO::FETCH_ASSOC);
					if(count($res_con) > 0){
						$nome_mem = $res_con[0]['nome'];
					}else{
						$nome_mem = 'Sem Membro';
					}

					$query_con = $pdo->query("SELECT * FROM usuarios where id = '$usuario_cad'");
					$res_con = $query_con->fetchAll(PDO::FETCH_ASSOC);
					if(count($res_con) > 0){
						$usuario_cad = $res_con[0]['nome'];
						
					}else{
						$usuario_cad = '';
					}


					$query_con = $pdo->query("SELECT * FROM usuarios where id = '$usuario_baixa'");
					$res_con = $query_con->fetchAll(PDO::FETCH_ASSOC);
					if(count($res_con) > 0){
						$usuario_baixa = $res_con[0]['nome'];
					}else{
						$usuario_baixa = '';
					}


					

					$valorF = number_format($valor, 2, ',', '.');
					$dataF = implode('/', array_reverse(explode('-', $data)));
					$data_baixaF = implode('/', array_reverse(explode('-', $data_baixa)));
					$vencimentoF = implode('/', array_reverse(explode('-', $vencimento)));
					?>			
					<tr class="<?php echo $classe_linha ?>">
						<td>
							<i class="bi bi-square-fill <?php echo $classe ?>"></i>
							<?php echo $descricao ?>

						</td>
						<td class="esc"><?php echo $nome_mem ?></td>
						<td >R$ <?php echo $valorF ?></td>
						<td class="esc"><?php echo $vencimentoF ?></td>
						<td class="esc"><?php echo $usuario_cad ?></td>
												

						<td class="d-none"><?php echo $pago ?></td>
						
						<td>
							<a href="#" onclick="editar('<?php echo $id ?>', '<?php echo $descricao ?>', '<?php echo $membro ?>', '<?php echo $valor ?>', '<?php echo $vencimento ?>')" title="Editar Registro">	<i class="bi bi-pencil-square text-primary <?php echo $ocultar ?>"></i> </a>

							<a href="#" onclick="excluir('<?php echo $id ?>' , '<?php echo $descricao ?>')" title="Excluir Registro">	<i class="bi bi-trash text-danger <?php echo $ocultar ?>"></i> </a>

							<a href="#" onclick="dados('<?php echo $descricao ?>', '<?php echo $nome_mem ?>', '<?php echo $valorF ?>', '<?php echo $dataF ?>', '<?php echo $vencimentoF ?>', '<?php echo $usuario_cad ?>', '<?php echo $usuario_baixa ?>', '<?php echo $data_baixaF ?>', '<?php echo $pago ?>')" title="Ver Dados">	<i class="bi bi-info-square-fill text-primary"></i> </a>

							
							<a href="#" onclick="baixar('<?php echo $id ?>', '<?php echo $descricao ?>')" title="Dar Baixa na Conta">
								<i class="bi bi-check-square-fill text-success <?php echo $ocultar ?>"></i></a>

							</td>
						</tr>	
					<?php } ?>	
				</tbody>
			</table>
		<?php }else{
			echo 'Não Existem Dados Cadastrados';
		} ?>
	</div>


	<div class="modal fade" id="modalForm" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="tituloModal"></h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<form id="form" method="post">
					<div class="modal-body">
						<div class="row">
							<div class="col-md-6">
								<div class="mb-3">
									<label for="exampleFormControlInput1" class="form-label">Descrição</label>
									<input type="text" class="form-control" id="descricao" name="descricao" placeholder="Insira a Descrição"  required>
								</div>
							</div>
							<div class="col-md-6">
								<div class="mb-3">
									<label for="exampleFormControlInput1" class="form-label">Membro</label>
									<select class="form-control sel2" id="membro" name="membro" style="width:100%;" required>
										
										<?php 
										$query = $pdo->query("SELECT * FROM membros order by id asc");
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


							</div>
							<div class="row">

								<div class="col-md-6">
									<div class="mb-3">
										<label for="exampleFormControlInput1" class="form-label">Valor</label>
										<input type="text" class="form-control" id="valor" name="valor" placeholder="Insira o Valor" required>
									</div>
								</div>

								<div class="col-md-6">
									<div class="mb-3">
										<label for="exampleFormControlInput1" class="form-label">Vencimento</label>
										<input type="date" class="form-control" id="vencimento" name="vencimento" value="<?php echo $data_atual ?>" required>
									</div>
								</div>

							


								</div>


								<input type="hidden" id="id" name="id">
								<input type="hidden" id="igreja2" name="igreja" value="<?php echo $id_igreja ?>">

							</div>
							<small><div align="center" id="mensagem"></div></small>
							<div class="modal-footer">
								<button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="btn-fechar">Fechar</button>
								<button type="submit" class="btn btn-primary">Salvar</button>
							</div>
						</form>
					</div>
				</div>
			</div>





			<!-- Modal -->
			<div class="modal fade" id="modalExcluir" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" id="exampleModalLabel"><span id="tituloModal">Excluir Registro</span></h5>
							<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
						</div>
						<form id="form-excluir" method="post">
							<div class="modal-body">

								Deseja Realmente excluir este Registro: <span id="nome-excluido"></span>?

								<small><div id="mensagem-excluir" align="center"></div></small>

								<input type="hidden" class="form-control" name="id-excluir"  id="id-excluir">


							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="btn-fechar-excluir">Fechar</button>
								<button type="submit" class="btn btn-danger">Excluir</button>
							</div>
						</form>
					</div>
				</div>
			</div>



			<div class="modal fade" id="modalDados" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" id="exampleModalLabel">Descrição : <span id="descricao-dados"></span></h5>
							<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
						</div>

						<div class="modal-body">

							<span class=""><b>Membro:</b> <span id="forn-dados"></span></span>
							<hr style="margin:4px">

							<span class=""><b>Valor: R$</b> <span id="valor-dados"></span></span>
							<hr style="margin:4px">

							<span class=""><b>Data Cadastro:</b> <span id="data-dados"></span></span>
							<hr style="margin:4px">

							<span class=""><b>Vencimento:</b> <span id="venc-dados"></span></span>
							<hr style="margin:4px">

							<span class=""><b>Usuário Cadastro:</b> <span id="usu-dados"></span></span>
							<hr style="margin:4px">

							<span class=""><b>Usuário Baixa:</b> <span id="usu-baixa-dados"></span></span>
							<hr style="margin:4px">

							<span class=""><b>Data Baixa:</b> <span id="data-baixa-dados"></span></span>
							<hr style="margin:4px">

							
							<span class=""><b>Pago:</b> <span id="pago-dados"></span></span>
							<hr style="margin:4px">

							

						</div>

					</form>
				</div>
			</div>
		</div>




		<!-- Modal -->
		<div class="modal fade" id="modalBaixar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="exampleModalLabel"><span id="tituloModal">Confirmar Pagamento</span></h5>
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<form id="form-excluir" method="post">
						<div class="modal-body">

							Deseja Realmente dar baixa nesta conta: <span id="descricao-baixar"></span>?

							<small><div id="mensagem-excluir" align="center"></div></small>

							<input type="hidden" class="form-control" name="id-baixar"  id="id-baixar">


						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="btn-fechar-baixar">Fechar</button>
							<a href="#" onclick="mudarStatus($('#id-baixar').val())" class="btn btn-success">Baixar</a>
						</div>
					</form>
				</div>
			</div>
		</div>




		<script type="text/javascript">var pag = "<?=$pagina?>"</script>
		<script src="../js/ajax.js"></script>


		<script type="text/javascript">

			function editar(id, descricao, membro, valor, vencimento){
				$('#id').val(id);
				$('#descricao').val(descricao);

				$('#valor').val(valor);
				$('#vencimento').val(vencimento);
				$('#membro').val(membro).change();
				
				$('#tituloModal').text('Editar Registro');
				var myModal = new bootstrap.Modal(document.getElementById('modalForm'), {		});
				myModal.show();
				$('#mensagem').text('');
			}



			function dados(descricao, membro, valor, data, vencimento, usuario_cad, usuario_baixa, data_baixa, pago){

				if(data_baixa === '00/00/0000'){
					data_baixa = 'Pendente';
				}


				$('#descricao-dados').text(descricao);
				$('#forn-dados').text(membro);
				$('#valor-dados').text(valor);
				$('#data-dados').text(data);
				$('#venc-dados').text(vencimento);
				$('#usu-dados').text(usuario_cad);
				$('#usu-baixa-dados').text(usuario_baixa);
				$('#data-baixa-dados').text(data_baixa);
				
				$('#pago-dados').text(pago);
				
				var myModal = new bootstrap.Modal(document.getElementById('modalDados'), {		});
				myModal.show();
				$('#mensagem').text('');
			}




			function limpar(){
				var data_at = "<?=$data_atual?>"

				$('#id').val('');
				$('#descricao').val('');		
				$('#valor').val('');
				$('#vencimento').val(data_at);		

				document.getElementById("membro").options.selectedIndex = 0;
				$('#membro').val($('#membro').val()).change();

				
			}


			function baixar(id, descricao){
				$('#id-baixar').val(id);
				$('#descricao-baixar').text(descricao);
				var myModal = new bootstrap.Modal(document.getElementById('modalBaixar'), {       });
				myModal.show();
				$('#mensagem-baixar').text('');
				limpar();
			}

		</script>



		<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
		<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

		<script>
			$(document).ready(function() {
				$('.sel2').select2({
			//placeholder: 'Selecione um Cliente',
			dropdownParent: $('#modalForm')
		});
			});
		</script>

		<style type="text/css">
			.select2-selection__rendered {
				line-height: 36px !important;
				font-size:16px !important;
				color:#666666 !important;

			}

			.select2-selection {
				height: 36px !important;
				font-size:16px !important;
				color:#666666 !important;

			}
		</style>  