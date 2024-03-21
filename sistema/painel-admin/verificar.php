<?php
@session_start();
if(@$_SESSION['nivel_usuario'] != 'bispo'){
	echo "<script>window.location='../index.php'</script>";
}

 ?>