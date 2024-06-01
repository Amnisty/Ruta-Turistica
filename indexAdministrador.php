<?php
//Carlos Andres Duran Torres
include("grafo.php");
include("guardarGrafo.php");
include("importarGrafo.php");

session_start();

if (!isset($_SESSION['grafo'])) {
	$_SESSION['grafo'] = new Grafo();
}

if (isset($_POST["AgregarVertice"])) {
	$Agregar = new Vertice($_POST['AgregarVertice'], new PuntoTuristico($_POST["NombreLugar"], $_POST["DescripcionLugar"], $_POST["CalificacionLugar"], $_POST["PrecioLugar"], $_POST["CategoriaLugar"], $_POST["TiempoLugar"]));
	$_SESSION["grafo"]->AgregarVertice($Agregar);
}

if (isset($_POST["Vertice_Origen"]) && ($_POST["Vertice_Destino"])) {
	$_SESSION["grafo"]->AgregarArista($_POST["Vertice_Origen"], $_POST["Vertice_Destino"], $_POST["Peso"]);
}
if (isset($_POST["LugarOrigen"]) && ($_POST["LugarDestino"])) {
	echo $_SESSION["grafo"]->caminoMasCorto($_POST["LugarOrigen"], $_POST["LugarDestino"]);
}

if (isset($_POST["IDVertice"])) {
	$_SESSION["grafo"]->eliminarVertice($_POST["IDVertice"]);
}

if (isset($_POST["Vertice_Origen_Eliminar"]) && ($_POST["Vertice_Destino_Eliminar"])) {
	$_SESSION["grafo"]->eliminarArista($_POST["Vertice_Origen_Eliminar"], $_POST["Vertice_Destino_Eliminar"]);
}

if (isset($_POST["GuardarGrafoBoton"]) && isset($_SESSION['grafo'])) {
	GuardarGrafo($_SESSION['grafo']);
}
if (isset($_POST["importarGrafo"])) {
	ImportarGrafo($_FILES['ImportarGrafoBoton']);
}

?>
<!DOCTYPE html>

<head>
	<title>Ruta Turistica</title>
	<script type="text/javascript" src="https://unpkg.com/vis-network/standalone/umd/vis-network.min.js"></script>
	<link href="https://unpkg.com/browse/vis-network@9.1.2/styles/vis-network.min.css" rel="stylesheet" type="text/css">
	<style type='text/css'>
		#grafo1{
			width: 600px;
			height: 400px;
			border: 1px solid lightgray;
		}
	</style>
</head>

<body>
	<form method="POST">
		<h2>Agregar Punto Turistico</h2>
		<label>Id Punto Turistico</label>
		<input type="text" name="AgregarVertice" require><br><br>
		<label>Nombre del Lugar</label>
		<input type="text" name="NombreLugar" require><br><br>
		<label>Descripcion del Lugar</label>
		<input type="text" name="DescripcionLugar" require><br><br>
		<label>Calificacion del Lugar</label>
		<input type="number" name="CalificacionLugar" require><br><br>
		<label>Precio del Lugar</label>
		<input type="text" name="PrecioLugar" require><br><br>
		<label>Categoria del Lugar</label>
		<input type="text" name="CategoriaLugar" require><br><br>
		<label>Tiempo de Visita Promedio</label>
		<input type="number" name="TiempoLugar" require>
		<input type="submit">
	</form>
	<hr>
	<form method="POST">
		<h2>Buscar el Camino Mas Corto</h2>
		<label>Ingrese el Nombre del Lugar de Origen</label>
		<input type="text" name="LugarOrigen" require><br><br>
		<label>Ingrese el Nombre del Lugar de Destino</label>
		<input type="text" name="LugarDestino" require>
		<input type="submit">
	</form>
	<hr>
	<form method="POST">
		<h2>Agregar Conexiones</h2>
		<label>Punto de Origen</label>
		<input type="text" name="Vertice_Origen" require><br><br>
		<label>Punto de Destino</label>
		<input type="text" name="Vertice_Destino" require><br><br>
		<label>Distancia</label>
		<input type="number" name="Peso" require>
		<input type="submit">
	</form>

	<hr>
	<form method="POST">

		<h2>Ver Grado</h2>
		<label>Id Punto Turistico</label>
		<input type="text" name="Grado_Vertice">
		<input type="submit">
		<br>
		<?php
		if (isset($_POST["Grado_Vertice"])) {
			echo ("El Grado Es:" . $_SESSION["grafo"]->grado($_POST["Grado_Vertice"]));
		}
		?>
	</form>
	<hr>
	<form method="POST">
		<h2>Eliminar Punto Turistico</h2>
		<label>Id del Punto Turistico</label>
		<input type="text" name="IDVertice">
		<input type="submit">
	</form>
	<hr>
	<form method="POST">
		<h2>Eliminar Conexion</h2>
		<label>Punto de Origen</label>
		<input type="text" name="Vertice_Origen_Eliminar"><br><br>
		<label>Punto de Destino</label>
		<input type="text" name="Vertice_Destino_Eliminar">
		<input type="submit">
	</form>
	<hr>
	<div id="grafo1"></div>
	<script>
		function CrearGrafo(ID, NodosPHP) {


			var Nodos = Object.keys(NodosPHP);
			var VectorNodos = [];
			for (var i = 0; i < Nodos.length; i++) {
				var ObjetosNodos = new Object();
				ObjetosNodos.id = Nodos[i];
				ObjetosNodos.label = Nodos[i];
				VectorNodos.push(ObjetosNodos);

			}
			var VectorAristas = [];
			for (var nodo in NodosPHP) {

				for (var NodoAdyacente in NodosPHP[nodo]) {
					var Arista = new Object();
					Arista.from = nodo;
					Arista.to = NodoAdyacente;
					Arista.label = NodosPHP[nodo][NodoAdyacente];
					VectorAristas.push(Arista);


				}
			}

			var DatosNodos = new vis.DataSet(VectorNodos);
			var DatosAristas = new vis.DataSet(VectorAristas);
			var Datos = {
				nodes: DatosNodos,
				edges: DatosAristas
			}
			var Opciones = {

				edges: {
					arrows: {
						to: {
							enabled: true
						}
					}
				}

			};

			var Grafos = new vis.Network(document.getElementById(ID), Datos, Opciones);


		}
		var NodosPHP = <?php echo json_encode($_SESSION['grafo']->getMatrizA()); ?>;
		CrearGrafo("grafo1", NodosPHP);
	</script>
	<hr>
	<form method="POST">
		<input name="GuardarGrafoBoton" hidden>
		<button>Guardar Grafo</button>
	</form>
	<hr>
	<form method="POST" enctype="multipart/form-data">
		<input name="ImportarGrafoBoton" type='file' accept=".json">
		<input name="importarGrafo" hidden>
		<button>Importar Grafo</button>
	</form>
</body>