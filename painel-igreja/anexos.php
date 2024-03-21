<?php 
require_once("../conexao.php");
require_once("verificar.php");
$pagina = 'anexos';

?>

<div class="row my-3">
	<div class="col-md-2">
		<a href="#" onclick="inserir()" type="button" class="btn btn-dark btn-sm">Novo Anexo</a>
	</div>
	
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
					<th class="esc">Descrição</th>
					<th >Arquivo</th>
					<th class="esc">Data</th>
					<th class="esc">Secretário / Pastor</th>
										
					<th>Ações</th>
				</tr>		
			</thead>
			<tbody>
				<?php 
				for($i=0; $i < $total_reg; $i++){
					foreach ($res[$i] as $key => $value){} 

					$descricao = $res[$i]['descricao'];
					$nome = $res[$i]['nome'];
					$usuario = $res[$i]['usuario'];
					$data = $res[$i]['data'];
					$arquivo = $res[$i]['arquivo'];
					$igreja = $res[$i]['igreja'];
					
					$id = $res[$i]['id'];


					//EXTRAIR EXTENSÃO DO ARQUIVO
					$ext = pathinfo($arquivo, PATHINFO_EXTENSION);   
					if($ext == 'pdf'){ 
						$tumb_arquivo = 'pdf.png';
					}else if($ext == 'rar' || $ext == 'zip'){
						$tumb_arquivo = 'rar.png';
					}else if($ext == 'doc' || $ext == 'docx'){
						$tumb_arquivo = 'word.png';
					}else{
						$tumb_arquivo = $arquivo;
					}


					$query_con = $pdo->query("SELECT * FROM usuarios where id = '$usuario'");
					$res_con = $query_con->fetchAll(PDO::FETCH_ASSOC);
					if(count($res_con) > 0){
						$usuario_cad = $res_con[0]['nome'];

					}else{
						$usuario_cad = '';
					}

					$dataF = implode('/', array_reverse(explode('-', $data)));
					?>			
					<tr>
						<td><?php echo $nome ?></td>
						<td class="esc"><?php echo $descricao ?></td>
						<td class="esc">
							<a href="../img/documentos/<?php echo $arquivo ?>" target="_blank">
								<img src="../img/documentos/<?php echo $tumb_arquivo ?>" width="30px">
							</a>
						</td>
						<td class="esc"><?php echo $dataF ?></td>
						<td class="esc"><?php echo $usuario_cad ?></td>
						
						<td>
							<a href="#" onclick="editar('<?php echo $id ?>', '<?php echo $nome ?>', '<?php echo $descricao ?>', '<?php echo $tumb_arquivo ?>', '<?php echo $data ?>')" title="Editar Registro">	<i class="bi bi-pencil-square text-primary"></i> </a>

							<a href="#" onclick="excluir('<?php echo $id ?>' , '<?php echo $nome ?>')" title="Excluir Registro">	<i class="bi bi-trash text-danger"></i> </a>

							<a href="#" onclick="dados('<?php echo $nome ?>', '<?php echo $descricao ?>', '<?php echo $tumb_arquivo ?>', '<?php echo $dataF ?>', '<?php echo $usuario_cad ?>')" title="Ver Dados">	<i class="bi bi-info-square-fill text-primary"></i> </a>
												

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
		<div class="modal-dialog modal-lg">
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
									<label for="exampleFormControlInput1" class="form-label">Nome</label>
									<input type="text" class="form-control" id="nome" name="nome" placeholder="Nome do Documento"  required>
								</div>
							</div>
							<div class="col-md-6">

								<div class="mb-3">
										<label for="exampleFormControlInput1" class="form-label">Data</label>
										<input type="date" class="form-control" id="data" name="data" value="<?php echo $data_atual ?>" required>
									</div>

								
								</div>

								
							</div>

							<div class="mb-3">
									<label for="exampleFormControlInput1" class="form-label">Descrição (Max 255 Caracteres)</label>
									<input maxlength="255" type="text" class="form-control" id="descricao" name="descricao" placeholder="Insira a Descrição">
								</div>

							<div class="row">
							
							<div class="col-md-5">
										<div class="mb-3">
											<label for="exampleFormControlInput1" class="form-label">Arquivo <small>(*pdf, *word, *imagens, *rar ou zip)</small></label>
											<input type="file" class="form-control-file" id="imagem" name="imagem" onChange="carregarImg();">
										</div>
									</div>
									<div class="col-md-2">
										<div id="divImg" class="mt-4">
											<img src="../img/documentos/sem-foto.jpg"  width="100px" id="target">									
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
							<h5 class="modal-title" id="exampleModalLabel">Documento : <span id="nome-dados"></span></h5>
							<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
						</div>

						<div class="modal-body">

							<span class=""><b>Descricao:</b> <span id="descricao-dados"></span></span>
							<hr style="margin:4px">

							<span class=""><b>Data Cadastro: </b> <span id="data-dados"></span></span>
							<hr style="margin:4px">

							<span class=""><b>Pastor / Secretário:</b> <span id="usuario-dados"></span></span>
							<hr style="margin:4px">

						
							<span class=""><img src="" id="foto-dados" width="200px"></span>
							<hr style="margin:4px">


						</div>

					</form>
				</div>
			</div>
		</div>




		



		<script type="text/javascript">var pag = "<?=$pagina?>"</script>
		<script src="../js/ajax.js"></script>


		<script type="text/javascript">

			function editar(id, nome, descricao, arquivo, data){
				$('#id').val(id);
				$('#descricao').val(descricao);
				$('#nome').val(nome);
				$('#data').val(data);
				$('#target').attr('src', '../img/documentos/' + arquivo);

				
				$('#tituloModal').text('Editar Registro');
				var myModal = new bootstrap.Modal(document.getElementById('modalForm'), {		});
				myModal.show();
				$('#mensagem').text('');
			}



			function dados(nome, descricao, arquivo, data, usuario){

				$('#descricao-dados').text(descricao);
				$('#nome-dados').text(nome);
				$('#data-dados').text(data);
				$('#usuario-dados').text(usuario);
				$('#foto-dados').attr('src', '../img/documentos/' + arquivo);


				var myModal = new bootstrap.Modal(document.getElementById('modalDados'), {		});
				myModal.show();
				$('#mensagem').text('');
			}




			function limpar(){
				var data_at = "<?=$data_atual?>"

				$('#id').val('');
				$('#descricao').val('');		
				$('#nome').val('');
				
				$('#target').attr('src', '../img/documentos/sem-foto.jpg');
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