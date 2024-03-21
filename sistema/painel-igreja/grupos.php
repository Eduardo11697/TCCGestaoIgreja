<?php 
require_once("../conexao.php");
require_once("verificar.php");
require_once("deslogar-tesoureiro.php");

$pagina = 'grupos';
?>

<div class="col-md-12 my-3">
	<a href="#" onclick="inserir()" type="button" class="btn btn-dark btn-sm">Novo Grupo</a>
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
					<th class="">Dias</th>
					<th class="esc">Horário</th>	
					<th class="esc">Pastor Responsável</th>
					<th class="esc">Regente</th>
					<th class="esc">Secretário</th>
					<th class="esc">Tesoureiro</th>
					<th class="esc">Lider 1</th>
					<th class="esc">Lider 2</th>	
					<th>Ações</th>
				</tr>		
			</thead>
			<tbody>
				<?php 
				for($i=0; $i < $total_reg; $i++){
					foreach ($res[$i] as $key => $value){} 

						$nome = $res[$i]['nome'];	
					$dias = $res[$i]['dias'];
					$hora = $res[$i]['hora'];
					$local = $res[$i]['local'];
					$pastor = $res[$i]['pastor'];
					$tesoureiro = $res[$i]['tesoureiro'];
					$secretario = $res[$i]['secretario'];
					$regente = $res[$i]['regente'];
					$lider1 = $res[$i]['lider1'];
					$lider2 = $res[$i]['lider2'];
					$obs = $res[$i]['obs'];
					$igreja = $res[$i]['igreja'];
					$id = $res[$i]['id'];


					//totalizar membros
					$query2 = $pdo->query("SELECT * FROM grupos_membros where igreja = '$id_igreja' and grupo = '$id'");
					$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
					$membros_grupo = count($res2);


					if($obs != ""){
						$classe_obs = 'text-warning';
					}else{
						$classe_obs = 'text-secondary';
					}


					$query_con = $pdo->query("SELECT * FROM pastores where id = '$pastor'");
					$res_con = $query_con->fetchAll(PDO::FETCH_ASSOC);
					if(count($res_con) > 0){
						$nome_pastor = $res_con[0]['nome'];
					}else{
						$nome_pastor = 'Nenhum';
					}

					$query_con = $pdo->query("SELECT * FROM membros where id = '$regente'");
					$res_con = $query_con->fetchAll(PDO::FETCH_ASSOC);
					if(count($res_con) > 0){
						$nome_regente = $res_con[0]['nome'];
					}else{
						$nome_regente = 'Nenhum';
					}


						$query_con = $pdo->query("SELECT * FROM tesoureiros where id = '$tesoureiro'");
					$res_con = $query_con->fetchAll(PDO::FETCH_ASSOC);
					if(count($res_con) > 0){
						$nome_tes = $res_con[0]['nome'];
					}else{
						$nome_tes = 'Nenhum';
					}

						$query_con = $pdo->query("SELECT * FROM secretarios where id = '$secretario'");
					$res_con = $query_con->fetchAll(PDO::FETCH_ASSOC);
					if(count($res_con) > 0){
						$nome_sec = $res_con[0]['nome'];
					}else{
						$nome_sec = 'Nenhum';
					}

					$query_con = $pdo->query("SELECT * FROM membros where id = '$lider1'");
					$res_con = $query_con->fetchAll(PDO::FETCH_ASSOC);
					if(count($res_con) > 0){
						$nome_lider1 = $res_con[0]['nome'];
					}else{
						$nome_lider1 = 'Nenhum';
					}


					$query_con = $pdo->query("SELECT * FROM membros where id = '$lider2'");
					$res_con = $query_con->fetchAll(PDO::FETCH_ASSOC);
					if(count($res_con) > 0){
						$nome_lider2 = $res_con[0]['nome'];
					}else{
						$nome_lider2 = 'Nenhum';
					}
					
					
					?>			
					<tr>

						<td>
							<?php echo $nome ?>
						</td>
						<td class=""><?php echo $dias ?></td>
						
						<td class="esc"><?php echo $hora ?></td>
						<td class="esc"><?php echo $nome_pastor ?></td>
						<td class="esc"><?php echo $nome_regente ?></td>
						<td class="esc"><?php echo $nome_sec ?></td>
						<td class="esc"><?php echo $nome_tes ?></td>
						<td class="esc"><?php echo $nome_lider1 ?></td>
						<td class="esc"><?php echo $nome_lider2 ?></td>

						<td>
							<big>
								<a href="#" onclick="editar('<?php echo $id ?>', '<?php echo $nome ?>', '<?php echo $dias ?>', '<?php echo $hora ?>', '<?php echo $local ?>', '<?php echo $pastor ?>', '<?php echo $regente ?>', '<?php echo $secretario ?>', '<?php echo $tesoureiro ?>', '<?php echo $lider1 ?>', '<?php echo $lider2 ?>')" title="Editar Registro">	<i class="bi bi-pencil-square text-primary"></i> </a>

								<a href="#" onclick="excluir('<?php echo $id ?>' , '<?php echo $nome ?>')" title="Excluir Registro">	<i class="bi bi-trash text-danger"></i> </a>

								<a href="#" onclick="dados('<?php echo $nome ?>', '<?php echo $dias ?>', '<?php echo $hora ?>', '<?php echo $local ?>', '<?php echo $nome_pastor ?>', '<?php echo $nome_regente ?>', '<?php echo $nome_sec ?>', '<?php echo $nome_tes ?>', '<?php echo $nome_lider1 ?>', '<?php echo $nome_lider2 ?>', '<?php echo $obs ?>', '<?php echo $membros_grupo ?>')" title="Ver Dados">	<i class="bi bi-info-square-fill text-primary"></i> </a>

								<a href="#" onclick="obs('<?php echo $id ?>','<?php echo $nome ?>', '<?php echo $obs ?>')" title="Observações">	<i class="bi bi-chat-right-text <?php echo $classe_obs ?>"></i> </a>

								<a href="#" onclick="addMembros('<?php echo $id ?>' , '<?php echo $nome ?>', '<?php echo $igreja ?>')" title="Adicionar Membros">	<i class="bi bi-plus-square-fill text-success"></i> </a>

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
								<label for="exampleFormControlInput1" class="form-label">Nome </label>
								<input type="text" class="form-control" id="nome" name="nome" placeholder="Nome da Célula" required>
							</div>
						</div>
						<div class="col-md-4">
							<div class="mb-3">
								<label for="exampleFormControlInput1" class="form-label">Dias </label>
								<input type="text" class="form-control" id="dias" name="dias" placeholder="Segundas Feiras" >
							</div>
						</div>
						<div class="col-md-4">
							<div class="mb-3">
								<label for="exampleFormControlInput1" class="form-label">Horário </label>
								<input type="text" class="form-control" id="hora" name="hora" placeholder="Das 18:00 as 20:00" >
							</div>
						</div>
					</div>

					<div class="mb-3">
								<label for="exampleFormControlInput1" class="form-label">Local da Célula </label>
								<input type="text" class="form-control" id="local" name="local" placeholder="Rua, Número e Bairro">
							</div>

					<div class="row">
						<div class="col-md-4">
							<div class="mb-3">
								<label for="exampleFormControlInput1" class="form-label">Pastor</label>
								<select class="form-control sel21" id="pastor" name="pastor" style="width:100%;">
									<option value="0">Selecione um Pastor</option>
									<?php 
									$query = $pdo->query("SELECT * FROM pastores where igreja = '$id_igreja' order by nome asc");
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

						<div class="col-md-4">
							<label for="exampleFormControlInput1" class="form-label">Regente</label>
									<select class="form-control sel2" id="regente" name="regente" style="width:100%;">
										<option value="0">Selecione um Membro</option>
										<?php 
										$query = $pdo->query("SELECT * FROM membros where igreja = '$id_igreja' and ativo = 'Sim' order by  nome asc");
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

						<div class="col-md-4">
							<label for="exampleFormControlInput1" class="form-label">Secretário</label>
									<select class="form-control sel2sec" id="secretario" name="secretario" style="width:100%;">
										<option value="0">Selecione um Secretário</option>
										<?php 
										$query = $pdo->query("SELECT * FROM secretarios where igreja = '$id_igreja' order by  nome asc");
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

						<div class="row">

							<div class="col-md-4">
								
								<div class="mb-3">
									<label for="exampleFormControlInput1" class="form-label">Tesoureiro</label>
									<select class="form-control sel2tes" id="tesoureiro" name="tesoureiro" style="width:100%;">
										<option value="0">Selecione um Tesoureiro</option>
										<?php 
										$query = $pdo->query("SELECT * FROM tesoureiros where igreja = '$id_igreja' order by  nome asc");
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
								<div class="col-md-4">
									<div class="mb-3">
										<label for="exampleFormControlInput1" class="form-label">1º Líder</label>
										<select class="form-control sel2" id="lider1" name="lider1" style="width:100%;">
											<option value="0">Selecione um Membro</option>
											<?php 
											$query = $pdo->query("SELECT * FROM membros where igreja = '$id_igreja' and ativo = 'Sim' order by nome asc");
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
									<div class="col-md-4">
										<div class="mb-3">
											<label for="exampleFormControlInput1" class="form-label">2º Líder</label>
											<select class="form-control sel2" id="lider2" name="lider2" style="width:100%;">
												<option value="0">Selecione um Membro</option>
												<?php 
												$query = $pdo->query("SELECT * FROM membros where igreja = '$id_igreja' and ativo = 'Sim' order by nome asc");
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





				<div class="modal fade" id="modalDados" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<h5 class="modal-title" id="exampleModalLabel">Nome : <span id="nome-dados"></span>  </h5><small> <span class="mx-2">(<span id="membros-dados"></span> Membros)</span></small>
								<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
							</div>

							<div class="modal-body">

								<span class=""><b>Dias:</b> <span id="dias-dados"></span></span>
								<hr style="margin:4px">

								<span class=""><b>Horário:</b> <span id="hora-dados"></span></span>
								<hr style="margin:4px">

								<span class=""><b>Local:</b> <span id="local-dados"></span></span>
								<hr style="margin:4px">

								<span class=""><b>Pastor Responsável:</b> <span id="pastor-dados"></span></span>
								<hr style="margin:4px">

								<span class=""><b>Regente:</b> <span id="regente-dados"></span></span>
								<hr style="margin:4px">

								<span class=""><b>Secretário:</b> <span id="secretario-dados"></span></span>
								<hr style="margin:4px">

								<span class=""><b>Tesoureiro:</b> <span id="tesoureiro-dados"></span></span>
								<hr style="margin:4px">

								<span class=""><b>1º Líder de Célula:</b> <span id="lider1-dados"></span></span>
								<hr style="margin:4px">

								<span class=""><b>2º Líder de Célula:</b> <span id="lider2-dados"></span></span>
								<hr style="margin:4px">

								<span class=""><b>OBS:</b> <span id="obs-dados"></span></span>
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
									<label for="exampleFormControlInput1" class="form-label">Observações (Máximo 1000 Caracteres)</label>
									<textarea class="form-control" id="obs" name="obs" maxlength="1000" style="height:200px"></textarea>
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
			<div class="modal fade" id="modalAddMembros" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
				<div class="modal-dialog modal-lg">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" id="exampleModalLabel"><span id="tituloModal">Adicionar Membros - <span id="nome-add"></span></span></h5>
							<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
						</div>
						<form id="form-add" method="post">
							<div class="modal-body">

								<div class="row">
									<div class="col-md-4">
										<div class="mb-3" id="listar-membros">
											
											</div>
										</div>
										<div class="col-md-8" id="listar-membros-add">

										</div>
									</div>



									<small><div id="mensagem-add" align="center"></div></small>

									<input type="hidden" class="form-control" name="id-add"  id="id-add">
									<input type="hidden" class="form-control" name="id-igreja"  id="id-ig">


								</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="btn-fechar-add">Fechar</button>
									<button type="submit" class="btn btn-primary">Adicionar</button>
								</div>
							</form>
						</div>
					</div>
				</div>




				<script type="text/javascript">var pag = "<?=$pagina?>"</script>
				<script src="../js/ajax.js"></script>


				<script type="text/javascript">

					function editar(id, nome, dias, hora, local, pastor, regente, secretario, tesoureiro, lider1, lider2){
						$('#id').val(id);
						$('#nome').val(nome);
						$('#dias').val(dias);
						$('#local').val(local);
						$('#hora').val(hora);
						$('#pastor').val(pastor).change();
						$('#regente').val(regente).change();
						$('#secretario').val(secretario).change();
						$('#tesoureiro').val(tesoureiro).change();
						$('#lider1').val(lider1).change();
						$('#lider2').val(lider2).change();

						$('#tituloModal').text('Editar Registro');
						var myModal = new bootstrap.Modal(document.getElementById('modalForm'), {		});
						myModal.show();
						$('#mensagem').text('');
					}



					function dados(nome, dias, hora, local, pastor, regente, secretario, tesoureiro, lider1, lider2, obs, membros){

						$('#nome-dados').text(nome);
						$('#dias-dados').text(dias);
						$('#hora-dados').text(hora);
						$('#local-dados').text(local);
						$('#pastor-dados').text(pastor);
						$('#regente-dados').text(regente);
						$('#secretario-dados').text(secretario);
						$('#tesoureiro-dados').text(tesoureiro);
						$('#lider1-dados').text(lider1);
						$('#lider2-dados').text(lider2);
						$('#obs-dados').text(obs);
						$('#membros-dados').text(membros);


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



					function addMembros(id, nome, igreja){
						console.log(obs)


						$('#nome-add').text(nome);
						$('#id-add').val(id);
						$('#id-ig').val(igreja);

						listarMembrosCB(id, igreja);
						listarMembrosAdd(id, igreja);

						var myModal = new bootstrap.Modal(document.getElementById('modalAddMembros'), {		});
						myModal.show();
						$('#mensagem-add').text('');
					}




					function limpar(){

						$('#id').val('');
						$('#nome').val('');
						$('#dias').val('');
						$('#local').val('');
						$('#hora').val('');	

						document.getElementById("pastor").options.selectedIndex = 0;
						$('#pastor').val($('#pastor').val()).change();

						document.getElementById("regente").options.selectedIndex = 0;
						$('#regente').val($('#regente').val()).change();

						document.getElementById("lider1").options.selectedIndex = 0;
						$('#lider1').val($('#lider1').val()).change();

						document.getElementById("lider2").options.selectedIndex = 0;
						$('#lider2').val($('#lider2').val()).change();	

						document.getElementById("secretario").options.selectedIndex = 0;
						$('#secretario').val($('#secretario').val()).change();	

						document.getElementById("tesoureiro").options.selectedIndex = 0;
						$('#tesoureiro').val($('#tesoureiro').val()).change();	

					}




					$("#form-add").submit(function () {
						event.preventDefault();
						var formData = new FormData(this);

						var igreja = "<?=$id_igreja?>";
						var celula = $('#id-add').val();
						
						$.ajax({
							url: pag + "/add-membros.php",
							type: 'POST',
							data: formData,

							success: function (mensagem) {
								$('#mensagem-add').text('');
								$('#mensagem-add').removeClass()
								if (mensagem.trim() == "Adicionado com Sucesso") {

									listarMembrosCB(celula, igreja);
									listarMembrosAdd(celula, igreja);
									
								} else {

									$('#mensagem-add').addClass('text-danger')
									$('#mensagem-add').text(mensagem)
								}


							},

							cache: false,
							contentType: false,
							processData: false,

						});

					});





	function listarMembrosCB(celula, igreja){
		console.log(obs)

		
		$.ajax({
        url: pag + "/listar-membros.php",
        method: 'POST',
        data: {celula, igreja},
        dataType: "text",

        success: function (result) {
            $("#listar-membros").html(result);               
        },

    });

	}


	function listarMembrosAdd(celula, igreja){
		console.log(obs)

		
		$.ajax({
        url: pag + "/listar-membros-add.php",
        method: 'POST',
        data: {celula, igreja},
        dataType: "text",

        success: function (result) {
            $("#listar-membros-add").html(result);               
        },

    });

	}



	function excluirMembro(id){
		event.preventDefault();
		var igreja = "<?=$id_igreja?>";
		var celula = $('#id-add').val();
				
		$.ajax({
        url: pag + "/excluir-membro.php",
        method: 'POST',
        data: {id},
        dataType: "text",

        success: function (result) {
            listarMembrosCB(celula, igreja);
			listarMembrosAdd(celula, igreja);            
        },

    });

	}


				</script>





				<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
				<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

				<script>
					$(document).ready(function() {
						$('.sel2').select2({
							placeholder: 'Selecione um Registro',
							dropdownParent: $('#modalForm')
						});
					});
				</script>

				<script>
					$(document).ready(function() {
						$('.sel21').select2({
							placeholder: 'Selecione um Pastor',
							dropdownParent: $('#modalForm')
						});
					});
				</script>


					<script>
					$(document).ready(function() {
						$('.sel2sec').select2({
							placeholder: 'Selecione um Secretário',
							dropdownParent: $('#modalForm')
						});
					});
				</script>

					<script>
					$(document).ready(function() {
						$('.sel2tes').select2({
							placeholder: 'Selecione um Tesoureiro',
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