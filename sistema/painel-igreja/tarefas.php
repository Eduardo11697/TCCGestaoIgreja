<?php 
require_once("../conexao.php");
require_once("verificar.php");
$pagina = 'tarefas';
?>

<div class="col-md-12 my-3">
	<a href="#" onclick="inserir()" type="button" class="btn btn-dark btn-sm">Nova Tarefa</a>
</div>

<div class="tabela bg-light">
	<?php 

	$query = $pdo->query("SELECT * FROM $pagina where igreja = '$id_igreja' order by status asc, data asc, hora asc");
	$res = $query->fetchAll(PDO::FETCH_ASSOC);
	$total_reg = count($res);
	if($total_reg > 0){

		?>

		<table id="example" class="table table-striped table-light table-hover my-4 my-4" style="width:100%">
			<thead>			
				<tr>
					<th>Título</th>
					<th class="esc">Descrição</th>
					<th class="esc">Hora</th>	
					<th class="">Data</th>	
					<th class="esc">Status</th>	
					<th>Ações</th>
				</tr>		
			</thead>
			<tbody>
				<?php 
				for($i=0; $i < $total_reg; $i++){
					foreach ($res[$i] as $key => $value){} 

					$titulo = $res[$i]['titulo'];	
					$data = $res[$i]['data'];
					$hora = $res[$i]['hora'];
					$descricao = $res[$i]['descricao'];
					$status = $res[$i]['status'];
					$igreja = $res[$i]['igreja'];
					$id = $res[$i]['id'];

					$dataF = implode('/', array_reverse(explode('-', $data)));


					if($status == 'Concluída'){
						$classe = 'text-success';
						$ativo = 'Reagendar Tarefa';
						$icone = 'bi-check-square';
						$ativar = 'Agendada';
						$inativa = '';
						

					}else{
						$classe = 'text-danger';
						$ativo = 'Concluir Tarefa';
						$icone = 'bi-square';
						$ativar = 'Concluída';
						$inativa = 'text-muted';
						
					}
					?>			
					<tr>
						<td>
<small><small><i class="bi bi-circle-fill <?php echo $classe ?> mr-1"></i></small></small>
							<?php echo $titulo ?>
						</td>
						<td class="esc"><?php echo $descricao ?></td>
						<td><?php echo $dataF ?></td>
						<td class="esc"><?php echo $hora ?></td>
						<td class="esc"><?php echo $status ?></td>

						<td>

							<a href="#" onclick="editar('<?php echo $id ?>', '<?php echo $titulo ?>', '<?php echo $descricao ?>', '<?php echo $data ?>', '<?php echo $hora ?>')" title="Editar Registro">	<i class="bi bi-pencil-square text-primary"></i> </a>

							<a href="#" onclick="excluir('<?php echo $id ?>' , '<?php echo $descricao ?>')" title="Excluir Registro">	<i class="bi bi-trash text-danger"></i> </a>

							<a href="#" onclick="mudarStatus('<?php echo $id ?>', '<?php echo $ativar ?>')" title="<?php echo $ativo ?>">
								<i class="bi <?php echo $icone ?> <?php echo $classe ?>"></i></a>

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
		<div class="modal-dialog ">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="tituloModal"></h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<form id="form" method="post">
					<div class="modal-body">

						<div class="mb-3">
							<label for="exampleFormControlInput1" class="form-label">Título <small>(Max 25 Caracteres)</small></label>
							<input type="text" maxlength="25" class="form-control" id="titulo" name="titulo" placeholder="Título da Tarefa" required>
						</div>

						<div class="mb-3">
							<label for="exampleFormControlInput1" class="form-label">Descrição</label>
							<input type="text" maxlength="50" class="form-control" id="descricao" name="descricao" placeholder="Insira a Descrição" >
						</div>

						<div class="row">
							<div class="col-md-6">
								<div class="mb-3">
									<label for="exampleFormControlInput1" class="form-label">Data</label>
									<input type="date" class="form-control" id="data" name="data" value="<?php echo $data_atual ?>" required>
								</div>
							</div>
							<div class="col-md-6">
								<div class="mb-3">
									<label for="exampleFormControlInput1" class="form-label">Hora</label>
									<input type="time" class="form-control" id="hora" name="hora" required>
								</div>
							</div>
						</div>


						<input type="hidden" id="id" name="id">
						<input type="hidden" id="igreja" name="igreja" value="<?php echo $id_igreja ?>">

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



	<script type="text/javascript">var pag = "<?=$pagina?>"</script>
	<script src="../js/ajax.js"></script>


	<script type="text/javascript">

		function editar(id, titulo, descricao, data, hora){
			$('#id').val(id);
			$('#titulo').val(titulo);
			$('#descricao').val(descricao);
			$('#data').val(data);
			$('#hora').val(hora);

			$('#tituloModal').text('Editar Registro');
			var myModal = new bootstrap.Modal(document.getElementById('modalForm'), {		});
			myModal.show();
			$('#mensagem').text('');
		}





		function limpar(){
			var data = "<?=$data_atual?>";

			$('#id').val('');
			$('#titulo').val('');
			$('#descricao').val('');
			$('#data').val(data);
			$('#hora').val('');		

		}

	</script>