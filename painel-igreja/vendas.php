<?php 
require_once("../conexao.php");
require_once("verificar.php");
$pagina = 'vendas';
?>

<div class="col-md-12 my-3">
	<a href="#" onclick="inserir()" type="button" class="btn btn-dark btn-sm">Nova Venda</a>
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
					<th>Valor</th>
					<th class="">Descrição</th>
					<th class="esc">Data</th>	
					<th class="esc">Tesoureiro / Pastor</th>	
					
					<th>Ações</th>
				</tr>		
			</thead>
			<tbody>
				<?php 
				for($i=0; $i < $total_reg; $i++){
					foreach ($res[$i] as $key => $value){} 

						$valor = $res[$i]['valor'];	
					$data = $res[$i]['data'];
					$descricao = $res[$i]['descricao'];
					$usuario = $res[$i]['usuario'];
					
					$id = $res[$i]['id'];

					$dataF = implode('/', array_reverse(explode('-', $data)));
					$valorF = number_format($valor, 2, ',', '.');


					
					$query_con = $pdo->query("SELECT * FROM usuarios where id = '$usuario'");
					$res_con = $query_con->fetchAll(PDO::FETCH_ASSOC);
					if(count($res_con) > 0){
						$usuario_cad = $res_con[0]['nome'];
						$nivel_usuario = $res_con[0]['nivel'];
					}else{
						$usuario_cad = '';
						$nivel_usuario = '';
					}

					
					?>			
					<tr>
						<td>R$ <?php echo $valorF ?></td>
						<td class="esc"><?php echo $descricao ?></td>
						<td class=""><?php echo $dataF ?></td>						
						<td class="esc"><?php echo $usuario_cad . ' <small>('. $nivel_usuario. ')</small>' ?></td>

						<td>

							<a href="#" onclick="editar('<?php echo $id ?>', '<?php echo $descricao ?>', '<?php echo $valor ?>', '<?php echo $data ?>', '<?php echo $usuario ?>')" title="Editar Registro">	<i class="bi bi-pencil-square text-primary"></i> </a>

							<a href="#" onclick="excluir('<?php echo $id ?>' , '<?php echo $valor ?>')" title="Excluir Registro">	<i class="bi bi-trash text-danger"></i> </a>

							
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

					<div class="row">
						<div class="col-md-6">
							<div class="mb-3">
								<label for="exampleFormControlInput1" class="form-label">Valor </label>
								<input type="text"  class="form-control" id="valor" name="valor" placeholder="Valor da Doação" required>
							</div>
						</div>
						<div class="col-md-6">
							<div class="mb-3">
								<label for="exampleFormControlInput1" class="form-label">Data </label>
								<input type="date"  class="form-control" id="data" name="data"  required>
							</div>	
						</div>
					</div>


					<div class="mb-3">
								<label for="exampleFormControlInput1" class="form-label">Descrição </label>
								<input type="text"  class="form-control" id="descricao" name="descricao" placeholder="Vendas da Cantina" required>
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

		function editar(id, descricao, valor, data){
			$('#id').val(id);
			$('#descricao').val(descricao);
			$('#valor').val(valor);
			$('#data').val(data);
			
			$('#tituloModal').text('Editar Registro');
			var myModal = new bootstrap.Modal(document.getElementById('modalForm'), {		});
			myModal.show();
			$('#mensagem').text('');
		}





		function limpar(){
			var data = "<?=$data_atual?>"

			$('#id').val('');
			$('#data').val(data);
			$('#valor').val('');
			$('#descricao').val('');
			


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