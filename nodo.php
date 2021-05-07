<?php

/**
 *
 */
class Nodo {
  private $id;
  private $izquierdo;
  private $derecho;
  function __construct($id) {
    $this->id = $id;
    $this->izquierdo = null;
    $this->derecho = null;
  }
  public function getId(){
    return $this->id;
  }
  public function setId($id){
    $this->id = $id;
  }
  public function getIzquierdo(){
    return $this->izquierdo;
  }
  public function setIzquierdo($izquierdo){
    $this->izquierdo = $izquierdo;
  }
  public function getDerecho(){
    return $this->derecho;
  }
  public function setDerecho($derecho){
    $this->derecho = $derecho;
  }

}

?>
