<?php
include ('nodo.php');
/**
 *
 */
class ArbolBinario {
  private $raiz;
  public $respuesta = "";
  public $NodosArray=[];

  function __construct() {
    $this->raiz = null;
  }

  function crearArbol($nodo) {
    $this->raiz = $nodo;
  }

  function getRaiz(){
    return $this->raiz;
  }

  function getNodoArray(){
    $this->NodosArray=[];
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
        return "Guardado correctamente";
      }else{
        return "No existe nodo padre o el elemento esta repetido";
      }
    }else{
      return "No existe raíz";
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
      if($raiz->getIzquierdo()!=null){
        $destino = $raiz->getIzquierdo()->getId();
        echo "{from: '$id', to: '$destino'},";
      }
      if ($raiz->getDerecho()!=null){
        $destino = $raiz->getDerecho()->getId();
        echo "{from: '$id', to: '$destino'},";
      }
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

  function eliminar($raiz, $nodo){
    $nodoEliminar = self::buscarNodo($this->raiz,$nodo);
    if(!empty($nodoEliminar)){
      if(($raiz!=null) && ($nodoEliminar!=null) && ($nodoEliminar->getIzquierdo()==null && $nodoEliminar->getDerecho()==null)){
        if($raiz->getId()==$nodo){
          self::crearArbol(null);
        }else{
          $izquierdo = $raiz->getIzquierdo();
          $derecho = $raiz->getDerecho();
          if(!empty($izquierdo) && ($izquierdo->getId() == $nodo)){
            $raiz->setIzquierdo(null);
          }
          if(!empty($derecho) && ($derecho->getId() == $nodo)){
            $raiz->setDerecho(null);
          }
          self::eliminar($raiz->getIzquierdo(), $nodo);
          self::eliminar($raiz->getDerecho(), $nodo);
        }
        return "Eliminado con éxito";
      }
      return "El nodo no se puede eliminar";
    }else{
      return "El nodo que desea eliminar no existe";
    }
  }

  function contar ($Nod){
    if($Nod != null){
      if($Nod != null){
       return self::contar($Nod->getIzquierdo()) + self::contar($Nod->getDerecho()) + 1;
      }else{
        return 1;
      }
    }else{
      return 0;
    }
  }

  function tomarcontar (){
    $total=0;
    $nodo=$this->raiz;
    $total=$total + $this->contar($nodo);
    return $total;
  }

  function Hojas($raiz){
    if($raiz != null){
      if((($raiz->getIzquierdo()) == null) && (($raiz->getDerecho()) == null )){
        $id=$raiz->getId();
        echo "{id:'$id',label:'$id',color:{background:'pink'}},";
      }else{
        $id=$raiz->getId();
      echo "{id:'$id',label:'$id'},";
      }
      self::Hojas($raiz->getIzquierdo());
      self::Hojas($raiz->getDerecho());
    }
  }

  function pares($raiz){
    if($raiz != null){
      $id=$raiz->getId();
      if(($id % 2 )== 0){
        echo "{id:'$id',label:'$id',color:{background:'pink'}},";
      }else{
        echo "{id:'$id',label:'$id'},";
      }
      self::pares($raiz->getIzquierdo());
      self::pares($raiz->getDerecho());
    }
  }

  function ArbolCompleto($raiz){
   $node=$raiz;
    if($node != null){
      if((($node->getIzquierdo() == null) && (($node->getDerecho()) == null)) || (($node->getIzquierdo() != null) && (($node->getDerecho()) != null))){
        array_push($this->NodosArray, 1);
      }else{
        array_push($this->NodosArray, 2);
      }
      self::ArbolCompleto($node->getIzquierdo());
      self::ArbolCompleto($node->getDerecho());
    }
    return $this->NodosArray;
  }

}
?>
