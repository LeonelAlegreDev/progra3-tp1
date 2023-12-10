<?php

abstract class Producto
{
  public $id;
  public $nombre;
  public $precio;
  public $descripcion;
  public $fechaBaja;

  abstract public function PostNew();
  abstract public function GetAll();
  abstract public function GetById($id);
  abstract public function DeleteById($id);
  abstract public function UpdateById($id);
}

?>