<?php 

$destinatario = $_POST['email_igreja'];
$assunto = $_POST['nome_igreja'] . ' - Email da Igreja';

$mensagem = utf8_decode('Nome: '.$_POST['nome']. "\r\n"."\r\n" . 'Telefone: '.$_POST['telefone']. "\r\n"."\r\n" . 'Mensagem: ' . "\r\n"."\r\n" .$_POST['mensagem']);


$cabecalhos = "From: ".$_POST['email'];

mail($destinatario, $assunto, $mensagem, $cabecalhos);

echo "<script language='javascript'> window.alert('Enviado com Sucesso!') </script>";
echo "<script>window.location='contatos.php'</script>";

 ?>