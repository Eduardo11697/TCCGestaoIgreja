<?php 
require_once("../conexao.php");
require_once("verificar.php");
require_once("deslogar-tesoureiro.php");
require_once("deslogar-secretario.php");
$pagina = 'alertas';
?>

<div class="row my-3" style="margin-right:20px">
	<div class="col-md-2">
		<a href="#" onclick="inserir()" type="button" class="btn btn-dark btn-sm">Novo Alerta</a>
	</div>


</div>

<div class="tabela bg-light">
	<?php 

	$query = $pdo->query("SELECT * FROM $pagina where igreja = '$id_igreja'  order by id desc");
	$res = $query->fetchAll(PDO::FETCH_ASSOC);
	$total_reg = count($res);
	if($total_reg > 0){

		?>

		<table id="example" class="table table-striped table-light table-hover my-4 my-4" style="width:100%">
			<thead>			
				<tr>
					<th>Título</th>
					<th>Data Expiração</th>
					<th class="esc">Usuário</th>
					<th class="esc">Ativo</th>
					<th class="esc">Foto</th>				
					<th>Ações</th>
				</tr>		
			</thead>
			<tbody>
				<?php 
				for($i=0; $i < $total_reg; $i++){
					foreach ($res[$i] as $key => $value){} 

						$titulo = $res[$i]['titulo'];
					$descricao = $res[$i]['descricao'];
					$link = $res[$i]['link'];
					$foto = $res[$i]['imagem'];
					$data = $res[$i]['data'];
					$usuario = $res[$i]['usuario'];
					$igreja = $res[$i]['igreja'];
					$ativo = $res[$i]['ativo'];
					
					$id = $res[$i]['id'];


					
					if($ativo == 'Sim'){
						$classe = 'text-success';
						$ativo = 'Desativar Item';
						$icone = 'bi-check-square';
						$ativar = 'Não';
						$inativa = '';
						$tab = 'Ativo';

					}else{
						$classe = 'text-danger';
						$ativo = 'Ativar Item';
						$icone = 'bi-square';
						$ativar = 'Sim';
						$inativa = 'text-muted';
						$tab = 'Inativo';
					}

					$query_con = $pdo->query("SELECT * FROM usuarios where id = '$usuario'");
					$res_con = $query_con->fetchAll(PDO::FETCH_ASSOC);
					if(count($res_con) > 0){
						$nome_usu_cad = $res_con[0]['nome'];
					}else{
						$nome_usu_cad = '';
					}

							

					$dataF = implode('/', array_reverse(explode('-', $data)));
					
					?>			
					<tr class="<?php echo $inativa ?> <?php echo $classe_item ?>">
						<td><?php echo $titulo ?></td>
						<td><?php echo $dataF ?></td>
						<td class="esc"><?php echo $nome_usu_cad ?></td>
						<td class="esc"><?php echo $tab ?></td>
											
						<td class="esc"><img src="../img/alertas/<?php echo $foto ?>" width="30px"></td>

					
						
						<td>
							<big>
								<a href="#" onclick="editar('<?php echo $id ?>', '<?php echo $titulo ?>', '<?php echo $descricao ?>', '<?php echo $link ?>', '<?php echo $foto ?>', '<?php echo $data ?>')" title="Editar Registro">	<i class="bi bi-pencil-square text-primary"></i> </a>

								<a href="#" onclick="excluir('<?php echo $id ?>' , '<?php echo $titulo ?>')" title="Excluir Registro">	<i class="bi bi-trash text-danger"></i> </a>

								<a href="#" onclick="dados('<?php echo $titulo ?>', '<?php echo $descricao ?>', '<?php echo $link ?>', '<?php echo $foto ?>', '<?php echo $dataF ?>', '<?php echo $ativo ?>', '<?php echo $nome_usu_cad ?>')" title="Ver Dados">	<i class="bi bi-info-square-fill text-primary"></i> </a>

								

								<a href="#" onclick="mudarStatus('<?php echo $id ?>', '<?php echo $ativar ?>')" title="<?php echo $ativo ?>">
									<i class="bi <?php echo $icone ?> <?php echo $classe ?>"></i></a>

								
								</big>

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
							<div class="col-md-4">
								<div class="mb-3">
									<label for="exampleFormControlInput1" class="form-label">Título</label>
									<input type="text" class="form-control" id="titulo" name="titulo" placeholder="Título do Alerta"  required>
								</div>
							</div>
							<div class="col-md-5">
								<div class="mb-3">
									<label for="exampleFormControlInput1" class="form-label">Link <small>(Se Existir)</small></label>
									<input type="text" class="form-control" id="link" name="link" placeholder="Insira o Link" >
								</div>
							</div>

							<div class="col-md-3">
								<div class="mb-3">
									<label for="exampleFormControlInput1" class="form-label">Data Expiração</label>
									<input type="date" class="form-control" id="data" name="data" value="<?php echo date('Y-m-d') ?>" required>
								</div>
							</div>


						</div>

						<div class="mb-3">
									<label for="exampleFormControlInput1" class="form-label">Descrição (Max 500 Caracteres)</label>
									<textarea maxlength="500" class="form-control" id="descricao" name="descricao"></textarea>
								</div>

						
					
						<div class="row">

							<div class="col-md-6">
								<div class="mb-3">
									<label for="exampleFormControlInput1" class="form-label">Foto</label>
									<input type="file" class="form-control-file" id="imagem" name="imagem" onChange="carregarImg();">
								</div>
							</div>
							<div class="col-md-2">
								<div id="divImg" class="mt-4">
									<img src="../img/alertas/sem-foto.jpg"  width="100px" id="target">									
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
					<h5 class="modal-title" id="exampleModalLabel">Título : <span id="titulo-dados"></span></h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>

				<div class="modal-body">
					<small>
					<span class=""><b>Descrição:</b> <span id="descricao-dados"></span></span>
					<hr style="margin:4px">

					<span class=""><b>Link:</b> <a id="link-ref" href="" target="_blank"><span id="link-dados"></span></a></span>
					<hr style="margin:4px">

					<span class=""><b>Data Expiração:</b> <span id="data-dados"></span></span>
					<hr style="margin:4px">

					<span class=""><b>Ativo:</b> <span id="ativo-dados"></span></span>
					<hr style="margin:4px">

				
					<span class=""><b>Usuário Cadastro:</b> <span id="usuario-dados"></span></span>
					<hr style="margin:4px">

					
					<span class=""><img src="" id="foto-dados" width="200px"></span>
					<hr style="margin:4px">

				</small>
				</div>

			</form>
		</div>
	</div>
</div>







		<script type="text/javascript">var pag = "<?=$pagina?>"</script>
		<script src="../js/ajax.js"></script>


		<script type="text/javascript">

			function editar(id, titulo, descricao, link, foto, data){
				$('#id').val(id);
				$('#titulo').val(titulo);
				
				$('#descricao').val(descricao);
				$('#link').val(link);
				$('#data').val(data);
				
				$('#target').attr('src', '../img/alertas/' + foto);

				$('#tituloModal').text('Editar Registro');
				var myModal = new bootstrap.Modal(document.getElementById('modalForm'), {		});
				myModal.show();
				$('#mensagem').text('');
			}



			function dados(titulo, descricao, link, foto, data, ativo, usuario){

				$('#link-ref').attr('href', link);

				$('#titulo-dados').text(titulo);
				$('#descricao-dados').text(descricao);
				$('#link-dados').text(link);
				
				$('#data-dados').text(data);
				
				$('#ativo-dados').text(ativo);
				$('#usuario-dados').text(usuario);
				
				$('#foto-dados').attr('src', '../img/alertas/' + foto);


				var myModal = new bootstrap.Modal(document.getElementById('modalDados'), {		});
				myModal.show();
				$('#mensagem').text('');
			}



			
			function limpar(){
				var data = "<?=$data_atual?>";

				$('#id').val('');
				$('#titulo').val('');		
				$('#descricao').val('');
				$('#link').val('');
				
				$('#data').val(data);

			
				$('#target').attr('src', '../img/alertas/sem-foto.jpg');
			}


		


		</script>



		<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
		<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

		<script>
			$(document).ready(function() {
				$('.sel2').select2({
			//placeholder: 'Selecione um Cliente',
			dropdownParent: $('#modalTransferir')
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