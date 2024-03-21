<?php 
@session_start();
if(@$_SESSION['nivel_usuario'] == 'tesoureiro'){
	echo "<script>window.location='../index.php'</script>";
}

 ?>