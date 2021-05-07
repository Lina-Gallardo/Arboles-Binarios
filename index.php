<?php
include ('ArbolBinario.php');
session_start();
if(!isset($_SESSION["Arbol"])){
  $_SESSION['Arbol'] = new ArbolBinario();
}
$action = isset($_POST['action'])? $_POST['action'] : "";
switch ($action) {
  case 'Crear Arbol':
    $nodo = new Nodo($_POST['raiz']);
    $_SESSION['Arbol']->crearArbol($nodo);
    break;
  case 'Agregar Nodo':
    $nodoNuevo = new Nodo($_POST['nombreHijo']);
    if($_SESSION['Arbol']->crearNodo($nodoNuevo, $_POST['ubicacion'], $_POST['nombrePadre'])){
      echo "Guardado con exito";
    }
    break;

  default:
    if($_SESSION['Arbol']) $_SESSION['Arbol']->recorrerPreOrden($_SESSION['Arbol']->getRaiz());
    break;
}
?>
<!DOCTYPE html>
<html lang="es" dir="ltr">
  <head>
    <meta charset="utf-8">
    <script type="text/javascript" src="vis/dist/vis.js"></script>
    <link rel="stylesheet" href="vis/dist/vis.css" type="text/css">
    <link rel="stylesheet" href="style.css" type="text/css">
    <title>Arboles s</title>
  </head>
  <body>
    <div class="">
      <form class="" action="index.php" method="post">
        <input type="text" name="raiz" placeholder="Raiz" required>
        <input type="submit" name="action" value="Crear Arbol">
      </form>
    </div>
    <div class="">
      <form class="" action="index.php" method="post">
        <input type="text" name="nombrePadre" placeholder="Nombre del padre" required>
        <div class="">
          <input type="radio" id="izquierda" name="ubicacion" value="Izquierda" required>
          <label for="izquierda">Izquierda</label>
          <input type="radio" id="derecha" name="ubicacion" value="Derecha">
          <label for="derecha">Derecha</label>
        </div>
        <input type="text" name="nombreHijo" placeholder="Nombre del hijo" required>
        <input type="submit" name="action" value="Agregar Nodo">
      </form>
    </div>
    <div class="container" id="Arbol1">

    </div>
    <script type="text/javascript">
      var nodos = new vis.DataSet([
        <?php
          $raiz = $_SESSION['Arbol']->getRaiz();
          if($raiz!=null){
            $_SESSION['Arbol']->mostrarNodos($raiz);
          }
        ?>
      ]);
      var aristas = new vis.DataSet([
        <?php
          $raiz = $_SESSION['Arbol']->getRaiz();
          if($raiz!=null){
            $_SESSION['Arbol']->mostarAristas($raiz);
          }
        ?>
      ]);
      var contenedor = document.getElementById('Arbol1');
      var opciones = {edges:{arrows:{to:{enabled:true}}}};
      var datos = {
        nodes: nodos,
        edges: aristas
      }
      var info = new vis.Network(contenedor, datos, opciones);
    </script>
  </body>
</html>
