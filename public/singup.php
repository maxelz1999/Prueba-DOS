<?php
    include '../template/header.php';
  
?>
<main class="contenedor sombra">
    <body>
     <?php
            include("../db/conexion.php");

            if(empty($_POST['nombre'] )){
                echo "Completar todos los campos";        
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
  
<form method="POST" enctype="multipart/form-data" style="">

<label style="font-weight:bold; font-family: sans-serif; font-size: 20px;">Nombre</label>
<input class="form-control" type="text" name="nombre" style="font-family: sans-serif; font-size: 20px; width:180px; height:50px ;">

<label style="font-weight:bold; font-family: sans-serif; font-size: 20px;">Foto</label>
<input class="form-control" type="file" name="imagen" style="font-family: sans-serif; font-size: 20px;" required="">

<label style="font-weight:bold; font-family: sans-serif; font-size: 20px;">Correo</label>
<input class="form-control" type="email" id="correo" name="correo" style="font-family: sans-serif; font-size: 20px; width:180px; height:50px ;" >


<label style="font-weight:bold; font-family: sans-serif; font-size: 20px;">Contraseña</label>
<input class="form-control" type="password" name="contrasena" style="font-family: sans-serif; font-size: 15px; width:180px; height:50px ;" required="">


<label style="font-weight:bold; font-family: sans-serif; font-size: 20px;">Descripcion</label>
<input class="form-control" type="text" name="descripcion" style="font-family: sans-serif; font-size: 15px; width:180px; height:50px ;" required="">


<label style="font-weight:bold; font-family: sans-serif; font-size: 20px;">Region</label>
<select class="form-select" name="region" style="font-family: sans-serif; font-size: 20px; width:240px; height:50px ;">
        <option value="1" style="font-weight:bold; font-family: sans-serif; font-size: 20px; ">Arica y Parinacota</option>
        <option value="2" style="font-weight:bold; font-family: sans-serif; font-size: 20px; ">Tarapaca</option>
        <option value="3" style="font-weight:bold; font-family: sans-serif; font-size: 20px; ">Antofagasta</option>
        <option value="4" style="font-weight:bold; font-family: sans-serif; font-size: 20px; ">Atacama</option>
        <option value="5" style="font-weight:bold; font-family: sans-serif; font-size: 20px; ">Coquimbo</option>
        <option value="6" style="font-weight:bold; font-family: sans-serif; font-size: 20px; ">Valparaiso</option>
        <option value="7" style="font-weight:bold; font-family: sans-serif; font-size: 20px; ">Santiago</option>
        <option value="8" style="font-weight:bold; font-family: sans-serif; font-size: 20px; ">O'Higgins</option>
        <option value="9" style="font-weight:bold; font-family: sans-serif; font-size: 20px; ">Maule</option>
        <option value="10" style="font-weight:bold; font-family: sans-serif; font-size: 20px; ">Bio-Bio</option>
        <option value="11" style="font-weight:bold; font-family: sans-serif; font-size: 20px; ">Araucania</option>
        <option value="12" style="font-weight:bold; font-family: sans-serif; font-size: 20px; ">Los Rios</option>
        <option value="13" style="font-weight:bold; font-family: sans-serif; font-size: 20px; ">Los Lagos</option>
        <option value="14" style="font-weight:bold; font-family: sans-serif; font-size: 20px; ">Aysen</option>
        <option value="15" style="font-weight:bold; font-family: sans-serif; font-size: 20px; ">Magallanes</option>

        


<center>
    <input type="submit" name="Guardar" value="Guardar" class="btn btn-info">
    <button><a href="index.php">Ver diseñadores</a></button>
</center>
</form>
    </body>
</main>
<?php
    include '../template/footer.php';
?>