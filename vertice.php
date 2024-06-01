<?php
//Carlos Andres Duran Torres
class Vertice
{

	private $id;
	private PuntoTuristico $informacion;
	private $visitado;

	public function __construct($i,$info)
	{
		$this->informacion = $info;
		$this->id = $i;
		$this->visitado = false;
	}

	public function getId()
	{
		return $this->id;
	}

	public function setId($i)
	{
		$this->id = $i;
	}

	public function getVisitado()
	{
		return $this->visitado;
	}

	public function setVisitado($v)
	{
		$this->visitado = $v;
	}

	public function getInformacion()
	{
		return $this->informacion;
	}

	public function setInformacion($info)
	{
		$this->informacion = $info;
	}
}

class PuntoTuristico
{
	private $nombre;
	private $descripcion;
	private $calificacion;
	private $precio;
	private $categoria;
	private $tiempo;

	public function __construct($lugar, $infolugar, $calilugar, $preciolugar, $catlugar, $tiempolugar)
	{
		$this->nombre = $lugar;
		$this->descripcion = $infolugar;
		$this->calificacion = $calilugar;
		$this->precio = $preciolugar;
		$this->categoria = $catlugar;
		$this->tiempo = $tiempolugar;
	}

	public function getNombre()
	{
		return $this->nombre;
	}

	public function setNombre($lugar)
	{
		$this->nombre = $lugar;
	}

	public function getDescripcion()
	{
		return $this->descripcion;
	}

	public function setDescripcion($infolugar)
	{
		$this->descripcion = $infolugar;
	}

	public function getCalificacion()
	{
		return $this->calificacion;
	}

	public function setCalificacion($calilugar)
	{
		$this->calificacion = $calilugar;
	}

	public function getPrecio()
	{
		return $this->precio;
	}

	public function setPrecio($preciolugar)
	{
		$this->precio = $preciolugar;
	}

	public function getCategoria()
	{
		return $this->categoria;
	}

	public function setCategoria($catlugar)
	{
		$this->categoria = $catlugar;
	}

	public function getTiempo()
	{
		return $this->tiempo;
	}

	public function setTiempo($tiempolugar)
	{
		$this->tiempo = $tiempolugar;
	}

}
