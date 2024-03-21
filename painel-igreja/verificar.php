<?php 
@session_start();
if(@$_SESSION['nivel_usuario'] != 'bispo' and @$_SESSION['nivel_usuario'] != 'pastor'  and @$_SESSION['nivel_usuario'] != 'tesoureiro'){
	echo "<script>window.location='../index.php'</script>";
}

 ?>