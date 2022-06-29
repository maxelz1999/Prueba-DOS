<?php
    include '../template/header.php';
  
    include("../db/conexion.php");

?>
<main class="contenedor sombra">
    <div>
<table>
    <tr>
        <td></td>
        <td><h1>Nombre </h1> </td>
        <td> <h1>descripcion </h1></td>
    </tr>
    <?php
    $query= mysqli_query($conn,"SELECT * FROM disenadores");
    $result = mysqli_num_rows($query);
    if($result>0){
        while($data= mysqli_fetch_array($query)){
            ?>
            <tr>
                <td><img height="100" src="data:image/jpg;base64, <?php echo base64_encode($data['imagen']) ?>"></td>
                <td><?php echo $data['nombre'] ?></td>
                <td><?php echo $data['descripcion'] ?></td>
     
            </tr>
            <?php         }
    }
    ?>
</table>
</div>

</main>
<?php
    include '../template/footer.php';
?>