<?php
//Carlos Andres Duran Torres
function ImportarGrafo($file) {
    $importFilePath = "Uploads/";
    $filepath=$importFilePath.$file['name'];
    move_uploaded_file($file['tmp_name'],$filepath);
    $fileGraph = file_get_contents($filepath);
    $jsonGraph = json_decode($fileGraph, true);
    $grafo = new Grafo(true);
    $grafo->setVectorV($jsonGraph['vectorV']);
    $grafo->setMatrizA($jsonGraph['matrizA']);
    $_SESSION['grafo'] = $grafo;
}
?>