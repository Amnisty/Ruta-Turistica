<?php
//Carlos Andres Duran Torres
include("vertice.php");
class Grafo
{

	private $matrizA;
	private $vectorV;
	private $dirigido;

	public function __construct($dir = true)
	{
		$this->matrizA = null;
		$this->vectorV = null;
		$this->dirigido = $dir;
	}

	//recepcion de objeto tipo vertice, no se puede repetir el id.
	public function agregarVertice($v)
	{
		if (!isset($this->vectorV[$v->getId()])) {
			$this->matrizA[$v->getId()] = [];
			$this->vectorV[$v->getId()] = $v;
		} else {
			return false;
		}
		return true;
	}
	//recepcion de id de nodo origen, destino y peso para grafos ponderados.
	public function getVertice($v)
	{
		return $this->vectorV[$v];
	}

	public function agregarArista($origen, $destino, $peso = null)
	{
		if (isset($this->vectorV[$origen]) && isset($this->vectorV[$destino])) {
			$this->matrizA[$origen][$destino] = $peso;
		} else {
			return false;
		}
		return true;
	}
	//recepcion de ide de nodo y retorno de sus adyacentes en un array
	public function getAdyacentes($v)
	{
		return $this->matrizA[$v];
	}
	public function getMatrizA()
	{
		return $this->matrizA;
	}
	public function setMatrizA($matriz1)
	{
		$this->matrizA = $matriz1;
	}
	public function getVectorV()
	{
		return $this->vectorV;
	}
	public function setVectorV($vector1)
	{
		$this->vectorV = $vector1;
	}

	//recepcion del id del vertice y retorno de grado salida del mismo
	public function gradoSalida($v)
	{
		return count($this->matrizA[$v]);
	}

	public function gradoEntrada($v)
	{
		$grado = 0;
		if ($this->matrizA != null) {
			foreach ($this->matrizA as $vp => $adyacencia) {
				if ($adyacencia != null) {
					foreach ($adyacencia as $destino => $peso) {
						if ($destino == $v) {
							$grado++;
						}
					}
				}
			}
		}
		return $grado;
	}
	public function grado($v)
	{
		return $this->gradoSalida($v) +
			$this->gradoEntrada($v);
	}
	public function eliminarArista($origen, $destino)
	{
		if (isset($this->matrizA[$origen][$destino])) {
			unset($this->matrizA[$origen][$destino]);
		} else {
			return false;
		}
		return true;
	}
	public function eliminarVertice($v)
	{
		if (isset($this->vectorV[$v])) {
			foreach ($this->matrizA as $vp => $adyacencia) {
				if ($adyacencia != null) {
					foreach ($adyacencia as $destino => $peso) {
						if ($destino == $v) {
							unset($this->matrizA[$vp][$destino]);
						}
					}
				}
			}
			unset($this->matrizA[$v]);
			unset($this->vectorV[$v]);
		} else {
			return false;
		}
		return true;
	}
	// Metodo de anchura 

	public function RecorridoAnchura($NodoInicial)
	{
		$Recorrido = [];
		$Cola = [];
		if (isset($NodoInicial)) {
			array_push($Cola, $NodoInicial);
			while (count($Cola) > 0) {

				$NodoActual = array_shift($Cola);
				array_push($Recorrido, $NodoActual);

				$Adyacentes = array_keys($this->getAdyacentes($NodoActual));
				sort($Adyacentes);

				foreach ($Adyacentes as $Nodo) {
					if (!in_array($Nodo, $Recorrido)) {
						if (!in_array($Nodo, $Cola)) {
							array_push($Cola, $Nodo);
						}
					}
				}
			}
		}
		return $Recorrido;
	}

	//Meto

	public function RecorridoProfundidad($NodoInicial)
	{
		$Recorrido = [];
		$Cola = [];
		if (isset($NodoInicial)) {

			$Recorrido = $this->RecorridoProfundidadR($NodoInicial, $Recorrido);
		}
		return $Recorrido;
	}

	private function RecorridoProfundidadR($Nodo, $Recorrido)
	{
		array_push($Recorrido, $Nodo);
		$Adyacentes = array_keys($this->getAdyacentes($Nodo));
		sort($Adyacentes);

		foreach ($Adyacentes as $NodoAdyacente) {
			if (!in_array($NodoAdyacente, $Recorrido)) {
				$Recorrido = $this->RecorridoProfundidadR($NodoAdyacente, $Recorrido);
			}
		}
		return $Recorrido;
	}
	public function caminoMasCorto($a, $b)
	{

		$S = array();

		$Q = array();

		foreach (array_keys($this->matrizA) as $val) $Q[$val] = 99999;

		$Q[$a] = 0;

		//inicio calculo

		while (!empty($Q)) {

			$min = array_search(min($Q), $Q);

			if ($min == $b) break;

			foreach ($this->matrizA[$min] as $key => $val) if (!empty($Q[$key]) && $Q[$min] + $val < $Q[$key]) {

				$Q[$key] = $Q[$min] + $val;

				$S[$key] = array($min, $Q[$key]);
			}

			unset($Q[$min]);
		}

		$path = array();

		$pos = $b;

		while ($pos != $a) {

			$path[] = $pos;
			if (!isset($S[$pos][0])) {
				return [];
			}
			$pos = $S[$pos][0];
		}

		$path[] = $a;

		$path = array_reverse($path);

		return $path;
	}
}
