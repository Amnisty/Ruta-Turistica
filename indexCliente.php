<?php
//Carlos Andres Duran Torres
include ("grafo.php");
session_start();
?>
<!DOCTYPE html>

<head>
<script type="text/javascript" src="https://unpkg.com/vis-network/standalone/umd/vis-network.min.js"></script>
    <link href="https://unpkg.com/browse/vis-network@9.1.2/styles/vis-network.min.css" rel="stylesheet" type="text/css">
    <style type='text/css'>
    </style>
    <title>Ruta Turistica</title>
    <meta charset="iso-8859-1" />
    <link rel="stylesheet" href='principal.css' />
</head>

<body>
    <div class='textbox'>
        <h1 id='titulo'>Ruta Turistica<h1>
    </div>
    <br>

    <div style="display:flex"><div id="grafo1"></div></div>
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
<br>
<div class="textbox">
<form method="POST">
		<h2>Buscar el Camino Mas Corto</h2>
		<label id="formulario">Ingrese el Nombre del Lugar de Origen</label>
		<input type="text" name="LugarOrigen" require><br><br>
		<label id="formulario">Ingrese el Nombre del Lugar de Destino</label>
		<input type="text" name="LugarDestino" require> <br><br>
		<input type="submit">
        <br>
        <?php
        if (isset($_POST["LugarOrigen"]) && ($_POST["LugarDestino"])) {
            print_r ($_SESSION["grafo"]->caminoMasCorto($_POST["LugarOrigen"], $_POST["LugarDestino"]));
        }
        ?>

</form>
</div>

</body>