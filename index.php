<?php 
require_once("conexao.php");
 ?>
<!DOCTYPE html>
<html>
<head>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">

	<link href="img/logo-icone.ico" rel="shortcut icon" type="image/x-icon">
	<link rel="stylesheet" type="text/css" href="css/login.css">

	<title><?php echo $nome_igreja_sistema ?></title>
</head>
<body>

	<div class="login">
	<img src="img/logo.png" width="100%" class="mb-4">
    <form method="post" action="autenticar.php">
    	<input type="text" name="usuario" placeholder="Email ou CPF" required="required" />
        <input type="password" name="senha" placeholder="Insira sua Senha" required="required" />
        <button type="submit" class="btn btn-primary btn-block btn-large">Logar</button>
    </form>
</div>

</body>
</html>