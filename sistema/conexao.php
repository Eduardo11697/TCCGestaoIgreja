<?php 
date_default_timezone_set('America/Sao_Paulo');

$banco = "hugocu75_igreja";
$servidor = "sh-pro24.hostgator.com.br";
$usuario = "hugocu75_igreja";
$senha = "hugoigreja";

try {
	$pdo = new PDO("mysql:dbname=$banco;host=$servidor", "$usuario", "$senha");
} catch (Exception $e) {
	echo 'Erro ao conectar com o Banco de Dados! <br><br>' .$e;
}



$url_sistema = "http://$_SERVER[HTTP_HOST]/sistema/";
$url = explode("//", $url_sistema);
if($url[1] == 'localhost/sistema/'){
	$url_sistema = "http://$_SERVER[HTTP_HOST]/igreja/sistema/";
}


$email_super_adm = "sistemasparaigrejas@gmail.com"; //email principal da igreja
$nome_igreja_sistema = "Igreja Pentecostal";
$telefone_igreja_sistema = '(00) 00000-0000';
$endereco_igreja_sistema = 'Rua A, Número 150, Bairro XX - Belo Horizonte - MG';



//VARIAVEIS GLOBAIS
$quantidade_tarefas = 20; //exibir as proximas 20 tarefas no painel da igreja
$limitar_tesoureiro = 'Sim'; //Se tiver sim, o tesoureiro nao poderá excluir e nem editar as ofertas e dizimos.
$relatorio_pdf = 'Sim'; //SE ESSA OPÇÃO ESTIVER NÃÕ, O RELATÓRIO SERÁ GERADO EM HTML
$cabecalho_rel_img = 'Sim'; //SE ESSA OPÇÃO ESTIVER SIM, O RELATÓRIO TERÁ UMA IMAGEM NO CABEÇALHO, CADA IGREJA DEVERÁ SUBIR A SUA IMAGEM JPG NO CADASTRO DE IGREJAS
$itens_por_pagina = 9;




//INSERIR REGISTROS INICIAIS

//Criar um Bispo (Pastor Presidente) padrão
$query = $pdo->query("SELECT * FROM bispos");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_reg = count($res);

if($total_reg == 0)
$pdo->query("INSERT INTO bispos SET nome = 'Super Administrador', email = '$email_super_adm', cpf = '000.000.000-00', telefone = '(00)00000-0000', foto = 'sem-foto.jpg' ");


//Criar o cadastro do Bispo na tabela de pastores
$query = $pdo->query("SELECT * FROM pastores");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_reg = count($res);

if($total_reg == 0)
$pdo->query("INSERT INTO pastores SET nome = 'Super Administrador', email = '$email_super_adm', cpf = '000.000.000-00', telefone = '(00)00000-0000', foto = 'sem-foto.jpg', data_cad = curDate(), data_nasc = curDate(), igreja = 1 ");



//Criar um Usuário Super com nivel de bispo padrão
$query = $pdo->query("SELECT * FROM usuarios");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_reg = count($res);

if($total_reg == 0)
$pdo->query("INSERT INTO usuarios SET nome = 'Super Administrador', email = '$email_super_adm', cpf = '000.000.000-00', senha = '123', nivel = 'bispo', id_pessoa = '1', foto = 'sem-foto.jpg' ");


//Criar a igreja matriz
$query = $pdo->query("SELECT * FROM igrejas");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_reg = count($res);

if($total_reg == 0)
$pdo->query("INSERT INTO igrejas SET nome = '$nome_igreja', telefone = '$telefone_igreja', endereco = '$endereco_igreja', matriz = 'Sim', imagem = 'sem-foto.jpg', data_cad = curDate(), pastor = '1', logo_rel = 'sem-foto.jpg', cab_rel = 'sem-foto.jpg', carteirinha_rel = 'sem-foto.jpg', email = '$email_super_adm' ");



//Criar o cargo de Membro
$query = $pdo->query("SELECT * FROM cargos");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_reg = count($res);

if($total_reg == 0)
$pdo->query("INSERT INTO cargos SET nome = 'Membro'");


//Criar a frequencia de uma vez (unica)
$query = $pdo->query("SELECT * FROM frequencias");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_reg = count($res);

if($total_reg == 0)
$pdo->query("INSERT INTO frequencias SET frequencia = 'Uma Vez', dias = 0");


//Criar variaveis padrões do sistema
$query = $pdo->query("SELECT * FROM config");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_reg = count($res);

if($total_reg == 0){
$pdo->query("INSERT INTO config SET nome = '$nome_igreja_sistema', email = '$email_super_adm', endereco = '$endereco_igreja_sistema', telefone = '$telefone_igreja_sistema', qtd_tarefas = '$quantidade_tarefas', limitar_tesoureiro = '$limitar_tesoureiro', relatorio_pdf = '$relatorio_pdf', cabecalho_rel_img = '$cabecalho_rel_img', itens_por_pagina = '$itens_por_pagina' ");

}


//BUSCAR INFORMAÇÕES DE CONFIGURAÇÕES NO BANCO
$query = $pdo->query("SELECT * FROM config");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$email_super_adm = $res[0]['email'];
$nome_igreja_sistema = $res[0]['nome'];
$telefone_igreja_sistema = $res[0]['telefone'];
$endereco_igreja_sistema = $res[0]['endereco'];
$quantidade_tarefas = $res[0]['qtd_tarefas'];
$limitar_tesoureiro = $res[0]['limitar_tesoureiro'];
$relatorio_pdf = $res[0]['relatorio_pdf'];
$cabecalho_rel_img = $res[0]['cabecalho_rel_img'];
$itens_por_pagina = $res[0]['itens_por_pagina'];
 ?>