<?php
include ('arbolBinario.php');
session_start();
if(!isset($_SESSION["Arbol"])){
  $_SESSION['Arbol'] = new ArbolBinario();
}
$respuesta = "";
$action = isset($_POST['action'])? $_POST['action'] : "";
switch ($action) {
  case 'Crear Árbol':
    $nodo = new Nodo($_POST['raiz']);
    $_SESSION['Arbol']->crearArbol($nodo);
    break;
  case 'Agregar Nodo':
    $nodoNuevo = new Nodo($_POST['nombreHijo']);
    if($_SESSION['Arbol']->crearNodo($nodoNuevo, $_POST['ubicacion'], $_POST['nombrePadre'])){
      echo "Guardado con exito";
    }
    break;
  case 'Eliminar Nodo':
    if($_SESSION['Arbol']->eliminar($_SESSION['Arbol']->getRaiz(),$_POST['nodo'])){
      echo "Eliminado correctamente";
    }
    break;
  case 'Pre-Orden':
    $_SESSION['Arbol']->inicializar();
    $respuesta = $_SESSION['Arbol']->recorrerPreOrden($_SESSION['Arbol']->getRaiz());
    $_SESSION['Arbol']->inicializar();
    break;

  case 'In-Orden':
    $_SESSION['Arbol']->inicializar();
    $respuesta = $_SESSION['Arbol']->recorrerInOrden($_SESSION['Arbol']->getRaiz());
    $_SESSION['Arbol']->inicializar();
    break;

  case 'Post-Orden':
    $_SESSION['Arbol']->inicializar();
    $respuesta = $_SESSION['Arbol']->recorrerPostOrden($_SESSION['Arbol']->getRaiz());
    $_SESSION['Arbol']->inicializar();
    break;

    case 'Por Niveles':
      $respuesta = $_SESSION['Arbol']->recorrerPorNiveles($_SESSION['Arbol']->getRaiz());
      break;

    case 'Altura':
      $respuesta = $_SESSION['Arbol']->Altura($_SESSION['Arbol']->getRaiz());
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
    <title>Árbol Binario</title>
  </head>
  <body>
    <div class="">
      <h1>Árbol Binario</h1>
      <hr>
    </div>
    <div class="content-box">
      <h2>Crear Árbol</h2>
      <form class="" action="index.php" method="post">
        <input type="text" name="raiz" placeholder="Raiz" required>
        <input class="color-green" type="submit" name="action" value="Crear Árbol">
      </form>
    </div>
    <div class="content-box">
      <form class="" action="index.php" method="post">
        <input type="text" name="nombrePadre" placeholder="Nombre del padre" required>
        <div class="box">
          <input type="radio" id="izquierda" name="ubicacion" value="Izquierda" required>
          <label for="izquierda">Izquierda</label><br>
          <input type="radio" id="derecha" name="ubicacion" value="Derecha">
          <label for="derecha">Derecha</label>
        </div>
        <input type="text" name="nombreHijo" placeholder="Nombre del hijo" required>
        <input class="color-green" type="submit" name="action" value="Agregar Nodo">
      </form>
    </div>
    <div class="content-box">
      <form class="" action="index.php" method="post">
        <input type="text" name="nodo" placeholder="Nombre Nodo" required>
        <input class="color-red" type="submit" name="action" value="Eliminar Nodo">
      </form>
      <hr>
    </div>
    <div class="content-box">
      <form action="index.php" method="post">
        <input class="btn" type="submit" name="action" value="In-Orden">
        <input class="btn" type="submit" name="action" value="Pre-Orden">
        <input class="btn" type="submit" name="action" value="Post-Orden">
        <input class="btn" type="submit" name="action" value="Por Niveles">
        <input class="btn" type="submit" name="action" value="Altura">
      </form>
      <div class="mostrar">
        <?php echo "".($respuesta? $respuesta:""); ?>
      </div>
    </div>
    <div class="container" id="Arbol1">

    </div>
    <script type="text/javascript">
      var nodos = new vis.DataSet([
        <?php
      if((isset($_POST["action"]) != null) || (isset($_POST["Mostrar"]) != null)){
     $raiz = $_SESSION['Arbol']->getRaiz();
          if($raiz!=null){
            $_SESSION['Arbol']->mostrarNodos($raiz);
          }
        }
          if(isset($_POST["BotomHoj"]) != null){
            $raiz = $_SESSION['Arbol']->getRaiz();
                 if($raiz!=null){
                   $_SESSION['Arbol']->Hojas($raiz);
                 }else{
                  echo "<script>alert('El arbol no existe');</script>"; 
                 }
               }
       
               if(isset($_POST["BotomPar"]) !=null){
            $raiz = $_SESSION['Arbol']->getRaiz();
                 if($raiz!=null){
                   $_SESSION['Arbol']->Pares($raiz);
                 }else{
                  echo "<script>alert('El arbol no existe');</script>"; 
                 }
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
    var opciones = 
    { layout: 
     { hierarchical: 
       { direction: "UD", 
         sortMethod: "directed",
         },
      },
         edges:
         { smooth:
           { 
             type: "cubicBezier",
           },
             arrows:
             { to:
                {
                  enabled:true
                },
              },
                     
          },
    };

      var datos = {
        nodes: nodos,
        edges: aristas
      };
      var info = new vis.Network(contenedor, datos, opciones);

 
    </script>
  </body>
</html>


<form class="" action="index.php" method="post">
  <input type="submit" name="Botomcont" value="contar">
</form>

<form class="" action="index.php" method="post">
  <input type="submit" name="BotomHoj" value="Hojas">
</form>

<form class="" action="index.php" method="post">
  <input type="submit" name="BotomPar" value="Pares">
</form>

<form class="" action="index.php" method="post">
  <input type="submit" name="BotomCom" value="Completo">
</form>

<form class="" action="index.php" method="post">
  <input type="submit" name="Mostrar" value="Mostrar">
</form>

<?php
if(isset($_POST["Botomcont"]) !=null){
 $_SESSION['Arbol']->tomarcontar();
}
?>



<?php
/*if(isset($_POST["BotomHoj"]) != null){
  $_SESSION['Arbol']->Hojas($_SESSION['Arbol']->getRaiz());
}*/
?>
 

<?php
/*
if(isset($_POST["BotomPar"]) !=null){
 $_SESSION['Arbol']->Pares($_SESSION['Arbol']->getRaiz());
} */
?>



<?php
if(isset($_POST["BotomCom"]) !=null){
  $contador=0;
  $fal=0;
  $raiz=$_SESSION['Arbol']->getRaiz();
  $_SESSION['Arbol']->getNodoArray();
  $dato = $_SESSION['Arbol']->ArbolCompleto($_SESSION['Arbol']->getRaiz());
  if($raiz != null){
  if($dato!=null){
    $message = (in_array(2,$dato))? "No esta completo" : "Completo";
    echo $message;
    $_SESSION['Arbol']->setNodoArray();
  }
}else{
  echo "<script>alert('El arbol no existe');</script>"; 
}

  if($raiz != null){
    foreach ($dato as $key )
   {
     if($key==2){
      $fal =  $contador=$contador+1;
     }
   }
   echo "<br> Faltan ".$fal." nodos";
 }
}
?>
