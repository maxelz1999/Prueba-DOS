<?php
    include '../template/header.php';
  
    include("../db/conexion.php");

    if(empty($_POST['nombre'] )){
        echo "llene todos los campos";        
    }else {
        $nombre = $_POST['nombre'];
        $imagen = addslashes(file_get_contents($_FILES['imagen']['tmp_name'])) ;
        
        $correo = $_POST['correo'];
        $contrasena = $_POST['contrasena'];
        $descripcion = $_POST['descripcion'];
        $region = $_POST['region'];
        $query="INSERT into disenadores (nombre, imagen, correo, contrasena , descripcion, region) VALUES ('$nombre','$imagen','$correo','$contrasena','$descripcion','$region')";
        $resultado = $conn->query($query);
        if($resultado){
            echo"se guardo el disenador";
        }else{
            echo "no se guardo error";
        }
    }
?>
<main class="contenedor sombra">
    <body>
        
  
<form method="POST" enctype="multipart/form-data">
<label>Nombre</label>
<input type="text" name="nombre">

<label>Foto</label>
<input type="file" name="imagen" required="">

<label>correo</label>
<input type="email" id="correo" name="correo" >


<label>contrasena</label>
<input type="password" name="contrasena" required="">


<label>descripcion</label>
<input type="text" name="descripcion">


<label>region</label>
<input type="number" name="region">

<center>
    <input type="submit" name="guardar" value="guardar">
    <button><a href="disenadores.php">ver disenadores</a></button>
</center>
</form>
    </body>
</main>
<?php
    include '../template/footer.php';
?>