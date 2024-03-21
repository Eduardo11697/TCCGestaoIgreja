<?php 
require_once("../conexao.php");
require_once("verificar.php");
$pagina = 'igrejas';
?>

<div class="col-md-12 my-3">
	<a href="#" onclick="inserir()" type="button" class="btn btn-dark btn-sm">Nova Igreja</a>
</div>

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
					<th>Nome</th>
					<th class="">Telefone</th>
					<th class="esc">Data Cadastro</th>
					<th class="esc">Membros</th>
					<th class="esc">Responsável</th>
					<th class="esc">Imagem</th>
					
					<th>Ações</th>
				</tr>		
			</thead>
			<tbody>
				<?php 
				for($i=0; $i < $total_reg; $i++){
					foreach ($res[$i] as $key => $value){} 

						$nome = $res[$i]['nome'];
					
					$telefone = $res[$i]['telefone'];
					$endereco = $res[$i]['endereco'];
					$foto = $res[$i]['imagem'];
					$matriz = $res[$i]['matriz'];					
					$data_cad = $res[$i]['data_cad'];
					$obs = $res[$i]['obs'];
					$pastor = $res[$i]['pastor'];
					$id = $res[$i]['id'];

					$query_con = $pdo->query("SELECT * FROM pastores where id = '$pastor'");
					$res_con = $query_con->fetchAll(PDO::FETCH_ASSOC);
					if(count($res_con) > 0){
						$nome_p = $res_con[0]['nome'];
					}else{
						$nome_p = 'Não Definido';
					}


					$query_m = $pdo->query("SELECT * FROM membros where igreja = '$id'");
			$res_m = $query_m->fetchAll(PDO::FETCH_ASSOC);
			$membrosCad = @count($res_m);


					//retirar quebra de texto do obs
					$obs = str_replace(array("\n", "\r"), ' + ', $obs);

					
					$data_cadF = implode('/', array_reverse(explode('-', $data_cad)));
					?>			
					<tr>
						<td><?php echo $nome ?></td>
						<td class=""><?php echo $telefone ?></td>
						<td class="esc"><?php echo $data_cadF ?></td>
						<td class="esc"><?php echo $membrosCad ?> Membros</td>
						<td class="esc"><?php echo $nome_p ?></td>
						<td class="esc"><img src="../img/igrejas/<?php echo $foto ?>" width="30px"></td>
						
						<td>
							<big>
							<a href="#" onclick="editar('<?php echo $id ?>', '<?php echo $nome ?>', '<?php echo $telefone ?>', '<?php echo $endereco ?>', '<?php echo $foto ?>', '<?php echo $pastor ?>')" title="Editar Registro">	<i class="bi bi-pencil-square text-primary"></i> </a>
							<a href="#" onclick="excluir('<?php echo $id ?>' , '<?php echo $nome ?>')" title="Excluir Registro">	<i class="bi bi-trash text-danger"></i> </a>
							<a href="#" onclick="dados('<?php echo $nome ?>', '<?php echo $telefone ?>', '<?php echo $endereco ?>', '<?php echo $foto ?>', '<?php echo $data_cadF ?>', '<?php echo $matriz ?>', '<?php echo $nome_p ?>')" title="Ver Dados">	<i class="bi bi-info-square-fill text-primary"></i> </a>

							<a href="#" onclick="obs('<?php echo $id ?>','<?php echo $nome ?>', '<?php echo $obs ?>')" title="Observações">	<i class="bi bi-chat-right-text text-secondary"></i> </a>

							<a href="#" onclick="arquivos('<?php echo $id ?>','<?php echo $nome ?>')" title="Ver Anexos">	<i class="bi bi-file-earmark-arrow-down-fill text-success"></i> </a>
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
						<div class="col-md-3">
							<div class="mb-3">
								<label for="exampleFormControlInput1" class="form-label">Nome</label>
								<input type="text" class="form-control" id="nome" name="nome" placeholder="Insira o Nome" required>
							</div>
						</div>
						
						<div class="col-md-3">
							<div class="mb-3">
								<label for="exampleFormControlInput1" class="form-label">Telefone</label>
								<input type="text" class="form-control" id="telefone" name="telefone" placeholder="Insira o Telefone" required>
							</div>
						</div>

						<div class="col-md-6">
							<div class="mb-3">
								<label for="exampleFormControlInput1" class="form-label">Endereço</label>
								<input type="text" class="form-control" id="endereco" name="endereco" placeholder="Insira o Endereço">
							</div>
						</div>

					</div>
					
						<div class="row">
						<div class="col-md-4">
							<div class="mb-3">
								<label for="exampleFormControlInput1" class="form-label">Pastor Responsável</label>
								<select class="form-control sel2" id="pastor" name="pastor" style="width:100%;">
									<?php 
									$query = $pdo->query("SELECT * FROM pastores order by nome asc");
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
							<div class="col-md-5">
								<div class="mb-3">
									<label for="exampleFormControlInput1" class="form-label">Foto</label>
									<input type="file" class="form-control-file" id="imagem" name="imagem" onChange="carregarImg();">
								</div>
							</div>
							<div class="col-md-3">
								<div id="divImg" class="mt-4">
									<img src="../img/igrejas/sem-foto.jpg"  width="130px" id="target">									
								</div>
							</div>
						</div>

					<input type="hidden" id="id" name="id">

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
				<h5 class="modal-title" id="exampleModalLabel">Nome : <span id="nome-dados"></span></h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			
			<div class="modal-body">

				
				<span class=""><b>Telefone:</b> <span id="telefone-dados"></span></span>
				<hr style="margin:4px">

				<span class=""><b>Endereço:</b> <span id="endereco-dados"></span></span>
				<hr style="margin:4px">

				<span class=""><b>Data de Cadastro:</b> <span id="cadastro-dados"></span></span>
				<hr style="margin:4px">

				<span class=""><b>Matriz: </b> <span id="matriz-dados"></span></span>
				<hr style="margin:4px">

				<span class=""><b>Pastor Responsável:</b> <span id="pastor-dados"></span></span>
					<hr style="margin:4px">

				<span class=""><img src="" id="foto-dados" width="200px"></span>
				<hr style="margin:4px">


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






<!-- Modal -->
<div class="modal fade" id="modalArquivos" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel"><span id="tituloModal">Igreja - <span id="nome-arquivo"></span></span></h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			
				<div class="modal-body">

					<div id="listar-arquivos">

					</div>	
				

				</div>
			
			
		</div>
	</div>
</div>





<script type="text/javascript">var pag = "<?=$pagina?>"</script>
<script src="../js/ajax.js"></script>


<script type="text/javascript">

	function editar(id, nome, telefone, endereco, foto, pastor){
		$('#id').val(id);
		$('#nome').val(nome);
		
		$('#telefone').val(telefone);
		$('#endereco').val(endereco);
		$('#pastor').val(pastor).change();
		$('#target').attr('src', '../img/igrejas/' + foto);
		
		$('#tituloModal').text('Editar Registro');
		var myModal = new bootstrap.Modal(document.getElementById('modalForm'), {		});
		myModal.show();
		$('#mensagem').text('');
	}



	function dados(nome, telefone, endereco, foto, data_cad, matriz, pastor){

		$('#nome-dados').text(nome);
		
		$('#telefone-dados').text(telefone);
		$('#endereco-dados').text(endereco);
		$('#cadastro-dados').text(data_cad);
		$('#matriz-dados').text(matriz);
		$('#foto-dados').attr('src', '../img/igrejas/' + foto);
		$('#pastor-dados').text(pastor);
		
		var myModal = new bootstrap.Modal(document.getElementById('modalDados'), {		});
		myModal.show();
		$('#mensagem').text('');
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


	function limpar(){
		$('#id').val('');
		$('#nome').val('');		
		$('#telefone').val('');
		$('#endereco').val('');	
		
		document.getElementById("pastor").options.selectedIndex = 0;
		$('#pastor').val($('#pastor').val()).change();


		$('#target').attr('src', '../img/igrejas/sem-foto.jpg');
	}


	function arquivos(id, nome){
		console.log(obs)

		$('#nome-arquivo').text(nome);


		$.ajax({
        url: pag + "/listar-arquivos.php",
        method: 'POST',
        data: {id},
        dataType: "text",

        success: function (result) {
            $("#listar-arquivos").html(result);               
        },

    });
			
		
		var myModal = new bootstrap.Modal(document.getElementById('modalArquivos'), {		});
		myModal.show();
		$('#mensagem-arquivos').text('');
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