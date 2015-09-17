<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
session_start();
require_once 'controller/CubeController.php';

$controller = new CubeController();

$controller->handleRequest();
?>

<div class="container">
	<div class="jumbotron">
		<h2>Presentación Prueba Hackerrank - Cube Summation</h2>      
		<p>By Jefferson Patrón</p>
	</div>
	<form method="POST" class="form-inline" action="">
		<div class="form-group">
			<input type="text" class="form-control  col-md-4" id="command" name="command" placeholder="Ingrese su Comando">
			<input type="hidden" class="form-control  col-md-4" id="new" name="new" value="1">
		</div>
			<button type="submit" class="btn btn-default ">Ejecutar</button>
	</form>
	<div class="jumbotron col-md-4" id="output">
		<samp><samp><?php if(isset($_SESSION['mensaje'])) {echo $_SESSION['mensaje'];} ?></samp></samp>
	</div>
<div>

