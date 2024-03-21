<?php 
require_once("../conexao.php");

$igreja = $_POST['igreja'];
$status = $_POST['status'];
$dataInicial = $_POST['dataInicial'];
$dataFinal = $_POST['dataFinal'];
$entrada = $_POST['entrada'];
$itens = $_POST['itens'];
//ALIMENTAR OS DADOS NO RELATÓRIO
$html = file_get_contents($url_sistema."rel/relPatrimonioHtml.php?igreja=$igreja&status=$status&entrada=$entrada&itens=$itens&dataInicial=$dataInicial&dataFinal=$dataFinal");

if($relatorio_pdf != 'Sim'){
	echo $html;
	exit();
}

//CARREGAR DOMPDF
require_once '../dompdf/autoload.inc.php';
use Dompdf\Dompdf;
use Dompdf\Options;

header("Content-Transfer-Encoding: binary");
header("Content-Type: image/png");

//INICIALIZAR A CLASSE DO DOMPDF
$options = new Options();
$options->set('isRemoteEnabled', true);
$pdf = new DOMPDF($options);


//Definir o tamanho do papel e orientação da página
$pdf->set_paper('A4', 'portrait');

//CARREGAR O CONTEÚDO HTML
$pdf->load_html($html);

//RENDERIZAR O PDF
$pdf->render();

//NOMEAR O PDF GERADO
$pdf->stream(
'patrimonios.pdf',
array("Attachment" => false)
);

 ?>