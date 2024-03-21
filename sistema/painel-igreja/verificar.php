<?php 
@session_start();
if(@$_SESSION['nivel_usuario'] != 'bispo' and @$_SESSION['nivel_usuario'] != 'pastor'  and @$_SESSION['nivel_usuario'] != 'tesoureiro' and @$_SESSION['nivel_usuario'] != 'secretario'){
	echo "<script>window.location='../index.php'</script>";
}

 ?>