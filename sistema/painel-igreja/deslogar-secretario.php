<?php 
@session_start();
if(@$_SESSION['nivel_usuario'] == 'secretario'){
	echo "<script>window.location='../index.php'</script>";
}

 ?>