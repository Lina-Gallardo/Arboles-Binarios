<?php
include ('nodo.php');
/**
 *
 */
class ArbolBinario {
  private $raiz;
  public $respuesta = "";

  function __construct() {
    $this->raiz = null;
  }

  function crearArbol($nodo) {
    $this->raiz = $nodo;
  }

  function getRaiz(){
    return $this->raiz;
  }

  function inicializar(){
     $this->respuesta = "";
  }

  function crearNodo($nodo, $ubicacion, $padre) {
    if($this->raiz!=null){
      $NodoPadre = self::buscarNodo($this->raiz,$padre);
      $NodoHijo = self::buscarNodo($this->raiz,$nodo->getId());
      if($NodoPadre!=null && $NodoPadre->getId()!=$nodo->getId() && $NodoHijo==null ){
        if($ubicacion=="Izquierda"){
          if(empty($NodoPadre->getIzquierdo())){
            $NodoPadre->setIzquierdo($nodo);
          }else{
            $Anterior = $NodoPadre->getIzquierdo();
            $NodoPadre->setIzquierdo($nodo);
            $nodo->setIzquierdo($Anterior);
          }
        }else{
          if(empty($NodoPadre->getDerecho())){
            $NodoPadre->setDerecho($nodo);
          }else{
            $Anterior = $NodoPadre->getDerecho();
            $NodoPadre->setDerecho($nodo);
            $nodo->setDerecho($Anterior);
          }
        }
        echo "Guardado correctamente";
      }else{
        echo "No exite la raiz o el elemento esta repetido";
      }
    }else{
      echo "No existe raiz";
    }
  }

  function buscarNodo($raiz, $nodo) {
    if($raiz == null){
      return null;
    }
    if($raiz->getId() == $nodo) {
      return $raiz;
    }
    $derecha = self::buscarNodo($raiz->getDerecho(), $nodo);
    $izquierdo = self::buscarNodo($raiz->getIzquierdo(), $nodo);
    if($derecha!=null){
      return $derecha;
    }else{
      return $izquierdo;
    }
  }

  function mostrarNodos($raiz){
    if($raiz!=null){
      $id=$raiz->getId();
      echo "{id:'$id',label:'$id'},";
      self::mostrarNodos($raiz->getIzquierdo());
      self::mostrarNodos($raiz->getDerecho());
    }
  }

  function mostarAristas($raiz){
    if($raiz!=null){
      $id=$raiz->getId();
      // $destino='1';

      if($raiz->getIzquierdo()!=null){
        $destino = $raiz->getIzquierdo()->getId();
        echo "{from: '$id', to: '$destino'},";
      }
      if ($raiz->getDerecho()!=null){
        $destino = $raiz->getDerecho()->getId();
        echo "{from: '$id', to: '$destino'},";
      }

      // $destino = $raiz->getDerecho()->getId();
      // echo "{from: '$id', to: '$destino'},";
      self::mostarAristas($raiz->getIzquierdo());
      self::mostarAristas($raiz->getDerecho());
    }
  }

  function recorrerPreOrden($node) {
    if($node!=null){
      $this->respuesta = $this->respuesta."Nodo:".$node->getId(). " - ";
      self::recorrerPreOrden($node->getIzquierdo());
      self::recorrerPreOrden($node->getDerecho());
     }
    return $this->respuesta;
  }

  function recorrerInOrden($node) {
    if($node!=null){
      self::recorrerInOrden($node->getIzquierdo());
      $this->respuesta = $this->respuesta."Nodo:".$node->getId(). " - ";
      self::recorrerInOrden($node->getDerecho());
    }
    return $this->respuesta;
  }

  function recorrerPostOrden($node) {
    if($node!=null){
      self::recorrerPostOrden($node->getIzquierdo());
      self::recorrerPostOrden($node->getDerecho());
      $this->respuesta =$this->respuesta."Nodo:".$node->getId(). " - ";
    }
    return $this->respuesta;
  }

  function recorrerPorNiveles($node){
    $respuesta = "";
    if($node!=null){
      $cola = [];
      array_push($cola,$node);
      while(!empty($cola)){
       $nodoActual = reset($cola);
       $id = array_search($nodoActual, $cola);
       unset($cola[$id]);
       $respuesta = $respuesta."Nodo:" .$nodoActual->getId(). " - ";
       if($nodoActual->getIzquierdo()!=null){
         array_push($cola,$nodoActual->getIzquierdo());
       }
       if($nodoActual->getDerecho()!=null){
         array_push($cola,$nodoActual->getDerecho());
       }
      }
    }else{
      $respuesta = "No existe el arbol";
    }
    return $respuesta;
  }

  function altura($nodoActual){
    if($nodoActual==null){
      return 0;
    }
    $izquierda = self::altura($nodoActual->getIzquierdo());
    $derecho = self::altura($nodoActual->getDerecho());
    if($izquierda > $derecho){
      return 1 + $izquierda;
    }else{
      return 1 + $derecho;
    }
  }

}


?>
