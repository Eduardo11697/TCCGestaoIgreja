<?php 
require_once("../conexao.php");
require_once("verificar.php");
$pagina = 'anexos';

?>

<div class="tabela bg-light">
	<?php 
	$query = $pdo->query("SELECT * FROM $pagina order by id desc");	
	$res = $query->fetchAll(PDO::FETCH_ASSOC);
	$total_reg = count($res);
	if($total_reg > 0){

		?>

		<table id="example" class="table table-striped table-light table-hover my-4 my-4" style="width:100%">
			<thead>			
				<tr>
					<th class="">Igreja</th>	
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


					$query_con = $pdo->query("SELECT * FROM igrejas where id = '$igreja'");
					$res_con = $query_con->fetchAll(PDO::FETCH_ASSOC);
					if(count($res_con) > 0){
						$nome_igreja = $res_con[0]['nome'];
						$foto_igreja = $res_con[0]['imagem'];

					}else{
						$nome_igreja = '';
					}

					$dataF = implode('/', array_reverse(explode('-', $data)));
					?>			
					<tr>
						<td>
							<img src="../img/igrejas/<?php echo $foto_igreja ?>" width="25px">
							<?php echo $nome_igreja ?>
								
							</td>
						<td><a class="text-primary" href="../img/documentos/<?php echo $arquivo ?>" target="_blank"><?php echo $nome ?></a></td>
						<td class="esc"><?php echo $descricao ?></td>
						<td class="esc">
							<a href="../img/documentos/<?php echo $arquivo ?>" target="_blank">
								<img src="../img/documentos/<?php echo $tumb_arquivo ?>" width="30px">
							</a>
						</td>
						<td class="esc"><?php echo $dataF ?></td>
						<td class="esc"><?php echo $usuario_cad ?></td>
						
						<td>
							
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