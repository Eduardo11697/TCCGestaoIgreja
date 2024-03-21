<?php 
require_once("../conexao.php");
require_once("verificar.php");
require_once("deslogar-tesoureiro.php");

$pagina = 'cultos';
?>

<div class="col-md-12 my-3">
	<a href="#" onclick="inserir()" type="button" class="btn btn-dark btn-sm">Novo Culto</a>
</div>

<div class="tabela bg-light">
	<?php 

	$query = $pdo->query("SELECT * FROM $pagina where igreja = '$id_igreja' order by id desc");
	$res = $query->fetchAll(PDO::FETCH_ASSOC);
	$total_reg = count($res);
	if($total_reg > 0){

		?>

		<table id="example" class="table table-striped table-light table-hover my-4 my-4" style="width:100%">
			<thead>			
				<tr>
					<th>Nome</th>
					<th class="">Dia</th>
					<th class="esc">Hora</th>	
					<th class="esc">Descrição</th>	
					<th>Ações</th>
				</tr>		
			</thead>
			<tbody>
				<?php 
				for($i=0; $i < $total_reg; $i++){
					foreach ($res[$i] as $key => $value){} 

					$nome = $res[$i]['nome'];	
					$dia = $res[$i]['dia'];
					$hora = $res[$i]['hora'];
					$descricao = $res[$i]['descricao'];
					$obs = $res[$i]['obs'];
					$igreja = $res[$i]['igreja'];
					$id = $res[$i]['id'];


					if($obs != ""){
						$classe_obs = 'text-warning';
					}else{
						$classe_obs = 'text-secondary';
					}

				
					?>			
					<tr>
						<td class=""><?php echo $nome ?></td>
						<td class=""><?php echo $dia ?></td>
						<td class="esc"><?php echo $hora ?></td>
						<td class="esc"><?php echo $descricao ?></td>
						<td>

							<a href="#" onclick="editar('<?php echo $id ?>', '<?php echo $nome ?>', '<?php echo $dia ?>', '<?php echo $hora ?>', '<?php echo $descricao ?>')" title="Editar Registro">	<i class="bi bi-pencil-square text-primary"></i> </a>

							<a href="#" onclick="excluir('<?php echo $id ?>' , '<?php echo $nome ?>')" title="Excluir Registro">	<i class="bi bi-trash text-danger"></i> </a>


							<a href="#" onclick="obs('<?php echo $id ?>','<?php echo $nome ?>', '<?php echo $obs ?>')" title="Observações">	<i class="bi bi-chat-right-text <?php echo $classe_obs ?>"></i> </a>

							

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
							<label for="exampleFormControlInput1" class="form-label">Nome</label>
							<input type="text" class="form-control" id="nome" name="nome" placeholder="Ex: Culto de Adoração" required>
						</div>

						<div class="mb-3">
							<label for="exampleFormControlInput1" class="form-label">Dia</label>
							<input type="text" class="form-control" id="dia" name="dia" placeholder="Ex: Domingo" required>
						</div>

						<div class="mb-3">
									<label for="exampleFormControlInput1" class="form-label">Hora</label>
									<input type="time" class="form-control" id="hora" name="hora" required>
								</div>

						<div class="mb-3">
							<label for="exampleFormControlInput1" class="form-label">Descrição</label>
							<input type="text" maxlength="255" class="form-control" id="descricao" name="descricao" placeholder="Insira a Descrição" >
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



	

<!-- Modal -->
<div class="modal fade" id="modalObs" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel"><span id="tituloModal">Observações - <span id="nome-obs"></span></span></h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<form id="form-obs" method="post">
				<div class="modal-body">

					<div class="mb-3">
						<label for="exampleFormControlInput1" class="form-label">Observações (Máximo 500 Caracteres)</label>
						<textarea class="form-control" id="obs" name="obs" maxlength="500" style="height:200px"></textarea>
					</div>

					

					<small><div id="mensagem-obs" align="center"></div></small>

					<input type="hidden" class="form-control" name="id-obs"  id="id-obs">


				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="btn-fechar-obs">Fechar</button>
					<button type="submit" class="btn btn-primary">Salvar</button>
				</div>
			</form>
		</div>
	</div>
</div>





	<script type="text/javascript">var pag = "<?=$pagina?>"</script>
	<script src="../js/ajax.js"></script>


	<script type="text/javascript">

		function editar(id, nome, dia, hora, descricao){
			$('#id').val(id);
			$('#nome').val(nome);
			$('#descricao').val(descricao);
			$('#dia').val(dia);
			$('#hora').val(hora);

			$('#tituloModal').text('Editar Registro');
			var myModal = new bootstrap.Modal(document.getElementById('modalForm'), {		});
			myModal.show();
			$('#mensagem').text('');
		}





		function limpar(){
			
			$('#id').val('');
			$('#nome').val('');
			$('#descricao').val('');
			$('#dia').val('');
			$('#hora').val('');		

		}


		function obs(id, nome, obs){
		console.log(obs)
		
		for (let letra of obs){  				
			if (letra === '+'){
				obs = obs.replace(' +  + ', '\n')
			}			
		}


		$('#nome-obs').text(nome);
		$('#id-obs').val(id);
		$('#obs').val(obs);
		

		
		var myModal = new bootstrap.Modal(document.getElementById('modalObs'), {		});
		myModal.show();
		$('#mensagem-obs').text('');
	}

	</script>