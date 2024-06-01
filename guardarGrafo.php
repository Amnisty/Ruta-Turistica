<?php
//Carlos Andres Duran Torres
function GuardarGrafo(Grafo $grafo)
{
    $file = 'lugares.json';
    $graphSave = [
        "vectorV"=>$grafo->getVectorV(),
        "matrizA"=>$grafo->getMatrizA()
    ];

    $fp = fopen($file, 'w');
    fwrite($fp, json_encode($graphSave));

    fclose($fp);

    if (file_exists($file)) {
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename=' . basename($file));
        header('Content-Transfer-Encoding: binary');
        header('Expires: 0');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Pragma: public');
        header('Content-Length: ' . filesize($file));
        ob_clean();
        flush();
        readfile($file);
        exit;
    }
}
